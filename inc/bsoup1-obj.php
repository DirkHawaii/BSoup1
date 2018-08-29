<?php
/**
 *   File: bsoup1-obj.php
 *
 *   Class: BSoup1_Obj
 *
 *     Functions:
 *       
 *       __construct( $version )
 *       setup_theme()
 *       change_post_label()
 *       change_post_object()
 *       comment_form_before()
 *       comment_form_defaults( $fields )
 *       comment_form_after()
 *       fonts_url()
 *       content_width()
 *       is_frontpage()
 *       resource_hints( $urls, $relation_type )
 *       excerpt_more( $link )
 *       javascript_detection()
 *       pingback_header()
 *       colors_css_wrap()
 *       custom_colors_css()
 *       
 */
 class BSoup1_Obj {
  protected $version;             // ATTRIBUTE - VERSION
  /*******************************************************************************************************************/
  public function __construct( $version ) {
    $this->version = $version;
  }
  /*******************************************************************************************************************/
  public function setup_theme() {

    load_theme_textdomain( 'bsoup1' );

    /***   A D D   T H E M E   S U P P O R T   ***/
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    add_image_size( 'bsoup1-featured-image', 2000, 1200, true );
    add_image_size( 'bsoup1-thumbnail-avatar', 100, 100, true );
    $GLOBALS['content_width'] = 525;

    /***   A D D   N A V I G A T I O N   M E N U   ***/
    register_nav_menus( array(
      'top'    => __( 'Top Menu', 'bsoup1' ),
      'social' => __( 'Social Links Menu', 'bsoup1' ),
    ) );
    add_theme_support( 'html5', array(
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );

    //add_theme_support( 'custom-background', array( 'default-color' => 'ffffff', ) );
    add_theme_support( 'post-formats', array( 
      'aside',
      'image',
      'video',
      'quote',
      'link',
      'gallery',
      'audio',
    ) );
    add_theme_support( 'custom-logo', array(
      'width'       => 250,
      'height'      => 250,
      'flex-width'  => true,
    ) );
    add_theme_support( 'customize-selective-refresh-widgets' );

    add_editor_style( array( 'assets/css/editor-style.css', $this->fonts_url() ) );

    $starter_content = array(
      'widgets' => array(
        // Place three core-defined widgets in the sidebar area.
        'sidebar-1' => array(
          'text_business_info',
          'search',
          'text_about',
        ),

        // Add the core-defined business info widget to the footer 1 area.
        'sidebar-2' => array(
          'text_business_info',
        ),

        // Put two core-defined widgets in the footer 2 area.
        'sidebar-3' => array(
          'text_about',
          'search',
        ),
      ),

      // Specify the core-defined pages to create and add custom thumbnails to some of them.
      'posts' => array(
        'home',
        'about' => array(
          'thumbnail' => '{{image-sandwich}}',
        ),
        'contact' => array(
          'thumbnail' => '{{image-espresso}}',
        ),
        'blog' => array(
          'thumbnail' => '{{image-coffee}}',
        ),
        'homepage-section' => array(
          'thumbnail' => '{{image-espresso}}',
        ),
      ),

      // Create the custom image attachments used as post thumbnails for pages.
      'attachments' => array(
        'image-espresso' => array(
          'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
          'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
        ),
        'image-sandwich' => array(
          'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
          'file' => 'assets/images/sandwich.jpg',
        ),
        'image-coffee' => array(
          'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
          'file' => 'assets/images/coffee.jpg',
        ),
      ),

      // Default to a static front page and assign the front and posts pages.
      'options' => array(
        'show_on_front' => 'page',
        'page_on_front' => '{{home}}',
        'page_for_posts' => '{{blog}}',
      ),

      // Set the front page section theme mods to the IDs of the core-registered pages.
      'theme_mods' => array(
        'panel_1' => '{{homepage-section}}',
        'panel_2' => '{{about}}',
        'panel_3' => '{{blog}}',
        'panel_4' => '{{contact}}',
      ),

      // Set up nav menus for each of the two areas registered in the theme.
      'nav_menus' => array(
        // Assign a menu to the "top" location.
        'top' => array(
          'name' => __( 'Top Menu', 'twentyseventeen' ),
          'items' => array(
            'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
            'page_about',
            'page_blog',
            'page_contact',
          ),
        ),

        // Assign a menu to the "social" location.
        'social' => array(
          'name' => __( 'Social Links Menu', 'twentyseventeen' ),
          'items' => array(
            'link_yelp',
            'link_facebook',
            'link_twitter',
            'link_instagram',
            'link_email',
          ),
        ),
      ),
    );
    $starter_content = apply_filters( 'bsoup1_starter_content', $starter_content );
    add_theme_support( 'starter-content', $starter_content );
  }
  /*******************************************************************************************************************/
  public function change_post_label() {
      global $menu;
      global $submenu;
      $menu[5][0] = 'Newsletter';
      $submenu['edit.php'][5][0] = 'Newsletter';
      $submenu['edit.php'][10][0] = 'Add News';
      $submenu['edit.php'][16][0] = 'News Tags';
  }
  /*******************************************************************************************************************/
  public function change_post_object() {
      global $wp_post_types;
      $labels = &$wp_post_types['post']->labels;
      $labels->name = 'Newsletter';
      $labels->singular_name = 'Newsletter';
      $labels->add_new = 'Add News';
      $labels->add_new_item = 'Add News';
      $labels->edit_item = 'Edit News';
      $labels->new_item = 'Newsletter';
      $labels->view_item = 'View News';
      $labels->search_items = 'Search News';
      $labels->not_found = 'No News found';
      $labels->not_found_in_trash = 'No News found in Trash';
      $labels->all_items = 'All News';
      $labels->menu_name = 'Newsletter';
      $labels->name_admin_bar = 'Newsletter';
  }
  /*******************************************************************************************************************/
  /**   C O M M E N T   F O R M   B E F O R E   **/
  public function comment_form_before() {
    echo '<div class="card"><div class="card-block">';
  }
  /*******************************************************************************************************************/
  /**   C O M M E N T   F O R M   **/
  public function comment_form_defaults( $fields ) {
    $fields['fields']['author'] = '
    <fieldset class="form-group comment-form-email">
      <label for="author">' . __( 'Name *', 'BSoup1' ) . '</label>
      <input type="text" class="form-control" name="author" id="author" placeholder="' . __( 'Name', 'BSoup1' ) . '" aria-required="true" required>
    </fieldset>';
    $fields['fields']['email'] ='
    <fieldset class="form-group comment-form-email">
      <label for="email">' . __( 'Email address *', 'BSoup1' ) . 'Email address *</label>
      <input type="email" class="form-control" id="email" placeholder="' . __( 'Enter email', 'BSoup1' ) . '" aria-required="true" required>
      <small class="text-muted">' . __( 'Your email address will not be published.', 'BSoup1' ) . '</small>
    </fieldset>';
    $fields['fields']['url'] = '
    <fieldset class="form-group comment-form-email">
      <label for="url">' . __( 'Website *', 'BSoup1' ) . '</label>
      <input type="text" class="form-control" name="url" id="url" placeholder="' . __( 'http://example.org', 'BSoup1' ) . '">
    </fieldset>';
    $fields['comment_field'] = '
    <fieldset class="form-group">
      <label for="comment">' . __( 'Comment *', 'BSoup1' ) . '</label>
      <textarea class="form-control" id="comment" name="comment" rows="3" aria-required="true" required></textarea>
    </fieldset>';
    $fields['comment_notes_before'] = '';
    $fields['class_submit'] = 'btn btn-primary';
    return $fields;
  }
  /*******************************************************************************************************************/
  /**   C O M M E N T   F O R M   A F T E R   **/
  public function comment_form_after() {
    echo '</div><!-- .card-block --></div><!-- .card -->';
  }

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
  public function content_width() {
    $content_width = $GLOBALS['content_width'];
    $page_layout = get_theme_mod( 'page_layout' );  // GET LAYOUT.
    if ( 'one-column' === $page_layout ) {  // CHECK IF LAYOUT IS ONE COLUMN.
      if ( $this->is_frontpage() ) {
        $content_width = 644;
      } elseif ( is_page() ) {
        $content_width = 740;
      }
    }
    // CHECK IF IS SINGLE POST AND THERE IS NO SIDEBAR.
    if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
      $content_width = 740;
    }
    $GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
  }
  /*******************************************************************************************************************/
  public function is_frontpage() {
    return ( is_front_page() && ! is_home() );
  }
  /*******************************************************************************************************************/
  public function resource_hints( $urls, $relation_type ) {
    if ( wp_style_is( 'bsoup1-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
      $urls[] = array(
        'href' => 'https://fonts.gstatic.com',
        'crossorigin',
      );
    }
    return $urls;
  }


  /*******************************************************************************************************************/
  public function excerpt_more( $link ) {
    if ( is_admin() ) {
      return $link;
    }
  
    $link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
      esc_url( get_permalink( get_the_ID() ) ),
      /* translators: %s: Name of current post */
      sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'BSoup1' ), get_the_title( get_the_ID() ) )
    );
    return ' &hellip; ' . $link;
  }


  /*******************************************************************************************************************/
  public function javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
  }

  /*******************************************************************************************************************/
  public function pingback_header() {
    if ( is_singular() && pings_open() ) {
      printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
    }
  }


  /*******************************************************************************************************************/
  public function colors_css_wrap() {
    if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
      return;
    }
    //require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
    $hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
    ?>
    <style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
      <?php echo $this->custom_colors_css(); ?>
    </style>
    <?php
  }
  /*******************************************************************************************************************/
  /*******************************************************************************************************************/


  /*******************************************************************************************************************/
  public function custom_colors_css() {
    $hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
  
    $saturation = absint( apply_filters( 'bsoup1_custom_colors_saturation', 50 ) );
    $reduced_saturation = ( .8 * $saturation ) . '%';
    $saturation = $saturation . '%';
    $css = '
  .colors-custom a:hover,
  .colors-custom a:active,
  .colors-custom .entry-content a:focus,
  .colors-custom .entry-content a:hover,
  .colors-custom .entry-summary a:focus,
  .colors-custom .entry-summary a:hover,
  .colors-custom .comment-content a:focus,
  .colors-custom .comment-content a:hover,
  .colors-custom .widget a:focus,
  .colors-custom .widget a:hover,
  .colors-custom .site-footer .widget-area a:focus,
  .colors-custom .site-footer .widget-area a:hover,
  .colors-custom .posts-navigation a:focus,
  .colors-custom .posts-navigation a:hover,
  .colors-custom .comment-metadata a:focus,
  .colors-custom .comment-metadata a:hover,
  .colors-custom .comment-metadata a.comment-edit-link:focus,
  .colors-custom .comment-metadata a.comment-edit-link:hover,
  .colors-custom .comment-reply-link:focus,
  .colors-custom .comment-reply-link:hover,
  .colors-custom .widget_authors a:focus strong,
  .colors-custom .widget_authors a:hover strong,
  .colors-custom .entry-title a:focus,
  .colors-custom .entry-title a:hover,
  .colors-custom .entry-meta a:focus,
  .colors-custom .entry-meta a:hover,
  .colors-custom.blog .entry-meta a.post-edit-link:focus,
  .colors-custom.blog .entry-meta a.post-edit-link:hover,
  .colors-custom.archive .entry-meta a.post-edit-link:focus,
  .colors-custom.archive .entry-meta a.post-edit-link:hover,
  .colors-custom.search .entry-meta a.post-edit-link:focus,
  .colors-custom.search .entry-meta a.post-edit-link:hover,
  .colors-custom .page-links a:focus .page-number,
  .colors-custom .page-links a:hover .page-number,
  .colors-custom .entry-footer a:focus,
  .colors-custom .entry-footer a:hover,
  .colors-custom .entry-footer .cat-links a:focus,
  .colors-custom .entry-footer .cat-links a:hover,
  .colors-custom .entry-footer .tags-links a:focus,
  .colors-custom .entry-footer .tags-links a:hover,
  .colors-custom .post-navigation a:focus,
  .colors-custom .post-navigation a:hover,
  .colors-custom .pagination a:not(.prev):not(.next):focus,
  .colors-custom .pagination a:not(.prev):not(.next):hover,
  .colors-custom .comments-pagination a:not(.prev):not(.next):focus,
  .colors-custom .comments-pagination a:not(.prev):not(.next):hover,
  .colors-custom .logged-in-as a:focus,
  .colors-custom .logged-in-as a:hover,
  .colors-custom a:focus .nav-title,
  .colors-custom a:hover .nav-title,
  .colors-custom .edit-link a:focus,
  .colors-custom .edit-link a:hover,
  .colors-custom .site-info a:focus,
  .colors-custom .site-info a:hover,
  .colors-custom .widget .widget-title a:focus,
  .colors-custom .widget .widget-title a:hover,
  .colors-custom .widget ul li a:focus,
  .colors-custom .widget ul li a:hover {
    color: hsl( ' . $hue . ', ' . $saturation . ', 0% ); /* base: #000; */
  }
  
  .colors-custom .entry-content a,
  .colors-custom .entry-summary a,
  .colors-custom .comment-content a,
  .colors-custom .widget a,
  .colors-custom .site-footer .widget-area a,
  .colors-custom .posts-navigation a,
  .colors-custom .widget_authors a strong {
    -webkit-box-shadow: inset 0 -1px 0 hsl( ' . $hue . ', ' . $saturation . ', 6% ); /* base: rgba(15, 15, 15, 1); */
    box-shadow: inset 0 -1px 0 hsl( ' . $hue . ', ' . $saturation . ', 6% ); /* base: rgba(15, 15, 15, 1); */
  }
  
  .colors-custom button,
  .colors-custom input[type="button"],
  .colors-custom input[type="submit"],
  .colors-custom .entry-footer .edit-link a.post-edit-link {
    background-color: hsl( ' . $hue . ', ' . $saturation . ', 13% ); /* base: #222; */
  }
  
  .colors-custom input[type="text"]:focus,
  .colors-custom input[type="email"]:focus,
  .colors-custom input[type="url"]:focus,
  .colors-custom input[type="password"]:focus,
  .colors-custom input[type="search"]:focus,
  .colors-custom input[type="number"]:focus,
  .colors-custom input[type="tel"]:focus,
  .colors-custom input[type="range"]:focus,
  .colors-custom input[type="date"]:focus,
  .colors-custom input[type="month"]:focus,
  .colors-custom input[type="week"]:focus,
  .colors-custom input[type="time"]:focus,
  .colors-custom input[type="datetime"]:focus,
  .colors-custom .colors-custom input[type="datetime-local"]:focus,
  .colors-custom input[type="color"]:focus,
  .colors-custom textarea:focus,
  .colors-custom button.secondary,
  .colors-custom input[type="reset"],
  .colors-custom input[type="button"].secondary,
  .colors-custom input[type="reset"].secondary,
  .colors-custom input[type="submit"].secondary,
  .colors-custom a,
  .colors-custom .site-title,
  .colors-custom .site-title a,
  .colors-custom .navigation-top a,
  .colors-custom .dropdown-toggle,
  .colors-custom .menu-toggle,
  .colors-custom .page .panel-content .entry-title,
  .colors-custom .page-title,
  .colors-custom.page:not(.twentyseventeen-front-page) .entry-title,
  .colors-custom .page-links a .page-number,
  .colors-custom .comment-metadata a.comment-edit-link,
  .colors-custom .comment-reply-link .icon,
  .colors-custom h2.widget-title,
  .colors-custom mark,
  .colors-custom .post-navigation a:focus .icon,
  .colors-custom .post-navigation a:hover .icon,
  .colors-custom .site-content .site-content-light,
  .colors-custom .twentyseventeen-panel .recent-posts .entry-header .edit-link {
    color: hsl( ' . $hue . ', ' . $saturation . ', 13% ); /* base: #222; */
  }
  
  .colors-custom .entry-content a:focus,
  .colors-custom .entry-content a:hover,
  .colors-custom .entry-summary a:focus,
  .colors-custom .entry-summary a:hover,
  .colors-custom .comment-content a:focus,
  .colors-custom .comment-content a:hover,
  .colors-custom .widget a:focus,
  .colors-custom .widget a:hover,
  .colors-custom .site-footer .widget-area a:focus,
  .colors-custom .site-footer .widget-area a:hover,
  .colors-custom .posts-navigation a:focus,
  .colors-custom .posts-navigation a:hover,
  .colors-custom .comment-metadata a:focus,
  .colors-custom .comment-metadata a:hover,
  .colors-custom .comment-metadata a.comment-edit-link:focus,
  .colors-custom .comment-metadata a.comment-edit-link:hover,
  .colors-custom .comment-reply-link:focus,
  .colors-custom .comment-reply-link:hover,
  .colors-custom .widget_authors a:focus strong,
  .colors-custom .widget_authors a:hover strong,
  .colors-custom .entry-title a:focus,
  .colors-custom .entry-title a:hover,
  .colors-custom .entry-meta a:focus,
  .colors-custom .entry-meta a:hover,
  .colors-custom.blog .entry-meta a.post-edit-link:focus,
  .colors-custom.blog .entry-meta a.post-edit-link:hover,
  .colors-custom.archive .entry-meta a.post-edit-link:focus,
  .colors-custom.archive .entry-meta a.post-edit-link:hover,
  .colors-custom.search .entry-meta a.post-edit-link:focus,
  .colors-custom.search .entry-meta a.post-edit-link:hover,
  .colors-custom .page-links a:focus .page-number,
  .colors-custom .page-links a:hover .page-number,
  .colors-custom .entry-footer .cat-links a:focus,
  .colors-custom .entry-footer .cat-links a:hover,
  .colors-custom .entry-footer .tags-links a:focus,
  .colors-custom .entry-footer .tags-links a:hover,
  .colors-custom .post-navigation a:focus,
  .colors-custom .post-navigation a:hover,
  .colors-custom .pagination a:not(.prev):not(.next):focus,
  .colors-custom .pagination a:not(.prev):not(.next):hover,
  .colors-custom .comments-pagination a:not(.prev):not(.next):focus,
  .colors-custom .comments-pagination a:not(.prev):not(.next):hover,
  .colors-custom .logged-in-as a:focus,
  .colors-custom .logged-in-as a:hover,
  .colors-custom a:focus .nav-title,
  .colors-custom a:hover .nav-title,
  .colors-custom .edit-link a:focus,
  .colors-custom .edit-link a:hover,
  .colors-custom .site-info a:focus,
  .colors-custom .site-info a:hover,
  .colors-custom .widget .widget-title a:focus,
  .colors-custom .widget .widget-title a:hover,
  .colors-custom .widget ul li a:focus,
  .colors-custom .widget ul li a:hover {
    -webkit-box-shadow: inset 0 0 0 hsl( ' . $hue . ', ' . $saturation . ', 13% ), 0 3px 0 hsl( ' . $hue . ', ' . $saturation . ', 13% );
    box-shadow: inset 0 0 0 hsl( ' . $hue . ', ' . $saturation . ' , 13% ), 0 3px 0 hsl( ' . $hue . ', ' . $saturation . ', 13% );
  }
  
  body.colors-custom,
  .colors-custom button,
  .colors-custom input,
  .colors-custom select,
  .colors-custom textarea,
  .colors-custom h3,
  .colors-custom h4,
  .colors-custom h6,
  .colors-custom label,
  .colors-custom .entry-title a,
  .colors-custom.twentyseventeen-front-page .panel-content .recent-posts article,
  .colors-custom .entry-footer .cat-links a,
  .colors-custom .entry-footer .tags-links a,
  .colors-custom .format-quote blockquote,
  .colors-custom .nav-title,
  .colors-custom .comment-body,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-current-item .wp-playlist-item-album {
    color: hsl( ' . $hue . ', ' . $reduced_saturation . ', 20% ); /* base: #333; */
  }
  
  .colors-custom .social-navigation a:hover,
  .colors-custom .social-navigation a:focus {
    background: hsl( ' . $hue . ', ' . $reduced_saturation . ', 20% ); /* base: #333; */
  }
  
  .colors-custom input[type="text"]:focus,
  .colors-custom input[type="email"]:focus,
  .colors-custom input[type="url"]:focus,
  .colors-custom input[type="password"]:focus,
  .colors-custom input[type="search"]:focus,
  .colors-custom input[type="number"]:focus,
  .colors-custom input[type="tel"]:focus,
  .colors-custom input[type="range"]:focus,
  .colors-custom input[type="date"]:focus,
  .colors-custom input[type="month"]:focus,
  .colors-custom input[type="week"]:focus,
  .colors-custom input[type="time"]:focus,
  .colors-custom input[type="datetime"]:focus,
  .colors-custom input[type="datetime-local"]:focus,
  .colors-custom input[type="color"]:focus,
  .colors-custom textarea:focus,
  .bypostauthor > .comment-body > .comment-meta > .comment-author .avatar {
    border-color: hsl( ' . $hue . ', ' . $reduced_saturation . ', 20% ); /* base: #333; */
  }
  
  .colors-custom h2,
  .colors-custom blockquote,
  .colors-custom input[type="text"],
  .colors-custom input[type="email"],
  .colors-custom input[type="url"],
  .colors-custom input[type="password"],
  .colors-custom input[type="search"],
  .colors-custom input[type="number"],
  .colors-custom input[type="tel"],
  .colors-custom input[type="range"],
  .colors-custom input[type="date"],
  .colors-custom input[type="month"],
  .colors-custom input[type="week"],
  .colors-custom input[type="time"],
  .colors-custom input[type="datetime"],
  .colors-custom input[type="datetime-local"],
  .colors-custom input[type="color"],
  .colors-custom textarea,
  .colors-custom .site-description,
  .colors-custom .entry-content blockquote.alignleft,
  .colors-custom .entry-content blockquote.alignright,
  .colors-custom .colors-custom .taxonomy-description,
  .colors-custom .site-info a,
  .colors-custom .wp-caption,
  .colors-custom .gallery-caption {
    color: hsl( ' . $hue . ', ' . $saturation . ', 40% ); /* base: #666; */
  }
  
  .colors-custom abbr,
  .colors-custom acronym {
    border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 40% ); /* base: #666; */
  }
  
  .colors-custom h5,
  .colors-custom .entry-meta,
  .colors-custom .entry-meta a,
  .colors-custom.blog .entry-meta a.post-edit-link,
  .colors-custom.archive .entry-meta a.post-edit-link,
  .colors-custom.search .entry-meta a.post-edit-link,
  .colors-custom .nav-subtitle,
  .colors-custom .comment-metadata,
  .colors-custom .comment-metadata a,
  .colors-custom .no-comments,
  .colors-custom .comment-awaiting-moderation,
  .colors-custom .page-numbers.current,
  .colors-custom .page-links .page-number,
  .colors-custom .navigation-top .current-menu-item > a,
  .colors-custom .navigation-top .current_page_item > a,
  .colors-custom .main-navigation a:hover,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-current-item .wp-playlist-item-artist {
    color: hsl( ' . $hue . ', ' . $saturation . ', 46% ); /* base: #767676; */
  }
  
  .colors-custom button:hover,
  .colors-custom button:focus,
  .colors-custom input[type="button"]:hover,
  .colors-custom input[type="button"]:focus,
  .colors-custom input[type="submit"]:hover,
  .colors-custom input[type="submit"]:focus,
  .colors-custom .entry-footer .edit-link a.post-edit-link:hover,
  .colors-custom .entry-footer .edit-link a.post-edit-link:focus,
  .colors-custom .social-navigation a,
  .colors-custom .prev.page-numbers:focus,
  .colors-custom .prev.page-numbers:hover,
  .colors-custom .next.page-numbers:focus,
  .colors-custom .next.page-numbers:hover,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item:hover,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item:focus {
    background: hsl( ' . esc_attr( $hue ) . ', ' . esc_attr( $saturation ) . ', 46% ); /* base: #767676; */
  }
  
  .colors-custom button.secondary:hover,
  .colors-custom button.secondary:focus,
  .colors-custom input[type="reset"]:hover,
  .colors-custom input[type="reset"]:focus,
  .colors-custom input[type="button"].secondary:hover,
  .colors-custom input[type="button"].secondary:focus,
  .colors-custom input[type="reset"].secondary:hover,
  .colors-custom input[type="reset"].secondary:focus,
  .colors-custom input[type="submit"].secondary:hover,
  .colors-custom input[type="submit"].secondary:focus,
  .colors-custom hr {
    background: hsl( ' . $hue . ', ' . $saturation . ', 73% ); /* base: #bbb; */
  }
  
  .colors-custom input[type="text"],
  .colors-custom input[type="email"],
  .colors-custom input[type="url"],
  .colors-custom input[type="password"],
  .colors-custom input[type="search"],
  .colors-custom input[type="number"],
  .colors-custom input[type="tel"],
  .colors-custom input[type="range"],
  .colors-custom input[type="date"],
  .colors-custom input[type="month"],
  .colors-custom input[type="week"],
  .colors-custom input[type="time"],
  .colors-custom input[type="datetime"],
  .colors-custom input[type="datetime-local"],
  .colors-custom input[type="color"],
  .colors-custom textarea,
  .colors-custom select,
  .colors-custom fieldset,
  .colors-custom .widget .tagcloud a:hover,
  .colors-custom .widget .tagcloud a:focus,
  .colors-custom .widget.widget_tag_cloud a:hover,
  .colors-custom .widget.widget_tag_cloud a:focus,
  .colors-custom .wp_widget_tag_cloud a:hover,
  .colors-custom .wp_widget_tag_cloud a:focus {
    border-color: hsl( ' . $hue . ', ' . $saturation . ', 73% ); /* base: #bbb; */
  }
  
  .colors-custom thead th {
    border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 73% ); /* base: #bbb; */
  }
  
  .colors-custom .entry-footer .cat-links .icon,
  .colors-custom .entry-footer .tags-links .icon {
    color: hsl( ' . $hue . ', ' . $saturation . ', 73% ); /* base: #bbb; */
  }
  
  .colors-custom button.secondary,
  .colors-custom input[type="reset"],
  .colors-custom input[type="button"].secondary,
  .colors-custom input[type="reset"].secondary,
  .colors-custom input[type="submit"].secondary,
  .colors-custom .prev.page-numbers,
  .colors-custom .next.page-numbers {
    background-color: hsl( ' . $hue . ', ' . $saturation . ', 87% ); /* base: #ddd; */
  }
  
  .colors-custom .widget .tagcloud a,
  .colors-custom .widget.widget_tag_cloud a,
  .colors-custom .wp_widget_tag_cloud a {
    border-color: hsl( ' . $hue . ', ' . $saturation . ', 87% ); /* base: #ddd; */
  }
  
  .colors-custom.twentyseventeen-front-page article:not(.has-post-thumbnail):not(:first-child),
  .colors-custom .widget ul li {
    border-top-color: hsl( ' . $hue . ', ' . $saturation . ', 87% ); /* base: #ddd; */
  }
  
  .colors-custom .widget ul li {
    border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 87% ); /* base: #ddd; */
  }
  
  .colors-custom pre,
  .colors-custom mark,
  .colors-custom ins {
    background: hsl( ' . $hue . ', ' . $saturation . ', 93% ); /* base: #eee; */
  }
  
  .colors-custom .navigation-top,
  .colors-custom .main-navigation > div > ul,
  .colors-custom .pagination,
  .colors-custom .comments-pagination,
  .colors-custom .entry-footer,
  .colors-custom .site-footer {
    border-top-color: hsl( ' . $hue . ', ' . $saturation . ', 93% ); /* base: #eee; */
  }
  
  .colors-custom .navigation-top,
  .colors-custom .main-navigation li,
  .colors-custom .entry-footer,
  .colors-custom .single-featured-image-header,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item,
  .colors-custom tr {
    border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 93% ); /* base: #eee; */
  }
  
  .colors-custom .site-content .wp-playlist-light {
    border-color: hsl( ' . $hue . ', ' . $saturation . ', 93% ); /* base: #eee; */
  }
  
  .colors-custom .site-header,
  .colors-custom .single-featured-image-header {
    background-color: hsl( ' . $hue . ', ' . $saturation . ', 98% ); /* base: #fafafa; */
  }
  
  .colors-custom button,
  .colors-custom input[type="button"],
  .colors-custom input[type="submit"],
  .colors-custom .entry-footer .edit-link a.post-edit-link,
  .colors-custom .social-navigation a,
  .colors-custom .site-content .wp-playlist-light a.wp-playlist-caption:hover,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item:hover a,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item:focus a,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item:hover,
  .colors-custom .site-content .wp-playlist-light .wp-playlist-item:focus,
  .colors-custom .prev.page-numbers:focus,
  .colors-custom .prev.page-numbers:hover,
  .colors-custom .next.page-numbers:focus,
  .colors-custom .next.page-numbers:hover,
  .colors-custom.has-header-image .site-title,
  .colors-custom.has-header-video .site-title,
  .colors-custom.has-header-image .site-title a,
  .colors-custom.has-header-video .site-title a,
  .colors-custom.has-header-image .site-description,
  .colors-custom.has-header-video .site-description {
    color: hsl( ' . $hue . ', ' . $saturation . ', 100% ); /* base: #fff; */
  }
  
  body.colors-custom,
  .colors-custom .navigation-top,
  .colors-custom .main-navigation ul {
    background: hsl( ' . $hue . ', ' . $saturation . ', 100% ); /* base: #fff; */
  }
  
  .colors-custom .widget ul li a,
  .colors-custom .site-footer .widget-area ul li a {
    -webkit-box-shadow: inset 0 -1px 0 hsl( ' . $hue . ', ' . $saturation . ', 100% ); /* base: rgba(255, 255, 255, 1); */
    box-shadow: inset 0 -1px 0 hsl( ' . $hue . ', ' . $saturation . ', 100% );  /* base: rgba(255, 255, 255, 1); */
  }
  
  .colors-custom .menu-toggle,
  .colors-custom .menu-toggle:hover,
  .colors-custom .menu-toggle:focus,
  .colors-custom .menu .dropdown-toggle,
  .colors-custom .menu-scroll-down,
  .colors-custom .menu-scroll-down:hover,
  .colors-custom .menu-scroll-down:focus {
    background-color: transparent;
  }
  
  .colors-custom .widget .tagcloud a,
  .colors-custom .widget .tagcloud a:focus,
  .colors-custom .widget .tagcloud a:hover,
  .colors-custom .widget.widget_tag_cloud a,
  .colors-custom .widget.widget_tag_cloud a:focus,
  .colors-custom .widget.widget_tag_cloud a:hover,
  .colors-custom .wp_widget_tag_cloud a,
  .colors-custom .wp_widget_tag_cloud a:focus,
  .colors-custom .wp_widget_tag_cloud a:hover,
  .colors-custom .entry-footer .edit-link a.post-edit-link:focus,
  .colors-custom .entry-footer .edit-link a.post-edit-link:hover {
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
  }
  
  /* Reset non-customizable hover styling for links */
  .colors-custom .entry-content a:hover,
  .colors-custom .entry-content a:focus,
  .colors-custom .entry-summary a:hover,
  .colors-custom .entry-summary a:focus,
  .colors-custom .comment-content a:focus,
  .colors-custom .comment-content a:hover,
  .colors-custom .widget a:hover,
  .colors-custom .widget a:focus,
  .colors-custom .site-footer .widget-area a:hover,
  .colors-custom .site-footer .widget-area a:focus,
  .colors-custom .posts-navigation a:hover,
  .colors-custom .posts-navigation a:focus,
  .colors-custom .widget_authors a:hover strong,
  .colors-custom .widget_authors a:focus strong {
    -webkit-box-shadow: inset 0 0 0 rgba(0, 0, 0, 0), 0 3px 0 rgba(0, 0, 0, 1);
    box-shadow: inset 0 0 0 rgba(0, 0, 0, 0), 0 3px 0 rgba(0, 0, 0, 1);
  }
  
  .colors-custom .gallery-item a,
  .colors-custom .gallery-item a:hover,
  .colors-custom .gallery-item a:focus {
    -webkit-box-shadow: none;
    box-shadow: none;
  }
  
  @media screen and (min-width: 48em) {
  
    .colors-custom .nav-links .nav-previous .nav-title .icon,
    .colors-custom .nav-links .nav-next .nav-title .icon {
      color: hsl( ' . $hue . ', ' . $saturation . ', 20% ); /* base: #222; */
    }
  
    .colors-custom .main-navigation li li:hover,
    .colors-custom .main-navigation li li.focus {
      background: hsl( ' . $hue . ', ' . $saturation . ', 46% ); /* base: #767676; */
    }
  
    .colors-custom .navigation-top .menu-scroll-down {
      color: hsl( ' . $hue . ', ' . $saturation . ', 46% ); /* base: #767676; */;
    }
  
    .colors-custom abbr[title] {
      border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 46% ); /* base: #767676; */;
    }
  
    .colors-custom .main-navigation ul ul {
      border-color: hsl( ' . $hue . ', ' . $saturation . ', 73% ); /* base: #bbb; */
      background: hsl( ' . $hue . ', ' . $saturation . ', 100% ); /* base: #fff; */
    }
  
    .colors-custom .main-navigation ul li.menu-item-has-children:before,
    .colors-custom .main-navigation ul li.page_item_has_children:before {
      border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 73% ); /* base: #bbb; */
    }
  
    .colors-custom .main-navigation ul li.menu-item-has-children:after,
    .colors-custom .main-navigation ul li.page_item_has_children:after {
      border-bottom-color: hsl( ' . $hue . ', ' . $saturation . ', 100% ); /* base: #fff; */
    }
  
    .colors-custom .main-navigation li li.focus > a,
    .colors-custom .main-navigation li li:focus > a,
    .colors-custom .main-navigation li li:hover > a,
    .colors-custom .main-navigation li li a:hover,
    .colors-custom .main-navigation li li a:focus,
    .colors-custom .main-navigation li li.current_page_item a:hover,
    .colors-custom .main-navigation li li.current-menu-item a:hover,
    .colors-custom .main-navigation li li.current_page_item a:focus,
    .colors-custom .main-navigation li li.current-menu-item a:focus {
      color: hsl( ' . $hue . ', ' . $saturation . ', 100% ); /* base: #fff; */
    }
  }';
  
    /**
     * Filters Twenty Seventeen custom colors CSS.
     *
     * @since Twenty Seventeen 1.0
     *
     * @param string $css        Base theme colors CSS.
     * @param int    $hue        The user's selected color hue.
     * @param string $saturation Filtered theme color saturation level.
     */
    return apply_filters( 'twentyseventeen_custom_colors_css', $css, $hue, $saturation );
  }




  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
}

