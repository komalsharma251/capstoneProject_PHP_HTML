<?php
declare(strict_types=1);

require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

$pageTitle = "Payment - Shahizewer";
require_once __DIR__ . '/views/header.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// ---------------- Load Cart ----------------
$cartItems = [];
$grand_total = 0;
$user_id = $_SESSION['user']['user_id'] ?? null;

if ($user_id) {
    // Logged-in user: fetch from DB
    $stmt = $pdo->prepare("
        SELECT c.product_id, c.quantity, p.product_name, p.price, p.image_url
        FROM carts c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Guest: use session cart
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $cartItems = $_SESSION['cart'];
}

// Calculate grand total
foreach ($cartItems as $item) {
    $grand_total += $item['price'] * $item['quantity'];
}
?>

<section class="py-5" style="background:#fffdf7;">
  <div class="container">
    <h2 class="fw-bold text-uppercase mb-4" style="color:#b8860b;">Payment</h2>
    
    <?php if (empty($cartItems)): ?>
      <div class="alert alert-warning text-center rounded-4 shadow-sm">
        Your cart is empty. <a href="<?= BASE_URL ?>/shop.php">Go to shop</a>
      </div>
      <div class="text-center mt-4">
        <a href="<?= BASE_URL ?>/cart.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
          <i class="bx bx-left-arrow-alt"></i> Back to Cart
        </a>
      </div>
    <?php else: ?>
      <!-- Order Summary -->
      <div class="mb-4">
        <h4 class="fw-bold mb-3">Order Summary</h4>
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cartItems as $item): ?>
                <tr>
                  <td><?= htmlspecialchars($item['product_name']) ?></td>
                  <td><?= (int)$item['quantity'] ?></td>
                  <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2" class="text-end fw-bold fs-5">Grand Total:</td>
                <td class="fw-bold fs-5">$<?= number_format($grand_total, 2) ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Payment Form -->
      <div class="card shadow-sm rounded-4 p-4" style="max-width:600px;">
        <h4 class="fw-bold mb-3">Enter Payment Details</h4>
        <form method="post" action="process_payment.php">
          <div class="mb-3">
            <label class="form-label fw-semibold">Name on Card</label>
            <input type="text" name="card_name" class="form-control rounded-pill" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Card Number</label>
            <input type="text" name="card_number" class="form-control rounded-pill" placeholder="1234 5678 9012 3456" required>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label fw-semibold">Expiry Month</label>
              <input type="text" name="exp_month" class="form-control rounded-pill" placeholder="MM" required>
            </div>
            <div class="col">
              <label class="form-label fw-semibold">Expiry Year</label>
              <input type="text" name="exp_year" class="form-control rounded-pill" placeholder="YYYY" required>
            </div>
            <div class="col">
              <label class="form-label fw-semibold">CVV</label>
              <input type="text" name="cvv" class="form-control rounded-pill" placeholder="123" required>
            </div>
          </div>

          <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/cart.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
              <i class="bx bx-left-arrow-alt"></i> Back to Cart
            </a>
            <button type="submit" class="btn btn-lg btn-warning fw-bold rounded-pill px-4">
              Pay $<?= number_format($grand_total, 2) ?>
            </button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/views/footer.php'; ?>
