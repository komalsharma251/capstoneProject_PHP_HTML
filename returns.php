
<?php 
require_once __DIR__ . '/db/app.php'; 
$pageTitle = "Returns Policy – Shahizewer"; 
require_once 'views/header.php'; 
?>

<section class="py-5 bg-white">
  <div class="container" style="max-width:900px;">
    
    <h2 class="fw-bold text-center mb-5 text-gold">Returns & Refunds</h2>

    <h5 class="fw-bold">Return Eligibility</h5>
    <p class="text-muted">
      Items can be returned within 7 days of delivery if unused and in original condition.
    </p>

    <h5 class="fw-bold mt-4">Non-Returnable Items</h5>
    <p class="text-muted">
      Customized or worn jewellery items are not eligible for return.
    </p>

    <h5 class="fw-bold mt-4">Refund Process</h5>
    <p class="text-muted">
      Refunds will be processed within 5–7 business days after inspection.
    </p>

    <h5 class="fw-bold mt-4">How to Request Return</h5>
    <p class="text-muted">
      Contact us at <strong>support@shahizewer.com</strong> with your order details.
    </p>

  </div>
</section>

<?php require_once 'views/footer.php'; ?>