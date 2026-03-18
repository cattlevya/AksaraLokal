<?php
/**
 * Profile Handler
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/User.php';
require_once BASE_PATH . '/classes/Order.php';

requireLogin();

$userModel  = new User();
$orderModel = new Order();

$userData   = $userModel->findById($_SESSION['user_id']);
$userOrders = $orderModel->findByBuyer($_SESSION['user_id']);

$pageTitle = 'My Profile';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/profile.php';
require BASE_PATH . '/views/layout/footer.php';
