<?php
/**
 * Singular Template
 *
 * WordPress currently supports custom post types at the database level, but it's still lacking
 * some major functionality in other places.  This template is in preparation for the future, at which
 * time I hope that full support of custom post types is a part of the platform.  Until then, this should
 * serve as a placeholder.  Ideally, each post type (on a singular view) would be represented by a
 * template hierarchy like so: $post_type-$template.php, $post_type-$slug.php, $post_type-$id.php, 
 * $post_type.php, and singular.php.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php hybrid_before_entry(); // Before entry hook ?>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<p class="pages">' . __( 'Pages:', 'hybrid' ), 'after' => '</p>' ) ); ?>
				</div><!-- .entry-content -->

				<?php hybrid_after_entry(); // After entry hook ?>

			</div><!-- .hentry -->

			<?php hybrid_after_singular(); // After singular hook ?>

			<?php comments_template( '/comments.php', true ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p class="no-data">
				<?php _e( 'Sorry, no posts matched your criteria.', 'hybrid' ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>