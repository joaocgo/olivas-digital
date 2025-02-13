<?php
function add_custom_dashboard_page() {
  add_menu_page(
    'Dashboard', // Título da página
    'Painel',              // Título do menu
    'manage_options',      // Permissão necessária
    'custom_dashboard',    // Slug da página
    'display_custom_dashboard', // Função de callback para o conteúdo
    '',                    // Ícone do menu
    1                      // Posição no menu
  );
}
add_action('admin_menu', 'add_custom_dashboard_page');

// Função que renderiza o conteúdo da página personalizada
function display_custom_dashboard() {
  $current_user = wp_get_current_user();
  $user_name = $current_user->first_name ?: $current_user->user_login;
  $last_login = get_user_meta($current_user->ID, 'last_login', true);
  $last_login_formatted = $last_login ? date('d/m/Y H:i:s', $last_login) : 'Primeiro acesso';
  $registered_date = date('d/m/Y', strtotime($current_user->user_registered));
  $roles = $current_user->roles;

  // Obtém os CPTs públicos
  $args = array(
    'public'   => true,
    '_builtin' => false
  );
  $custom_post_types = get_post_types($args, 'objects');

  // Obtém as páginas de opções do ACF dinamicamente
  $acf_option_pages = [];
  if (function_exists('acf_get_options_pages')) {
    $acf_option_pages = acf_get_options_pages();
  }
?>
  <div class="wrap">
    <div id="wrap-admin-intro-panel">
      <h1 class="wrap-admin-intro-panel-title">Bem-vindo, <?php echo $user_name ?></h1>
      <p>Bem-vindo ao painel administrativo da <?php echo get_bloginfo('name'); ?>.</p>
      <div class="wrap-admin-intro-panel-info">
        <span>Último acesso: <strong><?php echo $last_login_formatted ?></strong></span>
        <span>Data de registro: <strong><?php echo $registered_date ?></strong></span>
        <span>Permissões: <strong><?php echo implode(', ', $roles); ?></strong></span>
      </div>
    </div>
    <div class="admin-panel-header">
      <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z"/><path d="M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z"/></svg>
      <div>
        <h2 class="admin-panel-header-title">Gerenciamento de conteúdo dinâmico</h2>
        <p class="admin-panel-header-text">Gerencie facilmente todo o conteúdo de seu site através dos acessos rápidos.</p>
      </div>
    </div>
    <div id="wrap-admin-panels">
      <?php if (!empty($custom_post_types)) : ?>
        <?php foreach ($custom_post_types as $cpt) :
            $menu_icon = $cpt->menu_icon ?: 'dashicons-admin-post';
            $count_posts = wp_count_posts($cpt->name)->publish;
            $latest_post = get_posts([
              'post_type' => $cpt->name,
              'posts_per_page' => -1,
              'orderby' => 'modified',
              'order' => 'DESC',
            ]);
            $last_updated = !empty($latest_post) ? date('d/m/Y H:i:s', strtotime($latest_post[0]->post_modified)) : 'Sem atualizações';
          ?>
          <div class="admin-panel-card">
            <div class="admin-panel-card-header">
              <div class="admin-panel-card-title-wrapper">
                <span class="dashicons <?php echo esc_attr($menu_icon); ?>"></span>
                <h2 class="admin-panel-card-title"><?php echo $cpt->labels->singular_name; ?></h2>
              </div>
              <p class="admin-panel-card-text"><?php echo $cpt->description ?: 'Sem descrição disponível.'; ?></p>
            </div>
            <div class="admin-panel-card-body">
              <ul>
                <li><strong>Quantidade total:</strong> <code><?php echo $count_posts; ?></code> registro(s)</li>
                <li><strong>Última atualização:</strong> <?php echo $last_updated; ?></li>
              </ul>
            </div>
            <div class="admin-panel-card-buttons">
              <a href="<?php echo admin_url('post-new.php?post_type=' . $cpt->name); ?>" class="button button-primary">Adicionar novo</a>
              <a href="<?php echo admin_url('edit.php?post_type=' . $cpt->name); ?>" class="button">Ver Todos</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <?php if (!empty($acf_option_pages)) : ?>
      <div class="admin-panel-header">
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="m19,0H5C2.243,0,0,2.243,0,5v14c0,2.757,2.243,5,5,5h14c2.757,0,5-2.243,5-5V5c0-2.757-2.243-5-5-5Zm3,19c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V5c0-1.654,1.346-3,3-3h14c1.654,0,3,1.346,3,3v14Zm-3-11c0,.553-.447,1-1,1h-8v1c0,.553-.447,1-1,1s-1-.447-1-1v-1h-2c-.553,0-1-.447-1-1s.447-1,1-1h2v-1c0-.553.447-1,1-1s1,.447,1,1v1h8c.553,0,1,.447,1,1Zm0,8c0,.553-.447,1-1,1h-2v1c0,.553-.447,1-1,1s-1-.447-1-1v-1H6c-.553,0-1-.447-1-1s.447-1,1-1h8v-1c0-.553.447-1,1-1s1,.447,1,1v1h2c.553,0,1,.447,1,1Z"/></svg>
        <div>
          <h2 class="admin-panel-header-title">Configurações gerais do site</h2>
          <p class="admin-panel-header-text">Atualize informações globais do site, como telefones de contato, número de WhatsApp e outros conteúdos essenciais.</p>
        </div>
      </div>
      <div id="wrap-admin-panels-small">
        <?php foreach ($acf_option_pages as $option_page) : ?>
          <div class="admin-panel-card">
            <div class="admin-panel-card-header">
              <h2 class="admin-panel-card-title"><?php echo esc_html($option_page['menu_title']); ?></h2>
              <p class="admin-panel-card-text"><?php echo esc_html($option_page['page_title'] ?: 'Sem descrição.'); ?></p>
            </div>
            <div class="admin-panel-card-buttons">
              <a href="<?php echo admin_url('admin.php?page=' . $option_page['menu_slug']); ?>" class="button button-primary">Acessar página</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

<?php
  // Registra o último login do usuário
  function track_last_login($user_login, $user) {
    update_user_meta($user->ID, 'last_login', time());
  }
  add_action('wp_login', 'track_last_login', 10, 2);
}
