<?php
/**
 * Checkout Handler
 * POST: Apply voucher (AJAX) OR Place order (form submit with CSRF)
 *   - Uses PDO Transaction + SELECT FOR UPDATE (pessimistic locking)
 *   - Payment proof upload (JPG/PNG, max 2MB)
 * GET: Render checkout page
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Cart.php';
require_once BASE_PATH . '/classes/Product.php';
require_once BASE_PATH . '/classes/Order.php';
require_once BASE_PATH . '/classes/Voucher.php';

requireLogin();

// ── AJAX: Apply Voucher ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'apply_voucher') {
    header('Content-Type: application/json');
    $code = strtoupper(trim($_POST['voucher_code'] ?? ''));
    
    $voucherModel = new Voucher();
    $result = $voucherModel->isValid($code);
    
    if ($result['valid']) {
        $_SESSION['voucher_code']     = $code;
        $_SESSION['voucher_discount'] = $result['discount_percent'];
        $_SESSION['voucher_id']       = $result['voucher_id'];
    }
    
    echo json_encode($result);
    exit;
}

// ── POST: Place Order ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid request. Please try again.');
        redirect('/checkout.php');
    }

    if (Cart::isEmpty()) {
        setFlash('error', 'Your cart is empty.');
        redirect('/products.php');
    }

    // Handle payment proof upload
    $paymentProofFile = null;
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['payment_proof'];
        
        // Validate type
        $allowedTypes = ['image/jpeg', 'image/png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            setFlash('error', 'Payment proof must be JPG or PNG.');
            redirect('/checkout.php');
        }

        // Validate size (2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            setFlash('error', 'Payment proof must be under 2MB.');
            redirect('/checkout.php');
        }

        // Upload
        $ext = $mimeType === 'image/png' ? 'png' : 'jpg';
        $paymentProofFile = 'proof_' . time() . '_' . uniqid() . '.' . $ext;
        
        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }
        move_uploaded_file($file['tmp_name'], UPLOAD_PATH . $paymentProofFile);
    }

    // Calculate totals
    $subtotal   = Cart::getSubtotal();
    $shipping   = 12000;
    $tax        = round($subtotal * 0.08);
    $discount   = 0;
    
    if (isset($_SESSION['voucher_discount'])) {
        $discount = round($subtotal * $_SESSION['voucher_discount'] / 100);
    }
    
    $totalAmount = $subtotal + $shipping + $tax - $discount;

    // Prepare cart items for order
    $cartItems = [];
    foreach (Cart::getItems() as $item) {
        $cartItems[] = [
            'product_id' => $item['product_id'],
            'quantity'   => $item['quantity'],
            'unit_price' => $item['price'],
        ];
    }

    // Create order with pessimistic locking
    try {
        $orderModel = new Order();
        $orderId = $orderModel->createWithItems(
            $_SESSION['user_id'],
            $cartItems,
            $totalAmount,
            $paymentProofFile
        );

        // Increment voucher usage if applicable
        if (isset($_SESSION['voucher_id'])) {
            $voucherModel = new Voucher();
            $voucherModel->incrementUsage($_SESSION['voucher_id']);
        }

        // Clear cart and voucher session
        Cart::clear();
        unset($_SESSION['voucher_code'], $_SESSION['voucher_discount'], $_SESSION['voucher_id']);

        setFlash('success', "Order #$orderId placed successfully! We'll process it soon.");
        redirect('/profile.php');

    } catch (Exception $e) {
        setFlash('error', 'Checkout failed: ' . $e->getMessage());
        redirect('/checkout.php');
    }
}

// ── GET: Render checkout page ──
if (Cart::isEmpty()) {
    setFlash('error', 'Your cart is empty.');
    redirect('/products.php');
}

$cartItems = Cart::getItems();
$subtotal  = Cart::getSubtotal();

$pageTitle = 'Checkout';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/checkout.php';
require BASE_PATH . '/views/layout/footer.php';
