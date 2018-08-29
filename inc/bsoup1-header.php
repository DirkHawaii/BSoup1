<?php
/**
 *   File: inc/bsoup1-header.php
 *
 *   Class: BSoup1_Header
 *
 *     Functions:
 *
 *       init()
 *       custom_header_setup()                  add_action( 'after_setup_theme', 'custom_header_setup' )
 *       header_style()
 *       video_controls( $settings )            add_filter( 'header_video_settings', 'video_controls' )
 *
 */
class BSoup1_Header {
  protected $icon_obj;             // ATTRIBUTE - ICON OBJECT

  /***********************************************************************************************/
  public function __construct( $icon_obj ) {
    $this->icon_obj = $icon_obj;
  }
  /***********************************************************************************************/
  public function init() {
  }
  /***********************************************************************************************/
  public function custom_header_setup() {
  
    add_theme_support( 'custom-header', apply_filters( 'bsoup1_custom_header_args', array(
      'default-image'      => get_parent_theme_file_uri( '/assets/images/header.jpg' ),
      'width'              => 2000,
      'height'             => 1200,
      'flex-height'        => true,
      'video'              => true,
      'wp-head-callback'   => array( $this, 'header_style' ),
    ) ) );
  
    register_default_headers( array(
      'default-image' => array(
        'url'           => '%s/assets/images/header.jpg',
        'thumbnail_url' => '%s/assets/images/header.jpg',
        'description'   => __( 'Default Header Image', 'bsoup1' ),
      ),
    ) );
  }
  /***********************************************************************************************/
  public function header_style() {
    $header_text_color = get_header_textcolor();
  
    // IF NO CUSTOM OPTIONS FOR TEXT ARE SET, EXIT.
    // get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
    if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
      return;
    }
    // IF WE GET THIS FAR, WE HAVE CUSTOM STYLES.
    ?><style id="bsoup1-custom-header-styles" type="text/css"><?php
      // HAS THE TEXT BEEN HIDDEN?
    if ( 'blank' === $header_text_color ) :
      ?>
      .site-title,
      .site-description {
        position: absolute;
        clip: rect(1px, 1px, 1px, 1px);
      }
      <?php
    else :  // IF THE USER HAS SET A CUSTOM COLOR FOR THE TEXT USE THAT.
      ?>
      .site-title a,
      .colors-dark .site-title a,
      .colors-custom .site-title a,
      body.has-header-image .site-title a,
      body.has-header-video .site-title a,
      body.has-header-image.colors-dark .site-title a,
      body.has-header-video.colors-dark .site-title a,
      body.has-header-image.colors-custom .site-title a,
      body.has-header-video.colors-custom .site-title a,
      .site-description,
      .colors-dark .site-description,
      .colors-custom .site-description,
      body.has-header-image .site-description,
      body.has-header-video .site-description,
      body.has-header-image.colors-dark .site-description,
      body.has-header-video.colors-dark .site-description,
      body.has-header-image.colors-custom .site-description,
      body.has-header-video.colors-custom .site-description {
        color: #<?php echo esc_attr( $header_text_color ); ?>;
      }
      <?php
    endif;
    ?></style><?php
  }
  /***********************************************************************************************/
  public function video_controls( $settings ) {
    $settings['l10n']['play'] = '<span class="screen-reader-text">' . __( 'Play background video', 'bsoup1' ) . '</span>' . $this->icon_obj->get_svg( array( 'icon' => 'play' ) );
    $settings['l10n']['pause'] = '<span class="screen-reader-text">' . __( 'Pause background video', 'bsoup1' ) . '</span>' . $this->icon_obj->get_svg( array( 'icon' => 'pause' ) );
    return $settings;
  }
  /***********************************************************************************************/

}


