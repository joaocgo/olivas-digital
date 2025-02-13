<?php
  add_filter('wpcf7_autop_or_not', '__return_false');
  remove_action( 'wpcf7_swv_create_schema', 'wpcf7_swv_add_select_enum_rules', 20, 2 );

  function custom_smtp_mailer( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'host.com.br';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 465;
    $phpmailer->Username = 'no-reply@domain.com';
    $phpmailer->Password = 'pass_here';
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->From = 'no-reply@domain.com';
    $phpmailer->FromName = 'Olivas Digital';
  }
  add_action( 'phpmailer_init', 'custom_smtp_mailer' );
?>