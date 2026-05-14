<?php
declare(strict_types=1);

require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

$pageTitle = "Shopping Cart - Shahizewer";
require_once __DIR__ . '/views/header.php';

// ---------------- Load Cart ----------------
$cartItems = [];
$grand_total = 0;

if (!empty($_SESSION['user']['user_id'])) {
    // Logged-in user: fetch from DB
    $user_id = $_SESSION['user']['user_id'];
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
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $cartItems = $_SESSION['cart'];
}

// Calculate grand total
foreach ($cartItems as $item) {
    $grand_total += $item['price'] * $item['quantity'];
}
?>

<section class="py-5" style="background:#fffdf7;">
  <div class="container">
    <h2 class="fw-bold text-uppercase mb-4" style="color:#b8860b;">Your Shopping Cart</h2>

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
        <table class="table table-bordered align-middle">
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
                // Determine image path
                $image = $item['image_url'] ?? 'assets/images/default.png';
                if (!str_starts_with($image, "/")) {
                    $image = BASE_URL . "/" . $image;
                } else {
                    $image = BASE_URL . $image;
                }
              ?>
              <tr data-id="<?= (int)$item['product_id'] ?>">
                <td><img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="height:70px; object-fit:cover;"></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td>$<?= number_format((float)$item['price'], 2) ?></td>
                <td>
                  <input type="number" class="form-control quantity-input" value="<?= (int)$item['quantity'] ?>" min="1" style="width:80px;">
                </td>
                <td class="item-total">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                <td>
                  <button class="btn btn-danger btn-sm remove-item-btn">Remove</button>
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

      <!-- Keep Shopping + Checkout Buttons -->
      <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
        <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
          <i class="bx bx-left-arrow-alt"></i> Keep Shopping
        </a>

        <a href="<?= BASE_URL ?>/checkout.php" class="btn btn-lg btn-warning fw-bold rounded-pill px-4">
          Proceed to Checkout
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ================= AJAX Cart Update ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
  // Update quantity
  $('.quantity-input').on('change', function() {
    const row = $(this).closest('tr');
    const productId = row.data('id');
    const newQty = parseInt($(this).val());
    if (newQty < 1) { $(this).val(1); return; }

    $.post('cart_action.php', { action: 'update', product_id: productId, quantity: newQty }, function(data) {
      if (data.success) {
        row.find('.item-total').text('$' + data.item_total.toFixed(2));
        $('#grand-total').text('$' + data.grand_total.toFixed(2));
        $('.cart-count').text(data.cart_count);
      } else {
        alert('Failed to update quantity.');
      }
    }, 'json');
  });

  // Remove item
  $('.remove-item-btn').click(function() {
    const row = $(this).closest('tr');
    const productId = row.data('id');

    $.post('cart_action.php', { action: 'remove', product_id: productId }, function(data) {
      if (data.success) {
        row.remove();
        $('#grand-total').text('$' + data.grand_total.toFixed(2));
        $('.cart-count').text(data.cart_count);
        if (data.cart_count === 0) {
          location.reload(); // reload to show empty cart message
        }
      } else {
        alert('Failed to remove item.');
      }
    }, 'json');
  });
});
</script>

<?php require_once __DIR__ . '/views/footer.php'; ?>
