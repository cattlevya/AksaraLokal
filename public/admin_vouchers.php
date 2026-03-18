<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Voucher.php';

requireAdmin();

$voucherModel = new Voucher();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid token. Please try again.');
        redirect('/admin_vouchers.php');
    }

    $action = $_POST['action'] ?? '';
    $voucherId = (int)($_POST['voucher_id'] ?? 0);
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $discountPercent = (int)($_POST['discount_percent'] ?? 0);
    $maxUse = (int)($_POST['max_use'] ?? 100);
    $expiredAt = $_POST['expired_at'] ?? '';

    if ($action === 'create') {
        if (empty($code) || $discountPercent <= 0 || empty($expiredAt)) {
            setFlash('error', 'All fields are required and discount must be > 0.');
        } else {
            $existing = $voucherModel->findByCode($code);
            if ($existing) {
                setFlash('error', 'Voucher code already exists.');
            } else {
                $voucherModel->create([
                    'code'             => $code,
                    'discount_percent' => $discountPercent,
                    'max_use'          => $maxUse,
                    'used_count'       => 0,
                    'expired_at'       => $expiredAt
                ]);
                setFlash('success', 'Voucher created successfully.');
            }
        }
    } elseif ($action === 'delete') {
        try {
            $voucherModel->delete($voucherId);
            setFlash('success', 'Voucher deleted successfully.');
        } catch (PDOException $e) {
            setFlash('error', 'Cannot delete voucher. It might be linked to existing orders.');
        }
    }
    
    redirect('/admin_vouchers.php');
}

$vouchers = $voucherModel->findAll('id', 'DESC');

$pageTitle = 'Manage Vouchers';
require BASE_PATH . '/views/admin/layout/header.php';
require BASE_PATH . '/views/admin/vouchers.php';
require BASE_PATH . '/views/admin/layout/footer.php';
