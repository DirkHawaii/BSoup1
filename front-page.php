<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will appear.
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php // Show the selected frontpage content.
    if ( have_posts() ) :
      while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/page/content', 'front-page' );
      endwhile;
    else :
      get_template_part( 'template-parts/post/content', 'none' );
    endif; ?>

    <?php
    // Get each of our panels and show the post data.
    if ( 0 !== $tobj1->panel_count() || is_customize_preview() ) : // If we have pages to show.

      /**
       * Filter number of front page sections in BSoup1.
       */
      $num_sections = apply_filters( 'bsoup1_front_page_sections', 4 );
      global $bsoup1counter;

      // Create a setting and control for each of the sections available in the theme.
      for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
        $bsoup1counter = $i;
        $tobj1->front_page_section( null, $i );
      }

  endif; // The if ( 0 !== bsoup1_panel_count() ) ends here. ?>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
