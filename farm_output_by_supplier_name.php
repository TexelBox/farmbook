<?php
	$pageTitle = "Farm Output By Supplier Name";
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
		<h1>Farm Output by Supplier Name</h1>
		<p>Look for instances of farm outputs from a specific supplier Name.</p>
	</section>
</div>



<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryFarmID = NULL;
$querySupplierName = NULL;

if(isset($_POST["queryFarmID"]))
{
	$queryFarmID = $_POST["queryFarmID"];
	$querySupplierName = $_POST["querySupplierName"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Farm Output by Supplier Name</h3>
	<form action="farm_output_by_supplier_name.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Farm ID:</td>
			<td><input type="number" name="queryFarmID" value="<?php echo ''.(is_null($queryFarmID)? '0' : $queryFarmID); ?>" /></td>
			<td>Supplier ID:</td>
			<td><input type="text" name="querySupplierName" value="<?php echo ''.(is_null($querySupplierName)? 'name' : $querySupplierName); ?>" /></td>
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
			$sql = "SELECT	FO1.*
					FROM	SUPPLIES AS SU1
					JOIN	FARM AS F
					ON		F.`Supplier_Id` = SU1.`Supplier_Id`
					JOIN	FARM_OUTPUT AS FO1
					ON		SU1.`Output_Id` = FO1.`Output_Id`
					JOIN	LIVESTOCK AS L1
					ON		L1.`Output_Id` = FO1.`Output_Id`
					JOIN	CROP AS C1
					ON		C1.`Output_Id` = FO1.`Output_Id`
					WHERE	F.Name = ? AND
							(L1.Farm_Id = ? OR C1.Farm_Id = ?)
					UNION
					SELECT	FO2.*
					FROM	SUPPLIES AS SU2
					JOIN	NON_FARM_CORPORATION AS NFC
					ON		NFC.`Supplier_Id` = SU2.`Supplier_Id`
					JOIN	FARM_OUTPUT AS FO2
					ON		SU2.`Output_Id` = FO2.`Output_Id`
					JOIN	LIVESTOCK AS L2
					ON		L2.`Output_Id` = FO2.`Output_Id`
					JOIN	CROP AS C2
					ON		C2.`Output_Id` = FO2.`Output_Id`
					WHERE	NFC.Name = ? AND
							(L2.Farm_Id = ? OR C2.Farm_Id = ?)";
			$result = $db->preparedQuery($sql, "siisii", array($querySupplierName, $queryFarmID, $queryFarmID, $querySupplierName, $queryFarmID, $queryFarmID));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 2;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Output ID</th>
				<th>Lifespan</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['output_id']; ?></td>
				<td><?php echo $resultArr[$i]['lifespan']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Output ID", "Lifespan"];
			var filename = "farmOutputBySupplierName";
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
