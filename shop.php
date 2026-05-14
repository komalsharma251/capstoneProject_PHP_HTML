<?php
declare(strict_types=1);

require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

$pageTitle = "Shop - Shahizewer";
require_once __DIR__ . '/views/header.php';

// ------------------ Fetch Categories ------------------
$categories = $pdo->query("SELECT category_id, category_name FROM categories ORDER BY category_name ASC")
                  ->fetchAll(PDO::FETCH_ASSOC);

// ------------------ Filters ------------------
$category_id = (int)($_GET['category'] ?? 0);
$min_price   = $_GET['min_price'] ?? '';
$max_price   = $_GET['max_price'] ?? '';

$where = [];
$params = [];

// Filter by category
if ($category_id > 0) {
    $where[] = "p.category_id = ?";
    $params[] = $category_id;
}

// Filter by min price
if ($min_price !== '' && is_numeric($min_price)) {
    $where[] = "p.price >= ?";
    $params[] = (float)$min_price;
}

// Filter by max price
if ($max_price !== '' && is_numeric($max_price)) {
    $where[] = "p.price <= ?";
    $params[] = (float)$max_price;
}

// Final SQL
$sql = "
    SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-5" style="background:#fffdf7;">
  <div class="container">

    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase" style="color:#b8860b; letter-spacing:2px;">
        Shop Our Collection
      </h2>
      <p class="text-muted">Browse our jewellery products by category and price.</p>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-5">
      <form method="GET" class="row g-3 align-items-end">

        <!-- Category Filter -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Category</label>
          <select name="category" class="form-select form-select-lg rounded-3">
            <option value="0">All Categories</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= (int)$cat['category_id'] ?>"
                <?= ($category_id === (int)$cat['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['category_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Min Price -->
        <div class="col-md-3">
          <label class="form-label fw-semibold">Min Price</label>
          <input type="number" step="0.01" name="min_price"
                 value="<?= htmlspecialchars((string)$min_price) ?>"
                 class="form-control form-control-lg rounded-3"
                 placeholder="0">
        </div>

        <!-- Max Price -->
        <div class="col-md-3">
          <label class="form-label fw-semibold">Max Price</label>
          <input type="number" step="0.01" name="max_price"
                 value="<?= htmlspecialchars((string)$max_price) ?>"
                 class="form-control form-control-lg rounded-3"
                 placeholder="500">
        </div>

        <!-- Button -->
        <div class="col-md-2 d-grid">
          <button type="submit"
                  class="btn btn-lg rounded-pill fw-bold"
                  style="background:gold; color:black; border:none;">
            Filter
          </button>
        </div>

      </form>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">

      <?php if (!$products): ?>
        <div class="col-12">
          <div class="alert alert-warning text-center rounded-4 shadow-sm">
            No products found.
          </div>
        </div>
      <?php else: ?>

        <?php foreach ($products as $product): ?>

          <?php
            $image = $product['image_url'] ?? '';
            if (!$image) {
                $image = BASE_URL . "/assets/images/default.png";
            } else {
                if (str_starts_with($image, "/")) {
                    $image = BASE_URL . $image;
                } else {
                    $image = BASE_URL . "/" . $image;
                }
            }
          ?>

          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

              <img src="<?= htmlspecialchars($image) ?>"
                   class="w-100"
                   style="height:250px; object-fit:cover;"
                   alt="<?= htmlspecialchars($product['product_name']) ?>">

              <div class="card-body text-center p-4">

                <h5 class="fw-semibold mb-1">
                  <?= htmlspecialchars($product['product_name']) ?>
                </h5>

                <p class="text-muted small mb-2">
                  <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                </p>

                <p class="fw-bold fs-5" style="color:#b8860b;">
                  $<?= number_format((float)$product['price'], 2) ?> CAD
                </p>

                <a href="product_details.php?id=<?= (int)$product['product_id'] ?>"
                    class="btn btn-dark w-100 rounded-pill border border-warning text-warning fw-semibold mb-2">
                    View Details
                </a>

                <button class="btn btn-warning w-100 rounded-pill fw-semibold add-to-cart-btn"
                        data-id="<?= (int)$product['product_id'] ?>"
                        data-name="<?= htmlspecialchars($product['product_name'], ENT_QUOTES) ?>"
                        data-price="<?= (float)$product['price'] ?>">
                  Add to Cart
                </button>

              </div>

            </div>
          </div>

        <?php endforeach; ?>
      <?php endif; ?>

    </div>

  </div>
</section>

<!-- ================= AJAX Add to Cart ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
  $('.add-to-cart-btn').click(function() {
    const btn = $(this);
    const productId = btn.data('id');
    const name = btn.data('name');
    const price = btn.data('price');

    $.post('<?= BASE_URL ?>/cart_action.php', {
      action: 'add',
      product_id: productId,
      product_name: name,
      price: price
    }, function(data) {
      if (data.success) {
        $('.cart-count').text(data.cart_count); // Update header badge
        btn.text('Added').prop('disabled', true); // Feedback
      } else {
        alert("Error adding to cart.");
      }
    }, 'json');
  });
});
</script>


<?php require_once __DIR__ . '/views/footer.php'; ?>
