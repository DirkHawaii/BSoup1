<?php
/* bsoup1-manager.php */

/**
 * Class BSoup1_Manager
 *
 *
 */
class BSoup1_Manager {
  protected $loader;          // ATTRIBUTE - LOADER CLASS OBJECT
  protected $icon_obj;        // ATTRIBUTE - ICON CLASS OBJECT
  protected $template;        // ATTRIBUTE - TEMPLATE CLASS OBJECT
  protected $customizer;      // ATTRIBUTE - CUSTOMIZER CLASS OBJECT
  protected $version;         // ATTRIBUTE - VERSION
  protected $content_width;   // ATTRIBUTE - CONTENT WIDTH

  /*************************************************************************************************/
  public function __construct() {
    $this->version = '1.0.0';               // SET THE VERSION
    $this->content_width = 837;             // SET CONTENT WIDTH
    $this->load_dependencies();             // LOAD DEPENDENCIES
    $this->define_admin_hooks();            // SET ALL ADMIN HOOKS
  }
  /*************************************************************************************************/
  private function load_dependencies() {

    if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
      require_once get_template_directory() .'/inc/bsoup1-back-compat.php';
      return;
    }
    require_once get_template_directory() .'/inc/bsoup1-icon.php';                  // ICON       - DISPLAY OF SVG ICONS
    $this->icon_obj = new BSoup1_Icon( $this->get_version() );

    // NAV WALKER - MAKES BOOTSTRAP NAVIGATION POSSIBLE
    //require_once get_template_directory() .'/lib/bootstrap-four-wp-navwalker.php';
    require_once get_template_directory() .'/inc/bsoup1-obj.php';                   // OBJ        - HANDLES THEME SUPPORT SETTINGS, STARTUP SETTINGS AND CHANGING POST TO NEWSLETTER
    require_once get_template_directory() .'/inc/bsoup1-widgets.php';               // WIDGETS    - HANDLES THE WIDGETS
    require_once get_template_directory() .'/inc/bsoup1-style.php';                 // STYLE      - HANDLES THE LOADING OF GOOGLE FONTS AND SETTING UP THE SCRIPTS FOR BOOTSTRAP
    require_once get_template_directory() .'/inc/bsoup1-header.php';                // HEADER     - HEADER CUSTOMIZATION
    require_once get_template_directory() .'/inc/bsoup1-customizer.php';            // CUSTOMIZER - 
    $this->customizer = new BSoup1_Customizer( $this->get_version() );

    require_once get_template_directory() .'/inc/bsoup1-template.php';              // TEMPLATE   - TEMPLATE FUNCTIONS
    $this->template = new BSoup1_Template( $this->icon_obj, $this->customizer );

    $this->customizer->set_template_obj( $this->template );

