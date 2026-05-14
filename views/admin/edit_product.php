<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/app.php';
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$error = '';
$product_id = (int)($_GET['id'] ?? 0);

if (!$product_id) {
    header("Location: " . BASE_URL . "/views/admin/products.php");
    exit;
}

// Fetch product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: " . BASE_URL . "/views/admin/products.php");
    exit;
}

// Pre-fill values
$product_name   = $product['product_name'];
$category_id    = $product['category_id'];
$description    = $product['description'];
$price          = $product['price'];
$stock_quantity = $product['stock_quantity'];
$is_featured    = $product['is_featured'];
$image_url      = $product['image_url'];

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch categories
$categories = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name ASC")->fetchAll();

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF check
    $csrf = $_POST['csrf_token'] ?? '';
    if (!$csrf || $csrf !== $_SESSION['csrf_token']) {
        $error = "Invalid request.";
    } else {

        $product_name   = trim($_POST['product_name'] ?? '');
        $category_id    = trim($_POST['category_id'] ?? '');
        $description    = trim($_POST['description'] ?? '');
        $price          = trim($_POST['price'] ?? '');
        $stock_quantity = trim($_POST['stock_quantity'] ?? '');
        $is_featured    = isset($_POST['is_featured']) ? 1 : 0;

        if ($product_name === '' || $price === '' || $category_id === '') {
            $error = "Product name, price, and category are required.";
        } elseif (!is_numeric($price) || $price < 0) {
            $error = "Price must be a positive number.";
        } elseif (!is_numeric($stock_quantity) || $stock_quantity < 0) {
            $error = "Stock quantity must be a non-negative number.";
        } else {

            // Optional image upload
            if (!empty($_FILES['image']['tmp_name'])) {
                $target_dir = __DIR__ . "/../../assets/images/products/";
                $target_file = $target_dir . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                $image_url = "/assets/images/products/" . basename($_FILES['image']['name']);
            }

            // Update product
            $stmt = $pdo->prepare("
                UPDATE products SET 
                    category_id = :category_id,
                    product_name = :product_name,
                    description = :description,
                    price = :price,
                    stock_quantity = :stock_quantity,
                    is_featured = :is_featured,
                    image_url = :image_url
                WHERE product_id = :product_id
            ");

            $stmt->execute([
                'category_id'    => $category_id,
                'product_name'   => $product_name,
                'description'    => $description,
                'price'          => $price,
                'stock_quantity' => $stock_quantity,
                'is_featured'    => $is_featured,
                'image_url'      => $image_url,
                'product_id'     => $product_id
            ]);

            header("Location: " . BASE_URL . "/views/admin/products.php?updated=1");
            exit;
        }
    }
}

include __DIR__ . '/../header.php';
?>

<div class="container mt-5">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-gold btn-sm">&larr; Dashboard</a>
    </div>

    <h2 class="fw-bold mb-4 text-gold">Edit Product</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <!-- Product Name -->
        <div class="mb-3">
            <label class="form-label fw-bold">Product Name</label>
            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars((string)$product_name) ?>" required>
        </div>

        <!-- Category -->
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

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars((string)$description) ?></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label class="form-label fw-bold">Price ($)</label>
            <input type="text" name="price" class="form-control" value="<?= htmlspecialchars((string)$price) ?>" required>
        </div>

        <!-- Stock Quantity -->
        <div class="mb-3">
            <label class="form-label fw-bold">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars((string)$stock_quantity) ?>" required>
        </div>

        <!-- Featured -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_featured" class="form-check-input" id="featuredCheck" <?= $is_featured ? 'checked' : '' ?>>
            <label class="form-check-label fw-bold" for="featuredCheck">Featured Product</label>
        </div>

        <!-- Current Image -->
        <div class="mb-3">
            <label class="form-label fw-bold">Current Image</label><br>
            <?php if ($image_url): ?>
                <img src="<?= htmlspecialchars($image_url) ?>" alt="Product Image" width="150" class="mb-2">
            <?php else: ?>
                <span class="text-muted">No image uploaded</span>
            <?php endif; ?>
        </div>

        <!-- Change Image -->
        <div class="mb-3">
            <label class="form-label fw-bold">Change Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-gold">Update Product</button>
    </form>
</div>

<?php
include __DIR__ . '/../footer.php';
?>
