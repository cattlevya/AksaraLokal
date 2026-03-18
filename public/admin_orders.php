<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/AdminModel.php';
require_once BASE_PATH . '/classes/Order.php';

requireAdmin();

$adminModel = new AdminModel();
$orderModel = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid token. Please try again.');
        redirect('/admin_orders.php');
    }

    $action = $_POST['action'] ?? '';
    $orderId = (int)($_POST['order_id'] ?? 0);

    if ($action === 'verify_payment') {
        
        if ($orderModel->updateStatus($orderId, 'confirmed')) {
            setFlash('success', 'Order #' . $orderId . ' payment verified. Status updated to Confirmed.');
        } else {
            setFlash('error', 'Failed to verify payment. Please try again.');
        }
    }
    
    redirect('/admin_orders.php');
}

$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$totalOrders = $adminModel->countEntity('orders');
$totalPages = ceil($totalOrders / $limit);

$orders = $adminModel->getGlobalOrdersPaginated($limit, $offset);

$pageTitle = 'Global Orders & Verifications';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/orders.php';
require BASE_PATH . '/views/admin/layout/footer.php';
