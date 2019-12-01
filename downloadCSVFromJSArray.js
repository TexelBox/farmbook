/**
 * Uses the given JS array and 1D JS array header to download 
 * a CSV file from the given JS array.
 * filename does not have .csv
 * Uses comma "," delimiters
 *
 * Download is done by creating an invisible link and then clicking it
 */
function downloadCSVFromArray(array, arrayHeader, filename)
{
	//file content will be written as text
	let fileTable = "data:text/csv;charset=utf-8,";

	//Write each comma seperated row to the file table content
	//E.g.		   [["1", "Frost", "2019-09-02", "2019-10-14"]]
	//converted into "1, Frost, 2019-09-02, 2019-10-14\n"
	for(i = 0; i < arrayHeader.length; i++)
		fileTable += arrayHeader[i] + ", ";
	fileTable += "\n";

	
	for(i = 0; i < array.length; i++)
	{
		for(j = 0; j < arrayHeader.length; j++)
			fileTable += String(array[i][j]) + ", ";
		fileTable += "\n";
	}

	//Create invisible <a> download link and click it
	var downloadLink = document.createElement("a");
	downloadLink.href = fileTable;
	downloadLink.download = filename + ".csv";
				
	downloadLink.click();
}