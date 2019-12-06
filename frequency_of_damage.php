<?php
	$pageTitle = "Frequency of Damage Types";
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
										   !isset($_SESSION["farmer"]))) header("Location: login.php");?>

<div class="container">
    <section id="main">
        <h1>Frequency of Damage Types</h1>
		<p>Look for the number of  occurances of a specified damage type.</p>
    </section>
</div>

<!--Load Search Criteria or Assign them NULL values-->
<?php
$queryDamageId = NULL;

if(isset($_POST["queryDamageId"]))
{
	$queryDamageId = $_POST["queryDamageId"];
}
?>

<div class="container">
	<!--Forms for Search Criteria-->
	<h3>Search for Damage Frequencies</h3>
	<form action="frequency_of_damage.php" method="POST">
	<table id="searchTable">
		<tr>
			<td>Damage ID:</td>
			<td><input type="number" name="queryDamageId" value="<?php echo ''.(is_null($queryDamageId)? '0' : $queryDamageId); ?>" /></td>
		</tr>
	</table>
	
	<div id="centeredDiv">
		<input type="submit" value="Search"/>
	</div>
	</form>
	
	<!--Search Function gets query in $result if search criteria are submitted-->
	<?php if(!is_null($queryDamageId)): ?>
		<!--Retrieve and Store Query Result-->
		<?php		
			$db = new Database();		
			$sql = "SELECT D.name, COUNT(*) AS occurances
					FROM DAMAGE AS D
					WHERE D.name IN (SELECT D2.name FROM DAMAGE AS D2 WHERE D2.damage_id = ?)
					GROUP BY D.name";
			$result = $db->preparedQuery($sql, "i", array($queryDamageId));
			
			$resultArr = array();
			while($row = $result->fetch_array()){ $resultArr[] = $row; }
			$resultArrLen = count($resultArr);
			$resultArrWidth = 2;
			$i = 0;
		?>
		
		<!--Table to Display Query Results-->
		<table id = "resultTable">
			<tr>
				<th>Damage Name</th>
				<th>Occurances</th>
			</tr>
			<?php while($i < $resultArrLen): ?>
			<tr>
				<td><?php echo $resultArr[$i]['name']; ?></td>
				<td><?php echo $resultArr[$i]['occurances']; ?></td>
			</tr>
			<?php $i++; endwhile; ?>
		</table>
		
		<!--Functionality to Download Result Table as CSV in JS-->
		<script src="downloadCSVFromJSArray.js"></script>
		<script type="text/javascript">
			//Convert php array to JS array
			var resultArrJS = <?php echo json_encode($resultArr); ?> ;
			var resultArrJSHeaders = ["Damage Name", "Occurances"];
			var filename = "frequencyOfDamage";
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
