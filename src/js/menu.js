// Animação do menu dropdown
jQuery("#open-Menu").on("click", function () {
  let menu = jQuery("#menu-dropdown");
  let modalBg = jQuery("#modal-background");
  let isOpen = menu.hasClass("active");
  
  if (isOpen) {
    gsap.to(menu, {
      y: "-100%",
      duration: 0.4,
      ease: "power3.inOut",
      onComplete: function () {
        menu.removeClass("active").css("display", "none");
      }
    });
    gsap.to(modalBg, {
      visibility: "hidden",
      duration: 0.4,
      ease: "power3.inOut"
    });
  } else {
    menu.css("display", "block").addClass("active");
    gsap.fromTo(menu, 
      { y: "-100%" },
      { y: "0%", duration: 0.4, ease: "power3.out" }
    );
    gsap.to(modalBg, {
      visibility: "visible",
      duration: 0.4,
      ease: "power3.out"
    });
  }
});

// Fechar menu ao clicar no modal background
jQuery("#modal-background").on("click", function () {
  let menu = jQuery("#menu-dropdown");
  let modalBg = jQuery("#modal-background");
  
  gsap.to(menu, {
    y: "-100%",
    duration: 0.4,
    ease: "power3.inOut",
    onComplete: function () {
      menu.removeClass("active").css("display", "none");
    }
  });
  gsap.to(modalBg, {
    visibility: "hidden",
    duration: 0.4,
    ease: "power3.inOut"
  });
});
