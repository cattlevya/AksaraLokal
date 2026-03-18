<?php
/**
 * Application Configuration & Helpers
 * Aksara Lokal — PHP 8.2+ Native
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone to WIB (Jakarta)
date_default_timezone_set('Asia/Jakarta');

// Base path constants
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/apakekmonyet/public');
define('UPLOAD_PATH', BASE_PATH . '/public/assets/uploads/');

// Include database class
require_once BASE_PATH . '/config/database.php';

// ============================================================
// CSRF Token Helpers
// ============================================================

/**
 * Generate a CSRF token and store in session
 */
function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render hidden CSRF input field
 */
function csrfField(): string
{
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

/**
 * Validate CSRF token from POST request
 */
function validateCsrfToken(): bool
{
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    $valid = hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    // Regenerate token after validation
    unset($_SESSION['csrf_token']);
    return $valid;
}

// ============================================================
// Security Helpers
// ============================================================

/**
 * Sanitize output to prevent XSS
 */
function e(string|null $string): string
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize input string
 */
function sanitize(string $input): string
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// ============================================================
// Auth Helpers
// ============================================================

/**
 * Check if user is logged in
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Get current user data
 */
function currentUser(): ?array
{
    if (!isLoggedIn()) return null;
    return [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role'     => $_SESSION['role'],
        'email'    => $_SESSION['email'] ?? '',
    ];
}

/**
 * Require login — redirect if not authenticated
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        redirect('/login.php');
    }
}

/**
 * Middleware: Require Seller Role
 */
function requireSeller(): void
{
    requireLogin();
    if ($_SESSION['role'] !== 'seller') {
        setFlash('error', 'Access denied. Sellers only.');
        redirect('/');
    }
}

/**
 * Middleware: Require Admin Role
 */
function requireAdmin(): void
{
    requireLogin();
    if ($_SESSION['role'] !== 'admin') {
        setFlash('error', 'Access denied. Administrators only.');
        redirect('/');
    }
}

/**
 * Require specific role
 */
function requireRole(string $role): void
{
    requireLogin();
    if ($_SESSION['role'] !== $role) {
        http_response_code(403);
        die('Access denied. You need ' . e($role) . ' privileges.');
    }
}

// ============================================================
// Navigation & Utility Helpers
// ============================================================

/**
 * Redirect to a URL
 */
function redirect(string $path): never
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

/**
 * Set flash message
 */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear flash message
 */
function getFlash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Format price to Rupiah
 */
function formatRupiah(float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Get cart item count
 */
function getCartCount(): int
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return 0;
    }
    return array_sum(array_column($_SESSION['cart'], 'quantity'));
}
