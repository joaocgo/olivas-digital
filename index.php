<?php get_header(); ?>

<main class="main">
  <?php if(is_front_page() || is_home()): ?>
    <?php get_template_part('templates/pages/page-home'); ?>
  <?php endif; ?>

  <?php if(is_page(24)): ?>
    <?php get_template_part('templates/pages/page-projects'); ?>
  <?php endif; ?>

  <?php if(is_page(22)): ?>
    <?php get_template_part('templates/pages/page-contact'); ?>
  <?php endif; ?>

  <?php if(is_singular('projects')): ?>
    <?php get_template_part('templates/pages/single-projects'); ?>
  <?php endif; ?>

  <?php if((is_archive() || is_post_type_archive('projects'))): ?>
    <?php get_template_part('templates/pages/archive-projects'); ?>
  <?php endif; ?>
</main>

<div id="modal-background" style="visibility:hidden;"></div>

<?php get_footer(); ?>