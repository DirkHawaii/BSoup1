<?php
/**
 * Template part for displaying page content in page.php
 */
$tobj1=$GLOBALS['tobj1'];

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php $tobj1->edit_link( get_the_ID() ); ?>
  </header><!-- .entry-header -->
  <div class="entry-content">
    <?php
      the_content();

      wp_link_pages( array(
        'before' => '<div class="page-links">' . __( 'Pages:', 'bsoup1' ),
        'after'  => '</div>',
      ) );
    ?>
  </div><!-- .entry-content -->
</article><!-- #post-## -->
