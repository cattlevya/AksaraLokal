<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/User.php';

if (isLoggedIn()) {
    redirect('/');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    
    if (!validateCsrfToken()) {
        $error = 'Invalid request. Please try again.';
    } else {
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Please fill in all fields.';
        } else {
            $userModel = new User();
            $user = $userModel->authenticate($username, $password);

            if ($user) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['email']    = $user['email'];

                setFlash('success', 'Welcome back, ' . $user['username'] . '!');

                
                if ($user['role'] === 'seller') {
                    redirect('/seller_dashboard.php');
                } elseif ($user['role'] === 'admin') {
                    redirect('/admin_dashboard.php');
                } else {
                    redirect('/');
                }
            } else {
                $error = 'Invalid username or password.';
            }
        }
    }
}

$pageTitle = 'Login';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/auth/login.php';
require BASE_PATH . '/views/layout/footer.php';
