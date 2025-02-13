<?php
  function filter_projects_by_category() {
    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_send_json_error(['message' => 'Acesso não permitido.'], 403);
      exit;
    }

    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

    $args = array(
      'post_type'      => 'projects',
      'posts_per_page' => -1,
      'orderby'        => 'date',
      'order'          => 'DESC',
    );

    if ($category_id) {
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'category',
          'field'    => 'term_id',
          'terms'    => $category_id,
        ),
      );
    }

    $projects = new WP_Query($args);

    if ($projects->have_posts()) :
      while ($projects->have_posts()) : $projects->the_post();
        $categories = get_the_terms(get_the_ID(), 'category');
        $image = get_the_post_thumbnail(get_the_ID(), 'project-thumb');
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
      <?php endwhile;
      wp_reset_postdata();
    else :
      echo '<p>Nenhum projeto encontrado.</p>';
    endif;
    die();
  };

  add_action('wp_ajax_filter_projects', 'filter_projects_by_category');
  add_action('wp_ajax_nopriv_filter_projects', 'filter_projects_by_category');
?>