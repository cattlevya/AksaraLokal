<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Cart.php';
require_once BASE_PATH . '/classes/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add':
            $productId = (int)($_POST['product_id'] ?? 0);
            $quantity  = max(1, (int)($_POST['quantity'] ?? 1));
            
            $productModel = new Product();
            $product = $productModel->findById($productId);
            
            if (!$product || !$product['is_active']) {
                echo json_encode(['success' => false, 'message' => 'Product not found.']);
                exit;
            }
            if ($product['stock'] < $quantity) {
                echo json_encode(['success' => false, 'message' => 'Insufficient stock.']);
                exit;
            }

            
            $price = ($product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time())
                ? $product['flash_sale_price']
                : $product['price'];

            Cart::add($productId, $product['name'], $price, $quantity, $product['image']);
            echo json_encode(['success' => true, 'cart_count' => Cart::getCount()]);
            exit;

        case 'update':
            $productId = (int)($_POST['product_id'] ?? 0);
            $quantity  = (int)($_POST['quantity'] ?? 0);
            Cart::updateQty($productId, $quantity);
            echo json_encode(['success' => true, 'cart_count' => Cart::getCount()]);
            exit;

        case 'remove':
            $productId = (int)($_POST['product_id'] ?? 0);
            Cart::remove($productId);
            echo json_encode(['success' => true, 'cart_count' => Cart::getCount()]);
            exit;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            exit;
    }
}

$cartItems = Cart::getItems();
$subtotal  = Cart::getSubtotal();

$pageTitle = 'Your Cart';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/cart.php';
require BASE_PATH . '/views/layout/footer.php';
