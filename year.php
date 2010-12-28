<?php
/**
 * Year Template
 *
 * This template is used when a yearly archive is shown.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // Before content hook ?>

		<div class="archive-info date-info year-info">
			<h1 class="archive-title date-title year-title"><?php the_time( __( 'Y', hybrid_get_textdomain() ) ); ?></h1>

			<div class="archive-description date-description year-description">
				<p>
				<?php printf( __( 'You are browsing the archive for %1$s.', hybrid_get_textdomain() ), get_the_time( __( 'Y', hybrid_get_textdomain() ) ) ); ?>
				</p>
			</div><!-- .date-description .year-description -->

		</div><!-- .date-info .year-info -->

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php get_the_image( array( 'custom_key' => array( 'Thumbnail' ), 'size' => 'thumbnail' ) ); ?>

				<?php do_atomic( 'before_entry' ); // Before entry hook ?>

				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->

				<?php do_atomic( 'after_entry' ); // After entry hook ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

		<?php else: ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', hybrid_get_textdomain() ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>