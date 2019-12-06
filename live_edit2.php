<!-- reference: https://www.phpzag.com/create-live-editable-table-with-jquery-php-and-mysql/ -->
<!-- reference: https://www.webslesson.info/2017/05/live-table-data-edit-delete-using-tabledit-plugin-in-php.html -->

<?php
    require_once("database.php");
    $db = new Database();
    $input = filter_input_array(INPUT_POST);

        if ($input["action"] === "edit") {
            $updated_field_name = NULL;
            $updated_field_data = NULL;
            $types = NULL; // s, i, d, or b
            $updatingFarmOutputTable = false;
            if(isset($input["tag"])) {
                // validate...
                if (ctype_digit($input["tag"]) && 0 < $input["tag"]) {
                    $updated_field_name = "tag";
                    $updated_field_data = $input["tag"];
                    $types = "i";
                }
            } else if(isset($input["species"])) {
                // validate...
                if (ctype_alnum($input["species"])) {
                    $updated_field_name = "species";
                    $updated_field_data = $input["species"];
                    $types = "s";
                }
            } else if(isset($input["feed_type"])) {
                // validate...
                if (ctype_alnum($input["feed_type"])) {
                    $updated_field_name = "feed_type";
                    $updated_field_data = $input["feed_type"];
                    $types = "s";
                }
            } else if(isset($input["lifespan"])) {
                // validate...
                if (ctype_digit($input["lifespan"]) && 0 < $input["lifespan"] && $input["lifespan"] <= 100) {
                    $updated_field_name = "lifespan";
                    $updated_field_data = $input["lifespan"];
                    $types = "i";
                    $updatingFarmOutputTable = true;
                }
            }
            
            if (!is_null($updated_field_name) && !is_null($updated_field_data) && !is_null($types) && isset($input["output_id"])) {
    
                if ($updatingFarmOutputTable) {
                    $sql_query = "UPDATE FARM_OUTPUT SET ${updated_field_name} = '${updated_field_data}' WHERE output_id='" . $input["output_id"] . "'";
                    $db->query($sql_query);
                } else {
                    $sql_query = "UPDATE LIVESTOCK SET ${updated_field_name} = '${updated_field_data}' WHERE output_id='" . $input["output_id"] . "'";
                    $db->query($sql_query);
                }
            }
        } else if ($input["action"] === "delete") {
            // TODO...
        }
    
        echo json_encode($input);
?>