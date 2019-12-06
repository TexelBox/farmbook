<?php
    $pageTitle = "FARMHUB";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
    require_once("database.php");

    if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["farmer"])) header("Location: login.php");
    
    $db = new Database();
    $user_id = $_SESSION["user_id"];
    $result_fetch_farm_id = $db->preparedQuery("SELECT FARM.farm_id FROM USER_FARMS, FARM WHERE (USER_FARMS.user_id = ?) AND (USER_FARMS.farm_id = FARM.farm_id)", "i", array($user_id));
    // fetch the single (for now) farm_id belonging to this User who manages this farm
    $result_fetch_farm_id_row = $result_fetch_farm_id->fetch_assoc();
    $farm_id = $result_fetch_farm_id_row["farm_id"];
?>

<div class="container">
    <hr />
    <h3>GENERAL FARM INFO</h3>

    <?php
        $result_farm_info = $db->preparedQuery("SELECT * FROM FARM WHERE farm_id = ?", "i", array($farm_id));
        $result_farm_info_row = $result_farm_info->fetch_assoc();
    ?>

    <table id="table_farmhub_info" class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>LONGITUDE ([-180.0, 180.0])</th>
                <th>LATITUDE ([-90.0, 90.0])</th>
                <th>NAME (alpha-numeric)</th>
                <th>ACRES (>0)</th>
            </tr>
        </thead>
        <tbody>
            <!--tr id="--><!--?php echo $result_farm_info_row["farm_id"]; ?>"-->
            <tr>
                <td><?php echo is_null($result_farm_info_row["farm_id"]) ? "" : $result_farm_info_row["farm_id"]; ?></td>
                <td><?php echo is_null($result_farm_info_row["longitude"]) ? "" : $result_farm_info_row["longitude"]; ?></td>
                <td><?php echo is_null($result_farm_info_row["latitude"]) ? "" : $result_farm_info_row["latitude"]; ?></td>
                <td><?php echo is_null($result_farm_info_row["name"]) ? "" : $result_farm_info_row["name"]; ?></td>
                <td><?php echo is_null($result_farm_info_row["acres"]) ? "" : $result_farm_info_row["acres"]; ?></td>
            </tr>
        </tbody>
    </table>

    <hr />
    <h3>LIVESTOCK</h3>
    <hr />
    <h3>CROPS</h3>
    <hr />
    <h3>SUPPLY HISTORY</h3>
    <hr />
    <h3>SALE HISTORY</h3>
    <hr />
</div>

<?php
    require_once("footer.php");
?>