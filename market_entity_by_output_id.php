<?php
	$pageTitle = "Market Entity by Output Id";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
	require_once("database.php");
	
	if (!isset($_SESSION["logged_in"]) || (!isset($_SESSION["admin"]) && !isset($_SESSION["read_only"]) &&
										   !isset($_SESSION["supplier"]) &&
										   !isset($_SESSION["farmer"]))) header("Location: login.php");?>

<div class="container">
    <section id="main">
        <h1>Market Entity by Output Id</h1>
		<p>Look for market entities using a specified output Id.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryOutputId = NULL;

if(isset($_POST["queryOutputId"]))
{
	$queryOutputId = $_POST["queryOutputId"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Market Entities</h3>
	<form action="market_entity_by_output_id.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Output ID:</td>
			<td><input type="number" name="queryOutputId" value="<?php echo ''.(is_null($queryOutputId)? '0' : $queryOutputId); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryOutputId)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT ME.*
					FROM SOLD_TO AS ST
					JOIN MARKET_ENTITY AS ME
					ON ST.`market_id` = ME.`market_id`
					WHERE ST.Output_Id = ?";
			$result = $db->preparedQuery($sql, "i", array($queryOutputId));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 2;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
				<th>Market ID</th>
				<th>Name</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['market_id']; ?></td>
				<td><?php echo $resultArr[$i]['name']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Market ID", "Name"]];
			var filename = "marketEntityByOutputId";
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
