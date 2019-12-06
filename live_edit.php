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
            if(isset($input["longitude"])) {
                // validate...
                if (is_numeric($input["longitude"]) && -180.0 <= $input["longitude"] && $input["longitude"] <= 180.0) {
                    $updated_field_name = "longitude";
                    $updated_field_data = $input["longitude"];
                    $types = "d";
                }
            } else if(isset($input["latitude"])) {
                // validate...
                if (is_numeric($input["latitude"]) && -90.0 <= $input["latitude"] && $input["latitude"] <= 90.0) {
                    $updated_field_name = "latitude";
                    $updated_field_data = $input["latitude"];
                    $types = "d";
                }
            } else if(isset($input["name"])) {
                // validate...
                if (ctype_alnum($input["name"])) {
                    $updated_field_name = "name";
                    $updated_field_data = $input["name"];
                    $types = "s";
                }
            } else if(isset($input["acres"])) {
                // validate...
                if (ctype_digit($input["acres"]) && 0 < $input["acres"]) {
                    $updated_field_name = "acres";
                    $updated_field_data = $input["acres"];
                    $types = "i";
                }
            }
            
            if (!is_null($updated_field_name) && !is_null($updated_field_data) && !is_null($types) && isset($input["farm_id"])) {
    
                //$preparedQuery = "UPDATE FARM SET ${updated_field_name} = ? WHERE farm_id = ?";
                //$types .= "i";
                //$params = array($updated_field_data, $input["farm_id"]));
                //$db->preparedQuery($preparedQuery, $types, $params);
    
                $sql_query = "UPDATE FARM SET ${updated_field_name} = '${updated_field_data}' WHERE farm_id='" . $input["farm_id"] . "'";
                $db->query($sql_query);
            }
        } else if ($input["action"] === "delete") {
            // no need for this table
        }
    
        echo json_encode($input);
?>