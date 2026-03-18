<?php

require_once __DIR__ . '/../config/app.php';
require_once BASE_PATH . '/classes/Product.php';
require_once BASE_PATH . '/classes/Category.php';

requireRole('seller');

$sellerId      = $_SESSION['user_id'];
$productModel  = new Product();
$categoryModel = new Category();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken()) {
        setFlash('error', 'Invalid request.');
        redirect('/seller_products.php');
    }

    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'create':
            $name        = sanitize($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price       = abs((float)($_POST['price'] ?? 0));
            $stock       = abs((int)($_POST['stock'] ?? 0));
            $categoryId  = (int)($_POST['category_id'] ?? 0);

            if (!$name || !$description || $price <= 0 || $categoryId <= 0) {
                setFlash('error', 'Please fill in all required fields.');
                redirect('/seller_products.php?action=add');
            }

            
            $imageName = 'default.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageName = handleImageUpload($_FILES['image']);
                if (!$imageName) {
                    redirect('/seller_products.php?action=add');
                }
            }

            $productModel->createProduct([
                'seller_id'   => $sellerId,
                'name'        => $name,
                'description' => $description,
                'price'       => $price,
                'stock'       => $stock,
                'category_id' => $categoryId,
                'image'       => $imageName,
                'is_active'   => 1,
            ]);

            setFlash('success', 'Product created successfully!');
            redirect('/seller_products.php');
            break;

        case 'update':
            $productId   = (int)($_POST['product_id'] ?? 0);
            $name        = sanitize($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price       = abs((float)($_POST['price'] ?? 0));
            $stock       = abs((int)($_POST['stock'] ?? 0));
            $categoryId  = (int)($_POST['category_id'] ?? 0);

            if (!$name || !$description || $price <= 0 || $categoryId <= 0) {
                setFlash('error', 'Please fill in all required fields.');
                redirect('/seller_products.php?action=edit&id=' . $productId);
            }

            $data = [
                'name'        => $name,
                'description' => $description,
                'price'       => $price,
                'stock'       => $stock,
                'category_id' => $categoryId,
            ];

            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageName = handleImageUpload($_FILES['image']);
                if ($imageName) {
                    $data['image'] = $imageName;
                }
            }

            $productModel->updateProduct($productId, $sellerId, $data);
            setFlash('success', 'Product updated successfully!');
            redirect('/seller_products.php');
            break;

        case 'delete':
            $productId = (int)($_POST['product_id'] ?? 0);
            $productModel->deleteProduct($productId, $sellerId);
            setFlash('success', 'Product deleted.');
            redirect('/seller_products.php');
            break;

        case 'toggle':
            $productId = (int)($_POST['product_id'] ?? 0);
            $productModel->toggleActive($productId, $sellerId);
            setFlash('success', 'Product status updated.');
            redirect('/seller_products.php');
            break;
    }

    redirect('/seller_products.php');
}

function handleImageUpload(array $file): string|false
{
    $allowedTypes = ['image/jpeg', 'image/png'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        setFlash('error', 'Image must be JPG or PNG.');
        return false;
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        setFlash('error', 'Image must be under 2MB.');
        return false;
    }

    $ext = $mimeType === 'image/png' ? 'png' : 'jpg';
    $filename = 'prod_' . time() . '_' . uniqid() . '.' . $ext;
    $uploadDir = BASE_PATH . '/public/assets/images/';

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

    return $filename;
}

$viewAction = $_GET['action'] ?? 'list';

if ($viewAction === 'add') {
    $categories = $categoryModel->findAll('name', 'ASC');
    $product = null;
    $pageTitle = 'Add Product';
    require BASE_PATH . '/views/seller/layout/header.php';
    require BASE_PATH . '/views/seller/product_form.php';
    require BASE_PATH . '/views/seller/layout/footer.php';

} elseif ($viewAction === 'edit') {
    $productId = (int)($_GET['id'] ?? 0);
    $product = $productModel->findById($productId);
    if (!$product || $product['seller_id'] !== $sellerId) {
        setFlash('error', 'Product not found.');
        redirect('/seller_products.php');
    }
    $categories = $categoryModel->findAll('name', 'ASC');
    $pageTitle = 'Edit Product';
    require BASE_PATH . '/views/seller/layout/header.php';
    require BASE_PATH . '/views/seller/product_form.php';
    require BASE_PATH . '/views/seller/layout/footer.php';

} else {
    $sellerProducts = $productModel->findBySeller($sellerId);
    $pageTitle = 'My Products';
    require BASE_PATH . '/views/seller/layout/header.php';
    require BASE_PATH . '/views/seller/products.php';
    require BASE_PATH . '/views/seller/layout/footer.php';
}
