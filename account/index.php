<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../db/app.php';      // BASE_URL
require_once __DIR__ . '/../db/database.php'; // PDO $pdo

// ------------------- AUTH CHECK -------------------
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    // Redirect to login if not logged in or not customer
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$user_name = htmlspecialchars($_SESSION['user']['name']);

// ------------------- HEADER -------------------
include __DIR__ . '/../views/header.php';
?>

<!-- ================= CUSTOMER DASHBOARD ================= -->
<section class="py-5" style="background:#f8f9fa; min-height:80vh;">
  <div class="container">

    <!-- Welcome -->
    <div class="text-center mb-5">
      <h1 class="fw-bold" style="font-family:'Playfair Display', serif; color:#b8860b;">
        Welcome, <?= $user_name ?>!
      </h1>
      <p class="text-muted">Here’s your account dashboard where you can manage your orders, view your wishlist, and update your details.</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4">

      <!-- Orders Card -->
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg p-4 rounded-4 text-center h-100">
          <i class="bx bx-shopping-bag fs-1 mb-3 text-gold"></i>
          <h5 class="fw-bold">My Orders</h5>
          <p class="text-muted">View your current and past orders</p>
          <a href="#" class="btn btn-gold rounded-pill px-4 mt-2">View Orders</a>
        </div>
      </div>

      <!-- Wishlist Card -->
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg p-4 rounded-4 text-center h-100">
          <i class="bx bx-heart fs-1 mb-3 text-gold"></i>
          <h5 class="fw-bold">Wishlist</h5>
          <p class="text-muted">Your favorite jewellery pieces</p>
          <a href="#" class="btn btn-gold rounded-pill px-4 mt-2">View Wishlist</a>
        </div>
      </div>

      <!-- Account Info Card -->
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg p-4 rounded-4 text-center h-100">
          <i class="bx bx-user fs-1 mb-3 text-gold"></i>
          <h5 class="fw-bold">Account Info</h5>
          <p class="text-muted">Update your profile and password</p>
          <a href="#" class="btn btn-gold rounded-pill px-4 mt-2">Edit Profile</a>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ================= LOGOUT BUTTON IN HEADER ================= -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const headerIcons = document.querySelector('.navbar .d-flex.align-items-center.gap-3');
    if (headerIcons) {
      // Create logout button
      const logoutBtn = document.createElement('a');
      logoutBtn.href = "<?= BASE_URL ?>/auth/logout.php";
      logoutBtn.className = "btn btn-outline-light rounded-pill px-3";
      logoutBtn.style.background = "gold";
      logoutBtn.style.color = "black";
      logoutBtn.style.marginLeft = "8px";
      logoutBtn.innerText = "Logout";

      headerIcons.appendChild(logoutBtn);
    }
  });
</script>

<?php
// ------------------- FOOTER -------------------
include __DIR__ . '/../views/footer.php';
?>
