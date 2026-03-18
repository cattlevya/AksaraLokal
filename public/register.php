<?php
/**
 * Register Handler
 * POST: Create new user
 * GET: Render register form
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/User.php';

if (isLoggedIn()) {
    redirect('/');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    if (!validateCsrfToken()) {
        $error = 'Invalid request. Please try again.';
    } else {
        $username = sanitize($_POST['username'] ?? '');
        $email    = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = in_array($_POST['role'] ?? '', ['buyer', 'seller']) ? $_POST['role'] : 'buyer';
        $phone    = sanitize($_POST['phone'] ?? '');
        $address  = sanitize($_POST['address'] ?? '');

        // Validate
        if (empty($username) || empty($email) || empty($password)) {
            $error = 'Please fill in all required fields.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $userModel = new User();

            // Check duplicates
            if ($userModel->findByUsername($username)) {
                $error = 'Username already taken.';
            } elseif ($userModel->findByEmail($email)) {
                $error = 'Email already registered.';
            } else {
                $userId = $userModel->register([
                    'username' => $username,
                    'email'    => $email,
                    'password' => $password,
                    'role'     => $role,
                    'phone'    => $phone,
                    'address'  => $address,
                ]);

                // Auto-login
                $_SESSION['user_id']  = $userId;
                $_SESSION['username'] = $username;
                $_SESSION['role']     = $role;
                $_SESSION['email']    = $email;

                if ($role === 'seller') {
                    setFlash('success', 'Account created! Welcome to Aksara Lokal Seller Dashboard.');
                    redirect('/seller_dashboard.php');
                } else {
                    setFlash('success', 'Account created! Welcome to Aksara Lokal.');
                    redirect('/');
                }
            }
        }
    }
}

$pageTitle = 'Register';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/auth/register.php';
require BASE_PATH . '/views/layout/footer.php';
