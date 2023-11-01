<?php
$xml = simplexml_load_file('data.xml');

echo '<table border="1">';
echo '<tr><th>Marsruut</th><th>Lähtepunkt</th><th>Sihtpunkt</th><th>Väljumisaeg</th></tr>';

foreach ($xml->buss as $buss) {
    echo '<tr>';
    echo '<td>' . $buss->attributes()->marsruut . '</td>'; 
    echo '<td>' . $buss->lähtepunkt . '</td>';
    echo '<td>' . $buss->sihtpunkt . '</td>';
    echo '<td>' . $buss->väljumisaeg . '</td>';
    echo '</tr>';
}

echo '</table>';
?>
