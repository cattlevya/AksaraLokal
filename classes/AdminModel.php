<?php
require_once BASE_PATH . '/classes/BaseModel.php';

class AdminModel extends BaseModel
{
    

    

    public function getGlobalRevenue(): float
    {
        
        
        $stmt = $this->db->prepare("
            SELECT SUM(total_amount) as total_revenue 
            FROM orders 
            WHERE status IN ('confirmed', 'shipped', 'delivered')
        ");
        $stmt->execute();
        $result = $stmt->fetch();
        return (float) ($result['total_revenue'] ?? 0);
    }
    
    

    public function countEntity(string $table): int
    {
        
        $allowedTables = ['users', 'products', 'orders', 'categories', 'vouchers'];
        if (!in_array($table, $allowedTables)) {
            throw new InvalidArgumentException("Invalid table name for count.");
        }
        
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$table}");
        return (int) $stmt->fetchColumn();
    }

    

    public function getUsersPaginated(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    

    public function deleteUser(int $id): bool
    {
        
        
        
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    

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
    
    

    public function toggleProductStatus(int $productId): bool
    {
        
        $stmt = $this->db->prepare("SELECT is_active FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $current = $stmt->fetchColumn();
        
        if ($current === false) return false;
        
        $newStatus = $current ? 0 : 1;
        $update = $this->db->prepare("UPDATE products SET is_active = :status WHERE id = :id");
        return $update->execute(['status' => $newStatus, 'id' => $productId]);
    }
    

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
    

    public function setFlashSaleAdmin(int $productId, float $price, string $endDate): bool
    {
        
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
    
    

    public function removeFlashSaleAdmin(int $productId): bool
    {
        $update = $this->db->prepare("UPDATE products SET flash_sale_price = NULL, flash_sale_end = NULL WHERE id = :id");
        return $update->execute(['id' => $productId]);
    }
}
