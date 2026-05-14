<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

// Fetch all orders with customer name
$orders = $pdo->query("
    SELECT o.*, u.full_name
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../header.php';
?>

<div class="container-fluid mt-4">

  <!-- Header Section -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="fw-bold text-gold mb-0">Orders</h2>

    <a href="<?= BASE_URL ?>/views/admin/dashboard.php"
       class="btn btn-gold btn-sm rounded-pill px-3">
       ← Dashboard
    </a>
  </div>

  <!-- Orders Table -->
  <div class="table-responsive shadow rounded-4 overflow-hidden">
    <table class="table table-hover align-middle mb-0">

      <thead class="bg-dark text-gold">
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Status</th>
          <th>Total</th>
          <th>Date</th>
          <th>Shipping</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!$orders): ?>
          <tr>
            <td colspan="7" class="text-center text-muted py-4">
              No orders found.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($orders as $order): ?>
            <?php
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

            <tr>
              <td class="fw-bold">
                #<?= htmlspecialchars((string)$order['order_id']) ?>
              </td>

              <td>
                <?= htmlspecialchars($order['full_name'] ?? 'Guest') ?>
              </td>

              <td>
                <span class="badge <?= $badgeClass ?>">
                  <?= htmlspecialchars((string)$order['status']) ?>
                </span>
              </td>

              <td class="fw-bold text-success">
                $<?= number_format((float)$order['total_amount'], 2) ?>
              </td>

              <td>
                <?= date('Y-m-d', strtotime($order['order_date'])) ?>
              </td>

              <td>
                <?= htmlspecialchars($order['shipping_city'] ?? '-') ?>,
                <?= htmlspecialchars($order['shipping_country'] ?? '-') ?>
              </td>

              <td class="text-center">
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                  <a href="order_view.php?id=<?= (int)$order['order_id'] ?>"
                     class="btn btn-sm btn-dark border border-warning text-warning rounded-pill px-3">
                    View
                  </a>

                  <a href="order_update_status.php?id=<?= (int)$order['order_id'] ?>"
                     class="btn btn-sm btn-warning rounded-pill px-3">
                    Update
                  </a>
                </div>
              </td>
            </tr>

          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>

    </table>
  </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
