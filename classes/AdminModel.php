<?php
require_once BASE_PATH . '/classes/BaseModel.php';

/**
 * Admin Model
 * Inherits from BaseModel. Handles admin-specific queries securely via PDO.
 * Encapsulation implemented via access modifiers. 
 */
class AdminModel extends BaseModel
{
    // No specific table defined as Admin queries often span across multiple tables.

    /**
     * Get platform-wide global sales report (Total Revenue)
     */
    public function getGlobalRevenue(): float
    {
        // Only count 'shipped' or 'delivered' orders, or 'confirmed'. 
        // For this CPMK-01 context, 'confirmed', 'shipped', 'delivered' imply paid.
        $stmt = $this->db->prepare("
            SELECT SUM(total_amount) as total_revenue 
            FROM orders 
            WHERE status IN ('confirmed', 'shipped', 'delivered')
        ");
        $stmt->execute();
        $result = $stmt->fetch();
        return (float) ($result['total_revenue'] ?? 0);
    }
    
    /**
     * Get total number of specific entities
     */
    public function countEntity(string $table): int
    {
        // Parameterized queries cannot be used for table names. We must whitelist/sanitize it.
        $allowedTables = ['users', 'products', 'orders', 'categories', 'vouchers'];
        if (!in_array($table, $allowedTables)) {
            throw new InvalidArgumentException("Invalid table name for count.");
        }
        
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$table}");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Get paginated users
     */
    public function getUsersPaginated(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Delete user securely
     */
    public function deleteUser(int $id): bool
    {
        // Delete related dependent data if needed, or rely on ON DELETE CASCADE.
        // For standard setup without cascade, we must be careful. 
        // We'll just delete the user, and if a foreign key constraint fails, PDO will throw.
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    /**
     * Get paginated products for admin (includes inactive)
     */
    public function getProductsPaginated(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name, u.username as seller_name
             FROM products p
             JOIN categories c ON p.category_id = c.id
             JOIN users u ON p.seller_id = u.id
             ORDER BY p.created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Toggle product active status (Admin override)
     */
    public function toggleProductStatus(int $productId): bool
    {
        // First get current status
        $stmt = $this->db->prepare("SELECT is_active FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $current = $stmt->fetchColumn();
        
        if ($current === false) return false;
        
        $newStatus = $current ? 0 : 1;
        $update = $this->db->prepare("UPDATE products SET is_active = :status WHERE id = :id");
        return $update->execute(['status' => $newStatus, 'id' => $productId]);
    }
    /**
     * Get paginated orders for admin
     */
    public function getGlobalOrdersPaginated(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, u.username as buyer_name, u.email as buyer_email
             FROM orders o
             JOIN users u ON o.buyer_id = u.id
             ORDER BY o.created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * Set flash sale for any product (Admin override)
     */
    public function setFlashSaleAdmin(int $productId, float $price, string $endDate): bool
    {
        // Must ensure the price is actually lower than the regular price
        $stmt = $this->db->prepare("SELECT price FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $normalPrice = $stmt->fetchColumn();
        
        if ($normalPrice === false || $price >= $normalPrice) {
            return false;
        }
        
        $update = $this->db->prepare("UPDATE products SET flash_sale_price = :fprice, flash_sale_end = :fend WHERE id = :id");
        return $update->execute([
            'fprice' => $price,
            'fend'   => $endDate,
            'id'     => $productId
        ]);
    }
    
    /**
     * Remove flash sale from any product (Admin override)
     */
    public function removeFlashSaleAdmin(int $productId): bool
    {
        $update = $this->db->prepare("UPDATE products SET flash_sale_price = NULL, flash_sale_end = NULL WHERE id = :id");
        return $update->execute(['id' => $productId]);
    }
}
