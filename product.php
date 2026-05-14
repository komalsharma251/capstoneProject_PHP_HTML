<?php
require_once __DIR__ . '/../db/app.php';
require_once __DIR__ . '/../db/database.php';

$pageTitle = "Products – Shahizewer"; 
require_once 'header.php';

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-5 bg-white text-center">
  <div class="container">
    <h2 class="section-title mb-5">Our Products</h2>
    <div class="row g-4">
      <?php foreach ($products as $product): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card product-card h-100">
            <img src="<?= BASE_URL ?>/assets/images/placeholder.png" class="card-img-top" alt="<?= htmlspecialchars($product['product_name']) ?>">
            <div class="card-body">
              <h5><?= htmlspecialchars($product['product_name']) ?></h5>
              <p>$<?= number_format($product['price'], 2) ?> CAD</p>
              <a href="#" class="btn btn-dark w-100">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
