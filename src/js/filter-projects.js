jQuery(document).ready(function () {
  jQuery(".filter-item").on("click", function (e) {
    e.preventDefault();

    let categoryID = jQuery(this).data("category");
    let container = jQuery("#projects-container");

    jQuery(".filter-item").removeClass("active");
    jQuery(this).addClass("active");

    jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: {
        action: "filter_projects",
        category_id: categoryID,
      },
      beforeSend: function () {
        gsap.to(".project-item", {
          opacity: 0.3,
          duration: 0.3,
          ease: "power1.out"
        });

        if (!jQuery("#loading-indicator").length) {
          container.append('<div id="loading-indicator" style="text-align:center; opacity:0;">Carregando...</div>');
          gsap.to("#loading-indicator", { opacity: 1, duration: 0.3 });
        }
      },
      success: function (response) {
        gsap.to(".project-item", {
          opacity: 0,
          y: -20,
          duration: 0.4,
          stagger: 0.1,
          ease: "power2.in",
          onComplete: function () {
            container.html(response);
            jQuery("#loading-indicator").remove();
            initGSAPAnimation();
          }
        });
      }
    });
  });

  function initGSAPAnimation() {
    gsap.from(".project-item", {
      opacity: 0,
      y: 30,
      duration: 0.6,
      stagger: 0.15,
      ease: "power3.out"
    });
  }
});
