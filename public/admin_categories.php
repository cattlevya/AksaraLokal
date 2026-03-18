<?php
/**
 * Admin Categories Controller
 * Handles CRUD for master data categories with server-side validation
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Category.php';

requireAdmin();

$categoryModel = new Category();

// ── Handle POST: Create, Update, Delete ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid token. Please try again.');
        redirect('/admin_categories.php');
    }

    $action = $_POST['action'] ?? '';
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');

    if ($action === 'create') {
        if (empty($name)) {
            setFlash('error', 'Category name cannot be empty.');
        } else {
            $categoryModel->create(['name' => $name, 'iconClass' => 'fa-box']);
            setFlash('success', 'Category created successfully.');
        }
    } elseif ($action === 'update') {
        if (empty($name)) {
            setFlash('error', 'Category name cannot be empty.');
        } else {
            $categoryModel->update($categoryId, ['name' => $name]);
            setFlash('success', 'Category updated successfully.');
        }
    } elseif ($action === 'delete') {
        try {
            $categoryModel->delete($categoryId);
            setFlash('success', 'Category deleted successfully.');
        } catch (PDOException $e) {
            setFlash('error', 'Cannot delete category that is currently attached to products.');
        }
    }
    
    redirect('/admin_categories.php');
}

// ── GET: Load all categories ──
$categories = $categoryModel->getAllWithCount();

$pageTitle = 'Manage Categories';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/categories.php';
require BASE_PATH . '/views/admin/layout/footer.php';
