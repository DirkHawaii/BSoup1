<?php
/**
 *   Class: BSoup1_Customizer
 *
 *     Functions:
 *
 *       customize_register( $wp_customize )  add_action( 'customize_register', 'customize_register' );
 *       sanitize_page_layout( $input )
 *       sanitize_colorscheme( $input )
 *       customize_partial_blogname()
 *       customize_partial_blogdescription()
 *       is_static_front_page()
 *       is_view_with_layout_option()
 *       customize_preview_js()               add_action( 'customize_preview_init', 'customize_preview_js' );
 *       panels_js()                          add_action( 'customize_controls_enqueue_scripts', 'panels_js' );
 */
class BSoup1_Customizer {
  protected $version;    // ATTRIBUTE - VERSION
  protected $template;   // ATTRIBUTE - TEMPLATE

  public function __construct( $version ) {
    $this->version = $version;
  }
  public function set_template_obj( $template ) {
    $this->template = $template;
  
  }
  /************************************************************************************************************/
  public function customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
  
    $wp_customize->selective_refresh->add_partial( 'blogname', array(
      'selector' => '.site-title a',
      'render_callback' => array( $this, 'customize_partial_blogname' ),
    ) );
    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
      'selector' => '.site-description',
      'render_callback' => array( $this, 'customize_partial_blogdescription' ),
    ) );
  
    /**
     * Custom colors.
     */
    $wp_customize->add_setting( 'colorscheme', array(
      'default'           => 'light',
      'transport'         => 'postMessage',
      'sanitize_callback' => array( $this, 'sanitize_colorscheme' ),
    ) );
  
    $wp_customize->add_setting( 'colorscheme_hue', array(
      'default'           => 250,
      'transport'         => 'postMessage',
      'sanitize_callback' => 'absint', // The hue is stored as a positive integer.
    ) );
  
    $wp_customize->add_control( 'colorscheme', array(
      'type'    => 'radio',
      'label'    => __( 'Color Scheme', 'bsoup1' ),
      'choices'  => array(
        'light'  => __( 'Light', 'bsoup1' ),
        'dark'   => __( 'Dark', 'bsoup1' ),
        'custom' => __( 'Custom', 'bsoup1' ),
      ),
      'section'  => 'colors',
      'priority' => 5,
    ) );
  
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colorscheme_hue', array(
      'mode' => 'hue',
      'section'  => 'colors',
      'priority' => 6,
    ) ) );

    /************************************************************************************************************************************
     * Front Page Sections.
     ************************************************************************************************************************************/
    $wp_customize->add_section( 'fp_sections', array( 'title' => __( 'FP Sections', 'bsoup1' ), 'priority' => 130, ) );
    $wp_customize->add_setting( 'num_sections', array( 'default' => 4, 'sanitize_callback' => 'absint', 'transport' => 'postMessage', ) );

    $wp_customize->add_control( 'num_sections', array(
        'label'       => __( 'Num Section', 'bsoup1' ),
        'section'     => 'fp_sections',
        'type'        => 'select',
        'description' => __( 'Enter number of front page sections.', 'bsoup1' ),
        'choices'     => array( 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 10 => '10', 11 => '11', 12 => '12', 13 => '13', 14 => '14', ),
        'active_callback' => array( $this, 'is_view_with_layout_option' ),
    ) );

  
    /***   THEME OPTIONS.   ***/
    $wp_customize->add_section( 'theme_options', array(
      'title'    => __( 'Theme Options', 'bsoup1' ),
      'priority' => 130, // Before Additional CSS.
    ) );
  
    $wp_customize->add_setting( 'page_layout', array(
      'default'           => 'two-column',
      'sanitize_callback' => array( $this, 'sanitize_page_layout' ),
      'transport'         => 'postMessage',
    ) );
  
    $wp_customize->add_control( 'page_layout', array(
      'label'       => __( 'Page Layout', 'bsoup1' ),
      'section'     => 'theme_options',
      'type'        => 'radio',
      'description' => __( 'When the two-column layout is assigned, the page title is in one column and content is in the other.', 'bsoup1' ),
      'choices'     => array(
        'one-column' => __( 'One Column', 'bsoup1' ),
        'two-column' => __( 'Two Column', 'bsoup1' ),
      ),
      'active_callback' => array( $this, 'is_view_with_layout_option' ),
    ) );
  
    /**
     * Filter number of front page sections in Twenty Seventeen.
     */
    //$num_sections = apply_filters( 'bsoup1_front_page_sections', 4 );
    $num_sections = get_theme_mod( 'num_sections' );
  
    // Create a setting and control for each of the sections available in the theme.
    for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
      $wp_customize->add_setting( 'panel_' . $i, array(
        'default'           => false,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
      ) );
  
      $wp_customize->add_control( 'panel_' . $i, array(
        /* translators: %d is the front page section number */
        'label'          => sprintf( __( 'Front Page Section %d Content', 'bsoup1' ), $i ),
        'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'bsoup1' ) ),
        'section'        => 'theme_options',
        'type'           => 'dropdown-pages',
        'allow_addition' => true,
        'active_callback' => array( $this, 'is_static_front_page' ),
      ) );
  
      $wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
        'selector'            => '#panel' . $i,
        'render_callback'     => array( $this-template, 'front_page_section' ),
        'container_inclusive' => true,
      ) );
    }
  }
  /************************************************************************************************************/
  public function sanitize_page_layout( $input ) {
    $valid = array(
      'one-column' => __( 'One Column', 'bsoup1' ),
      'two-column' => __( 'Two Column', 'bsoup1' ),
    );
    if ( array_key_exists( $input, $valid ) ) {
      return $input;
    }
    return '';
  }
  /************************************************************************************************************/
  public function sanitize_colorscheme( $input ) {
    $valid = array( 'light', 'dark', 'custom' );
    if ( in_array( $input, $valid, true ) ) {
      return $input;
    }
    return 'light';
  }
  /************************************************************************************************************/
  public function customize_partial_blogname() {
    bloginfo( 'name' );
  }
  /************************************************************************************************************/
  public function customize_partial_blogdescription() {
    bloginfo( 'description' );
  }
  /************************************************************************************************************/
  public function is_static_front_page() {
    return ( is_front_page() && ! is_home() );
  }
  /************************************************************************************************************/
  public function is_view_with_layout_option() {
    return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
  }
  /************************************************************************************************************/
  public function customize_preview_js() {
    wp_enqueue_script( 'bsoup1-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
  }
  /************************************************************************************************************/
  public function panels_js() {
    wp_enqueue_script( 'bsoup1-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
  }










}

