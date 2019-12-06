<?php
	$pageTitle = "Remedy by Damage";
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
        <h1>Remedy by Damage</h1>
		<p>Look for instances of remedies with for a specified damage.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryDamageId = NULL;

if(isset($_POST["queryDamageId"]))
{
	$queryDamageId = $_POST["queryDamageId"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Remedies</h3>
	<form action="remedy_by_damage.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Damage ID:</td>
			<td><input type="number" name="queryDamageId" value="<?php echo ''.(is_null($queryDamageId)? '0' : $queryDamageId); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryDamageId)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT	R.*
					FROM	MITIGATED_BY AS MB
							JOIN REMEDY AS R
							ON MB.`Remedy_name` = R.`Remedy_name`
					WHERE	MB.Damage_Id = ?";
			$result = $db->preparedQuery($sql, "i", array($queryDamageId));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 3;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Remedy Name</th>
				<th>Start Date</th>
				<th>End Date</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['remedy_name']; ?></td>
				<td><?php echo $resultArr[$i]['start_date']; ?></td>
				<td><?php echo $resultArr[$i]['end_date']; ?></td>

			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["remedy_name", "start_date", "end_date"];
			var filename = "remedyByDamage";
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
