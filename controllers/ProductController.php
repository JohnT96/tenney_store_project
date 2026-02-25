<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $product;

    public function __construct($conn)
    {
        $this->product = new Product($conn);
    }

    public function list()
    {
        return $this->product->getAll();
    }

    public function add($post)
    {
        $name = trim($post['product_name'] ?? '');
        $desc = trim($post['product_description'] ?? '');
        $price = trim($post['product_price'] ?? '');

        $errors = [];
        if ($name === '' || $price === '') {
            $errors[] = "Product name and price are required.";
        } elseif (!is_numeric($price) || (float)$price < 0) {
            $errors[] = "Price must be a valid non-negative number.";
        }

        if ($errors) {
            return ['ok' => false, 'errors' => $errors, 'data' => ['product_name' => $name, 'product_description' => $desc, 'product_price' => $price]];
        }

        $this->product->create($name, $desc, (float)$price);
        return ['ok' => true];
    }

    public function edit($id, $post)
    {
        $name = trim($post['product_name'] ?? '');
        $desc = trim($post['product_description'] ?? '');
        $price = trim($post['product_price'] ?? '');

        $errors = [];
        if ($name === '' || $price === '') {
            $errors[] = "Product name and price are required.";
        } elseif (!is_numeric($price) || (float)$price < 0) {
            $errors[] = "Price must be a valid non-negative number.";
        }

        if ($errors) {
            return ['ok' => false, 'errors' => $errors, 'data' => ['product_id' => $id, 'product_name' => $name, 'product_description' => $desc, 'product_price' => $price]];
        }

        $this->product->update($id, $name, $desc, (float)$price);
        return ['ok' => true];
    }

    public function delete($id)
    {
        $this->product->delete($id);
    }

    public function getById($id)
    {
        return $this->product->getById($id);
    }
}
