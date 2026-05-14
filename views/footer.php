<?php
   declare(strict_types=1);

  // Include BASE_URL and start session
  require_once __DIR__ . '/../db/app.php';

?>

<!-- =================  FOOTER (BOOTSTRAP) ================= -->
<footer class="text-white pt-5" style="background:#000;">
  <div class="container">

    <div class="row g-5">

      <!-- Brand -->
      <div class="col-md-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="<?= BASE_URL ?>/assets/images/newlogo.png" width="55" class="rounded-circle">
          <h4 class="fw-bold m-0" style="color:#BFA56A;">SHAHIZEWER</h4>
        </div>
        <p class="text-light opacity-75">
          Timeless Indian craftsmanship blended with modern elegance.  
          Explore luxury jewellery crafted with passion and perfection.
        </p>

        <div class="d-flex gap-4 mt-4 fs-3">
          <a href="https://www.instagram.com/shahizewer/" class="text-decoration-none" style="color:#BFA56A;">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.facebook.com/navjot.komal.shori" class="text-decoration-none" style="color:#BFA56A;">
            <i class="fab fa-facebook"></i>
          </a>
          <a href="https://www.tiktok.com/@shahizewer" target="_blank" class="text-decoration-none" style="color:#BFA56A;">
            <i class="fab fa-tiktok"></i>
          </a>
        </div>


      </div>

      <!-- Quick Links -->
      <div class="col-md-2">
        <h6 class="fw-bold text-uppercase mb-3 text-gold">Quick Links</h6>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="<?= BASE_URL ?>/index.php" class="text-decoration-none text-light opacity-75">Home</a></li>
          <li><a href="<?= BASE_URL ?>/shop.php" class="text-decoration-none text-light opacity-75">Shop</a></li>
          <li><a href="<?= BASE_URL ?>/track_order.php" class="text-decoration-none text-light opacity-75">Track Order</a></li>
          <li><a href="<?= BASE_URL ?>/appointment.php" class="text-decoration-none text-light opacity-75">Appointment</a></li>
        </ul>
      </div>

      <!-- Policies -->
      <!-- Policies -->
<div class="col-md-2">
  <h6 class="fw-bold text-uppercase mb-3 text-gold">Policies</h6>
  <ul class="list-unstyled d-flex flex-column gap-2">

    <li>
      <a href="<?= BASE_URL ?>/privacy.php" 
        class="text-light 
        <?= (basename($_SERVER['PHP_SELF']) == 'privacy.php') ? 'active-link' : 'text-decoration-none opacity-75' ?>">
        Privacy Policy
      </a>
    </li>

    <li>
      <a href="<?= BASE_URL ?>/terms.php" 
        class="text-light 
        <?= (basename($_SERVER['PHP_SELF']) == 'terms.php') ? 'active-link' : 'text-decoration-none opacity-75' ?>">
        Terms & Conditions  
      </a>
    </li>

    <li>
      <a href="<?= BASE_URL ?>/shipping.php" 
        class="text-light 
        <?= (basename($_SERVER['PHP_SELF']) == 'shipping.php') ? 'active-link' : 'text-decoration-none opacity-75' ?>">
        Shipping Policy
      </a>
    </li>

    <li>
      <a href="<?= BASE_URL ?>/returns.php" 
        class="text-light 
        <?= (basename($_SERVER['PHP_SELF']) == 'returns.php') ? 'active-link' : 'text-decoration-none opacity-75' ?>">
        Return Policy
      </a>
    </li>

  </ul>
