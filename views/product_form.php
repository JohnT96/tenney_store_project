<?php if (!empty($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form method="POST">

    <label>Product Name:</label><br>
    <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name'] ?? ''); ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="product_description" rows="4" cols="40"><?php
                                                            echo htmlspecialchars($product['product_description'] ?? '');
                                                            ?></textarea><br><br>

    <label>Price:</label><br>
    <input type="text" name="product_price" value="<?php echo htmlspecialchars($product['product_price'] ?? ''); ?>"><br><br>

    <button type="submit">
        <?php echo ($mode === "edit") ? "Update Product" : "Add Product"; ?>
    </button>

</form>