<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController($conn);

$action = $_GET['action'] ?? 'list';

switch ($action) {

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->add($_POST);
            if ($result['ok']) {
                header("Location: index.php");
                exit;
            }
            $errors = $result['errors'];
            $product = $result['data'];
        } else {
            $errors = [];
            $product = ['product_name' => '', 'product_description' => '', 'product_price' => ''];
        }

        $title = "Add Product";
        $mode = "add";
        include __DIR__ . '/../views/header.php';
        include __DIR__ . '/../views/product_form.php';
        include __DIR__ . '/../views/footer.php';
        break;

    case 'edit':
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            die("Invalid product ID.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->edit($id, $_POST);
            if ($result['ok']) {
                header("Location: index.php");
                exit;
            }
            $errors = $result['errors'];
            $product = $result['data'];
        } else {
            $errors = [];
            $product = $controller->getById($id);
            if (!$product) {
                die("Product not found.");
            }
        }

        $title = "Edit Product";
        $mode = "edit";
        include __DIR__ . '/../views/header.php';
        include __DIR__ . '/../views/product_form.php';
        include __DIR__ . '/../views/footer.php';
        break;

    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $controller->delete($id);
        }
        header("Location: index.php");
        exit;

    case 'list':
    default:
        $title = "Catalog";
        $result = $controller->list();

        include __DIR__ . '/../views/header.php';
        include __DIR__ . '/../views/product_list.php';
        include __DIR__ . '/../views/footer.php';
        break;
}
