<?php
/**
 * Week Template
 *
 * This template is used when a weekly archive is shown.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<div class="archive-info date-info week-info">

			<h1 class="archive-title date-title week-title"><?php printf( __( 'Week %1$s of %2$s', 'hybrid' ), get_the_time( __( 'W', 'hybrid' ) ), get_the_time( __( 'Y', 'hybrid' ) ) ); ?></h1>

			<div class="archive-description date-description week-description">
				<p>
				<?php printf( __( 'You are browsing the archive for week %1$s of %2$s.', 'hybrid' ), get_the_time( __( 'W', 'hybrid' ) ), get_the_time( __( 'Y', 'hybrid' ) ) ); ?>
				</p>
			</div><!-- .date-description .week-description -->

		</div><!-- .date-info .week-info -->

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php get_the_image( array( 'custom_key' => array( 'Thumbnail' ), 'size' => 'thumbnail' ) ); ?>

				<?php hybrid_before_entry(); // Before entry hook ?>

				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->

				<?php hybrid_after_entry(); // After entry hook ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

		<?php else: ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', 'hybrid' ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>