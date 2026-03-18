<?php
/**
 * Admin Flash Sale Management Controller
 * Handles: list products, set flash sale, remove flash sale platform-wide
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/AdminModel.php';
require_once BASE_PATH . '/classes/Product.php';

requireAdmin();

$adminModel = new AdminModel();
$productModel = new Product();

// ── POST Actions ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid token. Please try again.');
        redirect('/admin_flash_sale.php');
    }

    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'set_flash_sale':
            $productId  = (int)($_POST['product_id'] ?? 0);
            $flashPrice = abs((float)($_POST['flash_sale_price'] ?? 0));
            $flashEnd   = trim($_POST['flash_sale_end'] ?? '');

            // Validate
            if ($productId <= 0 || $flashPrice <= 0 || empty($flashEnd)) {
                setFlash('error', 'Please fill in all flash sale fields.');
                redirect('/admin_flash_sale.php');
                exit; // Need to exit after redirect in case switches bleed
            }

            // Validate end date is in the future
            $endTimestamp = strtotime($flashEnd);
            if (!$endTimestamp || $endTimestamp <= time()) {
                setFlash('error', 'Flash sale end date must be in the future.');
                redirect('/admin_flash_sale.php');
                exit;
            }

            $endDate = date('Y-m-d H:i:s', $endTimestamp);
            $result = $adminModel->setFlashSaleAdmin($productId, $flashPrice, $endDate);

            if ($result) {
                setFlash('success', 'Flash sale activated successfully!');
            } else {
                setFlash('error', 'Failed to set flash sale. Ensure the flash price is lower than the regular price.');
            }
            redirect('/admin_flash_sale.php');
            exit;

        case 'remove_flash_sale':
            $productId = (int)($_POST['product_id'] ?? 0);
            $result = $adminModel->removeFlashSaleAdmin($productId);
            if ($result) {
                setFlash('success', 'Flash sale removed successfully.');
            } else {
                setFlash('error', 'Failed to remove flash sale.');
            }
            redirect('/admin_flash_sale.php');
            exit;
    }

    redirect('/admin_flash_sale.php');
    exit;
}

// ── GET: Load data and render view ──

// To populate the select dropdown for products (we load all active products)
$allProducts = $productModel->getActive(1000); 

// For the table, we reuse getFlashSale() from Product.php which fetches all active flash sales
$flashSales = $productModel->getFlashSale();

$pageTitle = 'Flash Sale Manager';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/flash_sale.php';
require BASE_PATH . '/views/admin/layout/footer.php';
