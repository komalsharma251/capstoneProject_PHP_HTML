<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$category_id = (int)($_GET['id'] ?? 0);

if (!$category_id) {
    header("Location: " . BASE_URL . "/views/admin/categories.php");
    exit;
}

// OPTIONAL: Check if category is used by products
$check = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
$check->execute([$category_id]);
$count = (int)$check->fetchColumn();

if ($count > 0) {
    header("Location: " . BASE_URL . "/views/admin/categories.php?error=used");
    exit;
}

// Delete category
$stmt = $pdo->prepare("DELETE FROM categories WHERE category_id = ?");
$stmt->execute([$category_id]);

header("Location: " . BASE_URL . "/views/admin/categories.php?deleted=1");
exit;
