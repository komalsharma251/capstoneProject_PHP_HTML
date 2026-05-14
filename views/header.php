<?php
declare(strict_types=1);

// Include BASE_URL and start session
require_once __DIR__ . '/../db/app.php';
require_once __DIR__ . '/../db/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$cart_count = 0;

// Calculate cart count only for logged-in users
if ($user) {
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total_qty FROM carts WHERE user_id = ?");
    $stmt->execute([$user['user_id']]);
    $row = $stmt->fetch();
    $cart_count = (int)($row['total_qty'] ?? 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $pageTitle ?? 'Shahizewer - Indian Traditional Jewellery' ?></title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS -->
   
</style>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap_custom.css">
  <script src="<?= BASE_URL ?>/assets/js/app.js" defer></script>
</head>
<body>

<!-- ================= TOP BAR ================= -->
<div class="py-2 text-center text-white small" style="background:#111;">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
    
    <div class="d-flex gap-3">
      <span><i class="bx bx-truck" style="color:#BFA56A;"></i> Free Shipping in Canada</span>
      <span class="d-none d-md-inline">|</span>
      <a href="<?= BASE_URL ?>/appointment.php" class="text-decoration-none text-white">
        <i class="bx bx-time" style="color:#BFA56A;"></i> Book Appointment
      </a>
    </div>

    <div class="mt-2 mt-md-0">
      <span><i class="bx bx-phone" style="color:#BFA56A;"></i> +1 647 123 4567</span>
    </div>

  </div>
</div>

<!-- ================= PREMIUM NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm" style="background:#000;">
  <div class="container py-2">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?= BASE_URL ?>/index.php">
      <img src="<?= BASE_URL ?>/assets/images/newlogo.png" width="45" class="rounded-circle">
      <span style="color:#BFA56A; letter-spacing:2px;">SHAHIZEWER</span>
    </a>

    <!-- Mobile Button -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="mainNav">

      <ul class="navbar-nav mx-auto gap-lg-4 text-uppercase fw-semibold">

        <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle 
     <?= (in_array(basename($_SERVER['PHP_SELF']), ['index.php','about.php','faq.php'])) ? 'active' : '' ?>"
     href="#" id="homeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
     Home
  </a>

  <ul class="dropdown-menu dropdown-menu-dark shadow border-0 mt-2">
    
    <li>
      <a class="dropdown-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>"
         href="<?= BASE_URL ?>/index.php">
         <i class="bx bx-home me-2"></i> Home
      </a>
    </li>

    <li>
      <a class="dropdown-item <?= (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : '' ?>"
         href="<?= BASE_URL ?>/about.php">
         <i class="bx bx-info-circle me-2"></i> About Us
      </a>
    </li>

    <li>
      <a class="dropdown-item <?= (basename($_SERVER['PHP_SELF']) == 'faq.php') ? 'active' : '' ?>"
         href="<?= BASE_URL ?>/faq.php">
         <i class="bx bx-help-circle me-2"></i> FAQ
      </a>
    </li>

  </ul>
</li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= (basename($_SERVER['PHP_SELF']) == 'shop.php') ? 'active' : '' ?>"
            href="<?= BASE_URL ?>/shop.php"
            id="shopMenu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            Shop
          </a>
          <ul class="dropdown-menu" aria-labelledby="shopMenu">
            <?php
            // Fetch categories dynamically
            $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY category_name ASC");
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $category):
                $categorySlug = strtolower(str_replace(' ', '-', $category['category_name']));
            ?>
              <li>
                <a class="dropdown-item" href="<?= BASE_URL ?>/category.php?id=<?= $category['category_id'] ?>">
                  <?= htmlspecialchars($category['category_name']) ?>
                </a>
              </li>
            <?php endforeach; ?>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="<?= BASE_URL ?>/shop.php">All Products</a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/index.php#products">Featured</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/index.php#gallerySection">Gallery</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'appointment.php') ? 'active' : '' ?>"
             href="<?= BASE_URL ?>/appointment.php">Appointment</a>
        </li>

        

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>/index.php#contact">Contact</a>
        </li>

      </ul>

      <!-- ================= Account & Cart ================= -->
      <div class="d-flex align-items-center gap-3">

        <!-- Currency -->
        <select id="currency" name="currency"
            class="form-select form-select-sm text-white border-0 rounded-pill px-3"
            style="background:#111; width:auto;">
            <option value="CAD">CAD $</option>
            <option value="USD">USD $</option>
            <option value="INR">INR ₹</option>
        </select>

        <!-- Search -->
        <a href="<?= BASE_URL ?>/shop.php" class="text-decoration-none fs-5" style="color:#BFA56A;">
            <i class="bx bx-search"></i>
        </a>

        <!-- Account -->
        <?php if ($user): ?>
            <div class="dropdown">
                <a class="text-decoration-none fs-5 dropdown-toggle" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" style="color:#BFA56A;">
                    <i class="bx bx-user"></i> <?= htmlspecialchars($user['name']) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/account/index.php">Account</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/auth/login.php" class="text-decoration-none fs-5" style="color:gold;">
                <i class="bx bx-user"></i>
            </a>
        <?php endif; ?>

        <!-- Cart -->
        <a href="<?= BASE_URL ?>/cart.php" class="text-decoration-none fs-5 position-relative" style="color:#BFA56A;">
            <i class="bx bx-cart"></i>
            <?php if ($user && $cart_count > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                    <?= $cart_count ?>
                </span>
            <?php endif; ?>
        </a>

      </div>

    </div>
  </div>
</nav>

