<?php
/* BACK COMPATABLE   */

/**
 *   File: bsoup1-back-compat.php
 *
 * Class BSoup1_BackCompat
 *
 *     Functions:
 *
 *       __construct( $version )
 *       load_dependencies()
 *       define_admin_hooks()
 *       switch_theme()
 *       upgrade_notice()
 *       customize()
 *       preview()
 *
 *   This class is built like the manager class.
 *   The main manager class will not be loaded if this class is created.
 *   This class will only be created if the user has a version of WordPress with a version less than 4.7
 *   Because of that, this class needs to use a loader, call to load_dependencies() and to define_admin_hooks().
 *
 */
class BSoup1_BackCompat {
  protected $loader;              // ATTRIBUTE - LOADER CLASS OBJECT

  /*******************************************************************************************************************/
  public function __construct( $version ) {
    $this->load_dependencies();             // INCLUDE LOADER
    $this->define_admin_hooks();            // SET ALL ADMIN HOOKS
  }
  /*******************************************************************************************************************/
  private function load_dependencies() {
    require_once get_template_directory() .'/inc/bsoup1-loader.php'; // LOADER - THIS IS USED TO LOAD ALL THE SCRIPT AND FUNCTION CALLS INTO AN ARRAY TO BE RUN BY THE MANAGER CLASS
    $this->loader = new BSoup1_Loader();
  }
  /*******************************************************************************************************************/
  private function define_admin_hooks() {
    $this->loader->add_action( 'after_switch_theme', $this, 'switch_theme',   10, 1 );
    $this->loader->add_action( 'admin_notices',      $this, 'upgrade_notice', 10, 1 );
    $this->loader->add_action( 'load-customize.php', $this, 'customize',      10, 1  );
    $this->loader->add_action( 'template_redirect',  $this, 'preview',        10, 1  );
  }
  /*******************************************************************************************************************/
  private function switch_theme() {
    switch_theme( WP_DEFAULT_THEME );
    unset( $_GET['activated'] );
    add_action( 'admin_notices', array( $this, 'upgrade_notice' ) );
  }
  /*******************************************************************************************************************/
  private function upgrade_notice() {
    $message = sprintf( __( 'BSoup 1 requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), $GLOBALS['wp_version'] );
    printf( '<div class="error"><p>%s</p></div>', $message );
  }
  /*******************************************************************************************************************/
  private function customize() {
    wp_die( sprintf( __( 'BSoup 1 requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), $GLOBALS['wp_version'] ), '', array(
      'back_link' => true,
    ) );
  }
  /*******************************************************************************************************************/
  private function preview() {
    if ( isset( $_GET['preview'] ) ) {
      wp_die( sprintf( __( 'BSoup 1 requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), $GLOBALS['wp_version'] ) );
    }
  }
}





