<?php
    $pageTitle = "PORTAL";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
    $navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
    require_once("database.php");

    if (!isset($_SESSION["logged_in"])) header("Location: login.php");
?>

<!-- DYNAMIC PAGE CONTENT -->
<!-- EXAMPLE USAGE -->
<?php if (isset($_SESSION["admin"])) : ?>
    <div class="container">
        <a class="btn btn-danger btn-lg btn-block" href="damage_by_time.php">DAMAGE BY TIME</a>
		<a class="btn btn-danger btn-lg btn-block" href="damage_by_symptom.php">DAMAGE BY SYMPTOM</a>
		<a class="btn btn-danger btn-lg btn-block" href="frequency_of_damage.php">FREQUENCY OF DAMAGE</a>
		<a class="btn btn-danger btn-lg btn-block" href="remedy_by_damage.php">REMEDY BY DAMAGE</a>
		<a class="btn btn-danger btn-lg btn-block" href="farms_by_name.php">FARMS BY NAME</a>
		<a class="btn btn-danger btn-lg btn-block" href="farms_by_id.php">FARMS BY ID</a>
		<a class="btn btn-danger btn-lg btn-block" href="neighbors_by_farm_id.php">NEIGHBORS BY FARM ID</a>
		<a class="btn btn-danger btn-lg btn-block" href="neighbors_by_farm_and_growing_year.php">NEIGHBORS BY FARM AND GROWING YEAR</a>
		<a class="btn btn-danger btn-lg btn-block" href="neighbors_by_farm_and_damage_name.php">NEIGHBORS BY FARM AND DAMAGE NAME</a>
		<a class="btn btn-danger btn-lg btn-block" href="neighbors_by_farm_and_remedy_name.php">NEIGHBORS BY FARM AND REMEDY NAME</a>
		<a class="btn btn-danger btn-lg btn-block" href="neighbors_by_damage.php">NEIGHBORS BY DAMAGE</a>
		<a class="btn btn-danger btn-lg btn-block" href="farm_output_by_damage_id.php">FARM OUTPUT BY DAMAGE</a>
		<a class="btn btn-danger btn-lg btn-block" href="farm_output_by_supplier_name.php">FARM OUTPUT BY SUPPLIER NAME</a>
		<a class="btn btn-danger btn-lg btn-block" href="farm_output_by_supplier_id.php">FARM OUTPUT BY SUPPLIER ID</a>
		<a class="btn btn-danger btn-lg btn-block" href="source_of_output.php">SOURCE OF OUTPUT</a>
		<a class="btn btn-danger btn-lg btn-block" href="supplier_by_id.php">SUPPLIER BY ID</a>
		<a class="btn btn-danger btn-lg btn-block" href="insurance_company_by_name.php">INSURANCE COMPANY BY NAME</a>
		<a class="btn btn-danger btn-lg btn-block" href="insurance_company_by_id.php">INSURANCE COMPANY BY ID</a>
		<a class="btn btn-danger btn-lg btn-block" href="market_entity_by_output_id.php">MARKET ENTITY BY OUTPUT ID</a>
    </div>
<?php else : ?>
    <div class="container">
        <a class="btn btn-danger btn-lg btn-block disabled" href="#">DAMAGE STUFF</a>
    </div>
<?php endif; ?>


<?php
    require_once("footer.php");
?>