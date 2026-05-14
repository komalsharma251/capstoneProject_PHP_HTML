document.addEventListener("DOMContentLoaded", function () {

  // === PROMO CAROUSEL ===
  const promoCarousel = document.getElementById('promoCarousel');
  if (promoCarousel) {
    new bootstrap.Carousel(promoCarousel, {
      interval: 5000,
      ride: 'carousel',
      pause: 'hover'
    });
  }

  // === CONTACT FORM ===
  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", function(e) {
      e.preventDefault();
      const formData = new FormData(contactForm);
      const alertBox = document.getElementById("successAlert");

      fetch("<?= BASE_URL ?>/contact_submit.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alertBox.classList.remove("d-none");
          contactForm.reset();
          setTimeout(() => alertBox.classList.add("d-none"), 4000);
        } else {
          alert("Error: " + data.error);
        }
      })
      .catch(err => alert("Request failed: " + err));
    });
  }

  // === TYPING EFFECT ===
  const text = "Timeless Elegance • Indian Heritage • Modern Luxury";
  let i = 0;
  const elem = document.querySelector(".typing-text");
  if (elem) {
    function typeEffect() {
      if (i < text.length) {
        elem.innerHTML += text.charAt(i);
        i++;
        setTimeout(typeEffect, 120);
      }
    }
    typeEffect();
  }

  // ✅ === BACK TO TOP BUTTON (FIXED) ===
  const backToTopBtn = document.getElementById("backToTopBtn");

  if (backToTopBtn) {
    window.addEventListener("scroll", function () {
      if (window.scrollY > 300) {
        backToTopBtn.style.display = "block";
      } else {
        backToTopBtn.style.display = "none";
      }
    });

    backToTopBtn.addEventListener("click", function () {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    });
  }

});