
<?php 
require_once __DIR__ . '/db/app.php'; 
$pageTitle = "Terms & Conditions – Shahizewer"; 
require_once 'views/header.php'; 
?>

<!-- ================= HERO ================= -->
<section class="policy-hero position-relative overflow-hidden">

  <img src="<?= BASE_URL ?>/assets/images/policy_banner.jpg" 
       class="policy-img"
       alt="Terms Banner">

  <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-3">
    <h1 class="fw-bold text-gold mb-2" style="letter-spacing:3px;">
      Terms & Conditions
    </h1>
    <p class="lead mb-0" style="color:#f0e6d2;">
      Your Rights & Responsibilities Simplified
    </p>
  </div>

</section>
<!-- ================= CONTENT ================= -->
<section class="py-5 bg-white">
  <div class="container" style="max-width:900px;">

    <h4 class="fw-bold text-gold mb-3">1. Introduction</h4>
    <p class="text-muted">
      Welcome to Shahizewer. By accessing our website, you agree to comply with these terms and conditions.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">2. Use of Website</h4>
    <p class="text-muted">
      You agree to use our website only for lawful purposes and in a way that does not infringe the rights of others.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">3. Product Information</h4>
    <p class="text-muted">
      We strive to ensure that all product details, descriptions, and prices are accurate. However, errors may occur.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">4. Pricing & Payments</h4>
    <p class="text-muted">
      All prices are listed in CAD unless stated otherwise. We reserve the right to change prices at any time without notice.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">5. Orders & Cancellations</h4>
    <p class="text-muted">
      We reserve the right to cancel or refuse any order at our discretion. Customers will be notified in case of any issue.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">6. Intellectual Property</h4>
    <p class="text-muted">
      All content on this website, including images and text, is the property of Shahizewer and may not be used without permission.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">7. Limitation of Liability</h4>
    <p class="text-muted">
      We are not liable for any indirect or consequential damages arising from the use of our website.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">8. Changes to Terms</h4>
    <p class="text-muted">
      We may update these terms from time to time. Continued use of the website means you accept the updated terms.
    </p>

    <h4 class="fw-bold text-gold mt-4 mb-3">9. Contact Information</h4>
    <p class="text-muted">
      For any questions regarding these terms, please contact us at 
      <strong>support@shahizewer.com</strong>.
    </p>

  </div>
</section>

<?php require_once 'views/footer.php'; ?>