<?php
session_start();
require_once __DIR__ . "/../includes/db_connect.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["product_name"] ?? "");
    $desc = trim($_POST["product_description"] ?? "");
    $price = trim($_POST["product_price"] ?? "");

    // Basic validation
    if ($name === "" || $price === "") {
        $error = "Product name and price are required.";
    } elseif (!is_numeric($price) || (float)$price < 0) {
        $error = "Price must be a valid non-negative number.";
    } else {
        // Prepared statement = safe insert
        $stmt = $conn->prepare(
            "INSERT INTO products (product_name, product_description, product_price) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ssd", $name, $desc, $price);

        $stmt->execute();
        $stmt->close();

        $success = "Product added successfully!";
        // Clear fields after success
        $name = $desc = $price = "";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>

<h1>Add Product</h1>

<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label>Product Name:</label><br>
    <input type="text" name="product_name" value="<?php echo htmlspecialchars($name ?? ""); ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="product_description" rows="4" cols="40"><?php echo htmlspecialchars($desc ?? ""); ?></textarea><br><br>

    <label>Price:</label><br>
    <input type="text" name="product_price" value="<?php echo htmlspecialchars($price ?? ""); ?>"><br><br>

    <button type="submit">Add Product</button>
</form>

<br>
<a href="catalog.php">Back to Catalog</a> |
<a href="../index.php">Back to Home</a>

</body>
</html>