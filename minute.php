<?php
/**
 * Minute Template
 *
 * This template is used when a minutely archive is shown.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<div class="archive-info date-info time-info">
			<h1 class="archive-title date-title time-title"><?php echo ( get_query_var( 'hour' ) ) ? get_the_time( __( 'g:i a', 'hybrid' ) ) : sprintf( __( 'Minute %1$s', 'hybrid' ), get_the_time( __( 'i', 'hybrid' ) ) ); ?></h1>

			<div class="archive-description date-description time-description">
				<p>
				<?php if ( get_query_var( 'hour' ) ) : ?>
					<?php printf( __( 'You are browsing the archive for %1$s.', 'hybrid' ), get_the_time( __( 'g:i a', 'hybrid' ) ) ); ?>
				<?php else : ?>
					<?php printf( __( 'You are browsing the archive for minute %1$s.', 'hybrid' ), get_the_time( __( 'i', 'hybrid' ) ) ); ?>
				<?php endif; ?>
				</p>
			</div><!-- .archive-description -->

		</div><!-- .archive-info -->

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