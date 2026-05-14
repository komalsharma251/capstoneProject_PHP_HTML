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

$error = "";

// Fetch order
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: orders.php");
    exit;
}

$status = strtolower($order['status'] ?? 'pending');

// Status badge styling
$badgeClass = match($status) {
    'pending' => 'bg-warning text-dark',
    'processing' => 'bg-info text-dark',
    'shipped' => 'bg-primary text-light',
    'delivered' => 'bg-success text-light',
    'cancelled' => 'bg-danger text-light',
    default => 'bg-secondary text-light'
};

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $csrf = $_POST['csrf_token'] ?? '';
    if (!$csrf || $csrf !== $_SESSION['csrf_token']) {
        $error = "Invalid request.";
    } else {

        $new_status = strtolower(trim($_POST['status'] ?? ''));

        $allowed = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($new_status, $allowed, true)) {
            $error = "Invalid status selected.";
        } else {

            $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
            $stmt->execute([$new_status, $order_id]);

            header("Location: orders.php?updated=1");
            exit;
        }
    }
}

include __DIR__ . '/../header.php';
?>

<div class="container mt-5">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="fw-bold text-gold mb-0">
      Update Order #<?= htmlspecialchars((string)$order_id) ?>
    </h2>

    <a href="<?= BASE_URL ?>/views/admin/dashboard.php"
       class="btn btn-gold btn-sm rounded-pill px-3">
      ← Dashboard
    </a>
  </div>

  <?php if ($error): ?>
    <div class="alert alert-danger shadow-sm rounded-3">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <div class="card shadow rounded-4 p-4">

    <!-- Current Status -->
    <div class="mb-4">
      <label class="fw-bold">Current Status:</label>
      <span class="badge <?= $badgeClass ?> ms-2">
        <?= ucfirst(htmlspecialchars($status)) ?>
      </span>
    </div>

    <!-- Update Form -->
    <form method="post">

      <input type="hidden" name="csrf_token"
             value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div class="mb-4">
        <label class="form-label fw-bold">Change Status</label>
        <select name="status"
                class="form-select rounded-3"
                required>

          <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="processing" <?= $status === 'processing' ? 'selected' : '' ?>>Processing</option>
          <option value="shipped" <?= $status === 'shipped' ? 'selected' : '' ?>>Shipped</option>
          <option value="delivered" <?= $status === 'delivered' ? 'selected' : '' ?>>Delivered</option>
          <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>

      <!-- Buttons -->
      <div class="d-flex gap-2 flex-wrap">
        <button type="submit"
                class="btn btn-gold rounded-pill px-4">
          Update Status
        </button>

        <a href="orders.php"
           class="btn btn-dark border border-warning text-warning rounded-pill px-4">
          Cancel
        </a>
      </div>

    </form>

  </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
