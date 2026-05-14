<?php
declare(strict_types=1);

require __DIR__ . '/../../auth/require_admin.php';
require __DIR__ . '/../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "/views/admin/products.php");
    exit;
}

// CSRF check
$csrf = $_POST['csrf_token'] ?? '';
if (!$csrf || $csrf !== ($_SESSION['csrf_token'] ?? '')) {
    die("Invalid request.");
}

// Get product ID
$product_id = (int)($_POST['product_id'] ?? 0);
if (!$product_id) {
    header("Location: " . BASE_URL . "/views/admin/products.php");
    exit;
}

// Optional: delete product image
$stmt = $pdo->prepare("SELECT image_url FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product && !empty($product['image_url'])) {
    $image_path = __DIR__ . "/../../" . ltrim($product['image_url'], '/');
    if (file_exists($image_path)) {
        unlink($image_path); // delete image file
    }
}

// Delete product
$stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);

header("Location: " . BASE_URL . "/views/admin/products.php?deleted=1");
exit;
