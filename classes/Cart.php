<?php
/**
 * Cart Class — Session-based Shopping Cart
 * Not extending BaseModel as this is session-only (no DB table)
 */
class Cart
{
    /**
     * Initialize cart in session
     */
    public static function init(): void
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Add item to cart
     */
    public static function add(int $productId, string $name, float $price, int $quantity = 1, string $image = 'default.jpg'): void
    {
        self::init();

        // If product already in cart, increment quantity
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $productId) {
                $item['quantity'] += $quantity;
                return;
            }
        }
        unset($item);

        // Add new item
        $_SESSION['cart'][] = [
            'product_id' => $productId,
            'name'       => $name,
            'price'      => $price,
            'quantity'   => $quantity,
            'image'      => $image,
        ];
    }

    /**
     * Update item quantity
     */
    public static function updateQty(int $productId, int $quantity): void
    {
        self::init();
        foreach ($_SESSION['cart'] as $key => &$item) {
            if ($item['product_id'] === $productId) {
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$key]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                } else {
                    $item['quantity'] = $quantity;
                }
                return;
            }
        }
    }

    /**
     * Remove item from cart
     */
    public static function remove(int $productId): void
    {
        self::init();
        $_SESSION['cart'] = array_values(
            array_filter($_SESSION['cart'], fn($item) => $item['product_id'] !== $productId)
        );
    }

    /**
     * Get all cart items (syncs with DB for accurate pricing)
     */
    public static function getItems(): array
    {
        self::init();
        require_once BASE_PATH . '/classes/Product.php';
        $productModel = new Product();
        
        $validItems = [];
        foreach ($_SESSION['cart'] as $item) {
            $product = $productModel->findById($item['product_id']);
            
            // Remove if product no longer exists or is inactive
            if (!$product || !$product['is_active']) {
                continue; 
            }
            
            // Recalculate price: check if flash sale is still active
            $price = ($product['flash_sale_price'] && strtotime($product['flash_sale_end']) > time())
                ? (float)$product['flash_sale_price']
                : (float)$product['price'];
                
            $item['price'] = $price;
            $item['name']  = $product['name'];
            $item['image'] = $product['image'];
            
            $validItems[] = $item;
        }
        
        // Update session with verified items and accurate prices
        $_SESSION['cart'] = $validItems;
        return $_SESSION['cart'];
    }

    /**
     * Get subtotal
     */
    public static function getSubtotal(): float
    {
        $total = 0;
        foreach (self::getItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Get total item count
     */
    public static function getCount(): int
    {
        return array_sum(array_column(self::getItems(), 'quantity'));
    }

    /**
     * Clear the cart
     */
    public static function clear(): void
    {
        $_SESSION['cart'] = [];
    }

    /**
     * Check if cart is empty
     */
    public static function isEmpty(): bool
    {
        return empty(self::getItems());
    }
}
