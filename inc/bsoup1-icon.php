<?php
/**
 *   File: inc/bsoup1-icon.php
 *
 *   Class: BSoup1_Icon
 *
 *     Functions:
 *
 *       __construct( $version )
 *       include_svg_icons()                                              add_action( 'wp_footer', 'include_svg_icons', 9999 );
 *       get_svg( $args = array() )
 *       nav_menu_social_icons( $item_output, $item, $depth, $args )      add_filter( 'walker_nav_menu_start_el', 'nav_menu_social_icons', 10, 4 );
 *       dropdown_icon_to_menu_link( $title, $item, $args, $depth )       add_filter( 'nav_menu_item_title', 'dropdown_icon_to_menu_link', 10, 4 );
 *       social_links_icons()
 */
class BSoup1_Icon {
  protected $version;             // ATTRIBUTE - VERSION

  /*******************************************************************************************************************/
  public function __construct( $version ) {
    $this->version = $version;
  }
  /*******************************************************************************************************************/
  public function include_svg_icons() {
    // DEFINE SVG SPRITE FILE.
    $svg_icons = get_parent_theme_file_path( '/assets/images/svg-icons.svg' );

    // IF IT EXISTS, INCLUDE IT.
    if ( file_exists( $svg_icons ) ) {
      require_once( $svg_icons );
    }
  }

  /*******************************************************************************************************************/
  public function get_svg( $args = array() ) {
    // MAKE SURE $args ARE AN ARRAY.
    if ( empty( $args ) ) {
      return __( 'Please define default parameters in the form of an array.', 'BSoup1' );
    }
  
    // DEFINE AN ICON.
    if ( false === array_key_exists( 'icon', $args ) ) {
      return __( 'Please define an SVG icon filename.', 'BSoup1' );
    }
    // SET DEFAULTS.
    $defaults = array(
      'icon'        => '',
      'title'       => '',
      'desc'        => '',
      'fallback'    => false,
    );
    // PARSE ARGS.
    $args = wp_parse_args( $args, $defaults );
    // SET ARIA HIDDEN.
    $aria_hidden = ' aria-hidden="true"';
    // SET ARIA.
    $aria_labelledby = '';
    /*
     * BSoup1 doesn't use the SVG title or description attributes;
     * non-decorative icons are described with .screen-reader-text.
     * However, child themes can use the title and description to add
     * information to non-decorative SVG icons to improve accessibility.
     * Example 1 with title:
     *   <?php echo get_svg( array( 'icon' => 'arrow-right', 'title' => 'This is the title' ) ); ?>
     * Example 2 with title and description:
     *   <?php echo get_svg( array( 'icon' => 'arrow-right', 'title' => 'This is the title', 'desc' => 'This is the description' ) ); ?>
     * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
     */
    if ( $args['title'] ) {
      $aria_hidden     = '';
      $unique_id       = uniqid();
      $aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';
      if ( $args['desc'] ) {
        $aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
      }
    }
    // BEGIN SVG MARKUP.
    $svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
    // DISPLAY THE TITLE.
    if ( $args['title'] ) {
      $svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';
      // DISPLAY THE DESC ONLY IF THE TITLE IS ALREADY SET.
      if ( $args['desc'] ) {
        $svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
      }
    }
    /* DISPLAY THE ICON.
     * THE WHITESPACE AROUND '<use>' IS INTENTIONAL
     * IT IS A WORK AROUND TO A KEYBOARD NAVIGATION BUG IN Safari 10.
     * See https://core.trac.wordpress.org/ticket/38387.
     */
    $svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';
    // ADD SOME MARKUP TO USE AS A FALLBACK FOR BROWSERS THAT DO NOT SUPPORT SVGs.
    if ( $args['fallback'] ) {
      $svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
    }
    $svg .= '</svg>';
    return $svg;
  }

  /*******************************************************************************************************************/
  public function nav_menu_social_icons( $item_output, $item, $depth, $args ) {
    // Get supported social icons.
    $social_icons = $this->social_links_icons();
  
    // Change SVG icon inside social links menu if there is supported URL.
    if ( 'social' === $args->theme_location ) {
      foreach ( $social_icons as $attr => $value ) {
        if ( false !== strpos( $item_output, $attr ) ) {
          $item_output = str_replace( $args->link_after, '</span>' . $this->get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
        }
      }
    }
    return $item_output;
  }
  

  /*******************************************************************************************************************/
  public function dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
    if ( 'top' === $args->theme_location ) {
      foreach ( $item->classes as $value ) {
        if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
          $title = $title . $this->get_svg( array( 'icon' => 'angle-down' ) );
        }
      }
    }
  
    return $title;
  }

  /*******************************************************************************************************************/
  public function social_links_icons() {
    // Supported social links icons.
    $social_links_icons = array(
      'behance.net'     => 'behance',
      'codepen.io'      => 'codepen',
      'deviantart.com'  => 'deviantart',
      'digg.com'        => 'digg',
      'docker.com'      => 'dockerhub',
      'dribbble.com'    => 'dribbble',
      'dropbox.com'     => 'dropbox',
      'facebook.com'    => 'facebook',
      'flickr.com'      => 'flickr',
      'foursquare.com'  => 'foursquare',
      'plus.google.com' => 'google-plus',
      'github.com'      => 'github',
      'instagram.com'   => 'instagram',
      'linkedin.com'    => 'linkedin',
      'mailto:'         => 'envelope-o',
      'medium.com'      => 'medium',
      'pinterest.com'   => 'pinterest-p',
      'pscp.tv'         => 'periscope',
      'getpocket.com'   => 'get-pocket',
      'reddit.com'      => 'reddit-alien',
      'skype.com'       => 'skype',
      'skype:'          => 'skype',
      'slideshare.net'  => 'slideshare',
      'snapchat.com'    => 'snapchat-ghost',
      'soundcloud.com'  => 'soundcloud',
      'spotify.com'     => 'spotify',
      'stumbleupon.com' => 'stumbleupon',
      'tumblr.com'      => 'tumblr',
      'twitch.tv'       => 'twitch',
      'twitter.com'     => 'twitter',
      'vimeo.com'       => 'vimeo',
      'vine.co'         => 'vine',
      'vk.com'          => 'vk',
      'wordpress.org'   => 'wordpress',
      'wordpress.com'   => 'wordpress',
      'yelp.com'        => 'yelp',
      'youtube.com'     => 'youtube',
    );
    return apply_filters( 'bsoup1_social_links_icons', $social_links_icons );
  }

  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
  /*******************************************************************************************************************/
}

