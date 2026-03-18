<?php
/**
 * Home Page — Public Entry Point
 * Loads featured products, categories, and renders home view
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Product.php';
require_once BASE_PATH . '/classes/Category.php';

$productModel  = new Product();
$categoryModel = new Category();

$products   = $productModel->getActive(8);
$flashSaleProducts = $productModel->getFlashSale();
$categories = $categoryModel->getAllWithCount();

$pageTitle = 'Home';

require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/home.php';
require BASE_PATH . '/views/layout/footer.php';
