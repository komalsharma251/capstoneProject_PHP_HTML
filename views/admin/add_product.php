<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$error = '';
$product_name = '';
$category_id = '';
$description = '';
$price = '';
$stock_quantity = '';
$is_featured = 0;
$image_url = '';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch categories for dropdown
$categories = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name ASC")->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF check
    $csrf = $_POST['csrf_token'] ?? '';
    if (!$csrf || $csrf !== $_SESSION['csrf_token']) {
        $error = "Invalid request. Please refresh and try again.";
    } else {
        $product_name   = trim($_POST['product_name'] ?? '');
        $category_id    = trim($_POST['category_id'] ?? '');
        $description    = trim($_POST['description'] ?? '');
        $price          = trim($_POST['price'] ?? '');
        $stock_quantity = trim($_POST['stock_quantity'] ?? '');
        $is_featured    = isset($_POST['is_featured']) ? 1 : 0;

        // Basic validation
        if ($product_name === '' || $price === '' || $category_id === '') {
            $error = "Product name, price, and category are required.";
        } elseif (!is_numeric($price) || $price < 0) {
            $error = "Price must be a positive number.";
        } elseif (!is_numeric($stock_quantity) || $stock_quantity < 0) {
            $error = "Stock quantity must be a non-negative number.";
        } else {

            // Optional: handle image upload
            $image_url = $_FILES['image']['name'] ?? '';
            if ($image_url && isset($_FILES['image']['tmp_name'])) {
                $target_dir = __DIR__ . "/../../assets/images/products/";
                $target_file = $target_dir . basename($image_url);
                move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                $image_url = "/assets/images/products/" . basename($image_url);
            }

            // Insert into products table
            $stmt = $pdo->prepare("
                INSERT INTO products 
                (category_id, product_name, description, price, stock_quantity, is_featured, image_url)
                VALUES (:category_id, :product_name, :description, :price, :stock_quantity, :is_featured, :image_url)
            ");

            $stmt->execute([
                'category_id'    => $category_id,
                'product_name'   => $product_name,
                'description'    => $description,
                'price'          => $price,
                'stock_quantity' => $stock_quantity,
                'is_featured'    => $is_featured,
                'image_url'      => $image_url
            ]);

            header("Location: " . BASE_URL . "/views/admin/products.php?added=1");
            exit;
        }
    }
}

// Include header
include __DIR__ . '/../header.php';
?>

<div class="container mt-5">
    <h2 class="fw-bold mb-4" style="color:gold;">Add Product</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <div class="mb-3">
            <label class="form-label fw-bold">Product Name</label>
            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product_name) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $category_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Price ($)</label>
            <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($price) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($stock_quantity) ?>" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_featured" class="form-check-input" id="featuredCheck" <?= $is_featured ? 'checked' : '' ?>>
            <label class="form-check-label fw-bold" for="featuredCheck">Featured Product</label>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Product Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-gold">Add Product</button>
    </form>
</div>

<?php
include __DIR__ . '/../footer.php';
?>
