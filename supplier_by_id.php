<?php
	$pageTitle = "Supplier by Id";
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
        <h1>Supplier by Id</h1>
		<p>Look for suppliers with a specified supplier Id.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$querySupplierId = NULL;

if(isset($_POST["querySupplierId"]))
{
	$querySupplierId = $_POST["querySupplierId"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Suppliers</h3>
	<form action="supplier_by_id.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Supplier ID:</td>
			<td><input type="number" name="querySupplierId" value="<?php echo ''.(is_null($querySupplierId)? '0' : $querySupplierId); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($querySupplierId)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT NFC.name, NFC.supplier_id
					FROM NON_FARM_CORPORATION AS NFC
					WHERE Supplier_Id = ?
					UNION 
					SELECT F.name, F.supplier_id
					FROM FARM AS F
					WHERE Supplier_Id = ?";
			$result = $db->preparedQuery($sql, "ii", array($querySupplierId, $querySupplierId));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 2;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Supplier Name</th>
				<th>Supplier ID</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['name']; ?></td>
				<td><?php echo $resultArr[$i]['supplier_id']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Supplier Name", "Supplier ID"];
			var filename = "supplierById";
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
