<?php
/**
 *   File: inc/bsoup1-template.php
 *
 *   Class: BSoup1_Template
 *
 *     Functions:
 *
 *       init()
 *       posted_on()
 *       time_link()
 *       entry_footer()
 *       edit_link()
 *       front_page_section( $partial = null, $id = 0 )
 *       categorized_blog()
 *       category_transient_flusher()                         add_action( 'edit_category', 'category_transient_flusher' )
 *                                                            add_action( 'save_post',     'category_transient_flusher' )
 *
 *       body_classes( $classes )                             add_filter( 'body_class',    'body_classes' )
 *       panel_count()
 *       is_frontpage()
 *
 */
class BSoup1_Template {
  protected $icon_obj;  // ATTRIBUTE - ICON OBJECT
  protected $customizer;

  /***********************************************************************************************/
  public function __construct( $icon_obj, $customizer ) {
    $this->icon_obj = $icon_obj;
    $this->customizer = $customizer;
  }
  /***********************************************************************************************/
  public function posted_on() {
    // GET THE AUTHOR NAME; WRAP IT IN A LINK.
    $byline = sprintf(
      /* translators: %s: post author */
      __( 'by %s', 'bsoup1' ),
      '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
    );
    // FINALLY, WRITE ALL OF THIS TO THE PAGE.
    echo '<span class="posted-on">' . $this->time_link() . '</span><span class="byline"> ' . $byline . '</span>';
  }
  /***********************************************************************************************/
  public function time_link() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
      $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }
  
    $time_string = sprintf( $time_string,
      get_the_date( DATE_W3C ),
      get_the_date(),
      get_the_modified_date( DATE_W3C ),
      get_the_modified_date()
    );
  
    // Wrap the time string in a link, and preface it with 'Posted on'.
    return sprintf(
      /* translators: %s: post date */
      __( '<span class="screen-reader-text">Posted on</span> %s', 'bsoup1' ),
      '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );
  }
  /***********************************************************************************************/
  public function entry_footer() {
  
    /* translators: used between list items, there is a space after the comma */
    $separate_meta = __( ', ', 'bsoup1' );
  
    // Get Categories for posts.
    $categories_list = get_the_category_list( $separate_meta );
  
    // Get Tags for posts.
    $tags_list = get_the_tag_list( '', $separate_meta );
  
    // We don't want to output .entry-footer if it will be empty, so make sure its not.
    if ( ( ( $this->categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {
  
      echo '<footer class="entry-footer">';
  
        if ( 'post' === get_post_type() ) {
          if ( ( $categories_list && $this->categorized_blog() ) || $tags_list ) {
            echo '<span class="cat-tags-links">';
  
              // Make sure there's more than one category before displaying.
              if ( $categories_list && $this->categorized_blog() ) {
                echo '<span class="cat-links">' . $this->icon_obj->get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Categories', 'twentyseventeen' ) . '</span>' . $categories_list . '</span>';
              }
  
              if ( $tags_list && ! is_wp_error( $tags_list ) ) {
                echo '<span class="tags-links">' . $this->icon_obj->get_svg( array( 'icon' => 'hashtag' ) ) . '<span class="screen-reader-text">' . __( 'Tags', 'twentyseventeen' ) . '</span>' . $tags_list . '</span>';
              }
  
            echo '</span>';
          }
        }
  
        $this->edit_link();
  
      echo '</footer> <!-- .entry-footer -->';
    }
  }
  /***********************************************************************************************/
  public function edit_link() {
    edit_post_link(
      sprintf(
        /* translators: %s: Name of current post */
        __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'bsoup1' ),
        get_the_title()
      ),
      '<span class="edit-link">',
      '</span>'
    );
  }
  
  /***********************************************************************************************/
  public function front_page_section( $partial = null, $id = 0 ) {
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
      echo '<article class="panel-placeholder panel bsoup1-panel' . $id . '" id="panel' . $id . '"><span class="bsoup1-panel-title">' . sprintf( __( 'Front Page Section %1$s Placeholder', 'bsoup1' ), $id ) . '</span></article>';
    }
  }
  /***********************************************************************************************/
  public function categorized_blog() {
    $category_count = get_transient( 'bsoup1_categories' );
  
    if ( false === $category_count ) {
      // CREATE AN ARRAY OF ALL THE CATEGORIES THAT ARE ATTACHED TO POSTS.
      $categories = get_categories( array(
        'fields'     => 'ids',
        'hide_empty' => 1,
        // WE ONLY NEED TO KNOW IF THERE IS MORE THAN ONE CATEGORY.
        'number'     => 2,
      ) );
      // COUNT THE NUMBER OF CATEGORIES THAT ARE ATTACHED TO THE POSTS.
      $category_count = count( $categories );
  
      set_transient( 'bsoup1_categories', $category_count );
    }
    // ALLOW VIEWING CASE OF 0 OR 1 CATEGORIES IN POST PREVIEW.
    if ( is_preview() ) {
      return true;
    }
    return $category_count > 1;
  }

  /***********************************************************************************************/
  public function category_transient_flusher() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }
    delete_transient( 'bsoup1_categories' );
  }
  /***********************************************************************************************/
  /***********************************************************************************************/
  public function body_classes( $classes ) {
    // Add class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
      $classes[] = 'group-blog';
    }
  
    // Add class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
      $classes[] = 'hfeed';
    }
  
    // Add class if we're viewing the Customizer for easier styling of theme options.
    if ( is_customize_preview() ) {
      $classes[] = 'bsoup1-customizer';
    }
  
    // Add class on front page.
    if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
      $classes[] = 'bsoup1-front-page';
    }
  
    // Add a class if there is a custom header.
    if ( has_header_image() ) {
      $classes[] = 'has-header-image';
    }
  
    // Add class if sidebar is used.
    if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
      $classes[] = 'has-sidebar';
    }
  
    // Add class for one or two column page layouts.
    if ( is_page() || is_archive() ) {
      if ( 'one-column' === get_theme_mod( 'page_layout' ) ) {
        $classes[] = 'page-one-column';
      } else {
        $classes[] = 'page-two-column';
      }
    }
  
    // Add class if the site title and tagline is hidden.
    if ( 'blank' === get_header_textcolor() ) {
      $classes[] = 'title-tagline-hidden';
    }
  
    // Get the colorscheme or the default if there isn't one.
    $colors = $this->customizer->sanitize_colorscheme( get_theme_mod( 'colorscheme', 'light' ) );
    $classes[] = 'colors-' . $colors;
  
    return $classes;
  }


  /***********************************************************************************************/
  public function panel_count() {
    $panel_count = 0;
    $num_sections = apply_filters( 'bsoup1_front_page_sections', 4 );
    // Create a setting and control for each of the sections available in the theme.
    for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
      if ( get_theme_mod( 'panel_' . $i ) ) {
        $panel_count++;
      }
    }
    return $panel_count;
  }

  /***********************************************************************************************/
  public function is_frontpage() {
    return ( is_front_page() && ! is_home() );
  }
  /***********************************************************************************************/
}


