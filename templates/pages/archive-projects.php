<?php
  $category = get_queried_object();
  $category_name = $category->name;

  $args = array(
    'post_type'       => 'projects',
    'posts_per_page'  =>  -1,
    'tax_query'       => array(
      array(
        'taxonomy'    => 'category',
        'field'       => 'term_id',
        'terms'       => $category->term_id,
      ),
    ),
  );

  $projects = get_posts($args);
?>

<section id="page-intro" class="page fix-padding-header">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2 text-center">
        <div class="cta-label scroll-bottom">
          <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/star.svg") ?>
          <span class="subtitle-text"><?php echo _e('Projetos e cases de sucesso', 'olivasdigital'); ?></span>
        </div>
        <h1 class="page-title scroll-bottom">
          <?php echo $category_name; ?>
        </h1>
      </div>
    </div>
  </div>
</section>

<?php if($projects): ?>
  <section id="project-list" class="page project-list-by-category pt-0">
    <div class="container">
      <div class="project-grid">
        <?php
          foreach($projects as $index => $project):
            $categories = get_the_terms($project->ID, 'category');
            $image = get_the_post_thumbnail($project->ID, 'project-thumb');
        ?>
        <div class="project-item scroll-bottom">
          <a href="<?php the_permalink($project->ID); ?>" class="project-item light">
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
                <?php echo get_the_date('Y', $project) ?>
              </span>
            </div>
          </a>
          <h3 class="project-title">
            <?php echo get_the_title($project->ID); ?>
          </h3>
        </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
<?php else: ?>
  <?php get_template_part( 'templates/partials/message-no-posts' ); ?>
<?php endif; ?>