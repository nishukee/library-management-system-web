function exportData(){
    var table = document.getElementById("members_table");
    var rows = [];
    for(var i=0,row; row = table.rows[i];i++){
        column1 = row.cells[0].innerText;
        column2 = row.cells[1].innerText;
        column3 = row.cells[2].innerText;
        column4 = row.cells[3].innerText;
        column5 = row.cells[4].innerText;
        rows.push(
            [
                column1,
                column2,
                column3,
                column4,
                column5,
            ]
        );
    }
    csvContent = "data:text/csv;charset=utf-8,";
    rows.forEach(function(rowArray){
        row = rowArray.join(",");
        csvContent += row + "\r\n"; 
    });

    var enodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href",enodedUri);
    link.setAttribute("download", "Members_Table.csv");
    document.body.appendChild(link);
    link.click();
}