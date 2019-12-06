<?php
	$pageTitle = "Farm Output By Supplier Id";
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
		<h1>Farm Output by Supplier Id</h1>
		<p>Look for instances of farm outputs from a specific supplier Id.</p>
	</section>
</div>



<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryFarmID = NULL;
$querySupplierId = NULL;

if(isset($_POST["queryFarmID"]))
{
	$queryFarmID = $_POST["queryFarmID"];
	$querySupplierId = $_POST["querySupplierId"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Farm Output by Supplier Id</h3>
	<form action="farm_output_by_supplier_id.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Farm ID:</td>
			<td><input type="number" name="queryFarmID" value="<?php echo ''.(is_null($queryFarmID)? '0' : $queryFarmID); ?>" /></td>
			<td>Supplier ID:</td>
			<td><input type="number" name="querySupplierId" value="<?php echo ''.(is_null($querySupplierId)? '0' : $querySupplierId); ?>" /></td>
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
					FROM	CROP AS C
					JOIN	SUPPLIES AS S1
					ON		C.`Output_Id` = S1.`Output_Id`
					JOIN	FARM_OUTPUT AS FO1
					ON		S1.`Output_Id` = FO1.`Output_Id`
					WHERE	C.Farm_Id = ? AND
							S1.Supplier_Id = ?
					UNION
					SELECT	FO2.*
					FROM	LIVESTOCK AS L
					JOIN	SUPPLIES AS S2
					ON		L.`Output_Id` = S2.`Output_Id`
					JOIN	FARM_OUTPUT AS FO2
					ON		S2.`Output_Id` = FO2.`Output_Id`
					WHERE	L.Farm_Id = ? AND
							S2.Supplier_Id = ?";
			$result = $db->preparedQuery($sql, "iiii", array($querySupplierId, $queryFarmID, $querySupplierId, $queryFarmID));
			
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
			var filename = "farmOutputBySupplierId";
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
