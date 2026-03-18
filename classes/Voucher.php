<?php
require_once BASE_PATH . '/classes/BaseModel.php';

/**
 * Voucher Model
 */
class Voucher extends BaseModel
{
    protected string $table = 'vouchers';

    private ?int $id = null;
    private string $code = '';
    private int $discountPercent = 0;
    private int $maxUse = 100;
    private int $usedCount = 0;
    private string $expiredAt = '';

    // ── Getters ──────────────────────────────────────────
    public function getId(): ?int { return $this->id; }
    public function getCode(): string { return $this->code; }
    public function getDiscountPercent(): int { return $this->discountPercent; }

    // ── Setters ──────────────────────────────────────────
    public function setCode(string $code): void { $this->code = $code; }
    public function setDiscountPercent(int $pct): void { $this->discountPercent = $pct; }

    /**
     * Find voucher by code
     */
    public function findByCode(string $code): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE code = :code LIMIT 1");
        $stmt->execute(['code' => strtoupper($code)]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Check if voucher is valid
     */
    public function isValid(string $code): array
    {
        $voucher = $this->findByCode($code);

        if (!$voucher) {
            return ['valid' => false, 'message' => 'Voucher code not found.'];
        }
        if (strtotime($voucher['expired_at']) < time()) {
            return ['valid' => false, 'message' => 'Voucher has expired.'];
        }
        if ($voucher['used_count'] >= $voucher['max_use']) {
            return ['valid' => false, 'message' => 'Voucher usage limit reached.'];
        }

        return [
            'valid'            => true,
            'message'          => 'Voucher applied!',
            'discount_percent' => $voucher['discount_percent'],
            'voucher_id'       => $voucher['id'],
        ];
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(int $id): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET used_count = used_count + 1 WHERE id = :id AND used_count < max_use"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
