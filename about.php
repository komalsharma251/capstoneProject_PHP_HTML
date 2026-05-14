<?php 
require_once __DIR__ . '/db/app.php'; 
$pageTitle = "About Us – Shahizewer"; 
require_once 'views/header.php'; 
?>

<!-- ================= HERO ================= -->
<section class="position-relative">
  <div style="
      background:url('<?= BASE_URL ?>/assets/images/about_image2.jpg') center/cover no-repeat;
      height:60vh;
      filter:brightness(60%);
  "></div>

  <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
    <h1 class="fw-bold">
      ABOUT <span class="text-gold">SHAHIZEWER</span>
    </h1>
    <p class="typing-text">Timeless Elegance • Indian Heritage • Modern Luxury</p>
  </div>
</section>

<!-- ================= OUR STORY ================= -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center g-5">
      
      <!-- Image -->
      <div class="col-lg-6">
        <img src="<?= BASE_URL ?>/assets/images/about_story.png" 
             class="img-fluid rounded-4 shadow-lg" alt="Our Story">
      </div>

      <!-- Text -->
      <div class="col-lg-6">
        <h2 class="fw-bold mb-3" style="color:#BFA56A;">Our Story</h2>
        
            <p class="text-muted">
              <strong>SHAHIZEWER</strong> was born from a deep love for 
              <span class="text-gold fw-semibold">traditional Indian jewellery</span> 
              and a vision to bring 
              <span class="text-gold fw-semibold">timeless elegance</span> 
              to modern women. Every piece tells a story of 
              <strong>heritage</strong>, <strong>craftsmanship</strong>, and <strong>passion</strong>.
            </p>

            <p class="text-muted">
              Founded in <strong>Canada</strong>, our brand bridges cultures — blending the richness of 
              <span class="text-gold fw-semibold">Indian traditions</span> 
              with 
              <span class="text-gold fw-semibold">contemporary luxury designs</span> 
              perfect for every occasion.
            </p>

            <p class="text-muted">
              At <strong>SHAHIZEWER</strong>, jewellery is more than adornment — it is a reflection of 
              <span class="text-gold fw-semibold">emotions</span>, 
              <span class="text-gold fw-semibold">memories</span>, 
              and <span class="text-gold fw-semibold">timeless beauty</span>. 
              Each piece is thoughtfully crafted to celebrate life’s most meaningful moments, from 
              <strong>weddings</strong> to <strong>everyday elegance</strong>.
            </p>

            <p class="text-muted">
              Inspired by the richness of <strong>Indian heritage</strong> and the grace of 
              <strong>modern design</strong>, our creations are made to make you feel 
              <span class="text-gold fw-semibold">confident</span>, 
              <span class="text-gold fw-semibold">radiant</span>, 
              and deeply connected to your story.  
              When you wear SHAHIZEWER, you carry not just jewellery, but a feeling of 
              <strong>tradition</strong>, <strong>love</strong>, and <strong>lasting elegance</strong>.
            </p>
      </div>

    </div>
  </div>
</section>

<!-- ================= MISSION / VISION ================= -->
<section class="py-5 text-white" style="background:#000;">
  <div class="container text-center">
    
    <h2 class="fw-bold mb-5" style="color:#BFA56A;">Our Philosophy</h2>

    <div class="row g-4">

      <div class="col-md-4">
        <div class="p-4 border rounded-4 h-100">
          <i class="bx bx-diamond fs-1 mb-3" style="color:#BFA56A;"></i>
          <h5 class="fw-bold">Craftsmanship</h5>
          <p class="text-light opacity-75">
            Each piece is handcrafted with precision, ensuring premium quality and attention to detail.
          </p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-4 border rounded-4 h-100">
          <i class="bx bx-heart fs-1 mb-3" style="color:#BFA56A;"></i>
          <h5 class="fw-bold">Passion</h5>
          <p class="text-light opacity-75">
            We design jewellery that celebrates love, tradition, and unforgettable moments.
          </p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="p-4 border rounded-4 h-100">
          <i class="bx bx-star fs-1 mb-3" style="color:#BFA56A;"></i>
          <h5 class="fw-bold">Elegance</h5>
          <p class="text-light opacity-75">
            Our collections are crafted to add sophistication and grace to every outfit.
          </p>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-5 bg-light">
  <div class="container">
    
    <div class="text-center mb-5">
      <h2 class="fw-bold" style="color:#BFA56A;">Why Choose Us</h2>
      <p class="text-muted">Experience luxury jewellery like never before</p>
    </div>

    <div class="row g-4 text-center">

      <div class="col-md-3">
        <div class="p-4 rounded-4 shadow-sm bg-white h-100">
          <i class="bx bx-check-shield fs-1 mb-3" style="color:#BFA56A;"></i>
          <h6 class="fw-bold">Premium Quality</h6>
        </div>
      </div>

      <div class="col-md-3">
        <div class="p-4 rounded-4 shadow-sm bg-white h-100">
          <i class="bx bx-gift fs-1 mb-3" style="color:#BFA56A;"></i>
          <h6 class="fw-bold">Perfect for Gifting</h6>
        </div>
      </div>

      <div class="col-md-3">
        <div class="p-4 rounded-4 shadow-sm bg-white h-100">
          <i class="bx bx-package fs-1 mb-3" style="color:#BFA56A;"></i>
          <h6 class="fw-bold">Fast Shipping</h6>
        </div>
      </div>

      <div class="col-md-3">
        <div class="p-4 rounded-4 shadow-sm bg-white h-100">
          <i class="bx bx-refresh fs-1 mb-3" style="color:#BFA56A;"></i>
          <h6 class="fw-bold">Easy Returns</h6>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-5 text-center text-white" style="background:#000;">
  <div class="container">
    <h2 class="fw-bold mb-3" style="color:#BFA56A;">Discover Our Collection</h2>
    <p class="mb-4 text-light opacity-75">
      Explore jewellery designed to make every moment special.
    </p>
    <a href="<?= BASE_URL ?>/shop.php" class="btn btn-lg px-5 fw-bold"
       style="background:#BFA56A; color:black; border-radius:30px;">
       Shop Now
    </a>
  </div>
</section>

<?php require_once 'views/footer.php'; ?>