<?php
/**
 *   File: inc/bsoup1-widgets.php
 *
 *   Class: BSoup1_Widgets
 *
 *     Functions:
 *
 *       init()
 *
 */
class BSoup1_Widgets {
  protected $version;             // ATTRIBUTE - VERSION

  public function __construct( $version ) {
    $this->version = $version;
  }

  public function init() {
    register_sidebar( array(
      'name'          => __( 'Blog Sidebar', 'BSoup1' ),
      'id'            => 'sidebar-1',
      'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
      'name'          => __( 'Footer 1', 'BSoup1' ),
      'id'            => 'sidebar-2',
      'description'   => __( 'Add widgets here to appear in your footer.', 'BSoup1' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
      'name'          => __( 'Footer 2', 'BSoup1' ),
      'id'            => 'sidebar-3',
      'description'   => __( 'Add widgets here to appear in your footer.', 'BSoup1' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
  }

}

