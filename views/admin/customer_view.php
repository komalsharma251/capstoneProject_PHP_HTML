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

// ------------------- Fetch Customer Details -------------------
$stmt = $pdo->prepare("
    SELECT u.*, COUNT(o.order_id) AS total_orders, SUM(o.total_amount) AS total_spent
    FROM users u
    LEFT JOIN orders o ON u.user_id = o.user_id
    WHERE u.user_id = ? AND u.role = 'customer'
    GROUP BY u.user_id
");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    header("Location: customers.php");
    exit;
}

// ------------------- Fetch Customer Orders -------------------
$stmt = $pdo->prepare("
    SELECT o.order_id, o.status, o.total_amount, o.order_date
    FROM orders o
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->execute([$customer_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../header.php';
?>

<div class="container mt-5">

    <!-- Back to Dashboard Button -->
    <div class="mb-3">
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-gold btn-sm">&larr; Dashboard</a>
    </div>

    <h2 class="fw-bold mb-4 text-gold">Customer Details</h2>

    <!-- Customer Info -->
    <div class="card shadow rounded-4 p-4 mb-4">
        <p><strong>Name:</strong> <?= htmlspecialchars($customer['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
        <p><strong>Joined:</strong> <?= date('Y-m-d', strtotime($customer['created_at'])) ?></p>
        <p><strong>Total Orders:</strong> <?= (int)$customer['total_orders'] ?></p>
        <p><strong>Total Spent:</strong> $<?= number_format((float)$customer['total_spent'], 2) ?></p>
    </div>

    <!-- Customer Orders -->
    <h4 class="fw-bold text-gold mb-3">Orders</h4>

    <div class="table-responsive shadow rounded-4 overflow-hidden">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-gold">
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!$orders): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No orders found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <?php
                        $status = strtolower($order['status'] ?? 'pending');
                        $status_class = match($status) {
                          'pending' => 'bg-warning text-dark',
                          'processing' => 'bg-info text-dark',
                          'shipped' => 'bg-primary text-light',
                          'delivered' => 'bg-success text-light',
                          'cancelled' => 'bg-danger text-light',
                          default => 'bg-secondary text-light'
                        };
                        ?>
                        <tr>
                            <td class="fw-bold">#<?= $order['order_id'] ?></td>
                            <td><span class="badge <?= $status_class ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                            <td>$<?= number_format((float)$order['total_amount'], 2) ?></td>
                            <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
                            <td>
                                <a href="order_view.php?id=<?= $order['order_id'] ?>"
                                   class="btn btn-sm btn-dark border border-warning text-warning rounded-pill px-3">
                                   View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <!-- Back Buttons -->
    <div class="mt-4 d-flex gap-2">
        <a href="customers.php" class="btn btn-dark border border-warning text-warning rounded-pill px-4">
            Back to Customers
        </a>
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-gold rounded-pill px-4">
            Back to Dashboard
        </a>
    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
