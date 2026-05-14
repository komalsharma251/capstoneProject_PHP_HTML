<?php 
require_once __DIR__ . '/db/app.php'; 
require_once __DIR__ . '/db/database.php'; // database connection

$pageTitle = "Home – Shahizewer"; 
require_once 'views/header.php'; 
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero-section position-relative">
  <video autoplay muted loop playsinline class="w-100" 
         style="height:100vh; object-fit:cover; filter: brightness(60%); position:absolute; top:0; left:0; z-index:-1;">
    <source src="assets/images/bgVideo.mp4" type="video/mp4">
  </video>

  <div class="hero-overlay d-flex flex-column justify-content-center align-items-center text-center text-white" style="height:100vh;">
  
  <h1 class="display-1 fw-bold text-center" style="letter-spacing:5px;">
    SOPHISTICATION <span class="text-gold">| Shahizewer Jewellery</span>
  </h1>
<p class="fs-4 text-light mt-3">
  Timeless Indian Heritage • Modern Luxury • Handcrafted Bangles & Earrings
</p>
  <!-- Buttons wrapper -->
  <div class="d-flex mt-3">
    <a href="<?= BASE_URL ?>/shop.php" class="btn-gold btn-gold-md me-3">
      Necklaces
    </a>
    <a href="https://cal.com/rehaan-shori-qccnuz/free-consultation" target="_blank" class="btn-gold btn-gold-md">
      Book Consultation
    </a>
  </div>

</div>
</section>

<!-- ================= FEATURED PRODUCTS ================= -->
<section class="py-5 bg-white text-center" id="products">
  <div class="container">
    <h2 class="section-title mb-2 text-center fw-bold">
      Featured Jewellery Collections
    </h2>
    <p class="text-muted fs-5 text-center mb-5">
      Discover our handpicked bangles, earrings, and necklaces, crafted with love and traditional Indian elegance.
    </p>
    <div class="row g-4 justify-content-center">

      <?php
      // Fetch featured products
      $stmt = $pdo->prepare("SELECT * FROM products WHERE is_featured = 1 ORDER BY product_id DESC");
      $stmt->execute();
      $featuredProducts = $stmt->fetchAll();

      foreach ($featuredProducts as $product):
          $imagePath = !empty($product['image_url']) ? ltrim($product['image_url'], '/') : 'assets/images/default.png';
          $imageSrc = BASE_URL . '/' . $imagePath;
          $price = is_numeric($product['price']) ? number_format((float)$product['price'], 2) : '0.00';
      ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card featured-card h-100 border-0 shadow-sm">
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" class="featured-img" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            <div class="card-body">
              <h5 class="fw-semibold"><?php echo htmlspecialchars($product['product_name']); ?></h5>
              <p class="text-muted mb-2">$<?php echo $price; ?> CAD</p>
              <a href="<?= BASE_URL ?>/product_details.php?id=<?= $product['product_id'] ?>" class="btn btn-gold w-100">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- ================= PROMO BANNER ================= -->
<section class="promo-banner py-4 text-center position-relative overflow-hidden">
  <div class="container">
    <p class="promo-tagline mb-0">
      <span class="sparkle">✨</span>
      <span class="tagline-item text-gold">Stunning Traditional Jewellery</span>
      <span class="separator">|</span>
      <span class="tagline-item text-gold">Handcrafted with Love</span>
      <span class="separator">|</span>
      <span class="tagline-item text-gold">Sophistication & Elegance for Every Occasion</span>
      <span class="sparkle">✨</span>
    </p>
  </div>
  <div class="sparkle-background"></div>
</section>

