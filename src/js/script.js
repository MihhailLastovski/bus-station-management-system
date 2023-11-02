let sortDirection = 1;
    let dir = "asc"; 

    function sortTable(columnIndex, columnName) {
        let table, rows, switching, i, x, y, shouldSwitch, sortIcon;
        table = document.querySelector(".buss-table");
        switching = true;
        sortIcon = document.getElementById(columnName + "SortIcon");

        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];
                let xValue = x.textContent.toLowerCase();
                let yValue = y.textContent.toLowerCase();
                if (sortDirection === 1) 
                {
                    if (xValue > yValue) 
                    {
                        shouldSwitch = true;
                        break;
                    }
                } 
                else
                {
                    if (xValue < yValue) 
                    {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
        sortDirection = (sortDirection === 1) ? -1 : 1;
        if (dir === "asc") 
        {
            dir = "desc";
            sortIcon.innerHTML = "&#9650;"; 
            console.log("sort up")
        } 
        else if (dir = "desc")
        {
            dir = "asc";
            sortIcon.innerHTML = "&#9660;"; 
            console.log("sort down")

        }
    }

    function searchTable() {
        let input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector("table");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            let found = false;
            for (j = 0; j < 4; j++) { 
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
                }
            }
            if (found) {
                tr[i].style.display = "";
            } 
            else {
                tr[i].style.display = "none";
            }
        }
    }