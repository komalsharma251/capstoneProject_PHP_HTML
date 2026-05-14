<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$error = '';
$success = '';
$category_name = '';

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $csrf = $_POST['csrf_token'] ?? '';
    if (!$csrf || $csrf !== $_SESSION['csrf_token']) {
        $error = "Invalid request.";
    } else {

        $category_name = trim($_POST['category_name'] ?? '');

        if ($category_name === '') {
            $error = "Category name is required.";
        } else {

            // Check if category already exists
            $check = $pdo->prepare("SELECT category_id FROM categories WHERE category_name = ?");
            $check->execute([$category_name]);

            if ($check->fetch()) {
                $error = "Category already exists.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
                $stmt->execute([$category_name]);

                header("Location: " . BASE_URL . "/views/admin/categories.php?added=1");
                exit;
            }
        }
    }
}

include __DIR__ . '/../header.php';
?>

<div class="container mt-5">
  <h2 class="fw-bold mb-4 text-gold">Add Category</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <div class="mb-3">
      <label class="form-label fw-bold">Category Name</label>
      <input type="text" name="category_name" class="form-control"
             value="<?= htmlspecialchars($category_name) ?>" required>
    </div>

    <button type="submit" class="btn btn-gold">Add Category</button>
    <a href="categories.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
