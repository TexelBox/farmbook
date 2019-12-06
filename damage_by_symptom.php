<?php
	$pageTitle = "Damage by Symptom";
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
        <h1>Damage by Symptom</h1>
		<p>Look for instances of farm damage with a specified symptom.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$querySymptomID = NULL;
$querySymptomDesc = NULL;

if(isset($_POST["querySymptomID"]))
{
	$querySymptomID = $_POST["querySymptomID"];
	$querySymptomDesc = $_POST["querySymptomDesc"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Damage</h3>
	<form action="damage_by_symptom.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Symptom ID:</td>
			<td><input type="text" name="querySymptomID" value="<?php echo ''.(is_null($querySymptomID)? 0 : $querySymptomID); ?>" /></td>
			
			<td>Symptom Description:</td>
			<td><input type="text" name="querySymptomDesc" value="<?php echo ''; ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($querySymptomID)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT D.* 
                    FROM   DAMAGE AS D, SYMPTOM AS S 
                    WHERE  D.damage_id = S.damage_id AND 
                           (S.Symptom_Id = ? OR 
                           S.symptom_description = ?)";
			$result = $db->preparedQuery($sql, "ss", array($querySymptomID, $querySymptomDesc));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 4;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Damage ID</th>
				<th>Damage Name</th>
				<th>Start Date</th>
				<th>End Date</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['damage_id']; ?></td>
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
