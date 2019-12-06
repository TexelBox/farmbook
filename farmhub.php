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

    if (isset($_POST["submitLivestock"])) {
        $livestockTag = $_POST["livestockTag"];
        $livestockSpecies = $_POST["livestockSpecies"];
        $livestockFeedType = $_POST["livestockFeedType"];
        $livestockLifespan = $_POST["livestockLifespan"];

        // validate...
        if (!empty($livestockTag) || !empty($livestockSpecies) || !empty($livestockFeedType) || !empty($livestockLifespan)) {
            // get here if we have at least 1 non-empty field enetered...
            if (empty($livestockTag)) $livestockTag = NULL;
            if (empty($livestockSpecies)) $livestockSpecies = NULL;
            if (empty($livestockFeedType)) $livestockFeedType = NULL; 
            if (empty($livestockLifespan)) $livestockLifespan = NULL;

            $invalidFormat = false;
            if (!is_null($livestockTag) && !(ctype_digit($livestockTag) && 0 < $livestockTag)) $invalidFormat = true;
            if (!is_null($livestockSpecies) && !(ctype_alnum($livestockSpecies))) $invalidFormat = true;
            if (!is_null($livestockFeedType) && !(ctype_alnum($livestockFeedType))) $invalidFormat = true;
            if (!is_null($livestockLifespan) && !(ctype_digit($livestockLifespan) && 0 < $livestockLifespan && $livestockLifespan <= 100)) $invalidFormat = true;

            if (!$invalidFormat) {

                // add to parent table first
                $sql = "INSERT INTO FARM_OUTPUT (output_id, lifespan) VALUES (NULL, ?)";
                $db->preparedQuery($sql, "i", array($livestockLifespan));
                $livestockID = $db->getLastInsertID();

                // add to child table...
                $sql = "INSERT INTO LIVESTOCK (output_id, tag, species, farm_id, feed_type, mother_id, father_id) VALUES (${livestockID}, ?, ?, ${farm_id}, ?, NULL, NULL)";
                $result = $db->preparedQuery($sql, "iss", array($livestockTag, $livestockSpecies, $livestockFeedType));
            }
        }
    }
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

    <table id="table_farmhub_livestock" class="table table-light table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>TAG (>0)</th>
                <th>SPECIES (alpha-numeric)</th>
                <th>FEED TYPE (alpha-numeric)</th>
                <th>LIFESPAN (years 1-100)</th>
            </tr>
        </thead>
        <tbody>
    <?php
        $result_livestock = $db->preparedQuery("SELECT * FROM FARM_OUTPUT, LIVESTOCK WHERE (FARM_OUTPUT.output_id = LIVESTOCK.output_id) AND (LIVESTOCK.farm_id = ?)", "i", array($farm_id));
        while ($result_livestock_row = $result_livestock->fetch_assoc()) {
    ?>
            <tr>
                <td><?php echo is_null($result_livestock_row["output_id"]) ? "" : $result_livestock_row["output_id"]; ?></td>
                <td><?php echo is_null($result_livestock_row["tag"]) ? "" : $result_livestock_row["tag"]; ?></td>
                <td><?php echo is_null($result_livestock_row["species"]) ? "" : $result_livestock_row["species"]; ?></td>
                <td><?php echo is_null($result_livestock_row["feed_type"]) ? "" : $result_livestock_row["feed_type"]; ?></td>
                <td><?php echo is_null($result_livestock_row["lifespan"]) ? "" : $result_livestock_row["lifespan"]; ?></td>
            </tr>
    <?php } ?>
        </tbody>
    </table>

    <form action="" method="post">
        <table class="table table-light table-striped table-bordered table-hover">
            <tr>
                <td><input type="text" name="livestockTag" placeholder="Tag" /></td>
                <td><input type="text" name="livestockSpecies" placeholder="Species" /></td>
                <td><input type="text" name="livestockFeedType" placeholder="Feed Type" /></td>
                <td><input type="text" name="livestockLifespan" placeholder="Lifespan" /></td>
                <td><button class="btn btn-primary" type="submit" name=submitLivestock>ADD</button></td>
            </tr>
        </table>
    </form>

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