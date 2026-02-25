<?php
session_start();
require_once __DIR__ . "/../includes/db_connect.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = (int)$_GET['id'];

// Fetch existing product
$stmt = $conn->prepare("SELECT product_name, product_description, product_price FROM products WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $description, $price);

if (!$stmt->fetch()) {
    die("Product not found.");
}
$stmt->close();

$error = "";
$success = "";

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['product_name']);
    $description = trim($_POST['product_description']);
    $price = trim($_POST['product_price']);

    if ($name === "" || $price === "") {
        $error = "Product name and price are required.";
    } elseif (!is_numeric($price) || (float)$price < 0) {
        $error = "Price must be a valid non-negative number.";
    } else {
        $updateStmt = $conn->prepare("UPDATE products SET product_name = ?, product_description = ?, product_price = ? WHERE product_id = ?");
        $updateStmt->bind_param("ssdi", $name, $description, $price, $id);
        $updateStmt->execute();
        $updateStmt->close();

        $success = "Product updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Product Name:</label><br>
    <input type="text" name="product_name" value="<?php echo htmlspecialchars($name); ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="product_description" rows="4" cols="40"><?php echo htmlspecialchars($description); ?></textarea><br><br>

    <label>Price:</label><br>
    <input type="text" name="product_price" value="<?php echo htmlspecialchars($price); ?>"><br><br>

    <button type="submit">Update Product</button>
</form>

<br>
<a href="catalog.php">Back to Catalog</a> |
<a href="../index.php">Back to Home</a>

</body>
</html>