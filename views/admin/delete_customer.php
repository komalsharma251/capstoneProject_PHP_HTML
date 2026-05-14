<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

// ------------------- Get Customer ID -------------------
$customer_id = (int)($_GET['id'] ?? 0);
if (!$customer_id) {
    header("Location: customers.php");
    exit;
}

// ------------------- Check if Customer Exists -------------------
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ? AND role = 'customer'");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    header("Location: customers.php");
    exit;
}

// ------------------- Optional: Delete Orders First -------------------
// Uncomment if you want to delete all orders of the customer
/*
$stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?)");
$stmt->execute([$customer_id]);

$stmt = $pdo->prepare("DELETE FROM orders WHERE user_id = ?");
$stmt->execute([$customer_id]);
*/

// ------------------- Delete Customer -------------------
$stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ? AND role = 'customer'");
$deleted = $stmt->execute([$customer_id]);

// ------------------- Redirect with Message -------------------
if ($deleted) {
    header("Location: customers.php?msg=Customer+deleted+successfully");
} else {
    header("Location: customers.php?msg=Failed+to+delete+customer");
}
exit;
?>
