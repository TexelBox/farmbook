<?php
	$pageTitle = "Farm by Id";
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
        <h1>Farm by Id</h1>
		<p>Look for farms with a specified farm Id.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryFarmId = NULL;

if(isset($_POST["queryFarmId"]))
{
	$queryFarmId = $_POST["queryFarmId"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Farms</h3>
	<form action="farms_by_id.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Farm ID:</td>
			<td><input type="number" name="queryFarmId" value="<?php echo ''.(is_null($queryFarmId)? '0' : $queryFarmId); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryFarmId)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT *
					FROM FARM
					WHERE Farm_Id = ?";
			$result = $db->preparedQuery($sql, "i", array($queryFarmId));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 6;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
				<th>Farm ID</th>
				<th>Longitude</th>
				<th>Latitude</th>
				<th>Farm Name</th>
				<th>Acres</th>
				<th>Supplier ID</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['farm_id']; ?></td>
				<td><?php echo $resultArr[$i]['longitude']; ?></td>
				<td><?php echo $resultArr[$i]['latitude']; ?></td>
				<td><?php echo $resultArr[$i]['name']; ?></td>
				<td><?php echo $resultArr[$i]['acres']; ?></td>
				<td><?php echo $resultArr[$i]['supplier_id']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Farm ID", "Longitude", "Latitude", "Farm Name", "Acres", "Supplier ID"]];
			var filename = "farmById";
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