</div>

      <!-- Newsletter -->
      <div class="col-md-4">
        <h6 class="fw-bold text-uppercase mb-3" style="color:#BFA56A;">Newsletter</h6>
        <p class="text-light opacity-75">
          Subscribe to get updates about new collections, offers & exclusive deals.
        </p>

        <form class="d-flex gap-2" id="newsletterForm" method="POST" action="#">
          <input type="email"
                id="newsletterEmail"
                name="newsletterEmail"
                class="form-control rounded-pill px-4"
                placeholder="Enter your email"
                autocomplete="email"
                required>

                  <button type="submit"
                  class="btn rounded-pill fw-bold px-4"
                  style="background:#BFA56A; color:black;">
            Subscribe
          </button>
        </form>


        <div class="mt-4">
          <p class="mb-1 text-light opacity-75">
            <i class="bx bx-map me-2" style="color:#BFA56A;"></i> Toronto, Canada
          </p>
          <p class="mb-1 text-light opacity-75">
            <i class="bx bx-phone me-2" style="color:#BFA56A;"></i> +1 647 123 4567
          </p>
          <p class="mb-0 text-light opacity-75">
            <i class="bx bx-envelope me-2" style="color:#BFA56A;"></i> support@shahizewer.com
          </p>
        </div>
      </div>

    </div>

    <hr class="border-secondary mt-5">

    <!-- Bottom Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pb-3">
      <p class="mb-2 mb-md-0 text-light opacity-75">
          © <?= date('Y') ?> <span style="color:#BFA56A;">SHAHIZEWER</span> | Made with ❤️ by Komal
      </p>

      <div class="d-flex align-items-center gap-4 mt-3">

  <!-- VISA -->
  <div class="payment-icon">
    <svg height="28" viewBox="0 0 80 30" xmlns="http://www.w3.org/2000/svg">
      <text x="50%" y="65%" text-anchor="middle"
            font-size="18"
            font-weight="bold"
            fill="#BFA56A"
            font-family="Arial, sans-serif">
        VISA
      </text>
    </svg>
  </div>

  <!-- MasterCard -->
  <div class="payment-icon">
    <svg height="28" viewBox="0 0 80 30" xmlns="http://www.w3.org/2000/svg">
      <circle cx="35" cy="15" r="10" fill="#BFA56A" opacity="0.9"/>
      <circle cx="50" cy="15" r="10" fill="#BFA56A" opacity="0.9"/>
    </svg>
  </div>

  <!-- PayPal -->
  <div class="payment-icon">
    <svg height="28" viewBox="0 0 80 30" xmlns="http://www.w3.org/2000/svg">
      <text x="50%" y="65%" text-anchor="middle"
            font-size="16"
            font-weight="bold"
            fill="#BFA56A"
            font-family="Arial, sans-serif">
        PayPal
      </text>
    </svg>
  </div>

</div>






    </div>

  </div>
</footer>


<!-- ================= GALLERY MODAL ================= -->
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center p-0">
        <img id="galleryModalImg" class="img-fluid rounded-4 shadow-lg">
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

<!-- Cart Count Auto Refresh Script -->
<script>
function refreshCartCount() {
  fetch("<?= BASE_URL ?>/cart_count.php")
    .then(res => res.json())
    .then(data => {
      const badge = document.querySelector(".cart-count");
      if (badge) {
        badge.innerText = data.cart_count;
      }
    })
    .catch(err => console.log(err));
}

// run instantly when page loads
document.addEventListener("DOMContentLoaded", function () {
  refreshCartCount();

  // auto refresh every 2 seconds
  setInterval(refreshCartCount, 2000);
});
</script>

<!-- Contact Form Submission Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("contactForm");
    const successAlert = document.getElementById("successAlert");

    if(form){
        form.addEventListener("submit", function(e){
            e.preventDefault();

            // Hide success message before sending new request
            if(successAlert) successAlert.classList.add("d-none");

            const formData = new FormData(form);
            console.log([...formData.entries()]); // Debug: check what is being sent

            fetch("<?= BASE_URL ?>/contact_submit.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    document.getElementById("successAlert").classList.remove("d-none");
                    form.reset();
                } else {
                    alert("Error sending message: " + data.error);
                }
            })
            .catch(err => alert("Request failed: " + err));

        });
    }

});

</script>



<!-- Back to Top Button -->
<button id="backToTopBtn" class="back-to-top">
  ↑
</button>
</body>
</html>