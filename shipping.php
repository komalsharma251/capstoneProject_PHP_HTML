
<?php 
require_once __DIR__ . '/db/app.php'; 
$pageTitle = "Shipping Policy – Shahizewer"; 
require_once 'views/header.php'; 
?>

<section class="py-5 bg-light">
  <div class="container" style="max-width:900px;">
    
    <h2 class="fw-bold text-center mb-5 text-gold">Shipping Policy</h2>

    <h5 class="fw-bold">Delivery Time</h5>
    <p class="text-muted">Orders are processed within 1–2 business days and delivered within 5–7 business days across Canada.</p>

    <h5 class="fw-bold mt-4">Shipping Charges</h5>
    <p class="text-muted">We offer free shipping on all orders within Canada.</p>

    <h5 class="fw-bold mt-4">Order Tracking</h5>
    <p class="text-muted">Once your order is shipped, you will receive a tracking number via email.</p>

    <h5 class="fw-bold mt-4">Delays</h5>
    <p class="text-muted">Delivery times may vary due to holidays or unforeseen circumstances.</p>

  </div>
</section>

<?php require_once 'views/footer.php'; ?>