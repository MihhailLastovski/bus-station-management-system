<?php
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

        $xml = simplexml_load_file('src/data/busses_data.xml');

        $newBuss = $xml->addChild('buss');
        $newBuss->addAttribute('marsruut', $marsruut);

        $newBuss->addChild('lähtepunkt', $lähtepunkt);
        $newBuss->addChild('sihtpunkt', $sihtpunkt);
        $newBuss->addChild('väljumisaeg', $väljumisaeg);

        $xml->asXML('src/data/busses_data.xml');

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
    <link rel="stylesheet" type="text/css" href="src/style/style.css">
    <script src="src/js/script.js"></script> 
</head>
<body>
    <header><h1>Bussijaama haldussüsteem</h1></header>

    <?php
    $xml = simplexml_load_file('src/data/busses_data.xml');

    $xslt = new XSLTProcessor;
    $xsl = new DOMDocument;
    $xsl->load('src/template/busses_template.xsl');
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
    ?>
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
    <footer>
            <p>&copy; <script>document.write(new Date().getFullYear())</script> Mihhail Lastovski</p>
    </footer>
</body>
</html>

