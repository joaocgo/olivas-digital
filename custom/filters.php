<?php
/**
 * Custom filters and actions for WordPress
 * Developed by camargoweb.com
*/

function remove_comments_from_pages() {
	remove_post_type_support('page', 'comments');
}
add_action('init', 'remove_comments_from_pages');

function remove_revisions_meta_box() {
	remove_meta_box('revisionsdiv', 'post', 'normal'); // Posts
	remove_meta_box('revisionsdiv', 'page', 'normal'); // Páginas
}
add_action('add_meta_boxes', 'remove_revisions_meta_box');

// Permitir envio de arquivos SVG
function allow_svg_upload($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

// Exibir miniaturas de SVGs no Media Library
function fix_svg_display() {
	echo '<style>
			.attachment-266x266, .thumbnail img[src$=".svg"] {
					width: 100% !important;
					height: auto !important;
			}
	</style>';
}
add_action('admin_head', 'fix_svg_display');

/* Rename files during upload */
function wp_modify_uploaded_file_names($file) {
  $info = pathinfo($file['name']);
  $ext  = empty($info['extension']) ? '' : '.' . strtolower($info['extension']);
  $name = basename($file['name'], $ext);
  $file['name'] = strtolower(md5(uniqid($name, true))) . $ext;
  return $file;
}
add_filter('wp_handle_upload_prefilter', 'wp_modify_uploaded_file_names', 1, 1);

/** Disable WordPress User Rest API (/wp-json/wp/v2/users/) */ 
add_filter('rest_endpoints', function($endpoints) {
  unset($endpoints['/wp/v2/users']);
  unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
  return $endpoints;
});

/** Custom Rest API Prefix (Make sure to go to Dashboard > Settings > Permalinks and press Save button to flush/rewrite url cache ) */
add_filter( 'rest_url_prefix', 'rest_api_url_prefix' );
function rest_api_url_prefix() {
	return 'api';
}

/* Disable image feature for pages */
function disable_featured_image_for_pages() {
	remove_post_type_support( 'page', 'thumbnail' ); // Remove suporte para imagens destacadas em páginas
}
add_action( 'init', 'disable_featured_image_for_pages' );

/* Disable some endpoints for unauthenticated users */
add_filter( 'rest_endpoints', 'disable_default_endpoints' );
function disable_default_endpoints( $endpoints ) {
	$endpoints_to_remove = array(
		'/oembed/1.0',
		'/wp/v2',
		'/wp/v2/media',
		'/wp/v2/types',
		'/wp/v2/statuses',
		'/wp/v2/taxonomies',
		'/wp/v2/tags',
		'/wp/v2/users',
		'/wp/v2/comments',
		'/wp/v2/settings',
		'/wp/v2/themes',
		'/wp/v2/blocks',
		'/wp/v2/oembed',
		'/wp/v2/posts',
		'/wp/v2/pages',
		'/wp/v2/block-renderer',
		'/wp/v2/search',
		'/wp/v2/categories'
	);

	if ( ! is_user_logged_in() ) {
		foreach ( $endpoints_to_remove as $rem_endpoint ) {
			// $base_endpoint = "/wp/v2/{$rem_endpoint}";
			foreach ( $endpoints as $maybe_endpoint => $object ) {
				if ( stripos( $maybe_endpoint, $rem_endpoint ) !== false ) {
					unset( $endpoints[ $maybe_endpoint ] );
				}
			}
		}
	}
	return $endpoints;
}

// Substituir o link do logotipo na tela de login
function custom_login_logo_url() {
  return home_url();
}
add_filter('login_headerurl', 'custom_login_logo_url');

// Alterar o texto do título ao passar o mouse sobre o logotipo
function custom_login_logo_url_title() {
  return 'Voltar para o site'; // Alterar para o texto desejado
}
add_filter('login_headertext', 'custom_login_logo_url_title');

/* Hide Login Errors in WordPress */
add_filter(
	'login_errors',
	function ( $error ) {
		return 'Houve um erro ao acessar. Tente novamente.';
	}
);

/* Custom WP Admin Footer */
add_filter(
	'admin_footer_text',
	function ( $footer_text ) {
		$footer_text = 'Desenvolvido por <a href="https://olivas.digital" target="_blank" rel="noopener">Olivas Digital</a>©, 2025.';
		return $footer_text;
	}
);

/* Remove Dashboard Welcome Panel */
add_action(
	'admin_init',
	function () {
		remove_action( 'welcome_panel', 'wp_welcome_panel' );
	}
);

/* Empty Admin Dashboard */
add_action('wp_dashboard_setup', 'custom_remove_dashboard_widgets');
function custom_remove_dashboard_widgets() {
	// Remove widgets padrão do painel
	remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Atividade
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // No momento
	remove_meta_box('dashboard_site_health', 'dashboard', 'normal'); // Saúde do site
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Rascunho rápido
	remove_meta_box('dashboard_primary', 'dashboard', 'side'); // Notícias do WordPress
	remove_meta_box('dashboard_secondary', 'dashboard', 'side'); // Eventos e notícias
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); // Plugins
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Comentários recentes
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); // Rascunhos recentes
	remove_meta_box('dashboard_browser_nag', 'dashboard', 'normal'); // Aviso de navegador
	remove_meta_box('dashboard_php_nag', 'dashboard', 'normal'); // Aviso de PHP
	remove_meta_box('rank_math_dashboard_widget', 'dashboard', 'normal'); // Rank Math
}

// Remove o menu principal "Painel"
function hide_dashboard_menu() {
  remove_menu_page('index.php');
}
add_action('admin_menu', 'hide_dashboard_menu', 999);

add_action('admin_menu', function() {
	remove_submenu_page('index.php', 'update-core.php');
});

add_action('admin_notices', function() {
	if (!current_user_can('update_core')) {
		remove_action('admin_notices', 'update_nag', 3);
	}
});

/* Disable Gutenberg Editor (use Classic Editor) */
add_filter('gutenberg_can_edit_post', '__return_false', 5);
add_filter('use_block_editor_for_post', '__return_false', 5);

/* Disable Widget Blocks */
add_filter( 'use_widgets_block_editor', '__return_false' );

/* Remove WordPress Version Number */
add_filter('the_generator', '__return_empty_string');

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );

/* Disable core auto-updates */
add_filter( 'auto_update_core', '__return_false' );

/* Disable auto-updates for plugins */
add_filter( 'auto_update_plugin', '__return_false' );

/* Disable auto-updates for themes */
add_filter( 'auto_update_theme', '__return_false' );

/* Disable XML-RPC */
add_filter( 'xmlrpc_enabled', '__return_false' );

/* Disable auto-update emails */
add_filter( 'auto_core_update_send_email', '__return_false' );

/* Disable auto-update emails for plugins */
add_filter( 'auto_plugin_update_send_email', '__return_false' );

/* Disable auto-update emails for themes */
add_filter( 'auto_theme_update_send_email', '__return_false' );

/* Hide plugins att */
add_filter('site_transient_update_plugins', '__return_null');

/* Hide WordPress Att */
add_filter('pre_site_transient_update_core', '__return_null');
?>