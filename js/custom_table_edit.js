// reference: https://www.phpzag.com/create-live-editable-table-with-jquery-php-and-mysql/
// reference: https://www.webslesson.info/2017/05/live-table-data-edit-delete-using-tabledit-plugin-in-php.html
// reference: https://stackoverflow.com/questions/12343714/typeerror-is-not-a-function-when-calling-jquery-function

jQuery(document).ready(function($){
    $('#table_farmhub_info').Tabledit({
        url: 'live_edit.php?table_name=table_farmhub_info',
        hideIdentifier: true,
        editButton: false,
        deleteButton: false,
        columns: {
            identifier: [0, 'farm_id'],
            editable: [[1, 'longitude'], [2, 'latitude'], [3, 'name'], [4, 'acres']]
        },
        onSuccess:function(data, textStatus, jqXHR){
            if (data.action === "delete"){
                //$('#'+data.farm_id).remove();
            }
        }
    });
});