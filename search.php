<?php
/**
 * Search Template
 *
 * The search template is loaded when a visitor uses the search form to search for something
 * on the site.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail' ) ); ?>

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>

				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->

				<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); // Loads the footer.php template. ?>