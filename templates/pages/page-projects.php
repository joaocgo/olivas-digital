<?php
  $categories = get_terms(array(
    'taxonomy'   => 'category',
    'hide_empty' => true,
  ));

  $args = array(
    'post_type'      => 'projects',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
  );
  $projects = new WP_Query($args);
?>

<section id="page-intro" class="page fix-padding-header">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2 text-center">
        <div class="cta-label scroll-bottom">
          <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/star.svg") ?>
          <span class="subtitle-text"><?php echo _e('Empresas que decolaram com nossa ajuda', 'olivasdigital'); ?></span>
        </div>
        <h1 class="page-title scroll-bottom">
          <?php echo _e('Projetos e cases de sucesso', 'olivasdigital'); ?>
        </h1>
      </div>
    </div>
  </div>
</section>

<section id="page-project-listing" class="page project-listing pt-0">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-4 col-xl-3">
        <aside class="aside-filters">
          <p class="label-filter">
            <?php echo _e('Filtrar por tipo de projeto:', 'olivasdigital'); ?>
          </p>
          <ul class="filters-list">
            <?php foreach($categories as $category): ?>
              <li>
                <button type="button" class="filter-item" data-category="<?php echo $category->term_id; ?>">
                  <?php echo $category->name; ?>
                </button>
              </li>
            <?php endforeach; ?>
            <li>
              <button type="button" class="filter-item active" data-category="0">
                <?php echo _e('Ver todos', 'olivasdigital'); ?>
              </button>
            </li>
          </ul>
        </aside>
      </div>
      <div class="col-12 col-lg-8 col-xl-9">
        <?php if($projects->have_posts()): ?>
          <div class="project-grid" id="projects-container">
            <?php while($projects->have_posts()): $projects->the_post();
              $categories = get_the_terms(get_the_ID(), 'category');
              $image = get_the_post_thumbnail($project->ID, 'project-thumb');
            ?>
            <div class="project-item">
              <a href="<?php the_permalink(); ?>" class="project-item light">
                <div class="project-image">
                  <?php if($image): ?>
                    <?php echo $image; ?>
                  <?php else: ?>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/projects-default-image.webp" alt="<?php echo get_the_title($project); ?>" width="550px" height="650px">
                  <?php endif; ?>
                  <?php if ($categories && !is_wp_error($categories)): ?>
                      <div class="project-types" role="list">
                        <?php foreach ($categories as $cat): ?>
                          <span role="listitem"><?php echo esc_html($cat->name); ?></span>
                        <?php endforeach; ?>
                      </div>
                  <?php endif; ?>
                </div>
                <div class="project-date">
                  <span class="date">
                    <?php echo get_the_date('Y') ?>
                  </span>
                </div>
              </a>
              <h2 class="project-title">
                <?php the_title(); ?>
              </h2>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          </div>
        <?php else: ?>
          <?php get_template_part( 'templates/partials/message-no-posts' ); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>