<?php
/**
 * Template part for displaying posts
 */

$tobj1=$GLOBALS['tobj1'];

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
  if ( is_sticky() && is_home() ) :
    echo $tobj1->get_svg( array( 'icon' => 'thumb-tack' ) );
  endif;
  ?>
  <header class="entry-header">
    <?php
    if ( 'post' === get_post_type() ) {
      echo '<div class="entry-meta">';
        if ( is_single() ) {
          $tobj1->posted_on();
        } else {
          echo $tobj1->time_link();
          $tobj1->edit_link();
        };
      echo '</div><!-- .entry-meta -->';
    };

    if ( is_single() ) {
      the_title( '<h1 class="entry-title">', '</h1>' );
    } elseif ( is_front_page() && is_home() ) {
      the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
    } else {
      the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    }
    ?>
  </header><!-- .entry-header -->

  <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
    <div class="post-thumbnail">
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail( 'bsoup1-featured-image' ); ?>
      </a>
    </div><!-- .post-thumbnail -->
  <?php endif; ?>

  <div class="entry-content">
    <?php
    /* translators: %s: Name of current post */
    the_content( sprintf(
      __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bsoup1' ),
      get_the_title()
    ) );

    wp_link_pages( array(
      'before'      => '<div class="page-links">' . __( 'Pages:', 'bsoup1' ),
      'after'       => '</div>',
      'link_before' => '<span class="page-number">',
      'link_after'  => '</span>',
    ) );
    ?>
  </div><!-- .entry-content -->

  <?php
  if ( is_single() ) {
    $tobj1->entry_footer();
  }
  ?>

</article><!-- #post-## -->