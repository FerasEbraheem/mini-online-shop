<?php
session_start();

// تحميل بيانات المنتجات من ملف JSON
$jsonData = file_get_contents("products.json");
if ($jsonData === false) {
    die("Fehler beim Laden der Produktdaten.");
}
$products = json_decode($jsonData, true);
if ($products === null) {
    die("Fehler beim Dekodieren der JSON-Daten.");
}

// قراءة قيمة البحث (إن وجدت) وتصفية المنتجات
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
    if ($searchQuery !== "") {
        $filteredProducts = [];
        foreach ($products as $product) {
            // تحقق إذا كان اسم المنتج يحتوي على عبارة البحث (غير حساس لحالة الأحرف)
            if (stripos($product['name'], $searchQuery) !== false) {
                $filteredProducts[] = $product;
            }
        }
        $products = $filteredProducts;
    }
}

// معالجة إضافة المنتج إلى عربة التسوق
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
    <title>Produkte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php require_once("login.php"); ?>
        <h1>Onlineshop - Produkte</h1>
        <?php require_once("templates/navigation.php"); ?>
    </header>

    <!-- نموذج البحث -->
    <form action="produkte.php" method="get" style="margin: 30px 0;">
        <input type="text" name="search" placeholder="Produkt suchen..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Suchen </button>
        

    </form>

    <!-- حاوية لجميع المنتجات -->
    <div class="product-container">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <h2>
                    <a href="produkt_detail.php?id=<?php echo $product['id']; ?>">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </a>
                </h2>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <?php if (isset($product['image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" width="200" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php endif; ?>
                <p>Preis: €<?php echo number_format($product['price'], 2); ?></p>
                <?php if (isset($_SESSION['eingeloggt'])): ?>
                    <form action="produkte.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <button name="add_product" type="submit">In den Warenkorb</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php require_once("templates/footer.php"); ?>
</body>
</html>
