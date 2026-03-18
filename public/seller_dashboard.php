<?php
/**
 * Seller Dashboard Handler
 * Requires seller role
 * Features: Stats, ASCII chart, recent orders, low stock alerts
 */
require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Product.php';
require_once BASE_PATH . '/classes/Order.php';

requireRole('seller');

$sellerId     = $_SESSION['user_id'];
$productModel = new Product();
$orderModel   = new Order();

// ── Load data ──
$sellerProducts = $productModel->findBySeller($sellerId);
$sellerOrders   = $orderModel->findBySeller($sellerId);
$salesData      = $orderModel->getSellerSalesLast7Days($sellerId);

// Stats
$pendingOrders  = array_filter($sellerOrders, fn($o) => $o['status'] === 'pending');
$lowStockProducts = array_filter($sellerProducts, fn($p) => $p['stock'] <= 5);

// ── Generate ASCII Chart ──
$asciiChart = generateAsciiChart($salesData);

function generateAsciiChart(array $salesData): string
{
    $days = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $days[$date] = 0;
    }
    foreach ($salesData as $row) {
        if (isset($days[$row['sale_date']])) {
            $days[$row['sale_date']] = (float)$row['daily_total'];
        }
    }

    $maxVal = max(1, max($days));
    $chartHeight = 10;
    $chart = '';

    $chart .= "\n";

    for ($row = $chartHeight; $row >= 1; $row--) {
        $threshold = ($row / $chartHeight) * $maxVal;
        $label = ($row === $chartHeight) ? formatShort($maxVal) : (($row === (int)($chartHeight/2)) ? formatShort($maxVal/2) : '');
        $chart .= str_pad($label, 8, ' ', STR_PAD_LEFT) . ' │';
        foreach ($days as $val) {
            $chart .= $val >= $threshold ? '  ██  ' : '      ';
        }
        $chart .= "\n";
    }

    $chart .= "         ├" . str_repeat('──────', count($days)) . "\n";
    $chart .= "         ";
    foreach ($days as $date => $val) {
        $chart .= ' ' . date('d/m', strtotime($date)) . ' ';
    }
    $chart .= "\n\n";

    $total = array_sum($days);
    $avg   = count($days) > 0 ? $total / count($days) : 0;
    $chart .= "  Total Revenue : Rp " . number_format($total, 0, ',', '.') . "\n";
    $chart .= "  Daily Average : Rp " . number_format($avg, 0, ',', '.') . "\n";
    if ($total > 0) {
        $chart .= "  Peak Day      : " . date('d M', strtotime(array_search(max($days), $days))) . " (Rp " . number_format(max($days), 0, ',', '.') . ")\n";
    }

    return $chart;
}

function formatShort(float $val): string
{
    if ($val >= 1000000) return round($val / 1000000, 1) . 'M';
    if ($val >= 1000) return round($val / 1000, 0) . 'K';
    return (string)(int)$val;
}

$pageTitle = 'Dashboard';
require BASE_PATH . '/views/seller/layout/header.php';
require BASE_PATH . '/views/seller/dashboard.php';
require BASE_PATH . '/views/seller/layout/footer.php';