<!-- ================= GALLERY ================= -->
<section class="py-5 bg-light" id="gallerySection">
  <div class="container text-center">
    <h2 class="gallery-title mb-5 fw-bold text-center">
      Explore Our Jewellery Collection
    </h2>
    <p class="text-muted fs-5 text-center mb-4">
      Browse our premium range of handcrafted bangles, earrings, and necklaces, designed for elegance and sophistication.
    </p>

    <div class="row g-4">

      <?php
      // Fetch all products
      $stmt = $pdo->prepare("SELECT * FROM products ORDER BY product_id DESC");
      $stmt->execute();
      $allProducts = $stmt->fetchAll();

      foreach ($allProducts as $product):
          $imagePath = !empty($product['image_url']) ? ltrim($product['image_url'], '/') : 'assets/images/default.png';
          $imageSrc = BASE_URL . '/' . $imagePath;
      ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="gallery-card position-relative overflow-hidden rounded-4 shadow-sm">
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            <div class="gallery-overlay d-flex flex-column justify-content-center align-items-center">
              <h5 class="text-gold mb-3"><?php echo htmlspecialchars($product['product_name']); ?></h5>
              <a href="<?= BASE_URL ?>/product_details.php?id=<?= $product['product_id'] ?>" class="btn btn-gold btn-lg">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<?php
// ================= PROMO SLIDER FROM DB =================
$stmt = $pdo->prepare("SELECT * FROM promo_slides WHERE is_active = 1 ORDER BY id ASC");
$stmt->execute();
$promoSlides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if(!empty($promoSlides)): ?>
<section class="promo-slider-section py-5 position-relative">
  <div class="container">
    <div id="promoCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

      <!-- Indicators -->
      <div class="carousel-indicators">
        <?php foreach ($promoSlides as $index => $slide): ?>
          <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="<?= $index ?>"
                  class="<?= $index === 0 ? 'active' : '' ?>"
                  aria-current="<?= $index === 0 ? 'true' : 'false' ?>"
                  aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
      </div>

      <!-- Slides -->
      <div class="carousel-inner">
        <?php foreach ($promoSlides as $index => $slide): ?>
          <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
            <div class="row align-items-center g-5">

              <!-- Text Column -->
              <div class="col-lg-6 text-center text-lg-start">

                <div class="promo-content-dark">

          <!-- Title & Description -->
          <h2 class="promo-title fw-bold mb-3">
            <?= htmlspecialchars($slide['title']) ?>
          </h2>

          <p class="promo-text mb-2 fs-5">
            <?= htmlspecialchars($slide['description']) ?>
          </p>

          <ul class="promo-highlights mb-4 ps-3">
            <li>✨ Handcrafted bangles, earrings, and necklaces</li>
            <li>💛 Premium quality, made with love</li>
            <li>🚚 Fast shipping across Canada</li>
            <li>🎁 Perfect for gifting or special occasions</li>
          </ul>

          <!-- Limited Time Offer -->
          <p class="fw-semibold mb-3">
            Limited Time Offer — Shop Now & Save 20%
          </p>

</div>

                <!-- Feature Highlights -->
                <ul class="promo-highlights mb-4" style="list-style:none; padding-left:0;">
                  <li>✨ Handcrafted with love</li>
                  <li>💛 Premium quality materials</li>
                  <li>🚚 Fast & secure shipping across Canada</li>
                  <li>🎁 Perfect for gifting & special occasions</li>
                </ul>

                <!-- Call to Action -->
                <a href="<?= htmlspecialchars($slide['link']) ?>" class="btn btn-gold promo-btn px-4 py-2 fw-bold">
                  <?= htmlspecialchars($slide['button_text']) ?>
                </a>

              </div>

              <!-- Image Column -->
              <div class="col-lg-6 text-center position-relative">
                <div class="promo-img-container">
                  <img src="<?= BASE_URL . '/' . ltrim($slide['image_url'], '/') ?>"
                       class="img-fluid promo-img"
                       alt="<?= htmlspecialchars($slide['title']) ?>">
                  <div class="sparkle-overlay"></div>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>

    </div>
  </div>
</section>
<?php endif; ?>