    require_once get_template_directory() .'/inc/bsoup1-loader.php';                // LOADER     - THIS IS USED TO LOAD ALL THE SCRIPT AND FUNCTION CALLS INTO AN ARRAY TO BE RUN BY THE MANAGER CLASS
    $this->loader = new BSoup1_Loader();
  }
  /*************************************************************************************************/
  private function define_admin_hooks() {
    $theme = new BSoup1_Obj( $this->get_version() );
    $this->loader->add_action( 'after_setup_theme', $theme, 'setup_theme', 10, 1 );
    $this->loader->add_action( 'template_redirect', $theme, 'content_width', 0, 1 );
    $this->loader->add_filter( 'wp_resource_hints', $theme, 'resource_hints', 10, 2 );
    $this->loader->add_filter( 'excerpt_more',      $theme, 'excerpt_more', 10, 2 );
    $this->loader->add_action( 'wp_head',           $theme, 'javascript_detection', 0, 1 );
    $this->loader->add_action( 'wp_head',           $theme, 'pingback_header', 10, 2 );
    $this->loader->add_action( 'wp_head',           $theme, 'colors_css_wrap', 10, 2 );

    $this->loader->add_action( 'wp_footer',                  $this->icon_obj, 'include_svg_icons', 9999, 2 );
    $this->loader->add_filter( 'walker_nav_menu_start_el',   $this->icon_obj, 'nav_menu_social_icons', 10, 4 );
    $this->loader->add_filter( 'nav_menu_item_title',        $this->icon_obj, 'dropdown_icon_to_menu_link', 10, 4 );

    $widgets = new BSoup1_Widgets( $this->get_version() );
    $this->loader->add_action( 'widgets_init', $widgets, 'init', 10, 1 );

    $style = new BSoup1_Style( $this->get_version(), $this->get_icon() );
    $this->loader->add_action( 'wp_enqueue_scripts',                  $style, 'theme_scripts', 10, 1 );
    $this->loader->add_filter( 'wp_calculate_image_sizes',            $style, 'content_image_sizes_attr', 10, 2 );
    $this->loader->add_filter( 'get_header_image_tag',                $style, 'header_image_tag', 10, 3 );
    $this->loader->add_filter( 'wp_get_attachment_image_attributes',  $style, 'post_thumbnail_sizes_attr', 10, 3 );
    $this->loader->add_filter( 'frontpage_template',                  $style, 'front_page_template', 10, 1 );
    $this->loader->add_filter( 'widget_tag_cloud_args',               $style, 'widget_tag_cloud_args', 10, 1 );

    $header = new BSoup1_Header( $this->get_icon() );
    $this->loader->add_action( 'after_setup_theme',     $header, 'custom_header_setup', 10, 1  );
    $this->loader->add_filter( 'header_video_settings', $header, 'video_controls', 10, 1  );

    $this->loader->add_action( 'customize_register',                  $this->customizer, 'customize_register', 10, 5 );
    $this->loader->add_action( 'customize_preview_init',              $this->customizer, 'customize_preview_js', 10, 5 );
    $this->loader->add_action( 'customize_controls_enqueue_scripts',  $this->customizer, 'panels_js', 10, 5 );

    $this->loader->add_action( 'edit_category', $this->template, 'category_transient_flusher', 10, 1 );
    $this->loader->add_action( 'save_post',     $this->template, 'category_transient_flusher', 10, 1 );
    $this->loader->add_filter( 'body_class',    $this->template, 'body_classes', 10, 1 );
  }
  /*************************************************************************************************/
  public function run() {
    $this->loader->run();
  }
  /*************************************************************************************************/
  public function get_svg( $args = array() ) {
    return $this->icon_obj->get_svg( $args );
  }
  /*************************************************************************************************/
  public function posted_on() {
    return $this->template->posted_on();
  }
  /*************************************************************************************************/
  public function time_link() {
    return $this->template->time_link();
  }
  /*************************************************************************************************/
  public function entry_footer() {
    return $this->template->entry_footer();
  }
  /*************************************************************************************************/
  public function edit_link() {
    return $this->template->edit_link();
  }
  /*************************************************************************************************/
  public function front_page_section( $partial, $id ) {
    return $this->template->front_page_section( $partial, $id );
  }
  /*************************************************************************************************/
  public function categorized_blog() {
    return $this->template->categorized_blog();
  }
  /*************************************************************************************************/
  public function panel_count() {
    return $this->template->panel_count();
  }
  /*************************************************************************************************/
  public function is_frontpage() {
    
    //return $this->template->is_frontpage();
    return ( is_front_page() && ! is_home() );
  }
  /*************************************************************************************************/
  public function get_version() {
    return $this->version;
  }
  /*************************************************************************************************/
  public function get_icon() {
    return $this->icon_obj;
  }
  /*************************************************************************************************/
  public function get_content_width() {
    return $this->content_width;
  }
  /*************************************************************************************************/
  public function panel_count_old() {
    $pnl_count = 0;
    $num_sections = apply_filters( 'bsoup1_front_page_sections', 4 );   /* FILTER NUMBER OF FRONT PAGE SECTIONS IN THIS THEME. */
    for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {                  /* CREATE A SETTING AND CONTROL FOR EACH OF THE SECTIONS AVAILABLE IN THE THEME. */
      if ( get_theme_mod( 'panel_'. $i ) ) { $pnl_count++; }
    }
    return $pnl_count;
  }
  /*************************************************************************************************/
  public function front_page_section_old( $partial = null, $id = 0 ) {
    if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
      // FIND OUT THE ID AND SET IT UP DURING A SELECTIVE REFRESH.
      global $bsoup1counter;
      $id = str_replace( 'panel_', '', $partial->id );
      $bsoup1counter = $id;
    }
    global $post; // MODIFY THE GLOBAL POST OBJECT BEFORE SETTING UP POST DATA.
    if ( get_theme_mod( 'panel_' . $id ) ) {
      $post = get_post( get_theme_mod( 'panel_' . $id ) );
      setup_postdata( $post );
      set_query_var( 'panel', $id );
      get_template_part( 'template-parts/page/content', 'front-page-panels' );
      wp_reset_postdata();
    } elseif ( is_customize_preview() ) {
      // THE OUTPUT PLACEHOLDER ANCHOR.
      echo '<article class="panel-placeholder panel bsoup1-panel bsoup1-panel' . $id . '" id="panel' . $id . '"><span class="bsoup1-panel-title">' . sprintf( __( 'Front Page Section %1$s Placeholder', 'BSoup1' ), $id ) . '</span></article>';
    }
  }
  /*************************************************************************************************/
  public function get_posts_pagination_old( $args = '' ) {
    global $wp_query;
    $pagination = '';
    if ( $GLOBALS['wp_query']->max_num_pages > 1 ) :
      $defaults = array(
        'total'     => isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1,
        'current'   => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
        'type'      => 'array',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
      );
      $params = wp_parse_args( $args, $defaults );
      $paginate = paginate_links( $params );
      if( $paginate ) :
        $pagination .= "<ul class='pagination'>";
        foreach( $paginate as $page ) :
          if( strpos( $page, 'current' ) ) :
            $pagination .= "<li class='active'>$page</li>";
          else :
            $pagination .= "<li>$page</li>";
          endif;
        endforeach;
        $pagination .= "</ul>";
      endif;
    endif;
    return $pagination;
  }
  /*************************************************************************************************/
  public function the_posts_pagination_old( $args = '' ) {
    echo $this->get_posts_pagination( $args );
  }
}









