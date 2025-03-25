<?php
session_start();


function removeProduct($product_id) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['remove_product']) && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        removeProduct($product_id);
        header("Location: warenkorb.php");
        exit;
    }
    if (isset($_POST['decrease_quantity']) && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => &$item) {
                if ($item['id'] == $product_id) {
                    $item['quantity']--;
                    if ($item['quantity'] <= 0) {
                        
                        removeProduct($product_id);
                    }
                    break;
                }
            }
        }
        header("Location: warenkorb.php");
        exit;
    }
    if (isset($_POST['increase_quantity']) && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => &$item) {
                if ($item['id'] == $product_id) {
                    $item['quantity']++;
                    break;
                }
            }
        }
        header("Location: warenkorb.php");
        exit;
    }
    if (isset($_POST['clear_cart'])) {
        unset($_SESSION['cart']);
        header("Location: warenkorb.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <?php require_once("login.php"); ?>
    <h1>Onlineshop - Warenkorb</h1>
    <?php require_once("templates/navigation.php"); ?>
</header>

    <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            echo "<h1>Warenkorb von " . $_SESSION['username'] . "</h1>";
            echo "<ul>";
            $total_cost = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total_cost += $subtotal;
                echo "<li>";
                echo "Produkt: " . htmlspecialchars($item['name']) . " - Preis: " . number_format($item['price'], 2) . " € - Anzahl: " . $item['quantity'] . " - Zwischensumme: " . number_format($subtotal, 2) . " €";
                ?>
                <form action="warenkorb.php" method="POST" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                    <button type="submit" name="increase_quantity">+</button>
                    <button type="submit" name="decrease_quantity">-</button>
                    <button type="submit" name="remove_product">Entfernen</button>
                </form>
                <?php
                echo "</li>";
            }
            echo "</ul>";
            echo "<p>Gesamtkosten: " . number_format($total_cost, 2) . " €</p>";
            ?>
            <form action="warenkorb.php" method="POST">
                <button type="submit" name="clear_cart">Warenkorb leeren</button>
            </form>
            <?php
        } else {
            echo "<p>Ihr Warenkorb ist leer.</p>";
        }
    ?>

    <?php require_once("templates/footer.php"); ?>
</body>
</html>
