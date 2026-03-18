<?php
/**
 * Admin Products Controller
 * Handles Product Approvals (toggling is_active)
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/AdminModel.php';

requireAdmin();

$adminModel = new AdminModel();

// ── Handle POST: Toggle Status ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid token. Please try again.');
        redirect('/admin_products.php');
    }

    $action = $_POST['action'] ?? '';
    $productId = (int)($_POST['product_id'] ?? 0);

    if ($action === 'toggle_status') {
        if ($adminModel->toggleProductStatus($productId)) {
            setFlash('success', 'Product visibility status updated.');
        } else {
            setFlash('error', 'Failed to update product status.');
        }
    }
    redirect('/admin_products.php');
}

// ── GET: Pagination ──
$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$totalProducts = $adminModel->countEntity('products');
$totalPages = ceil($totalProducts / $limit);

$products = $adminModel->getProductsPaginated($limit, $offset);

$pageTitle = 'Product Approvals';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/products.php';
require BASE_PATH . '/views/admin/layout/footer.php';
