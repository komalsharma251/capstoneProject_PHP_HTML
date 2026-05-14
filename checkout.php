<?php
declare(strict_types=1);

require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

$pageTitle = "Checkout - Shahizewer";
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
    <h2 class="fw-bold text-uppercase mb-4" style="color:#b8860b;">Checkout</h2>
    <p>Review your items and proceed to payment.</p>

    <?php if (empty($cartItems)): ?>
      <div class="alert alert-warning text-center rounded-4 shadow-sm">
        Your cart is empty.
      </div>
      <div class="text-center mt-4">
        <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
          <i class="bx bx-left-arrow-alt"></i> Keep Shopping
        </a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered align-middle" id="checkout-table">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cartItems as $item): ?>
              <?php
                $image = $item['image_url'] ?? 'assets/images/default.png';
                if (!str_starts_with($image, "/")) $image = BASE_URL . "/" . $image;
                else $image = BASE_URL . $image;
              ?>
              <tr data-product-id="<?= $item['product_id'] ?>">
                <td><img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="height:70px; object-fit:cover;"></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td>$<?= number_format((float)$item['price'], 2) ?></td>
                <td>
                  <input type="number" class="form-control quantity-input" value="<?= (int)$item['quantity'] ?>" min="1" style="width:80px;">
                </td>
                <td class="item-total">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                <td>
                  <button class="btn btn-sm btn-danger remove-item">Remove</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-end fw-bold fs-5">Grand Total:</td>
              <td colspan="2" class="fw-bold fs-5" id="grand-total">$<?= number_format($grand_total, 2) ?></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Keep Shopping + Proceed to Payment -->
      <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
        <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
          <i class="bx bx-left-arrow-alt"></i> Keep Shopping
        </a>

        <a href="<?= BASE_URL ?>/payment.php" class="btn btn-lg btn-warning fw-bold rounded-pill px-4">
          Proceed to Payment
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const table = document.getElementById('checkout-table');

  // Update quantity
  table.addEventListener('input', (e) => {
    if (e.target.classList.contains('quantity-input')) {
      const row = e.target.closest('tr');
      const productId = row.dataset.productId;
      const quantity = parseInt(e.target.value);

      if (quantity < 1) return;

      fetch('cart_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
          action: 'update',
          product_id: productId,
          quantity: quantity
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const price = parseFloat(row.children[2].textContent.replace('$',''));
          row.querySelector('.item-total').textContent = '$' + (price * quantity).toFixed(2);
          document.getElementById('grand-total').textContent = '$' + data.grand_total.toFixed(2);
          document.querySelector('.cart-count').textContent = data.cart_count;
        }
      });
    }
  });

  // Remove item
  table.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-item')) {
      const row = e.target.closest('tr');
      const productId = row.dataset.productId;

      fetch('cart_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
          action: 'remove',
          product_id: productId
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          row.remove();
          document.getElementById('grand-total').textContent = '$' + data.grand_total.toFixed(2);
          document.querySelector('.cart-count').textContent = data.cart_count;

          if (data.cart_count === 0) {
            table.innerHTML = '<tr><td colspan="6" class="text-center p-4">Your cart is empty. <a href="<?= BASE_URL ?>/shop.php">Go to shop</a></td></tr>';
          }
        }
      });
    }
  });
});
</script>

<?php require_once __DIR__ . '/views/footer.php'; ?>
