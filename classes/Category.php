<?php
require_once BASE_PATH . '/classes/BaseModel.php';

/**
 * Category Model
 */
class Category extends BaseModel
{
    protected string $table = 'categories';

    private ?int $id = null;
    private string $name = '';
    private string $iconClass = 'fa-box';

    // ── Getters ──────────────────────────────────────────
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getIconClass(): string { return $this->iconClass; }

    // ── Setters ──────────────────────────────────────────
    public function setName(string $name): void { $this->name = $name; }
    public function setIconClass(string $icon): void { $this->iconClass = $icon; }

    /**
     * Get all categories with product count
     */
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
