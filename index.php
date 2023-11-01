<?php
$xml = simplexml_load_file('busses_data.xml');

$xslt = new XSLTProcessor;
$xsl = new DOMDocument;
$xsl->load('busses_template.xsl');
$xslt->importStylesheet($xsl);

if (isset($_GET['sort'])) {
    $sortField = $_GET['sort'];
    $xml = sortXML($xml, $sortField);
}

if (isset($_GET['search'])) {
    $searchField = $_GET['search'];
    $xml = searchXML($xml, $searchField);
}

$html = $xslt->transformToXML($xml);

echo $html;

function sortXML($xml, $sortField) {
    $sortedXML = $xml->xpath('//buss');
    usort($sortedXML, function($a, $b) use ($sortField) {
        return strnatcmp($a->$sortField, $b->$sortField);
    });

    $sortedXml = new SimpleXMLElement('<bussid></bussid>');
    foreach ($sortedXML as $node) {
        $sortedXml->addChild('buss', $node->asXML());
    }

    return $sortedXml;
}

function searchXML($xml, $searchField) {
    $filteredXML = new SimpleXMLElement('<bussid></bussid>');
    foreach ($xml->xpath('//buss') as $node) {
        foreach ($node->children() as $child) {
            if (stristr($child, $searchField) !== false) {
                $filteredXML->addChild('buss', $node->asXML());
                break;
            }
        }
    }

    return $filteredXML;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marsruut = $_POST['marsruut'];
    $lähtepunkt = $_POST['lähtepunkt'];
    $sihtpunkt = $_POST['sihtpunkt'];
    $väljumisaeg = $_POST['väljumisaeg'];

    $xml = simplexml_load_file('busses_data.xml');

    $newBuss = $xml->addChild('buss');
    $newBuss->addAttribute('marsruut', $marsruut);

    $newBuss->addChild('lähtepunkt', $lähtepunkt);
    $newBuss->addChild('sihtpunkt', $sihtpunkt);
    $newBuss->addChild('väljumisaeg', $väljumisaeg);

    $xml->asXML('busses_data.xml');

    echo "Andmete lisamine õnnestus";
    header('Location: index.php');
} 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bussijaama haldussüsteem</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Andmete lisamine</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="marsruut">Marsruut:</label>
                <input type="text" name="marsruut" id="marsruut" required>
            </div>

            <div class="form-group">
                <label for="lähtepunkt">Lähtepunkt:</label>
                <input type="text" name="lähtepunkt" id="lähtepunkt" required>
            </div>

            <div class="form-group">
                <label for="sihtpunkt">Sihtpunkt:</label>
                <input type="text" name="sihtpunkt" id="sihtpunkt" required>
            </div>

            <div class="form-group">
                <label for="väljumisaeg">Väljumisaeg:</label>
                <input type="datetime-local" name="väljumisaeg" id="väljumisaeg" required>
            </div>

            <input type="submit" value="Lisa">
        </form>
    </div>
</body>
</html>



<script>
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
</script>

