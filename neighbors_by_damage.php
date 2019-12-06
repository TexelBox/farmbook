<?php
	$pageTitle = "Neighbors by Damage";
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
		<h1>Neighbors by Damage</h1>
		<p>Look for instances of neighboring farms that were affected by a specific damage.</p>
	</section>
</div>



<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryFarmID = NULL;
$queryDamageID = NULL;

if(isset($_POST["queryFarmID"]))
{
	$queryFarmID = $_POST["queryFarmID"];
	$queryDamageID = $_POST["queryDamageID"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Neighbors by Damage</h3>
	<form action="neighbors_by_damage.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Farm ID:</td>
			<td><input type="number" name="queryFarmID" value="<?php echo ''.(is_null($queryFarmID)? '0' : $queryFarmID); ?>" /></td>
			
			<td>Damage ID:</td>
			<td><input type="number" name="queryDamageID" value="<?php echo ''.(is_null($queryDamageID)? '0' : $queryDamageID); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryFarmID)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT  F.*
					FROM    DAMAGED_BY AS DB 
							JOIN CROP AS C 
							ON DB.`output_id` = C.`output_id`
							JOIN FARM AS F
							ON C.`farm_id` = F.`farm_id`
					WHERE   DB.damage_id = ? AND
							F.farm_id IN (SELECT farm_id_1 AS farm_id FROM NEIGHBORS WHERE farm_id_2 = ? UNION SELECT farm_id_2 AS farm_id FROM NEIGHBORS WHERE farm_id_1 = ?)
					UNION
					SELECT  F.*
					FROM    DAMAGED_BY AS DB 
							JOIN LIVESTOCK AS L
							ON DB.`output_id` = L.`output_id`
							JOIN FARM AS F
							ON L.`farm_id` = F.`farm_id`
					WHERE   DB.damage_id = ? AND
							F.farm_id IN (SELECT farm_id_1 AS farm_id FROM NEIGHBORS WHERE farm_id_2 = ? UNION SELECT farm_id_2 AS farm_id FROM NEIGHBORS WHERE farm_id_1 = ?)";
			$result = $db->preparedQuery($sql, "iiiiii", array($queryDamageID, $queryFarmID, $queryFarmID, $queryDamageID, $queryFarmID, $queryFarmID));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 6;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
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
			var resultArrJSHeaders = ["Farm ID", "Longitude", "Latitude", "Farm Name", "Acres", "Supplier ID"];
			var filename = "neighborsByDamage";
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
