<?php if ($result && $result->num_rows > 0) : ?>
    <ul>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <li>
                <strong><?php echo htmlspecialchars($row['product_name']); ?></strong><br>
                <?php echo htmlspecialchars($row['product_description']); ?><br>
                $<?php echo number_format((float)$row['product_price'], 2); ?><br>

                <a href="index.php?action=edit&id=<?php echo $row['product_id']; ?>">
                    Edit
                </a>

                |

                <a href="index.php?action=delete&id=<?php echo $row['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                    Delete
                </a>
            </li>
            <hr>
        <?php endwhile; ?>
    </ul>
<?php else : ?>
    <p>No products found.</p>
<?php endif; ?>

<p><a href="index.php?action=add">Add Product</a></p>