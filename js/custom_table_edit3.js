// reference: https://www.phpzag.com/create-live-editable-table-with-jquery-php-and-mysql/
// reference: https://www.webslesson.info/2017/05/live-table-data-edit-delete-using-tabledit-plugin-in-php.html
// reference: https://stackoverflow.com/questions/12343714/typeerror-is-not-a-function-when-calling-jquery-function

jQuery(document).ready(function($){
    $('#table_farmhub_crops').Tabledit({
        url: 'live_edit3.php',
        hideIdentifier: true,
        editButton: false,
        deleteButton: true,
        columns: {
            identifier: [0, 'output_id'],
            editable: [[1, 'crop_id'], [2, 'species'], [3, 'variety'], [4, 'lifespan']]
        },
        onSuccess:function(data, textStatus, jqXHR){
            if (data.action === "delete"){
                //$('#'+data.farm_id).remove();
            }
        }
    });
});