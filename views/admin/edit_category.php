<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$error = '';
$category_id = (int)($_GET['id'] ?? 0);

if (!$category_id) {
    header("Location: " . BASE_URL . "/views/admin/categories.php");
    exit;
}

// Fetch category
$stmt = $pdo->prepare("SELECT * FROM categories WHERE category_id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    header("Location: " . BASE_URL . "/views/admin/categories.php");
    exit;
}

$category_name = $category['category_name'];

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

            // Check if another category already has this name
            $check = $pdo->prepare("
                SELECT category_id FROM categories
                WHERE category_name = ? AND category_id != ?
            ");
            $check->execute([$category_name, $category_id]);

            if ($check->fetch()) {
                $error = "Category name already exists.";
            } else {

                $stmt = $pdo->prepare("
                    UPDATE categories
                    SET category_name = ?
                    WHERE category_id = ?
                ");
                $stmt->execute([$category_name, $category_id]);

                header("Location: " . BASE_URL . "/views/admin/categories.php?updated=1");
                exit;
            }
        }
    }
}

include __DIR__ . '/../header.php';
?>

<div class="container mt-5">

    <!-- Heading + Back Button Row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-gold mb-0">Edit Category</h2>
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-gold btn-sm">&larr; Dashboard</a>
    </div>

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

        <button type="submit" class="btn btn-gold">Update Category</button>
        <a href="categories.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
