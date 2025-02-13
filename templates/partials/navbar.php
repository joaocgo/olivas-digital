<header>
  <div class="container">
    <div class="row">
      <div class="col-6 col-lg-4">
        <a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name'); ?>" class="d-inline-flex align-items-center h-100">
          <img class="img-logotipo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/brand/logo.webp" alt="<?php echo get_bloginfo('name'); ?>" width=180px" height="46px">
        </a>
      </div>
      <div class="col-6 col-lg-8">
        <div class="menu-wrapper d-flex align-items-center justify-content-end gap-5 h-100">
          <div class="navbar d-none d-lg-inline-flex">
            <?php
              if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                  'theme_location'  => 'primary',
                  'container'       => 'nav',
                  'container_class' => 'primary-menu-container',
                  'menu_class'      => 'primary-menu',
                ));
              }
            ?>
          </div>
          <div class="button-desktop d-none d-lg-inline-flex justify-content-end">
            <a href="https://www.olivas.digital/orcamento" target="_blank" class="button-cta">
              <span class="cta-text">
                <?php echo _e('Solicite um orçamento', 'olivasdigital'); ?>
              </span>
              <div class="cta-icon">
                <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
              </div>
            </a>
          </div>
          <div class="button-mobile d-inline-flex d-lg-none">
            <button type="button" id="open-Menu">
              <span><?php echo _e('menu', 'olivasdigital'); ?></span>
              <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/menu.svg") ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="menu-dropdown" class="nav-overlay" style="display:none;">
    <?php
      if (has_nav_menu('primary')) {
        wp_nav_menu(array(
          'theme_location'  => 'primary',
          'container'       => 'nav',
          'container_class' => 'primary-menu-container',
          'menu_class'      => 'primary-menu',
        ));
      }
    ?>
    <a href="https://www.olivas.digital/orcamento" target="_blank" class="button-cta">
      <span class="cta-text">
        <?php echo _e('Solicite um orçamento', 'olivasdigital'); ?>
      </span>
      <div class="cta-icon">
        <?php echo file_get_contents(get_stylesheet_directory() . "/assets/icons/arrow.svg") ?>
      </div>
    </a>
  </div>
</header>