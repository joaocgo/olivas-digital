gsap.registerPlugin(ScrollTrigger);

/****************************************/
/* Lenis
/****************************************/
const lenis = new Lenis({
  autoRaf: true,
});

/****************************************/
/* Scroll Animations
/****************************************/
const scrolls = jQuery('.scroll-left, .scroll-right, .scroll-bottom, .scroll-top');
jQuery(scrolls).each(function() {
  ScrollTrigger.create({
    trigger: this,
    endTrigger: "body",
    start: "top 90%",
    toggleClass: "ativo",
  });
});

/****************************************/
/* Split Text and Animate
/****************************************/
let splitType = new SplitType("[text-split]", {
  types: "words, chars",
  tagName: "span",
});

let totalDuration = 2;
let letterFadeElements = document.querySelectorAll("[letter-fade]");

letterFadeElements.forEach(function (element) {
  let childLetters = element.querySelectorAll(".char");
  let tl = gsap.timeline({
    scrollTrigger: {
      trigger: element,
      start: "top 90%",
      end: "top 40%",
      scrub: 2,
    },
    defaults: {
      ease: "power2.out",
    },
  });

  childLetters.forEach(function (childLetter) {
    let randomDuration = gsap.utils.random(0.6, totalDuration);
    let maxDelay = totalDuration - randomDuration;
    let randomDelay = gsap.utils.random(0, maxDelay);

    tl.from(childLetter, {
      opacity: 0,
      duration: randomDuration
    }, randomDelay);
  });

  tl.from(element, {
    scale: 1.05,
    duration: totalDuration
  }, 0);
});

/****************************************/
/* Animação label
/****************************************/
if (jQuery(".cta-label").length) {
  jQuery(() => {
    gsap.to(".cta-label svg", {
      rotation: "+=90",
      scale: 1,
      duration: 1,
      repeat: -1,
      ease: "power1.inOut",
      onUpdate: function() {
        gsap.to(".cta-label svg", { scale: .8, duration: 0.5, ease: "power1.inOut" });
      }
    });
  });
}

/****************************************/
/* Animação Botão CTA
/****************************************/
jQuery(".button-cta").hover(
  function () {
    let $ctaIcon = jQuery(this).find(".cta-icon");
    let $svg = $ctaIcon.find("svg");
    let $ctaText = jQuery(this).find(".cta-text");
    
    hoverTimeout = setTimeout(() => {
      gsap.to($ctaIcon, { 
        width: 40, 
        height: 40, 
        opacity: 1, 
        duration: 0.8, 
        ease: "elastic.out(1, 0.5)" 
      });
      gsap.fromTo($svg, 
        { x: "-20%", opacity: 0, scale: 0 }, 
        { x: "0%", opacity: 1, transform: "none", transformOrigin: "center center", duration: 0.6, ease: "power1.out" }
      );
      gsap.to($ctaText, {
        x: "-10%", 
        duration: 0.4, 
        ease: "power1.out"
      });
    }, 150);
  },
  function () {
    clearTimeout(hoverTimeout);

    let $ctaIcon = jQuery(this).find(".cta-icon");
    let $svg = $ctaIcon.find("svg");
    let $ctaText = jQuery(this).find(".cta-text");
    
    gsap.to($ctaIcon, { 
      width: 0, 
      height: 0, 
      opacity: 0, 
      duration: 0.5, 
      ease: "power1.inOut" 
    });
    gsap.to($svg, { 
      scale: 0, 
      x: "-20%", 
      y: "0%", 
      opacity: 0, 
      transform: "none", 
      transformOrigin: "center center", 
      duration: 0.5, 
      ease: "power1.inOut" 
    });
    gsap.to($ctaText, {
      x: "0%", 
      duration: 0.4, 
      ease: "power1.inOut"
    });
  }
);

/****************************************/
/* Animação Hero (Home)
/****************************************/
if (jQuery("#hero").length) {
  jQuery(window).on("scroll", function () {
    var scrollTop = jQuery(this).scrollTop();
    var heroHeight = jQuery("#hero").height();
    var opacity = 1 - (scrollTop / heroHeight);
    var scale = 1 - (scrollTop / heroHeight * .15);

    gsap.to("#hero", { 
      opacity: opacity, 
      scale: scale, 
      duration: 0.2, 
      ease: "power1.out" 
    });
  });
};

/****************************************/
/* Animação Hero (Projeto Single)
/****************************************/
if (jQuery("#project-hero.page .project-card-intro").length) {
  gsap.set(".project-card-intro", { scale: 0.8 });

	gsap.to(".project-card-intro", {
		scale: 1,
		duration: 0.8,
		ease: "power3.out"
	});
}