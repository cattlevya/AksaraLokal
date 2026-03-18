<?php
require_once BASE_PATH . '/classes/BaseModel.php';

class Product extends BaseModel
{
    protected string $table = 'products';

    private ?int $id = null;
    private int $sellerId = 0;
    private string $name = '';
    private string $description = '';
    private float $price = 0;
    private int $stock = 0;
    private int $categoryId = 0;
    private string $image = 'default.jpg';
    private bool $isActive = true;
    private ?float $flashSalePrice = null;
    private ?string $flashSaleEnd = null;

    
    public function getId(): ?int { return $this->id; }
    public function getSellerId(): int { return $this->sellerId; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function getCategoryId(): int { return $this->categoryId; }
    public function getImage(): string { return $this->image; }
    public function getIsActive(): bool { return $this->isActive; }
    public function getFlashSalePrice(): ?float { return $this->flashSalePrice; }
    public function getFlashSaleEnd(): ?string { return $this->flashSaleEnd; }

    
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $desc): void { $this->description = $desc; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setStock(int $stock): void { $this->stock = $stock; }
    public function setCategoryId(int $id): void { $this->categoryId = $id; }
    public function setImage(string $image): void { $this->image = $image; }

    

    public function getActive(int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name, u.username as seller_name 
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             JOIN users u ON p.seller_id = u.id
             WHERE p.is_active = 1
             ORDER BY p.created_at DESC
             LIMIT :lim"
        );
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function findByCategory(int $categoryId, int $limit = 20): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name, u.username as seller_name
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             JOIN users u ON p.seller_id = u.id
             WHERE p.is_active = 1 AND p.category_id = :cat_id
             ORDER BY p.created_at DESC
             LIMIT :lim"
        );
        $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function findBySeller(int $sellerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             WHERE p.seller_id = :seller_id
             ORDER BY p.created_at DESC"
        );
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll();
    }

    

    public function search(string $keyword, int $limit = 20): array
    {
        $keyword = '%' . $keyword . '%';
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name, u.username as seller_name
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             JOIN users u ON p.seller_id = u.id
             WHERE p.is_active = 1 AND (p.name LIKE :kw OR p.description LIKE :kw2)
             ORDER BY p.created_at DESC
             LIMIT :lim"
        );
        $stmt->bindValue(':kw', $keyword);
        $stmt->bindValue(':kw2', $keyword);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function searchAdvanced(array $filters, int $limit = 12, int $offset = 0): array
    {
        $sql = "SELECT p.*, c.name as category_name, u.username as seller_name
                FROM {$this->table} p
                JOIN categories c ON p.category_id = c.id
                JOIN users u ON p.seller_id = u.id
                WHERE p.is_active = 1";
        
        $params = [];
        
        if (!empty($filters['keyword'])) {
            $sql .= " AND (p.name LIKE :kw OR p.description LIKE :kw)";
            $params['kw'] = '%' . $filters['keyword'] . '%';
        }
        if (!empty($filters['category'])) {
            $sql .= " AND p.category_id = :cat_id";
            $params['cat_id'] = $filters['category'];
        }
        if (!empty($filters['min_price'])) {
            
            $sql .= " AND (COALESCE((CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN p.flash_sale_price ELSE NULL END), p.price) >= :min_price)";
            $params['min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND (COALESCE((CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN p.flash_sale_price ELSE NULL END), p.price) <= :max_price)";
            $params['max_price'] = $filters['max_price'];
        }
        
        $sortOrder = "p.created_at DESC";
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $sortOrder = "COALESCE((CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN p.flash_sale_price ELSE NULL END), p.price) ASC";
                    break;
                case 'price_desc':
                    $sortOrder = "COALESCE((CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN p.flash_sale_price ELSE NULL END), p.price) DESC";
                    break;
                case 'newest':
                default:
                    $sortOrder = "p.created_at DESC";
            }
        }
        
        $sql .= " ORDER BY $sortOrder LIMIT :lim OFFSET :off";
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function countAdvanced(array $filters): int
    {
        $sql = "SELECT COUNT(p.id)
                FROM {$this->table} p
                WHERE p.is_active = 1";
        
        $params = [];
        
        if (!empty($filters['keyword'])) {
            $sql .= " AND (p.name LIKE :kw OR p.description LIKE :kw)";
            $params['kw'] = '%' . $filters['keyword'] . '%';
        }
        if (!empty($filters['category'])) {
            $sql .= " AND p.category_id = :cat_id";
            $params['cat_id'] = $filters['category'];
        }
        if (!empty($filters['min_price'])) {
            $sql .= " AND (COALESCE((CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN p.flash_sale_price ELSE NULL END), p.price) >= :min_price)";
            $params['min_price'] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND (COALESCE((CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN p.flash_sale_price ELSE NULL END), p.price) <= :max_price)";
            $params['max_price'] = $filters['max_price'];
        }
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    

    public function lockForUpdate(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = :id FOR UPDATE"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    

    public function decrementStock(int $id, int $qty): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET stock = stock - :qty WHERE id = :id AND stock >= :qty2"
        );
        $stmt->execute(['qty' => $qty, 'id' => $id, 'qty2' => $qty]);
        return $stmt->rowCount() > 0;
    }

    

    public function getDetail(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name, u.username as seller_name, u.address as seller_location
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             JOIN users u ON p.seller_id = u.id
             WHERE p.id = :id"
        );
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    

    public function getRelated(int $productId, int $categoryId, int $limit = 4): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, u.username as seller_name
             FROM {$this->table} p
             JOIN users u ON p.seller_id = u.id
             WHERE p.is_active = 1 AND p.category_id = :cat_id AND p.id != :pid
             ORDER BY RAND()
             LIMIT :lim"
        );
        $stmt->bindValue(':cat_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':pid', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function getFlashSale(): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name, u.username as seller_name
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             JOIN users u ON p.seller_id = u.id
             WHERE p.is_active = 1
             AND p.flash_sale_price IS NOT NULL
             AND p.flash_sale_end > NOW()
             ORDER BY p.flash_sale_end ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function createProduct(array $data): int
    {
        return $this->create($data);
    }

    

    public function updateProduct(int $id, int $sellerId, array $data): bool
    {
        $product = $this->findById($id);
        if (!$product || $product['seller_id'] !== $sellerId) return false;
        return $this->update($id, $data);
    }

    

    public function toggleActive(int $id, int $sellerId): bool
    {
        $product = $this->findById($id);
        if (!$product || $product['seller_id'] !== $sellerId) return false;
        return $this->update($id, ['is_active' => $product['is_active'] ? 0 : 1]);
    }

    

    public function deleteProduct(int $id, int $sellerId): bool
    {
        $product = $this->findById($id);
        if (!$product || $product['seller_id'] !== $sellerId) return false;
        return $this->delete($id);
    }

    

    public function setFlashSale(int $id, int $sellerId, float $price, string $endDate): bool
    {
        $product = $this->findById($id);
        if (!$product || $product['seller_id'] !== $sellerId) return false;
        if ($price >= $product['price']) return false;
        return $this->update($id, [
            'flash_sale_price' => $price,
            'flash_sale_end'   => $endDate,
        ]);
    }

    

    public function removeFlashSale(int $id, int $sellerId): bool
    {
        $product = $this->findById($id);
        if (!$product || $product['seller_id'] !== $sellerId) return false;
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET flash_sale_price = NULL, flash_sale_end = NULL WHERE id = :id"
        );
        return $stmt->execute(['id' => $id]);
    }

    

    public function getFlashSaleBySeller(int $sellerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name as category_name,
                    CASE 
                        WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN 'active'
                        WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end <= NOW() THEN 'expired'
                        ELSE 'none'
                    END as flash_status
             FROM {$this->table} p
             JOIN categories c ON p.category_id = c.id
             WHERE p.seller_id = :seller_id
             ORDER BY 
                CASE WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end > NOW() THEN 0
                     WHEN p.flash_sale_price IS NOT NULL AND p.flash_sale_end <= NOW() THEN 1
                     ELSE 2 END,
                p.flash_sale_end ASC"
        );
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll();
    }
}
