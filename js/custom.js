document.addEventListener("DOMContentLoaded", function () {
  // Back to Top Arrow AND Hide Navbar
  const backToTop = document.getElementById("backToTop");
  const header = document.querySelector(".header_section");
  let prevScrollPos = window.scrollY;

    // Show/hide the arrow and navbar based on scroll position
    window.onscroll = function () {
      const currentScrollPos = window.scrollY;

      // Back to Top Arrow
      if (currentScrollPos > 300) {
        backToTop.classList.add("show");
      } else {
        backToTop.classList.remove("show");
      }

      // Hide/Show Navbar
      if (prevScrollPos > currentScrollPos) {
        header.classList.remove("hide");
      } else {
        header.classList.add("hide");
      }

      prevScrollPos = currentScrollPos;
    };

    // Scroll to top when the arrow is clicked
    backToTop.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });

    //=============================================================\\
    //Slide In Animation
    const slideInLeftElements = document.querySelectorAll(".slide-in-left");
    const slideInRightElements = document.querySelectorAll(".slide-in-right");

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    });

    slideInLeftElements.forEach((element) => {
      observer.observe(element);
    });

    slideInRightElements.forEach((element) => {
      observer.observe(element);
    });

    

    
});

// lightbox gallery
$(document).on("click", '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
