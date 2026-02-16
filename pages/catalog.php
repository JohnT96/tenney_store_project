<?php
session_start();
require_once "../includes/db_connect.php";

$sql = "SELECT product_id, product_name, product_description, product_price FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html> 
<head>
    <title>Catalog</title>
</head>
<body>

<h1>Catalog Page</h1>
<p><a href="add_product.php">Add a Product</a></p>
<hr>
<?php if ($result && $result->num_rows > 0): ?>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['product_name']); ?></strong><br>
                <?php echo htmlspecialchars($row['product_description']); ?><br>
                $<?php echo number_format((float)$row['product_price'], 2); ?><br>

                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"
                    onclick="return confirm('Are you sure you want to delete this product?');">
                    Delete
                </a>

                <br>

                <a href="edit_product.php?id=<?php echo$row['product_id']; ?>">
                Edit
            </a>
            </li>
            <hr>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<a href="../index.php">Back to home</a>

</body>
</html>
