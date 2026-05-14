<?php
declare(strict_types=1);

require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$totalQty = 0;

// Check if user is logged in
$user_id = $_SESSION['user']['user_id'] ?? null;

if ($user_id) {
    // Logged-in user: get cart count from DB
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) AS total_qty 
        FROM carts 
        WHERE user_id = ?
    ");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();
    $totalQty = (int)($row['total_qty'] ?? 0);

} else {
    // Guest user: use session cart
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $totalQty += (int)$item['quantity'];
        }
    }
}

header('Content-Type: application/json');
echo json_encode(['cart_count' => $totalQty]);
exit;
