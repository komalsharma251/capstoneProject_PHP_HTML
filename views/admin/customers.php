<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

// ------------------- Pagination Setup -------------------
$limit = 10; // customers per page
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// ------------------- Search -------------------
$search = trim($_GET['search'] ?? '');
$where = "WHERE u.role = 'customer'";
$params = [];

if ($search !== '') {
    $where .= " AND (u.full_name LIKE ? OR u.email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// ------------------- Total Customers -------------------
$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM users u $where");
$total_stmt->execute($params);
$total_customers = (int)$total_stmt->fetchColumn();
$total_pages = (int)ceil($total_customers / $limit);

// ------------------- Fetch Customers -------------------
$sql = "
    SELECT u.user_id, u.full_name, u.email, u.created_at, COUNT(o.order_id) AS order_count
    FROM users u
    LEFT JOIN orders o ON u.user_id = o.user_id
    $where
    GROUP BY u.user_id
    ORDER BY u.created_at DESC
    LIMIT $limit OFFSET $offset
";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../header.php';
?>

<div class="container mt-5">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-gold btn-sm">&larr; Dashboard</a>
    </div>

    <h2 class="fw-bold mb-4 text-gold">Customers</h2>

    <!-- Search Form -->
    <form class="mb-4" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by name or email..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-dark border border-warning text-warning" type="submit">
                <i class="bx bx-search"></i> Search
            </button>
        </div>
    </form>

    <div class="table-responsive shadow rounded-4 overflow-hidden">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-dark text-gold">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Orders</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$customers): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No customers found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($customers as $c): ?>
                        <tr>
                            <td><?= $c['user_id'] ?></td>
                            <td><?= htmlspecialchars($c['full_name']) ?></td>
                            <td><?= htmlspecialchars($c['email']) ?></td>
                            <td><?= date('Y-m-d', strtotime($c['created_at'])) ?></td>
                            <td><?= $c['order_count'] ?></td>
                            <td>
                                <a href="customer_view.php?id=<?= $c['user_id'] ?>" 
                                   class="btn btn-sm btn-dark border border-warning text-warning rounded-pill px-3">
                                   View
                                </a>
                                <a href="delete_customer.php?id=<?= $c['user_id'] ?>" 
                                   class="btn btn-sm btn-danger rounded-pill px-3"
                                   onclick="return confirm('Are you sure to delete this customer?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
