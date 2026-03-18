<?php
/**
 * Product Detail Handler
 * GET: ?id=N
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Product.php';

$productModel = new Product();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $productModel->getDetail($id);

if (!$product) {
    setFlash('error', 'Product not found.');
    redirect('/products.php');
}

$relatedProducts = $productModel->getRelated($product['id'], $product['category_id'], 4);

$pageTitle = $product['name'];
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/product_detail.php';
require BASE_PATH . '/views/layout/footer.php';
