<?php
require_once BASE_PATH . '/classes/BaseModel.php';

class Category extends BaseModel
{
    protected string $table = 'categories';

    private ?int $id = null;
    private string $name = '';
    private string $iconClass = 'fa-box';

    
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getIconClass(): string { return $this->iconClass; }

    
    public function setName(string $name): void { $this->name = $name; }
    public function setIconClass(string $icon): void { $this->iconClass = $icon; }

    

    public function getAllWithCount(): array
    {
        $stmt = $this->db->prepare(
            "SELECT c.*, COUNT(p.id) as product_count
             FROM {$this->table} c
             LEFT JOIN products p ON p.category_id = c.id AND p.is_active = 1
             GROUP BY c.id
             ORDER BY c.name ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
