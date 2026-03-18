<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/AdminModel.php';
require_once BASE_PATH . '/classes/User.php';

requireAdmin();

$adminModel = new AdminModel();
$userModel = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid token. Please try again.');
        redirect('/admin_users.php');
    }

    $action = $_POST['action'] ?? '';
    $userId = (int)($_POST['user_id'] ?? 0);

    
    if ($userId === (int)$_SESSION['user_id']) {
        setFlash('error', 'Cannot alter your own active session account here.');
        redirect('/admin_users.php');
    }

    if ($action === 'delete') {
        try {
            
            $adminModel->deleteUser($userId);
            setFlash('success', 'User completely deleted from system.');
        } catch (PDOException $e) {
            setFlash('error', 'Cannot delete user because they have existing orders or products.');
        }
    } elseif ($action === 'update_role') {
        $newRole = $_POST['role'] ?? 'buyer';
        $allowedRoles = ['buyer', 'seller', 'admin'];
        if (in_array($newRole, $allowedRoles)) {
            $userModel->update($userId, ['role' => $newRole]);
            setFlash('success', "User role updated to $newRole.");
        }
    }
    redirect('/admin_users.php');
}

$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$totalUsers = $adminModel->countEntity('users');
$totalPages = ceil($totalUsers / $limit);

$users = $adminModel->getUsersPaginated($limit, $offset);

$pageTitle = 'Manage Users';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/users.php';
require BASE_PATH . '/views/admin/layout/footer.php';
