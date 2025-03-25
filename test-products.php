<?php
// JSON-Datei laden
$jsonData = file_get_contents("products.json");

// Überprüfen, ob das Laden der Datei erfolgreich war
if ($jsonData === false) {
    die("Fehler beim Laden der Produktdaten.");
}

// JSON in ein PHP-Array umwandeln
$products = json_decode($jsonData, true);

// Überprüfen, ob die Umwandlung erfolgreich war
if ($products === null) {
    die("Fehler beim Dekodieren der JSON-Daten.");
}

// Produkte auf der Seite anzeigen
echo "<h1>Produkte</h1>";
echo "<ul>";
foreach ($products as $product) {
    echo "<li>";
    echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
    echo "<p>Preis: €" . number_format($product['price'], 2) . "</p>";
    echo "<p>" . htmlspecialchars($product['description']) . "</p>";
    // Produktbild anzeigen, falls vorhanden
    if (isset($product['image'])) {
        echo "<img src='" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "' width='200'/>";
    }
    echo "</li>";
}
echo "</ul>";
?>
