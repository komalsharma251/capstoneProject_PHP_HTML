
<?php 
require_once __DIR__ . '/db/app.php'; 
$pageTitle = "Privacy Policy – Shahizewer"; 
require_once 'views/header.php'; 
?>

<!-- ================= HERO ================= -->
<section class="policy-hero position-relative">
  <img src="<?= BASE_URL ?>/assets/images/privacy_banner.jpg" 
       class="w-100 h-100 object-fit-cover" 
       style="filter: brightness(60%);" 
       alt="Policy Banner">

  <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
    <h1 class="fw-bold text-gold" style="letter-spacing:3px; font-size:3rem;">
      <?= $pageTitle ?? 'Policy' ?>
    </h1>
    <p class="lead mt-2" style="color:#f0e6d2;">Transparent, Customer-Friendly & Professional</p>
  </div>
</section>

<style>
.policy-hero {
    height: 25vh; /* Perfect height, not too tall */
    max-height: 200px; /* Optional: prevents it from being too big on large screens */
}

.policy-hero img {
    object-fit: cover;
}
</style>

<!-- ================= CONTENT ================= -->
<section class="py-5 bg-white">
  <div class="container" style="max-width:900px;">
    
    <h4 class="fw-bold text-gold mb-3">1. Information We Collect</h4>
    <p class="text-muted">
      We collect personal information such as your name, email, phone number, and address when you place an order or contact us.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">2. How We Use Your Information</h4>
    <p class="text-muted">
      Your information is used to process orders, provide customer support, and improve our services.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">3. Data Protection</h4>
    <p class="text-muted">
      We implement secure measures to protect your personal data from unauthorized access or misuse.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">4. Cookies</h4>
    <p class="text-muted">
      Our website may use cookies to enhance your browsing experience.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">5. Third-Party Services</h4>
    <p class="text-muted">
      We do not sell or share your personal data with third parties except as required to deliver our services.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">6. Contact Us</h4>
    <p class="text-muted">
      If you have any questions, please contact us at <strong>support@shahizewer.com</strong>.
    </p>

  </div>
</section>

<?php require_once 'views/footer.php'; ?>