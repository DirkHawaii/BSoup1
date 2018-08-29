<?php
/**
 *   File: bsoup1-style.php
 *
 *   Class BSoup1_Style
 *
 *     Functions:
 *
 *       __construct( $version )
 *       fonts_url_bs()
 *       fonts_url()
 *       admin_style()
 *       theme_scripts_bs()
 *       nav_li_class( $classes )
 *       nav_anchor_class( $atts )
 *
 *       theme_scripts()
 *       content_image_sizes_attr( $sizes, $size )..................add_filter( 'wp_calculate_image_sizes', 'content_image_sizes_attr', 10, 2 );
 *       header_image_tag( $html, $header, $attr )..................add_filter( 'get_header_image_tag', 'header_image_tag', 10, 3 );
 *       post_thumbnail_sizes_attr( $attr, $attachment, $size ).....add_filter( 'wp_get_attachment_image_attributes', 'post_thumbnail_sizes_attr', 10, 3 );
 *       front_page_template( $template )...........................add_filter( 'frontpage_template',  'front_page_template' );
 *       widget_tag_cloud_args( $args ).............................add_filter( 'widget_tag_cloud_args', 'widget_tag_cloud_args' );
 *
 */
class BSoup1_Style {
  protected $version;             // ATTRIBUTE - VERSION
  protected $icon_obj;

  /*******************************************************************************************************************/
  public function __construct( $version, $icon_obj ) {
    $this->version = $version;
    $this->icon_obj = $icon_obj;
  }

