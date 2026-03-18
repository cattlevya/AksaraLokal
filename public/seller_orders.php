<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Order.php';
require_once BASE_PATH . '/classes/Product.php';

requireRole('seller');

$sellerId   = $_SESSION['user_id'];
$orderModel = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid request.');
        redirect('/seller_orders.php');
    }

    $orderId = (int)($_POST['order_id'] ?? 0);

    if (isset($_POST['confirm_payment'])) {
        $orderModel->updateStatus($orderId, 'confirmed');
        setFlash('success', "Order #$orderId — Payment accepted & confirmed.");
    } elseif (isset($_POST['reject_payment'])) {
        $orderModel->updateStatus($orderId, 'cancelled');
        setFlash('success', "Order #$orderId — Payment rejected & cancelled.");
    } elseif (isset($_POST['ship_order'])) {
        $orderModel->updateStatus($orderId, 'shipped');
        setFlash('success', "Order #$orderId — Marked as shipped.");
    }

    
    if (isset($_POST['return_detail'])) {
        redirect('/seller_orders.php?id=' . $orderId);
    }
    redirect('/seller_orders.php');
}

if (isset($_GET['id'])) {
    $orderId = (int)$_GET['id'];
    $order = $orderModel->getSellerOrderDetail($orderId, $sellerId);
    if (!$order) {
        setFlash('error', 'Order not found.');
        redirect('/seller_orders.php');
    }

    $pageTitle = "Order #$orderId";
    require BASE_PATH . '/views/seller/layout/header.php';
    require BASE_PATH . '/views/seller/order_detail.php';
    require BASE_PATH . '/views/seller/layout/footer.php';
    exit;
}

$statusFilter = $_GET['status'] ?? null;
$validStatuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
if ($statusFilter && !in_array($statusFilter, $validStatuses)) {
    $statusFilter = null;
}

$sellerOrders = $orderModel->findBySellerFiltered($sellerId, $statusFilter);

$allOrders = $orderModel->findBySellerFiltered($sellerId);
$statusCounts = [
    'all'       => count($allOrders),
    'pending'   => count(array_filter($allOrders, fn($o) => $o['status'] === 'pending')),
    'confirmed' => count(array_filter($allOrders, fn($o) => $o['status'] === 'confirmed')),
    'shipped'   => count(array_filter($allOrders, fn($o) => $o['status'] === 'shipped')),
    'delivered' => count(array_filter($allOrders, fn($o) => $o['status'] === 'delivered')),
];

$pageTitle = 'Order Management';
require BASE_PATH . '/views/seller/layout/header.php';
require BASE_PATH . '/views/seller/orders.php';
require BASE_PATH . '/views/seller/layout/footer.php';
