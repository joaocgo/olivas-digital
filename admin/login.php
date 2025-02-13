<?php
/* Custom Login and Forgot Password Page */
// Enfileirar estilos personalizados para login
function custom_login_enqueue_styles() {
  if (get_query_var('acesso') || get_query_var('redefinir-senha')) {
    wp_enqueue_style(
      'custom-login-style',
      get_template_directory_uri() . '/dist/css/custom-login.css',
      array(),
      '1.0.0'
    );
  }
}
add_action('wp_enqueue_scripts', 'custom_login_enqueue_styles');

// Criar regras de reescrita para URLs personalizadas
function custom_login_rewrite_rules() {
  add_rewrite_rule('^acesso/?$', 'index.php?acesso=1', 'top');
  add_rewrite_rule('^redefinir-senha/?$', 'index.php?redefinir-senha=1', 'top');
}
add_action('init', 'custom_login_rewrite_rules');

// Registrar query vars para capturar as URLs personalizadas
function custom_login_query_vars($vars) {
  $vars[] = 'acesso';
  $vars[] = 'redefinir-senha';
  return $vars;
}
add_filter('query_vars', 'custom_login_query_vars');

// Manipular as rotas personalizadas
function handle_custom_login_routes() {
  if (get_query_var('acesso')) {
    include get_template_directory() . '/admin/custom-login-template.php';
    exit;
  } elseif (get_query_var('redefinir-senha')) {
    include get_template_directory() . '/admin/custom-reset-password-template.php';
    exit;
  }
}
add_action('template_redirect', 'handle_custom_login_routes');

// Redirecionar wp-login.php para a URL personalizada
function redirect_wp_login_to_custom() {
  $login_page = home_url('acesso');

  if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false && !is_user_logged_in() && !isset($_GET['action'])) {
    wp_safe_redirect($login_page);
    exit;
  }
}
add_action('init', 'redirect_wp_login_to_custom');

// Impedir usuário logado de acessar a página de login
function prevent_logged_in_user_access() {
  if (get_query_var('acesso') && is_user_logged_in()) {
    wp_safe_redirect(home_url());
    exit;
  }
}
add_action('template_redirect', 'prevent_logged_in_user_access');

// Alterar a URL de "esqueci minha senha"
function custom_forgot_password_url($lostpassword_url, $redirect) {
  return home_url('redefinir-senha');
}
add_filter('lostpassword_url', 'custom_forgot_password_url', 10, 2);
?>