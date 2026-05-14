<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$order_id = (int)($_GET['id'] ?? 0);

if (!$order_id) {
    header("Location: orders.php");
    exit;
}

// Fetch order details
$stmt = $pdo->prepare("
    SELECT o.*, u.full_name, u.email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.user_id
    WHERE o.order_id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: orders.php");
    exit;
}

// Fetch order items
$stmt = $pdo->prepare("
    SELECT oi.*, p.product_name
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../header.php';

// Status badge styling
$status = strtolower($order['status'] ?? 'pending');
$badgeClass = match($status) {
    'pending' => 'bg-warning text-dark',
    'processing' => 'bg-info text-dark',
    'shipped' => 'bg-primary text-light',
    'delivered' => 'bg-success text-light',
    'cancelled' => 'bg-danger text-light',
    default => 'bg-secondary text-light'
};
?>

<div class="container mt-5">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="fw-bold text-gold mb-0">
      Order #<?= htmlspecialchars((string)$order['order_id']) ?>
    </h2>

    <a href="<?= BASE_URL ?>/views/admin/dashboard.php"
       class="btn btn-gold btn-sm rounded-pill px-3">
      ← Dashboard
    </a>
  </div>

  <!-- Order Summary -->
  <div class="card shadow rounded-4 p-4 mb-4">

    <div class="row g-3">

      <div class="col-md-6">
        <p><strong>Customer:</strong>
          <?= htmlspecialchars($order['full_name'] ?? 'Guest') ?>
        </p>

        <p><strong>Email:</strong>
          <?= htmlspecialchars($order['email'] ?? '-') ?>
        </p>

        <p><strong>Status:</strong>
          <span class="badge <?= $badgeClass ?>">
            <?= htmlspecialchars((string)$order['status']) ?>
          </span>
        </p>

        <p><strong>Date:</strong>
          <?= date('Y-m-d', strtotime($order['order_date'])) ?>
        </p>
      </div>

      <div class="col-md-6 text-md-end">
        <h4 class="fw-bold text-success">
          $<?= number_format((float)$order['total_amount'], 2) ?>
        </h4>
        <small class="text-muted">Total Amount</small>
      </div>

    </div>

    <hr>

    <p class="fw-bold mb-2">Shipping Address</p>
    <p class="mb-0">
      <?= htmlspecialchars($order['shipping_address'] ?? '-') ?><br>
      <?= htmlspecialchars($order['shipping_city'] ?? '-') ?>,
      <?= htmlspecialchars($order['shipping_postal_code'] ?? '-') ?><br>
      <?= htmlspecialchars($order['shipping_country'] ?? '-') ?>
    </p>

  </div>

  <!-- Order Items -->
  <h4 class="fw-bold text-gold mb-3">Order Items</h4>

  <div class="table-responsive shadow rounded-4 overflow-hidden">
    <table class="table table-hover align-middle mb-0">

      <thead class="bg-dark text-gold">
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Price</th>
          <th class="text-end">Total</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!$order_items): ?>
          <tr>
            <td colspan="4" class="text-center text-muted py-4">
              No items found.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($order_items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['product_name'] ?? 'Unknown') ?></td>
              <td><?= (int)$item['quantity'] ?></td>
              <td>$<?= number_format((float)$item['price'], 2) ?></td>
              <td class="fw-bold text-end">
                $<?= number_format((float)$item['price'] * (int)$item['quantity'], 2) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>

    </table>
  </div>

  <!-- Bottom Buttons -->
  <div class="mt-4 d-flex gap-2 flex-wrap">
    <a href="orders.php"
       class="btn btn-dark border border-warning text-warning rounded-pill px-4">
      Back to Orders
    </a>

    <a href="<?= BASE_URL ?>/views/admin/dashboard.php"
       class="btn btn-gold rounded-pill px-4">
      Back to Dashboard
    </a>
  </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
