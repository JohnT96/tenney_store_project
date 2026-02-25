<?php

class Product
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT product_id, product_name, product_description, product_price FROM products";
        return $this->conn->query($sql);
    }

    public function create($name, $desc, $price)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO products (product_name, product_description, product_price) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ssd", $name, $desc, $price);
        $stmt->execute();
        $stmt->close();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT product_id, product_name, product_description, product_price
FROM products WHERE product_id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $stmt->close();

        return $product;
    }

    public function update($id, $name, $description, $price)
    {
        $stmt = $this->conn->prepare(
            "UPDATE products
SET product_name = ?, product_description = ?, product_price = ?
WHERE product_id = ?"
        );
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
        $stmt->execute();
        $stmt->close();
    }
}
