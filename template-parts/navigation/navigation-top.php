<?php
/**
 * Displays top navigation
 */
$tobj1=$GLOBALS['tobj1'];

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'bsoup1' ); ?>">
  <button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
    <?php
    echo $tobj1->get_svg( array( 'icon' => 'bars' ) );
    echo $tobj1->get_svg( array( 'icon' => 'close' ) );
    _e( 'Menu', 'bsoup1' );
    ?>
  </button>

  <?php wp_nav_menu( array(
    'theme_location' => 'top',
    'menu_id'        => 'top-menu',
  ) ); ?>

  <?php if ( ( $tobj1->is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
    <a href="#content" class="menu-scroll-down"><?php echo $tobj1->get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'bsoup1' ); ?></span></a>
  <?php endif; ?>
</nav><!-- #site-navigation -->
