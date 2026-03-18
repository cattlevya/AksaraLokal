<?php
require_once BASE_PATH . '/classes/BaseModel.php';

/**
 * Order Model
 * Handles order creation with PDO Transaction + pessimistic locking
 */
class Order extends BaseModel
{
    protected string $table = 'orders';

    private ?int $id = null;
    private int $buyerId = 0;
    private float $totalAmount = 0;
    private string $status = 'pending';
    private string $paymentMethod = 'bank_transfer';
    private ?string $paymentProof = null;

    // ── Getters ──────────────────────────────────────────
    public function getId(): ?int { return $this->id; }
    public function getBuyerId(): int { return $this->buyerId; }
    public function getTotalAmount(): float { return $this->totalAmount; }
    public function getStatus(): string { return $this->status; }
    public function getPaymentProof(): ?string { return $this->paymentProof; }

    // ── Setters ──────────────────────────────────────────
    public function setBuyerId(int $id): void { $this->buyerId = $id; }
    public function setTotalAmount(float $amount): void { $this->totalAmount = $amount; }
    public function setStatus(string $status): void { $this->status = $status; }

    /**
     * Create order with items — uses Transaction + SELECT FOR UPDATE
     *
     * @param int   $buyerId
     * @param array $cartItems  [['product_id' => int, 'quantity' => int, 'unit_price' => float], ...]
     * @param float $totalAmount
     * @param string|null $paymentProof
     * @return int Order ID
     * @throws Exception on stock issues or DB failure
     */
    public function createWithItems(int $buyerId, array $cartItems, float $totalAmount, ?string $paymentProof = null): int
    {
        $this->db->beginTransaction();

        try {
            // 1. Lock and validate stock for each product (Pessimistic Locking)
            $productModel = new Product();
            foreach ($cartItems as $item) {
                $product = $productModel->lockForUpdate($item['product_id']);
                if (!$product) {
                    throw new Exception("Product #{$item['product_id']} not found.");
                }
                if ($product['stock'] < $item['quantity']) {
                    throw new Exception("Insufficient stock for '{$product['name']}'. Available: {$product['stock']}");
                }
            }

            // 2. Create the order
            $orderId = $this->create([
                'buyer_id'       => $buyerId,
                'total_amount'   => $totalAmount,
                'status'         => 'pending',
                'payment_method' => 'bank_transfer',
                'payment_proof'  => $paymentProof,
            ]);

            // 3. Insert order items & decrement stock
            foreach ($cartItems as $item) {
                $stmtItem = $this->db->prepare(
                    "INSERT INTO order_items (order_id, product_id, quantity, unit_price)
                     VALUES (:oid, :pid, :qty, :price)"
                );
                $stmtItem->execute([
                    'oid'   => $orderId,
                    'pid'   => $item['product_id'],
                    'qty'   => $item['quantity'],
                    'price' => $item['unit_price'],
                ]);

                if (!$productModel->decrementStock($item['product_id'], $item['quantity'])) {
                    throw new Exception("Failed to update stock for product #{$item['product_id']}.");
                }
            }

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Find orders by buyer
     */
    public function findByBuyer(int $buyerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, GROUP_CONCAT(p.name SEPARATOR ', ') as product_names
             FROM {$this->table} o
             LEFT JOIN order_items oi ON oi.order_id = o.id
             LEFT JOIN products p ON p.id = oi.product_id
             WHERE o.buyer_id = :buyer_id
             GROUP BY o.id
             ORDER BY o.created_at DESC"
        );
        $stmt->execute(['buyer_id' => $buyerId]);
        return $stmt->fetchAll();
    }

    /**
     * Find orders for a seller (orders containing their products)
     */
    public function findBySeller(int $sellerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT o.*, u.username as buyer_name
             FROM {$this->table} o
             JOIN order_items oi ON oi.order_id = o.id
             JOIN products p ON p.id = oi.product_id
             JOIN users u ON u.id = o.buyer_id
             WHERE p.seller_id = :seller_id
             ORDER BY o.created_at DESC"
        );
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll();
    }

    /**
     * Get sales data for seller's last 7 days
     */
    public function getSellerSalesLast7Days(int $sellerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT DATE(o.created_at) as sale_date, 
                    SUM(oi.unit_price * oi.quantity) as daily_total
             FROM {$this->table} o
             JOIN order_items oi ON oi.order_id = o.id
             JOIN products p ON p.id = oi.product_id
             WHERE p.seller_id = :seller_id
             AND o.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
             AND o.status != 'cancelled'
             GROUP BY DATE(o.created_at)
             ORDER BY sale_date ASC"
        );
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll();
    }

    /**
     * Update order status
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->update($orderId, ['status' => $status]);
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(int $orderId, string $filename): bool
    {
        return $this->update($orderId, ['payment_proof' => $filename]);
    }

    /**
     * Get order with items
     */
    public function getOrderWithItems(int $orderId): ?array
    {
        $order = $this->findById($orderId);
        if (!$order) return null;

        $stmt = $this->db->prepare(
            "SELECT oi.*, p.name as product_name, p.image as product_image
             FROM order_items oi
             JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id = :oid"
        );
        $stmt->execute(['oid' => $orderId]);
        $order['items'] = $stmt->fetchAll();

        return $order;
    }

    /**
     * Get detailed order for seller — includes buyer info + verifies seller owns products in order
     */
    public function getSellerOrderDetail(int $orderId, int $sellerId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT o.*, u.username as buyer_name, u.email as buyer_email, u.address as buyer_address, u.phone as buyer_phone
             FROM {$this->table} o
             JOIN order_items oi ON oi.order_id = o.id
             JOIN products p ON p.id = oi.product_id
             JOIN users u ON u.id = o.buyer_id
             WHERE o.id = :oid AND p.seller_id = :sid
             LIMIT 1"
        );
        $stmt->execute(['oid' => $orderId, 'sid' => $sellerId]);
        $order = $stmt->fetch();
        if (!$order) return null;

        // Get only items from this seller
        $stmtItems = $this->db->prepare(
            "SELECT oi.*, p.name as product_name, p.image as product_image
             FROM order_items oi
             JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id = :oid AND p.seller_id = :sid"
        );
        $stmtItems->execute(['oid' => $orderId, 'sid' => $sellerId]);
        $order['items'] = $stmtItems->fetchAll();

        return $order;
    }

    /**
     * Find orders for a seller, optionally filtered by status
     */
    public function findBySellerFiltered(int $sellerId, ?string $status = null): array
    {
        $sql = "SELECT DISTINCT o.*, u.username as buyer_name,
                       GROUP_CONCAT(DISTINCT p.name SEPARATOR ', ') as product_names
                FROM {$this->table} o
                JOIN order_items oi ON oi.order_id = o.id
                JOIN products p ON p.id = oi.product_id
                JOIN users u ON u.id = o.buyer_id
                WHERE p.seller_id = :seller_id";

        $params = ['seller_id' => $sellerId];

        if ($status) {
            $sql .= " AND o.status = :status";
            $params['status'] = $status;
        }

        $sql .= " GROUP BY o.id ORDER BY o.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
