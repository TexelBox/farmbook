<?php
	$pageTitle = "Neighbors by Farm Id";
	$navbarLink1 = "index.php";
	$navbarLink1Title = "HOME";
	$navbarLink2 = "auth.php";
	$navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
	$navbarLink3Title = "PORTAL";
	require_once("header.php");
	require_once("database.php");
	
	if (!isset($_SESSION["logged_in"]) || (!isset($_SESSION["admin"]) && !isset($_SESSION["read_only"]) &&
										   !isset($_SESSION["farmer"]))) header("Location: login.php");?>

<div class="container">
	<section id="main">
		<h1>Neighbors by Farm Id</h1>
		<p>Look for instances of neighboring farms for a specific farm Id.</p>
	</section>
</div>



<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryFarmID = NULL;

if(isset($_POST["queryFarmID"]))
{
	$queryFarmID = $_POST["queryFarmID"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Neighbors by Farm Id</h3>
	<form action="neighbors_by_farm_id.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Farm ID:</td>
			<td><input type="number" name="queryFarmID" value="<?php echo ''.(is_null($queryFarmID)? '0' : $queryFarmID); ?>" /></td>
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
			$sql = "SELECT F.*
					FROM FARM AS F
					WHERE F.Farm_Id IN (SELECT farm_id_1 AS farm_id FROM NEIGHBORS WHERE farm_id_2 = ? UNION SELECT farm_id_2 AS farm_id FROM NEIGHBORS WHERE farm_id_1 = ?)";
			$result = $db->preparedQuery($sql, "ii", array( $queryFarmID, $queryFarmID));
			
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
			<?php $i++; endwhile; $i=0; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Farm ID", "Longitude", "Latitude", "Farm Name", "Acres", "Supplier ID"];
			var filename = "neighborsByFarmId";
		</script>
		<div id="centeredDiv">
			<input type="button" onclick="downloadCSVFromArray(resultArrJS, resultArrJSHeaders, filename)" value="Download Result">
		</div>
		<p>Enable pop-ups and disable your adblocker to enable downloads.</p>
		
		<!--Display Farm locations using a Siema carousel. Reference: https://pawelgrzybek.github.io/siema/ -->
		<!--This maps embed is from https://www.embedgooglemap.net/ -->
		<div class="container">
			<div id="centeredDiv">
				<div class="siema">
					<?php while($i < $resultArrLen): ?>
						<div id="centeredDiv" class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $resultArr[$i]['latitude']; ?>%2C%20<?php echo $resultArr[$i]['longitude']; ?>&t=&z=7&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.couponflat.com/cyberghost-coupon/"></a></div><style>.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style></div>							
					<?php $i++; endwhile; $i = 0;?>
				</div>
				<?php if($resultArrLen > 1): ?>
					<input type="button" class="prev" value="prev farm"></input>
					<input type="button" class="next" value="next farm"></input>				
					
					<script src="siema-master\dist\siema.min.js"></script>
					<script type="text/javascript"> 
						const farmSiema = new Siema();
						document.querySelector('.prev').addEventListener('click', () => farmSiema.prev());
						document.querySelector('.next').addEventListener('click', () => farmSiema.next());
					</script>	
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</div>



<?php
	require_once("footer.php");
?>
