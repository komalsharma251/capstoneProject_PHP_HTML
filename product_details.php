<?php
declare(strict_types=1);

require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

$product_id = (int)($_GET['id'] ?? 0);

if ($product_id <= 0) {
    header("Location: shop.php");
    exit;
}

// Fetch product
$stmt = $pdo->prepare("
    SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = ?
    LIMIT 1
");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: shop.php");
    exit;
}

$pageTitle = $product['product_name'] . " - Shahizewer";
require_once __DIR__ . '/views/header.php';

// Image handling
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

<section class="py-5" style="background:#fffdf7;">
  <div class="container">

    <div class="row g-5 align-items-center">

      <!-- Product Image -->
      <div class="col-lg-6">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
          <img src="<?= htmlspecialchars($image) ?>"
               class="w-100"
               style="height:500px; object-fit:cover;"
               alt="<?= htmlspecialchars($product['product_name']) ?>">
        </div>
      </div>

      <!-- Product Info -->
      <div class="col-lg-6">

        <h2 class="fw-bold mb-2" style="color:#b8860b;">
          <?= htmlspecialchars($product['product_name']) ?>
        </h2>

        <p class="text-muted mb-3">
          Category: <strong><?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?></strong>
        </p>

        <h3 class="fw-bold mb-4" style="color:#000;">
          $<?= number_format((float)$product['price'], 2) ?> CAD
        </h3>

        <p class="text-muted mb-4" style="line-height:1.8;">
          <?= nl2br(htmlspecialchars($product['description'] ?? 'No description available.')) ?>
        </p>

        <p class="fw-semibold mb-3">
          Stock Available:
          <span class="badge bg-dark text-warning px-3 py-2 rounded-pill">
            <?= (int)$product['stock_quantity'] ?>
          </span>
        </p>

        <!-- Quantity & Add to Cart -->
        <div class="d-flex align-items-center gap-3 mb-4">
          <label class="fw-semibold mb-0">Quantity:</label>
          <input type="number" id="productQty" value="1" min="1"
                 class="form-control" style="width:100px; border-radius:12px;">
        </div>

        <div class="d-flex gap-3">
          <button id="addToCartBtn"
                  class="btn btn-lg rounded-pill fw-bold px-5"
                  style="background:gold; color:black; border:none;">
            Add to Cart
          </button>

          <a href="shop.php"
             class="btn btn-lg btn-dark rounded-pill px-5 border border-warning text-warning fw-semibold">
            Back to Shop
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('#addToCartBtn').click(function(e) {
        e.preventDefault();

        const qty = parseInt($('#productQty').val()) || 1;

        $.post('cart_action.php', {
            action: 'add',
            product_id: <?= $product_id ?>,
            quantity: qty,
            product_name: '<?= addslashes($product['product_name']) ?>',
            price: <?= (float)$product['price'] ?>
        }, function(data) {
            if (data.success) {
                alert('✅ Product added to cart!');
                $('.cart-count').text(data.cart_count);
            } else {
                alert('❌ Failed to add to cart.');
            }
        }, 'json');
    });
});
</script>

<?php require_once __DIR__ . '/views/footer.php'; ?>