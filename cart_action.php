<?php
declare(strict_types=1);
require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

$response = [
    'success' => false,
    'cart_count' => 0,
    'grand_total' => 0,
    'item_total' => 0
];

$action = $_POST['action'] ?? '';
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
$product_name = $_POST['product_name'] ?? '';
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;

// ---------------- Use consistent session key ----------------
$user_id = $_SESSION['user']['user_id'] ?? null;

if ($user_id) {
    // ------------------- ADD -------------------
    if ($action === 'add' && $product_id > 0) {
        $stmt = $pdo->prepare("
            INSERT INTO carts (user_id, product_id, quantity) 
            VALUES (?, ?, 1) 
            ON DUPLICATE KEY UPDATE quantity = quantity + 1, updated_at = NOW()
        ");
        $stmt->execute([$user_id, $product_id]);
        $response['success'] = true;

    // ------------------- UPDATE -------------------
    } elseif ($action === 'update' && $product_id > 0) {
        $stmt = $pdo->prepare("UPDATE carts SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([max(1,$quantity), $user_id, $product_id]);
        $response['success'] = true;

        // Get actual price for item total
        $stmt2 = $pdo->prepare("SELECT price FROM products WHERE product_id = ?");
        $stmt2->execute([$product_id]);
        $product = $stmt2->fetch();
        $response['item_total'] = $product ? $product['price'] * $quantity : 0;

    // ------------------- REMOVE -------------------
    } elseif ($action === 'remove' && $product_id > 0) {
        $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $response['success'] = true;
    }

    // ------------------- CALCULATE TOTALS -------------------
    $stmt = $pdo->prepare("
        SELECT SUM(c.quantity) as total_qty, SUM(c.quantity * p.price) as total_amount
        FROM carts c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $totals = $stmt->fetch();

    $response['cart_count'] = (int)($totals['total_qty'] ?? 0);
    $response['grand_total'] = (float)($totals['total_amount'] ?? 0);

} else {
    // ------------------- GUEST SESSION CART -------------------
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    if ($action === 'add' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'product_id' => $product_id,
                'product_name' => $product_name,
                'price' => $price,
                'quantity' => 1
            ];
        }
        $response['success'] = true;

    } elseif ($action === 'update' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] = max(1,$quantity);
            $response['item_total'] = $_SESSION['cart'][$product_id]['price'] * $_SESSION['cart'][$product_id]['quantity'];
            $response['success'] = true;
        }

    } elseif ($action === 'remove' && $product_id > 0) {
        unset($_SESSION['cart'][$product_id]);
        $response['success'] = true;
    }

    // Calculate totals
    $grandTotal = 0;
    $totalQty = 0;
    foreach ($_SESSION['cart'] as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
        $totalQty += $item['quantity'];
    }
    $response['cart_count'] = $totalQty;
    $response['grand_total'] = $grandTotal;
}

echo json_encode($response);
exit;
