<?php
session_start();

// Laden von Produktdaten aus einer JSON-Datei
$jsonData = file_get_contents("products.json");
if ($jsonData === false) {
    die("Fehler beim Laden der Produktdaten.");
}
$products = json_decode($jsonData, true);
if ($products === null) {
    die("Fehler beim Dekodieren der JSON-Daten.");
}

// Verarbeitung des Hinzufügens eines Produkts zum Warenkorb bei Erhalt einer POST-Anfrage
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        ];
        echo "Produkt wurde erfolgreich zum Warenkorb hinzugefügt.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktdetails</title>
</head>
<body>
    <?php require_once("login.php"); ?>
    <h1>Onlineshop - Produktdetails</h1>
    <?php require_once("templates/navigation.php"); ?>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $productFound = false;
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                $productFound = true;
                echo "<div>";
                echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";
                echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                if (isset($product['image'])) {
                    echo "<img src='" . htmlspecialchars($product['image']) . "' width='400' alt='" . htmlspecialchars($product['name']) . "'>";
                }
                echo "<p>Preis: €" . number_format($product['price'], 2) . "</p>";
                if (isset($_SESSION['eingeloggt'])) {
                    echo "<form action='produkt_detail.php?id=" . $product['id'] . "' method='POST'>";
                    echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
                    echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($product['name']) . "'>";
                    echo "<input type='hidden' name='product_price' value='" . $product['price'] . "'>";
                    echo "<button name='add_product' type='submit'>In den Warenkorb</button>";
                    echo "</form>";
                }
                echo "</div>";
                break;
            }
        }
        if (!$productFound) {
            echo "<p>Produkt nicht gefunden.</p>";
        }
    } else {
        echo "<p>Keine Produkt-ID angegeben.</p>";
    }
    ?>

    <?php require_once("templates/footer.php"); ?>
</body>
</html>
