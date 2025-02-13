<?php 
  $terms = get_the_terms(get_the_ID(), 'category');
  $image = get_the_post_thumbnail($project->ID, 'project-full', array('loading' => 'lazy')); 
  $project_url = get_field('project_url', $project->ID);
?>

<section id="project-hero" class="page single fix-padding-header">
  <div class="container">
    <div class="project-card-intro">
      <?php if($image): ?>
        <?php echo $image; ?>
      <?php else: ?>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/projects-default-image-full.webp" alt="<?php echo get_the_title($project); ?>" width="1920px" height="690px">
      <?php endif; ?>
      <h1 class="project-title">
        <?php echo get_the_title(); ?>
      </h1>
    </div>
  </div>
</section>

<section id="project-details" class="page single pt-0">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="project-info-grid">
          <?php if($terms): ?>
            <div class="project-item">
              <p class="label"><?php echo _e('Categoria(s)', 'olivasdigital'); ?></p>
              <ul class="list-categories">
                <?php foreach($terms as $term): ?>
                  <li>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" target="_self">
                      <?php echo $term->name ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <div class="project-item date">
            <p class="label">Mês / Ano</p>
            <span class="value"><?php echo get_the_date('m/Y', $project) ?></span>
          </div>
          <div class="project-item project-url">
            <p class="label">Link externo</p>
            <?php if($project_url): ?>
              <a href="<?php echo $project_url ?>" target="_blank" class="button-cta">
                <span class="cta-text">
                  <?php echo _e('Ver projeto', 'olivasdigital'); ?>
                </span>
                <div class="cta-icon">
                  <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
                </div>
              </a>
            <?php else: ?>
              <a href="javascript:;" target="_self" class="button-cta-blocked">
                <span class="cta-text">
                  <?php echo _e('Link não disponível', 'olivasdigital'); ?>
                </span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="project-content" class="page single pt-0">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="title mb-4 mb-md-5"><?php echo _e('Descritivo', 'olivasdigital'); ?></h2>
        <div class="editor scroll-bottom">
          <?php echo the_content(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php # Projetos relacionados ?>
<?php get_template_part( 'templates/partials/single-projects-related' ); ?>