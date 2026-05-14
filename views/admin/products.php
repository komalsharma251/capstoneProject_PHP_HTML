<?php
declare(strict_types=1);

require __DIR__ . '/../../auth/require_admin.php';
require __DIR__ . '/../../db/database.php';

// Fetch all products with category name
$products = $pdo->query("
    SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    ORDER BY p.product_id DESC
")->fetchAll(PDO::FETCH_ASSOC);

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include __DIR__ . '/../header.php';
?>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-gold">Products</h2>
    <div>
      <a href="dashboard.php" class="btn btn-gold btn-sm me-2">&larr; Dashboard</a>
      <a href="add_product.php" class="btn btn-gold">+ Add Product</a>
    </div>
  </div>

  <!-- Success Alerts -->
  <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">Product deleted successfully.</div>
  <?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Product updated successfully.</div>
  <?php endif; ?>

  <div class="table-responsive shadow rounded-4 overflow-hidden">
    <table class="table table-hover align-middle mb-0">
      <thead class="bg-dark text-gold">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Featured</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$products): ?>
          <tr>
            <td colspan="8" class="text-center text-muted py-4">No products found.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?= $p['product_id'] ?></td>
              <td><?= htmlspecialchars($p['product_name']) ?></td>
              <td><?= htmlspecialchars($p['category_name'] ?? '-') ?></td>
              <td>$<?= number_format((float)$p['price'], 2) ?></td>
              <td><?= $p['stock_quantity'] ?></td>
              <td><?= $p['is_featured'] ? 'Yes' : 'No' ?></td>
              <td><?= date('Y-m-d', strtotime($p['created_at'])) ?></td>
              <td>
                <a href="edit_product.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                <!-- Delete form -->
                <form method="post" action="delete_product.php" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
