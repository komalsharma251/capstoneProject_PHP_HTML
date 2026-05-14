<?php
// Enable strict type checking for better PHP type safety
declare(strict_types=1);

// Include application configuration / database connection
require_once __DIR__ . '/db/app.php';

// Page title used inside header.php
$pageTitle = "Book Appointment - Shahizewer";

// Include shared website header
require_once __DIR__ . '/views/header.php';
?>

<!-- =========================
     APPOINTMENT SECTION
========================= -->
<section class="py-5" style="background:#fffdf7;">

  <div class="container py-5">

    <!-- =========================
         SUCCESS / ERROR ALERTS
    ========================= -->

    <?php if (isset($_GET['success'])): ?>

      <!-- Success message displayed after successful booking -->
      <div class="alert alert-success text-center rounded-4 shadow-sm">
        Appointment booked successfully! We will contact you soon.
      </div>

    <?php elseif (isset($_GET['error'])): ?>

      <!-- Error message displayed if form submission fails -->
      <div class="alert alert-danger text-center rounded-4 shadow-sm">

        <!-- htmlspecialchars prevents XSS attacks -->
        <?= htmlspecialchars($_GET['error']) ?>

      </div>

    <?php endif; ?>

    <!-- =========================
         PAGE HEADING
    ========================= -->
    <div class="text-center mb-5">

      <!-- Main heading -->
      <h2 class="fw-bold text-uppercase"
          style="color:#b8860b; letter-spacing:2px;">

        Book an Appointment

      </h2>

      <!-- Subheading -->
      <p class="text-muted">
        Schedule a jewellery consultation with us.
        We will contact you soon to confirm.
      </p>

    </div>

    <!-- =========================
         APPOINTMENT FORM CONTAINER
    ========================= -->
    <div class="row justify-content-center">

      <div class="col-lg-8">

        <!-- Card wrapper for premium UI -->
        <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5">

          <!-- =========================
               APPOINTMENT FORM
          ========================= -->
          <form action="appointment_submit.php" method="POST">

            <div class="row g-4">

              <!-- =========================
                   FULL NAME FIELD
              ========================= -->
              <div class="col-md-6">

                <label class="form-label fw-semibold">
                  Full Name
                </label>

                <input
                  type="text"
                  name="name"
                  class="form-control form-control-lg rounded-3"
                  required
                >

              </div>

              <!-- =========================
                   EMAIL FIELD
              ========================= -->
              <div class="col-md-6">

                <label class="form-label fw-semibold">
                  Email
                </label>

                <input
                  type="email"
                  name="email"
                  class="form-control form-control-lg rounded-3"
                  required
                >

              </div>

              <!-- =========================
                   PHONE NUMBER FIELD
              ========================= -->
              <div class="col-md-6">

                <label class="form-label fw-semibold">
                  Phone Number
                </label>

                <input
                  type="text"
                  name="phone"
                  class="form-control form-control-lg rounded-3"
                  required
                >

              </div>

              <!-- =========================
                   APPOINTMENT DATE FIELD
              ========================= -->
              <div class="col-md-6">

                <label class="form-label fw-semibold">
                  Appointment Date
                </label>

                <input
                  type="date"
                  name="date"
                  class="form-control form-control-lg rounded-3"
                  required
                >

              </div>

              <!-- =========================
                   APPOINTMENT TIME SELECT
              ========================= -->
              <div class="col-md-6">

                <label class="form-label fw-semibold">
                  Preferred Time
                </label>

                <select
                  name="time"
                  class="form-select form-select-lg rounded-3"
                  required
                >

                  <option value="">Select Time</option>

                  <option value="10:00 AM">10:00 AM</option>
                  <option value="12:00 PM">12:00 PM</option>
                  <option value="2:00 PM">2:00 PM</option>
                  <option value="4:00 PM">4:00 PM</option>
                  <option value="6:00 PM">6:00 PM</option>

                </select>

              </div>

              <!-- =========================
                   APPOINTMENT PURPOSE SELECT
              ========================= -->
              <div class="col-md-6">

                <label class="form-label fw-semibold">
                  Purpose
                </label>

                <select
                  name="purpose"
                  class="form-select form-select-lg rounded-3"
                  required
                >

                  <option value="">Select</option>

                  <option value="Bridal Jewellery">
                    Bridal Jewellery
                  </option>

                  <option value="Custom Jewellery">
                    Custom Jewellery
                  </option>

                  <option value="Gift Consultation">
                    Gift Consultation
                  </option>

                  <option value="General Inquiry">
                    General Inquiry
                  </option>

                </select>

              </div>

              <!-- =========================
                   MESSAGE TEXTAREA
              ========================= -->
              <div class="col-12">

                <label class="form-label fw-semibold">
                  Message
                </label>

                <textarea
                  name="message"
                  rows="5"
                  class="form-control form-control-lg rounded-3"
                  placeholder="Write your message..."
                ></textarea>

              </div>

              <!-- =========================
                   SUBMIT BUTTON
              ========================= -->
              <div class="col-12 mt-3">

                <button
                  type="submit"
                  class="btn btn-lg w-100 rounded-pill fw-bold"
                  style="background:gold; color:black; border:none;"
                >

                  Book Appointment

                  <!-- Button icon -->
                  <i class="bx bx-calendar ms-2"></i>

                </button>

              </div>

            </div>

          </form>

        </div>

      </div>
    </div>

  </div>
</section>

<?php
// Include shared website footer
require_once __DIR__ . '/views/footer.php';
?>