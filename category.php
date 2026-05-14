<?php
require_once __DIR__ . '/db/app.php';
require_once __DIR__ . '/db/database.php';

// Get category ID
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch category


$stmt = $pdo->prepare("SELECT * FROM categories WHERE category_id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);


// SEO Title
$pageTitle = $category 
    ? $category['category_name'] . " Jewellery in Canada | Shahizewer"
    : "Shop Jewellery | Shahizewer";

require_once 'views/header.php';

// Safe values
$categoryName = $category['category_name'] ?? 'Jewellery Collection';

$heroImage = (!empty($category['image_url']))
    ? BASE_URL . '/' . ltrim($category['image_url'], '/')
    : BASE_URL . '/assets/images/default-banner.jpg';

$heroText = (!empty($category['description']))
    ? $category['description']
    : 'Explore our exclusive handcrafted jewellery collection designed for elegance and luxury.';
?>




<!-- ================= CATEGORY HERO ================= -->
<?php if ($category): ?>
<section class="policy-hero position-relative">

  <img src="<?= htmlspecialchars($heroImage) ?>"
       class="w-100 h-100 object-fit-cover"
       style="filter: brightness(60%);"
       alt="<?= htmlspecialchars($categoryName) ?> Jewellery Banner"
       onerror="this.src='<?= BASE_URL ?>/assets/images/default-banner.jpg'">

  <div class="position-absolute top-50 start-50 translate-middle text-center text-white">

    <!-- Breadcrumb -->
    <p class="mb-2">
      <a href="<?= BASE_URL ?>" class="text-light text-decoration-none">Home</a>
      <span> / </span>
      <span><?= htmlspecialchars($categoryName) ?></span>
    </p>

    <!-- Title -->
    <h1 class="fw-bold text-gold" style="letter-spacing:3px; font-size:3rem;">
      <?= htmlspecialchars($categoryName) ?>
    </h1>

    <!-- Description -->
    <p class="lead mt-3" style="color:#f0e6d2; max-width:700px;">
      <?= htmlspecialchars($heroText) ?>
    </p>

    <!-- CTA Button -->
    <a href="#products" class="btn btn-gold mt-3 px-4 py-2 fw-bold">
      Shop <?= htmlspecialchars($categoryName) ?>
    </a>

  </div>
</section>
<?php endif; ?>


<!-- ================= PRODUCTS ================= -->
<section class="py-5 bg-light" id="products">
  <div class="container text-center">

    <?php if (!$category): ?>
        <h3 class="text-danger">Sorry, this category does not exist.</h3>
    <?php else: ?>

        <div class="row g-4 justify-content-center">

        <?php
        // Fetch products
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY product_id DESC");
        $stmt->execute([$category_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($products):
            foreach ($products as $product):
                $imagePath = !empty($product['image_url']) 
                    ? ltrim($product['image_url'], '/') 
                    : 'assets/images/default.png';

                $imageSrc = BASE_URL . '/' . $imagePath;

                $price = is_numeric($product['price']) 
                    ? number_format((float)$product['price'], 2) 
                    : '0.00';
        ?>

            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card featured-card h-100 border-0 shadow-sm">

                <img src="<?= htmlspecialchars($imageSrc) ?>"
                     class="featured-img"
                     loading="lazy"
                     alt="<?= htmlspecialchars($product['product_name']) ?>"
                     onerror="this.src='<?= BASE_URL ?>/assets/images/default.png'">

                <div class="card-body">
                  <h5 class="fw-semibold">
                    <?= htmlspecialchars($product['product_name']) ?>
                  </h5>

                  <p class="text-muted mb-2">
                    $<?= $price ?> CAD
                  </p>

                  <a href="<?= BASE_URL ?>/product_details.php?id=<?= $product['product_id'] ?>"
                     class="btn btn-gold w-100">
                     View Details
                  </a>
                </div>

              </div>
            </div>

        <?php
            endforeach;
        else:
        ?>

            <h5 class="text-muted mt-4">
              No products found in this category yet.
            </h5>

        <?php endif; ?>

        </div>

    <?php endif; ?>

  </div>
</section>

<?php require_once 'views/footer.php'; ?>