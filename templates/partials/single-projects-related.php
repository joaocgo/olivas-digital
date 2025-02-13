<?php 
  $terms = get_the_terms(get_the_ID(), 'category');
  $current_post_id = get_the_ID();
  $categories = wp_get_post_terms($current_post_id, 'category', array(
    'fields'  =>  'ids',
  ));

  $args = array(
    'post_type'       =>  'projects',
    'posts_per_page'  => 4,
    'post__not_in'    => array($current_post_id),
    'orderby'         => 'date',
    'order'           => 'DESC',
  );

  if(!empty($categories)) {
    $args['tax_query'] = array(
      array(
        'taxonomy'  => 'category',
        'field'     => 'term_id',
        'terms'     =>  $categories,
      ),
    );
  };

  $posts = new WP_Query($args);

  // Buscar todos posts caso não tenha da mesma categoria
  if(!$posts->have_posts()) {
    $args['tax_query'] = ''; 
    $posts = new WP_Query($args);
  }
?>

<section id="project-related" class="page single">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8 d-flex flex-column justify-content-center">
        <h3 class="title" letter-fade text-split>
          <?php echo _e('Gostou? Confira outros projetos 🚀', 'olivasdigital'); ?>
        </h3>
      </div>
      <div class="col-12 col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
        <ul class="related-categories-list">
          <?php if($terms): ?>
            <?php foreach($terms as $term): ?>
              <li>
                <a href="<?php echo esc_url(get_term_link($term)); ?>" target="_self" class="button">
                  <span class="cta-text">
                    <?php echo _e('Veja mais projetos de', 'olivasdigital'); ?>&nbsp;<strong><?php echo $term->name ?></strong>
                  </span>
                  <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow2.svg") ?>
                </a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php if($posts->have_posts()): ?>
          <div id="swiper-projects" class="swiper-projects scroll-bottom">
            <div class="swiper-wrapper">
              <?php while($posts->have_posts()):
                  $posts->the_post();
                  $categories = get_the_terms($project->ID, 'category');
                  $image = get_the_post_thumbnail($project->ID, 'project-thumb'); 
                ?>
                <div class="swiper-slide project-item">
                  <a href="<?php echo get_permalink($project); ?>" title="<?php echo get_the_title($project); ?>" target="_self">
                    <div class="project-image">
                      <?php if($image): ?>
                        <?php echo $image; ?>
                      <?php else: ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/projects-default-image.webp" alt="<?php echo get_the_title($project); ?>" width="550px" height="650px">
                      <?php endif; ?>
                    </div>
                    <?php if($categories): ?>
                      <div class="project-types" role="list">
                        <?php foreach($categories as $cat): ?>
                          <span role="listitem"><?php echo $cat->name; ?></span>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                    <h3 class="project-title">
                      <?php echo get_the_title($project) ?>
                    </h3>
                  </a>
                </div>
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
            </div>
          </div>
        <?php else: ?>
          <?php get_template_part( 'templates/partials/message-no-posts' ); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>