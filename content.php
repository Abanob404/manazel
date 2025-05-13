<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Manazel_Real_Estate_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) : // For single posts/pages
			the_title( 
				'<h1 class="entry-title">',
				'</h1>'
			);
		else : // For archive pages, blog index
			the_title(
				'<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">',
				'</a></h2>'
			);
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				// manazel_theme_posted_on(); // We will define this function later in template-tags.php or functions.php
				// manazel_theme_posted_by(); // We will define this function later
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php //manazel_theme_post_thumbnail(); // We will define this function later ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content(
				 sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'manazel-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'manazel-theme' ),
					'after'  => '</div>',
				)
			);
		} else {
			the_excerpt(); // Display excerpt for archives/blog index
			 echo '<a href="' . esc_url(get_permalink()) . '" class="read-more-link">' . esc_html__('Read More', 'manazel-theme') . '</a>';
		}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php // manazel_theme_entry_footer(); // We will define this function later ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

