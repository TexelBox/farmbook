<?php
	$pageTitle = "Insurance Company by Name";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
	require_once("database.php");
	
	if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["admin"])) header("Location: login.php");
?>

<div class="container">
    <section id="main">
        <h1>Insurance Company by Name</h1>
		<p>Look for insurance companies using a specified name.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryName = NULL;

if(isset($_POST["queryName"]))
{
	$queryName = $_POST["queryName"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Insurance Companies</h3>
	<form action="insurance_company_by_name.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Insurer Name:</td>
			<td><input type="text" name="queryName" value="<?php echo ''.(is_null($queryName)? 'name' : $queryName); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryName)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT *
					FROM INSURANCE_COMPANY
					WHERE name = ?";
			$result = $db->preparedQuery($sql, "s", array($queryName));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 2;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
				<th>Insurer ID</th>
				<th>Name</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['insurer_id']; ?></td>
				<td><?php echo $resultArr[$i]['name']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Insurer ID", "Name"]];
			var filename = "insuranceCompanyByName";
		</script>
		<div id="centeredDiv">
			<input type="button" onclick="downloadCSVFromArray(resultArrJS, resultArrJSHeaders, filename)" value="Download Result">
		</div>
		<p>Enable pop-ups and disable your adblocker to enable downloads.</p>
	<?php endif; ?>
</div>



<?php
    require_once("footer.php");
?>