<!-- ================= CONTACT ================= -->
<section class="py-5" id="contact" style="background:#fffdf7;">
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-uppercase mb-3" style="color:#b8860b; letter-spacing:2px;">Contact Us</h2>
        <p class="text-muted fs-5 mb-5">
          Have questions about our handcrafted jewellery collections or want to schedule a consultation? We’re here to help.
        </p>
    </div>

    <div class="row g-4 align-items-stretch">
      <!-- Left Info Card -->
      <div class="col-lg-5">
        <div class="p-5 rounded-4 shadow-lg h-100 text-white" style="background:#000;">
          <h3 class="fw-bold mb-3" style="color:#BFA56A;">Get in Touch</h3>
          <p class="text-light opacity-75 mb-4">Feel free to contact us anytime. We’ll respond as quickly as possible.</p>
          <div class="d-flex align-items-center mb-4">
            <i class="bx bx-map fs-2 me-3" style="color:#BFA56A;"></i>
            <div>
              <h6 class="mb-0 fw-semibold">Address</h6>
              <small class="text-light opacity-75">Toronto, Canada</small>
            </div>
          </div>
          <div class="d-flex align-items-center mb-4">
            <i class="bx bx-phone fs-2 me-3" style="color:#BFA56A;"></i>
            <div>
              <h6 class="mb-0 fw-semibold">Phone</h6>
              <small class="text-light opacity-75">+1 647 123 4567</small>
            </div>
          </div>
          <div class="d-flex align-items-center mb-4">
            <i class="bx bx-envelope fs-2 me-3" style="color:#BFA56A;"></i>
            <div>
              <h6 class="mb-0 fw-semibold">Email</h6>
              <small class="text-light opacity-75">support@shahizewer.com</small>
            </div>
          </div>
          <hr class="border-secondary my-4">
          <h6 class="fw-semibold mb-3" style="color:#BFA56A;">Follow Us</h6>
          <div class="d-flex gap-3 fs-4">
            <a href="#" class="text-decoration-none" style="color:#BFA56A;"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-decoration-none" style="color:#BFA56A;"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-decoration-none" style="color:#BFA56A;"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>

      <!-- Right Form Card -->
      <div class="col-lg-7">
        <div class="p-5 rounded-4 shadow-lg bg-white h-100">
          <h3 class="fw-bold mb-4 text-dark">Send Us a Message</h3>
          <form id="contactForm" action="<?= BASE_URL ?>/contact_submit.php" method="POST">
            <div id="successAlert" class="alert alert-success d-none rounded-3" role="alert">
              ✅ Your message has been sent successfully! We will contact you soon.
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label fw-semibold">Full Name</label>
                <input type="text" id="name" name="name"
                       class="form-control form-control-lg rounded-3"
                       placeholder="Enter your name" autocomplete="name" required>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input type="email" id="email" name="email"
                       class="form-control form-control-lg rounded-3"
                       placeholder="Enter your email" autocomplete="email" required>
              </div>
              <div class="col-12">
                <label for="subject" class="form-label fw-semibold">Subject</label>
                <input type="text" id="subject" name="subject"
                       class="form-control form-control-lg rounded-3"
                       placeholder="Subject" required>
              </div>
              <div class="col-12">
                <label for="message" class="form-label fw-semibold">Message</label>
                <textarea id="message" name="message" rows="5"
                          class="form-control form-control-lg rounded-3"
                          placeholder="Write your message..." required></textarea>
              </div>
              <div class="col-12 mt-3">
                <button type="submit"
                        class="btn btn-lg w-100 rounded-pill fw-bold"
                        style="background:#BFA56A; color:black; border:none;">
                  Send Message <i class="bx bx-send ms-2"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= GOOGLE MAP ================= -->
<section class="py-0">
    <iframe class="w-100" height="350" style="border:0;" loading="lazy" allowfullscreen
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.428580270074!2d-79.383184!3d43.653226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b34d1f2e9d2f5%3A0x1b7f5c1c2c6c2c6c!2sToronto!5e0!3m2!1sen!2sca!4v1710000000000">
    </iframe>
</section>

<?php require_once 'views/footer.php'; ?>
