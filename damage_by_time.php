<?php
	$pageTitle = "Damage by Time";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
	require_once("database.php");
	
	if (!isset($_SESSION["logged_in"]) || (!isset($_SESSION["admin"]) && !isset($_SESSION["read_only"]) &&
										   !isset($_SESSION["insurer"]) &&
										   !isset($_SESSION["farmer"]))) header("Location: login.php");
?>

<div class="container">
    <section id="main">
        <h1>Damage by Time</h1>
		<p>Look for instances of farm damage that started and ended in the given time period.</p>
    </section>
</div>



<!--Upload Entity Attributes or Assign them NULL values-->
<?php
$uploadName = NULL;
$uploadStartDate = NULL;
$uploadEndDate = NULL;

if(isset($_POST["uploadName"]))
{
	$uploadName = $_POST["uploadName"];
	$uploadStartDate = $_POST["uploadStartDate"];
	$uploadEndDate = $_POST["uploadEndDate"];
}
?>

<?php if (isset($_SESSION["admin"]) || isset($_SESSION["farmer"])): ?>
<div class="container">
	<!--Forms for Uploading Damage-->
	<h3>Upload Damage Instance</h3>
	<form action="damage_by_time.php" method="POST">
	<table id="formTable">
		<tr>
			<td>Damage Name:</td>
			<td><input type="text" name="uploadName" value="<?php echo ""; ?>" /></td>
		
			<td>Start Date:</td>
			<td><input type="date" name="uploadStartDate" value="<?php echo date('Y-m-d'); ?>" /></td>
			
			<td>End Date:</td>
			<td><input type="date" name="uploadEndDate" value="<?php echo date('Y-m-d') ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Upload"/>
	</div>
	</form>
</div>
<?php endif; ?>

<!--Upload Damage Entry-->
<?php		
	if($uploadName != "")
	{
		$db = new Database();		
		//$sql = "INSERT INTO `DAMAGE` (`damage_id`, `name`, `start_date`, `end_date`) VALUES (NULL, 'name', '2019-11-10', '2019-11-11')";
		$sql = "INSERT INTO `DAMAGE` (`damage_id`, `name`, `start_date`, `end_date`) VALUES (NULL, ?, ?, ?)";
		$result = $db->preparedQuery($sql, "sss", array($uploadName, $uploadStartDate, $uploadEndDate));		
	}
?>



<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryStartDate = NULL;
$queryEndDate = NULL;

if(isset($_POST["queryStartDate"]))
{
	$queryStartDate = $_POST["queryStartDate"];
	$queryEndDate = $_POST["queryEndDate"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Damage</h3>
	<form action="damage_by_time.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Start Date:</td>
			<td><input type="date" name="queryStartDate" value="<?php echo ''.(is_null($queryStartDate)? date('Y-m-d') : $queryStartDate); ?>" /></td>
			
			<td>End Date:</td>
			<td><input type="date" name="queryEndDate" value="<?php echo ''.(is_null($queryEndDate)? date('Y-m-d') : $queryEndDate); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryStartDate)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT * 
					FROM `DAMAGE` AS D 
					WHERE D.start_date >= ? AND 
						  D.end_date <= ?";
			$result = $db->preparedQuery($sql, "ss", array($queryStartDate, $queryEndDate));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 4;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Damage Name</th>
				<th>Start Date</th>
				<th>End Date</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['name']; ?></td>
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
			var resultArrJSHeaders = ["Damage ID", "Damage Name", "Start Date", "End Date"];
			var filename = "damageByTime";
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
