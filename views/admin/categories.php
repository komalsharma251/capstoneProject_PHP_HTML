<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

// Fetch all categories
$categories = $pdo->query("
    SELECT * FROM categories
    ORDER BY category_id DESC
")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../header.php';
?>

<div class="container-fluid mt-4">

  <!-- Heading + Back Button Row -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-gold fw-bold mb-0">Categories</h2>
    <div>
      <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-gold btn-sm me-2">&larr; Dashboard</a>
      <a href="add_category.php" class="btn btn-gold">+ Add Category</a>
    </div>
  </div>

  <div class="table-responsive shadow rounded-4 overflow-hidden">
    <table class="table table-hover align-middle mb-0">
      <thead class="bg-dark text-gold">
        <tr>
          <th>ID</th>
          <th>Category Name</th>
          <th>Created At</th>
          <th style="width: 200px;">Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php if (!$categories): ?>
          <tr>
            <td colspan="4" class="text-center text-muted py-4">No categories found.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($categories as $cat): ?>
            <tr>
              <td><?= (int)$cat['category_id'] ?></td>
              <td><?= htmlspecialchars($cat['category_name']) ?></td>
              <td><?= date('Y-m-d', strtotime($cat['created_at'])) ?></td>
              <td>
                <a href="edit_category.php?id=<?= (int)$cat['category_id'] ?>" class="btn btn-sm btn-warning">
                  Edit
                </a>

                <a href="delete_category.php?id=<?= (int)$cat['category_id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure you want to delete this category?');">
                  Delete
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>

    </table>
  </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
