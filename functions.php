<?php
include('custom/filters.php');
include('custom/form-settings.php');
include('admin/login.php');
include('admin/login-security.php');
include('admin/custom-admin-dashboard.php');
include('ajax/filter-projects.php');

/* Theme Function */
if ( ! function_exists( 'theme' ) ) :
	function theme() {
		load_theme_textdomain( 'olivasdigital', get_template_directory() . '/languages' );
		add_theme_support('post-thumbnails');
		register_nav_menus( array(
			'primary'   => __( 'Menu Principal', 'olivasdigital' ),
		) );
	}
endif;
add_action( 'after_setup_theme', 'theme' );

function theme_libraries() {
	wp_enqueue_script('jquery');
	wp_enqueue_style('bootstrap-grid', get_stylesheet_directory_uri() . '/dist/css/libraries/bootstrap-grid.min.css', array(), '1.0', 'all');
	wp_enqueue_style('bootstrap-utilities', get_stylesheet_directory_uri() . '/dist/css/libraries/bootstrap-utilities.min.css', array(), '1.0', 'all');
	wp_enqueue_style('swiper-bundle', get_stylesheet_directory_uri() . '/dist/css/libraries/swiper-bundle.min.css', array(), '1.0', 'all');
	wp_enqueue_script('libraries', get_stylesheet_directory_uri() . '/dist/js/libraries.js', '1.0', 'libraries');
} add_action( 'wp_enqueue_scripts', 'theme_libraries' );

function theme_assets() {
	wp_enqueue_style('css', get_stylesheet_directory_uri() . '/dist/css/theme.css', array(), '1.0', 'all');
	wp_enqueue_script('js', get_stylesheet_directory_uri() . '/dist/js/theme.js', array(), '1.0', array('strategy' => 'defer'), '1.0', 'all');
} add_action( 'wp_enqueue_scripts', 'theme_assets' );

function custom_admin_css() {
	wp_enqueue_style( 'custom-admin-style', get_template_directory_uri() . '/dist/css/admin-panel.css' );
}
add_action( 'admin_enqueue_scripts', 'custom_admin_css' );

// Admin Theme
function custom_admin_color_scheme() {
	wp_admin_css_color(
		'olivasdigital_theme',
		'Olivas Digital',
		get_template_directory_uri() . '/dist/css/admin-theme.css',
		['#c6b92c', '#7f7f7f', '#841E7F', '#7f7f7f']
	);
}
add_action('admin_init', 'custom_admin_color_scheme');

// Define o esquema de cores padrão ao registrar um novo usuário
function set_default_admin_color_scheme($user_id) {
	update_user_meta($user_id, 'admin_color', 'olivasdigital_theme');
}
add_action('user_register', 'set_default_admin_color_scheme');

// Força o esquema de cores para todos os usuários logados
function force_admin_color_scheme() {
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();
		update_user_meta($user_id, 'admin_color', 'olivasdigital_theme');
	}
}
add_action('init', 'force_admin_color_scheme');

// Página personalizada de primeiro acesso
function redirect_dashboard_to_custom_page() {
  global $pagenow;
  if ('index.php' === $pagenow && is_admin()) {
    wp_redirect(admin_url('admin.php?page=custom_dashboard'));
    exit;
  }
}
add_action('admin_init', 'redirect_dashboard_to_custom_page');

// Custom images sizes
function theme_image_sizes() {
	add_image_size('project-thumb', '550', '650', true);
	add_image_size('project-full', '1920', '690', true);
}
add_action('after_setup_theme', 'theme_image_sizes');