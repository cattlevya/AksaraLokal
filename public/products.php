<?php
/**
 * Products Listing Handler
 * GET params: ?category=N to filter by category
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Product.php';
require_once BASE_PATH . '/classes/Category.php';

$productModel  = new Product();
$categoryModel = new Category();

$currentCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$minPrice = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
$maxPrice = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = 12; // CPMK-01 requirement: min 10 data/halaman
$offset = ($page - 1) * $limit;

$categories = $categoryModel->findAll('name', 'ASC');

// Build filters array
$filters = [
    'keyword'   => $searchQuery,
    'category'  => $currentCategory,
    'min_price' => $minPrice,
    'max_price' => $maxPrice,
    'sort'      => $sort
];

// Get total data and calculate pages
$totalData = $productModel->countAdvanced($filters);
$totalPages = ceil($totalData / $limit);
if ($totalPages < 1) $totalPages = 1;

// Get products for current page
$products = $productModel->searchAdvanced($filters, $limit, $offset);

// Dynamic Page Title
if ($searchQuery !== '') {
    $pageTitle = "Search: $searchQuery";
} elseif ($currentCategory) {
    if ($catName = array_search($currentCategory, array_column($categories, 'id'))) {
        $pageTitle = $categories[$catName]['name'];
    } else {
        $pageTitle = 'Category';
    }
} else {
    $pageTitle = 'Shop All Products';
}
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/products.php';
require BASE_PATH . '/views/layout/footer.php';
