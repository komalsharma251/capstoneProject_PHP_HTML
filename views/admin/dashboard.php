<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';

// ------------------- AUTH CHECK -------------------
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$admin_name = htmlspecialchars($_SESSION['user']['name'] ?? 'Admin');

// ------------------- FETCH DYNAMIC DATA -------------------

// Total products
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn() ?: 0;

// Total orders
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn() ?: 0;

// Total customers
$total_customers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn() ?: 0;

// Total revenue
$total_revenue = $pdo->query("SELECT SUM(total_amount) FROM orders")->fetchColumn() ?: 0;

// Recent 5 orders
$recent_orders = $pdo->query("
    SELECT o.order_id, u.full_name, o.status, o.total_amount, o.order_date
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// ------------------- INCLUDE HEADER -------------------
include __DIR__ . '/../header.php';
?>

<style>
  .admin-sidebar {
    background: #111;
    min-height: 100vh;
    border-right: 1px solid rgba(255, 215, 0, 0.2);
  }

  .admin-sidebar .nav-link {
    padding: 12px 15px;
    border-radius: 12px;
    margin-bottom: 8px;
    transition: 0.2s;
    font-weight: 600;
  }

  .admin-sidebar .nav-link:hover {
    background: rgba(255, 215, 0, 0.15);
    color: #BFA56A !important;
  }

  .admin-sidebar .nav-link.active {
    background: #BFA56A;
    color: black !important;
  }

  .stat-card {
    background: #111;
    border: 1px solid rgba(255, 215, 0, 0.2);
    color: white;
    transition: 0.2s;
  }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0px 10px 25px rgba(0,0,0,0.4);
  }

  .badge-gold {
    background: #BFA56A;
    color: black;
    font-weight: bold;
  }

  .table thead {
    background: #111;
    color: #BFA56A;
  }
</style>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar p-3">
      <h4 class="fw-bold mb-4" style="color:#BFA56A; font-family:'Playfair Display', serif;">
        Shahizewer Admin
      </h4>

      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>"
             href="<?= BASE_URL ?>/views/admin/dashboard.php">
            <i class="bx bx-home-alt me-2"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : '' ?>"
             href="<?= BASE_URL ?>/views/admin/products.php">
            <i class="bx bx-box me-2"></i> Products
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'active' : '' ?>"
            href="<?= BASE_URL ?>/views/admin/categories.php">
        <i class="bx bx-category me-2"></i> Categories
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : '' ?>"
             href="<?= BASE_URL ?>/views/admin/orders.php">
            <i class="bx bx-cart-alt me-2"></i> Orders
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : '' ?>"
             href="<?= BASE_URL ?>/views/admin/customers.php">
            <i class="bx bx-user me-2"></i> Customers
          </a>
        </li>

        <li class="nav-item mt-3">
          <a class="nav-link text-danger fw-bold"
             href="<?= BASE_URL ?>/auth/logout.php">
            <i class="bx bx-log-out me-2"></i> Logout
          </a>
        </li>
      </ul>
    </nav>

    <!-- Main Content -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">

      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="fw-bold" style="font-family:'Playfair Display', serif; color:#BFA56A;">
            Admin Dashboard
          </h1>
          <p class="text-muted mb-0">Welcome back, <?= $admin_name ?></p>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="row g-4">

        <div class="col-md-3">
          <div class="card stat-card shadow rounded-4 text-center p-4">
            <i class="bx bx-box fs-1 mb-2" style="color:#BFA56A;"></i>
            <h6 class="fw-bold">Products</h6>
            <p class="text-light small mb-2 opacity-75">
              Total inventory items
            </p>
            <span class="badge badge-gold fs-6 px-3 py-2"><?= $total_products ?></span>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card stat-card shadow rounded-4 text-center p-4">
            <i class="bx bx-cart-alt fs-1 mb-2" style="color:#BFA56A;"></i>
            <h6 class="fw-bold">Orders</h6>
            <p class="text-light small mb-2 opacity-75"> All orders placed</p>
            <span class="badge badge-gold fs-6 px-3 py-2"><?= $total_orders ?></span>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card stat-card shadow rounded-4 text-center p-4">
            <i class="bx bx-user fs-1 mb-2" style="color:#BFA56A;"></i>
            <h6 class="fw-bold">Customers</h6>
            <p class="text-light small mb-2 opacity-75">Registered customers</p>
            <span class="badge badge-gold fs-6 px-3 py-2"><?= $total_customers ?></span>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card stat-card shadow rounded-4 text-center p-4">
            <i class="bx bx-dollar-circle fs-1 mb-2" style="color:#BFA56A;"></i>
            <h6 class="fw-bold">Revenue</h6>
            <p class="text-light small mb-2 opacity-75">Total sales amount</p>
            <span class="badge badge-gold fs-6 px-3 py-2">
              $<?= number_format((float)$total_revenue, 2) ?>
            </span>
          </div>
        </div>

      </div>

      <!-- Recent Orders -->
      <div class="mt-5">
        <h4 class="fw-bold mb-3" style="color:gold;">Recent Orders</h4>

        <div class="table-responsive shadow rounded-4 overflow-hidden">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Total</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              <?php if (!$recent_orders): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    No orders found.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($recent_orders as $order): ?>
                  <tr>
                    <td class="fw-bold">#<?= htmlspecialchars((string)$order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['full_name'] ?? 'Guest') ?></td>

                    <td>
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
                      <span class="badge <?= $status_class ?>">
                        <?= htmlspecialchars((string)$order['status']) ?>
                      </span>
                    </td>

                    <td class="fw-bold">
                      $<?= number_format((float)$order['total_amount'], 2) ?>
                    </td>

                    <td>
                      <?= date('Y-m-d', strtotime($order['order_date'])) ?>
                    </td>

                    <td>
                      <a href="<?= BASE_URL ?>/views/admin/order_view.php?id=<?= $order['order_id'] ?>"
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
      </div>

    </main>
  </div>
</div>

<?php
include __DIR__ . '/../footer.php';
?>
