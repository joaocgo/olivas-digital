<section id="page-intro" class="page fix-padding-header">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2 text-center">
        <div class="cta-label scroll-bottom">
          <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/star.svg") ?>
          <span class="subtitle-text"><?php echo _e('Fale agora com um especialista', 'olivasdigital'); ?></span>
        </div>
        <h1 class="page-title scroll-bottom">
          <?php echo _e('Vamos crescer juntos', 'olivasdigital'); ?>
        </h1>
      </div>
    </div>
  </div>
</section>

<section id="contact" class="home scroll-bottom" style="transition-delay:600ms;">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">
        <h4 class="title" text-split letter-fade>
          <?php echo _e('Envie sua mensagem para nós!', 'olivasdigital'); ?>
        </h4>
      </div>
      <div class="col-12 col-lg-4">
        <p class="heading-text">
          <?php echo _e('A Olivas Digital tem a solução certa para seu negócio. Seja marketing digital de excelência ou desenvolvimento de aplicativos e websites, nós ajudamos seu negócio a crescer. Utilize o formulário para que um de nossos especialistas entre em contato.'); ?>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php echo apply_shortcodes('[contact-form-7 id="31ad87d"]'); ?>
      </div>
    </div>
  </div>
</section>