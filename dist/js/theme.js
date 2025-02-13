gsap.registerPlugin(ScrollTrigger);let lenis=new Lenis({autoRaf:!0}),scrolls=jQuery(".scroll-left, .scroll-right, .scroll-bottom, .scroll-top"),splitType=(jQuery(scrolls).each(function(){ScrollTrigger.create({trigger:this,endTrigger:"body",start:"top 90%",toggleClass:"ativo"})}),new SplitType("[text-split]",{types:"words, chars",tagName:"span"})),totalDuration=2,letterFadeElements=document.querySelectorAll("[letter-fade]");letterFadeElements.forEach(function(e){var t=e.querySelectorAll(".char");let r=gsap.timeline({scrollTrigger:{trigger:e,start:"top 90%",end:"top 40%",scrub:2},defaults:{ease:"power2.out"}});t.forEach(function(e){var t=gsap.utils.random(.6,totalDuration),o=totalDuration-t,o=gsap.utils.random(0,o);r.from(e,{opacity:0,duration:t},o)}),r.from(e,{scale:1.05,duration:totalDuration},0)}),jQuery(".cta-label").length&&jQuery(()=>{gsap.to(".cta-label svg",{rotation:"+=90",scale:1,duration:1,repeat:-1,ease:"power1.inOut",onUpdate:function(){gsap.to(".cta-label svg",{scale:.8,duration:.5,ease:"power1.inOut"})}})}),jQuery(".button-cta").hover(function(){let e=jQuery(this).find(".cta-icon"),t=e.find("svg"),o=jQuery(this).find(".cta-text");hoverTimeout=setTimeout(()=>{gsap.to(e,{width:40,height:40,opacity:1,duration:.8,ease:"elastic.out(1, 0.5)"}),gsap.fromTo(t,{x:"-20%",opacity:0,scale:0},{x:"0%",opacity:1,transform:"none",transformOrigin:"center center",duration:.6,ease:"power1.out"}),gsap.to(o,{x:"-10%",duration:.4,ease:"power1.out"})},150)},function(){clearTimeout(hoverTimeout);var e=jQuery(this).find(".cta-icon"),t=e.find("svg"),o=jQuery(this).find(".cta-text");gsap.to(e,{width:0,height:0,opacity:0,duration:.5,ease:"power1.inOut"}),gsap.to(t,{scale:0,x:"-20%",y:"0%",opacity:0,transform:"none",transformOrigin:"center center",duration:.5,ease:"power1.inOut"}),gsap.to(o,{x:"0%",duration:.4,ease:"power1.inOut"})}),jQuery("#hero").length&&jQuery(window).on("scroll",function(){var e=jQuery(this).scrollTop(),t=jQuery("#hero").height();gsap.to("#hero",{opacity:1-e/t,scale:1-e/t*.15,duration:.2,ease:"power1.out"})}),jQuery("#project-hero.page .project-card-intro").length&&(gsap.set(".project-card-intro",{scale:.8}),gsap.to(".project-card-intro",{scale:1,duration:.8,ease:"power3.out"})),jQuery(document).ready(function(){jQuery(".carrossel-animation .list-items").each(function(){var e=jQuery(this),t=e.html(),o=jQuery("<div>").addClass("carrossel-ativo"),e=(o.html(t),e.empty().append(o),e.outerWidth()),r=o[0].scrollWidth,a=Math.ceil(e/r);for(let e=0;e<a;e++)o.append(t);o.append(t)})}),jQuery(document).ready(function(){jQuery(".filter-item").on("click",function(e){e.preventDefault();e=jQuery(this).data("category");let t=jQuery("#projects-container");jQuery(".filter-item").removeClass("active"),jQuery(this).addClass("active"),jQuery.ajax({url:ajaxurl,type:"POST",data:{action:"filter_projects",category_id:e},beforeSend:function(){gsap.to(".project-item",{opacity:.3,duration:.3,ease:"power1.out"}),jQuery("#loading-indicator").length||(t.append('<div id="loading-indicator" style="text-align:center; opacity:0;">Carregando...</div>'),gsap.to("#loading-indicator",{opacity:1,duration:.3}))},success:function(e){gsap.to(".project-item",{opacity:0,y:-20,duration:.4,stagger:.1,ease:"power2.in",onComplete:function(){t.html(e),jQuery("#loading-indicator").remove(),gsap.from(".project-item",{opacity:0,y:30,duration:.6,stagger:.15,ease:"power3.out"})}})}})})}),jQuery(document).ready(function(){function a(e){return 11===e.replace(/\D/g,"").length?"+55 (00) 00000-0000":"+55 (00) 0000-00009"}var e={onKeyPress:function(e,t,o,r){o.mask(a.apply({},arguments),r)}};jQuery(".phonebr").mask(a,e),jQuery(".cpfcnpj").mask("000.000.000-00",{onKeyPress:function(e,t,o,r){var a=["000.000.000-00","00.000.000/0000-00"];o.mask(11<e.replace(/\D/g,"").length?a[1]:a[0],r)}}),jQuery(".cnpj").mask("00.000.000/0000-00",{reverse:!0}),jQuery(".cep").mask("00000-000",{reverse:!0}),jQuery(".nf").mask("000.000.000",{reverse:!0})}),jQuery("#open-Menu").on("click",function(){let e=jQuery("#menu-dropdown");var t=jQuery("#modal-background");e.hasClass("active")?(gsap.to(e,{y:"-100%",duration:.4,ease:"power3.inOut",onComplete:function(){e.removeClass("active").css("display","none")}}),gsap.to(t,{visibility:"hidden",duration:.4,ease:"power3.inOut"})):(e.css("display","block").addClass("active"),gsap.fromTo(e,{y:"-100%"},{y:"0%",duration:.4,ease:"power3.out"}),gsap.to(t,{visibility:"visible",duration:.4,ease:"power3.out"}))}),jQuery("#modal-background").on("click",function(){let e=jQuery("#menu-dropdown");var t=jQuery("#modal-background");gsap.to(e,{y:"-100%",duration:.4,ease:"power3.inOut",onComplete:function(){e.removeClass("active").css("display","none")}}),gsap.to(t,{visibility:"hidden",duration:.4,ease:"power3.inOut"})}),new Swiper("#swiper-projects",{direction:"horizontal",loop:!1,speed:500,slidesPerView:3.2,grabCursor:!0,keyboard:!0,spaceBetween:24,allowTouchMove:!0,navigation:{nextEl:"#projects .swiper-next",prevEl:"#projects .swiper-prev"},breakpoints:{0:{slidesPerView:1.1,spaceBetween:24},650:{slidesPerView:2.2,spaceBetween:16},767:{slidesPerView:2.2,spaceBetween:16},992:{slidesPerView:3.2,spaceBetween:24}}});