  /*******************************************************************************************************************/
  public function theme_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'bsoup1-fonts', $this->fonts_url(), array(), null );
  
    // Theme stylesheet.
    wp_enqueue_style( 'bsoup1-style', get_stylesheet_uri() );
  
    // Load the dark colorscheme.
    if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
      wp_enqueue_style( 'bsoup1-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'bsoup1-style' ), '1.0' );
    }
    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if ( is_customize_preview() ) {
      wp_enqueue_style( 'bsoup1-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'bsoup1-style' ), '1.0' );
      wp_style_add_data( 'bsoup1-ie9', 'conditional', 'IE 9' );
    }
    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style( 'bsoup1-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'bsoup1-style' ), '1.0' );
    wp_style_add_data( 'bsoup1-ie8', 'conditional', 'lt IE 9' );
    // Load the html5 shiv.
    wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
    wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
    wp_enqueue_script( 'bsoup1-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );
    $bsoup1_l10n = array(
      'quote' => $this->icon_obj->get_svg( array( 'icon' => 'quote-right' ) ),
    );
    if ( has_nav_menu( 'top' ) ) {
      wp_enqueue_script( 'bsoup1-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
      $bsoup1_l10n['expand']   = __( 'Expand child menu', 'bsoup1' );
      $bsoup1_l10n['collapse'] = __( 'Collapse child menu', 'bsoup1' );
      $bsoup1_l10n['icon']     = $this->icon_obj->get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
    }
    wp_enqueue_script( 'bsoup1-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );
    wp_localize_script( 'bsoup1-skip-link-focus-fix', 'bsoup1ScreenReaderText', $bsoup1_l10n );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }

  /*******************************************************************************************************************/
  public function content_image_sizes_attr( $sizes, $size ) {
    $width = $size[0];
    if ( 740 <= $width ) {
      $sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
    }
    if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
      if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
         $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
      }
    }
    return $sizes;
  }

  /*******************************************************************************************************************/
  public function header_image_tag( $html, $header, $attr ) {
    if ( isset( $attr['sizes'] ) ) {
      $html = str_replace( $attr['sizes'], '100vw', $html );
    }
    return $html;
  }

  /*******************************************************************************************************************/
  public function post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
    if ( is_archive() || is_search() || is_home() ) {
      $attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
    } else {
      $attr['sizes'] = '100vw';
    }
    return $attr;
  }
  /*******************************************************************************************************************/
  public function front_page_template( $template ) {
    return is_home() ? '' : $template;
  }
  /*******************************************************************************************************************/
  public function widget_tag_cloud_args( $args ) {
    $args['largest']  = 1;
    $args['smallest'] = 1;
    $args['unit']     = 'em';
    $args['format']   = 'list';
  
    return $args;
  }
  /*******************************************************************************************************************/

  /*******************************************************************************************************************/

  /*******************************************************************************************************************/



  /*******************************************************************************************************************/
  public function fonts_url() {
    $fonts_url = '';
    /*
     * Translators: If there are characters in your language that are not
     * supported by Libre Franklin, translate this to 'off'. Do not translate
     * into your own language.
     */
    $libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'BSoup1' );

    if ( 'off' !== $libre_franklin ) {
      $font_families = array();
      $font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';
      $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,latin-ext' ),
      );
      $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
    return esc_url_raw( $fonts_url );
  }

  /*******************************************************************************************************************/
  private function fonts_url_bs() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    /*** TRANSLATORS: IF THERE ARE CHARACTERS IN YOUR LANGUAGE THAT ARE NOT SUPPORTED BY THE     ***/
    /*** FOLLOWING FONTS, TRANSLATE THIS TO 'off'. DO NOT TRANSLATE INTO YOUR OWN LANGUAGE.      ***/
    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'BSoup1' ) )    { $fonts[] = 'Open Sans';    }
    if ( 'off' !== _x( 'on', 'Hind font: on or off', 'BSoup1' ) )         { $fonts[] = 'Hind:400,700'; }
    if ( 'off' !== _x( 'on', 'Varela Round font: on or off', 'BSoup1' ) ) { $fonts[] = 'Varela Round'; }
    if ( $fonts ) {
      $fonts_url = add_query_arg( array(
        'family' => urlencode( implode( '|', $fonts ) ),
        'subset' => urlencode( $subsets ),
      ), 'https://fonts.googleapis.com/css' );
    }
    return $fonts_url;
  }
  /*******************************************************************************************************************/
  public function admin_style() {
    wp_enqueue_style( 'admin-styles', get_template_directory_uri().'/css/admin.css');
  }
  /*******************************************************************************************************************/
  public function theme_scripts_bs() {
    global $BSoup1_version;

    wp_register_style( 'BSoup1-jqui',    get_template_directory_uri() . '/css/jquery-ui.css', array(), $this->version );
    wp_enqueue_style( 'BSoup1-uistyles', get_stylesheet_uri(), array( 'BSoup1-jqui' ), '1' );

    wp_enqueue_style( 'BSoup1-fonts',      $this->fonts_url(), array(), null );
    wp_register_style( 'BSoup1-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $this->version );
    wp_enqueue_style( 'BSoup1-styles',     get_stylesheet_uri(), array( 'BSoup1-bootstrap' ), '1' );
    wp_enqueue_script( 'BSoup1-popper',    get_template_directory_uri() .'/js/vendor/popper.min.js', array( 'jquery' ), $this->version, true );
    wp_enqueue_script( 'BSoup1-docs',      get_template_directory_uri() .'/js/docs.min.js', array( 'jquery' ), $this->version, true );
    wp_enqueue_script( 'BSoup1-bstrap',    get_template_directory_uri() .'/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
    wp_enqueue_script( 'BSoup1-iewo',      get_template_directory_uri() .'/js/ie10-viewport-bug-workaround.js', array( 'jquery' ), $this->version, true );
  }


  /*************************************************************************************************/
  /**   N A V   L I   C L A S S   ( $classes, $item )                                             **/
  /*************************************************************************************************/
  public function nav_li_class( $classes ) {
    $classes[] .= ' nav-item';
    return $classes;
  }
  /*************************************************************************************************/
  /**   N A V   A N C H O R   C L A S S    ( $atts, $item, $args )                                **/
  /*************************************************************************************************/
  public function nav_anchor_class( $atts ) {
    $atts['class'] .= ' nav-link';
    return $atts;
  }




}
