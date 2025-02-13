<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="profile" href="https://gmpg.org/xfn/11" />
  <meta name="theme-color" content="#ffffff" />
  <meta name="format-detection" content="telephone=no">
  <?php wp_head(); ?>
  <script>
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  </script>
</head>

<body <?php body_class(); ?>>
  <?php get_template_part( 'templates/partials/navbar' ); ?>
