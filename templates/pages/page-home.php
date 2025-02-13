<section id="hero" class="hero home">
  <div class="container">
    <div class="hero-card">
      <div class="hero-body">
        <div class="hero-title">
          <div class="cta-label scroll-bottom">
            <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/star.svg") ?>
            <span class="subtitle-text"><?php echo _e('Bem-vindo a Olivas Digital', 'olivasdigital'); ?></span>
          </div>
          <h1 class="scroll-bottom">
            <?php printf( __('Marketing e Tecnologia para sua empresa %s muito mais.', 'olivasdigital'),  '<span>vender</span>' ); ?>
          </h1>
        </div>
        <div class="hero-description scroll-bottom">
          <p>
            <?php echo _e('Tenha toda experiência e suporte de uma martech e faça sua empresa decolar. Criamos sites, aplicativos, e-commerces e sistemas sob medida.', 'olivasdigital'); ?>
          </p>
        </div>
        <div class="hero-buttons scroll-bottom">
          <a href="<?php echo get_permalink(24) ?>" target="_self" class="button-cta">
            <span class="cta-text">
              <?php echo _e('Conhecer projetos', 'olivasdigital'); ?>
            </span>
            <div class="cta-icon">
              <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="hero-logos carrossel-animation scroll-bottom">
      <div class="shadow-carrossel"></div>
      <div class="shadow-carrossel right"></div>
      <div class="wrapper">
        <div class="list-items">
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/abeeolica.webp" alt="Abeeolica" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/aec.webp" alt="Aec" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/aster.webp" alt="Aster" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/brentani-roncolatto.webp" alt="Brentani Roncolatto" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/confidence-travelex.webp" alt="Confidence Travelex" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/fitboard.webp" alt="Fitboard" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/habitat-brasil.webp" alt="Habitat Brasil" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/koin.webp" alt="Koin" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/robbyson.webp" alt="Robbyson" width="180px" height="74px">
          </div>
          <div class="list-item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clients/sao-pedro-capital.webp" alt="São Pedro Capital" width="180px" height="74px">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $args = array(
    'post_type'       => 'projects',
    'posts_per_page'  => -1,
    'order'           => 'DESC',
    'orderby'         => 'date'
  );
  $projects = get_posts($args);
?>

<?php if(!empty($projects)): ?>
  <section id="projects" class="home">
    <div class="container">
      <div class="card-projects">
        <div class="row">
          <div class="col-12 col-lg-8">
            <div class="project-headline">
              <h2 class="title">
                <?php echo _e('Últimos projetos', 'olivasdigital'); ?>
              </h2>
              <div class="swiper-arrows">
                <button type="button" class="swiper-prev" aria-label="<?php echo _e('Anterior', 'olivasdigital'); ?>">
                  <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
                </button>
                <button type="button" class="swiper-next" aria-label="<?php echo _e('Próximo', 'olivasdigital'); ?>">
                  <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
                </button>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
            <a href="<?php echo get_permalink(24) ?>" target="_self" class="button-cta">
              <span class="cta-text">
                <?php echo _e('Veja mais projetos', 'olivasdigital'); ?>
              </span>
              <div class="cta-icon">
                <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
              </div>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div id="swiper-projects" class="swiper-projects">
              <div class="swiper-wrapper">
                <?php
                  foreach($projects as $index => $project):
                    $categories = get_the_terms($project->ID, 'category');
                    $image = get_the_post_thumbnail($project->ID, 'project-thumb');
                ?>
                  <div class="swiper-slide project-item">
                    <a href="<?php echo get_permalink($project); ?>" title="<?php echo get_the_title($project); ?>" target="_self">
                      <div class="project-date">
                        <span class="date">
                          <?php echo get_the_date('Y', $project) ?>
                        </span>
                      </div>
                      <div class="project-image">
                        <?php if($image): ?>
                          <?php echo $image; ?>
                        <?php else: ?>
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/projects-default-image.webp" alt="<?php echo get_the_title($project); ?>" width="550px" height="650px">
                        <?php endif; ?>
                        <?php if($categories): ?>
                          <div class="project-types" role="list">
                            <?php foreach($categories as $cat): ?>
                              <span role="listitem"><?php echo $cat->name; ?></span>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </a>
                    <h3 class="project-title">
                      <?php echo get_the_title($project) ?>
                    </h3>
                    <p class="project-resume">
                      <?php 
                        $resumo = get_the_excerpt($project);
                        if (empty($resumo)) {
                          $resumo = wp_strip_all_tags(get_post_field('post_content', $project->ID));
                        }
                        echo esc_html(mb_strimwidth($resumo, 0, 150, '...'));
                      ?>
                    </p>
                    <a href="<?php echo get_permalink($project) ?>" target="_self" class="project-link">
                      <span><?php echo _e('Confira o case completo', 'olivasdigital'); ?></span>
                      <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow2.svg") ?>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<section id="contact" class="home">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">
        <h4 class="title" text-split letter-fade>
          <?php echo _e('Pronto para iniciar um novo projeto conosco?', 'olivasdigital'); ?>
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