
<?php 
require_once __DIR__ . '/db/app.php'; 
$pageTitle = "FAQ – Shahizewer"; 
require_once 'views/header.php'; 
?>

<!-- ================= HERO ================= -->
<section class="position-relative">
  <div style="
      background:url('<?= BASE_URL ?>/assets/images/faq_image.png') center/cover no-repeat;
      height:50vh;
      filter:brightness(60%);
  "></div>

  <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
    <h1 class="display-4 fw-bold" style="letter-spacing:3px;">Frequently Asked Questions</h1>
    <p class="lead">We’re here to help you</p>
  </div>
</section>

<!-- ================= FAQ SECTION ================= -->
<section class="py-5 bg-light">
  <div class="container">

    <div class="text-center mb-5">
      <h2 class="fw-bold" style="color:#BFA56A;">Got Questions?</h2>
      <p class="text-muted">Find answers to the most common queries about our jewellery and services.</p>
    </div>

    <div class="accordion" id="faqAccordion">

      <!-- Q1 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
        <h2 class="accordion-header">
          <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            Do you ship across Canada?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Yes, we offer fast and secure shipping across Canada with tracking included.
          </div>
        </div>
      </div>

      <!-- Q2 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
            What is your return policy?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            We accept returns within 7 days of delivery, provided the product is unused and in original condition.
          </div>
        </div>
      </div>

      <!-- Q3 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
            Are your jewellery pieces handmade?
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Yes, our jewellery is handcrafted with attention to detail, blending traditional artistry with modern designs.
          </div>
        </div>
      </div>

      <!-- Q4 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
            Do you offer custom jewellery?
          </button>
        </h2>
        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            Yes! You can book an appointment with us to create a personalized jewellery design.
          </div>
        </div>
      </div>

      <!-- Q5 -->
      <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
            How can I track my order?
          </button>
        </h2>
        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body text-muted">
            You can track your order using the "Track Order" page by entering your order ID.
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-5 text-center text-white" style="background:#000;">
  <div class="container">
    <h2 class="fw-bold mb-3" style="color:#BFA56A;">Still Have Questions?</h2>
    <p class="text-light opacity-75 mb-4">
      Our team is here to assist you anytime.
    </p>
    <a href="<?= BASE_URL ?>/index.php#contact" class="btn btn-lg px-5 fw-bold"
       style="background:#BFA56A; color:black; border-radius:30px;">
       Contact Us
    </a>
  </div>
</section>

<?php require_once 'views/footer.php'; ?>