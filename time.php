<?php
/**
 * Time Template
 *
 * This template is used when a time-based archive is shown.  This file is more or 
 * less a placeholder. It will only show archives if not handled by hour.php or minute.php.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<div class="archive-info time-info">
			<h1 class="archive-title date-title time-title"><?php the_time(); ?></h1>

			<div class="archive-description date-description time-description">
				<p>
				<?php printf( __( 'You are browsing the archive for %1$s.', 'hybrid' ), get_the_time() ); ?>
				</p>
			</div><!-- .date-description .time-description -->

		</div><!-- .archive-info .time-info -->

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