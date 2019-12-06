<?php
	$pageTitle = "Source of Output";
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
        <h1>Source of Output</h1>
		<p>Look for instances of supplies for a given output ID.</p>
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
	<h3>Search for Supplies</h3>
	<form action="source_of_output.php" method="POST">
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
			$sql = "SELECT * FROM SUPPLIES AS S WHERE output_id = ?";
			$result = $db->preparedQuery($sql, "s", array($queryOutputId));
			//$sql = "SELECT * FROM 'supplies' WHERE output_id = 1";
			//$result = $db->query($sql);

			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 5;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Supplier ID</th>
				<th>Output ID</th>
				<th>Price</th>
				<th>Date</th>
				<th>Quantity</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['supplier_id']; ?></td>
				<td><?php echo $resultArr[$i]['output_id']; ?></td>
				<td><?php echo $resultArr[$i]['price']; ?></td>
				<td><?php echo $resultArr[$i]['date']; ?></td>
				<td><?php echo $resultArr[$i]['quantity']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Supplier ID", "Output ID", "Price", "Date", "Quantity"];
			var filename = "sourceOfOutput";
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
