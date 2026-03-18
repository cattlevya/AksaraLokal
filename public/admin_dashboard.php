<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/AdminModel.php';

requireAdmin();

$adminModel = new AdminModel();

$globalRevenue = $adminModel->getGlobalRevenue();
$totalUsers = $adminModel->countEntity('users');
$totalProducts = $adminModel->countEntity('products');
$totalOrders = $adminModel->countEntity('orders');
$totalCategories = $adminModel->countEntity('categories');

$pageTitle = 'Admin Dashboard';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/dashboard.php';
require BASE_PATH . '/views/admin/layout/footer.php';
