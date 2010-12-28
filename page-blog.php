<?php
/**
 * Template Name: Blog
 *
 * If you want to set up an alternate blog page, just use this template for your page.
 * This template shows your latest posts.
 * @link http://themehybrid.com/themes/hybrid/page-templates/blog
 *
 * @package Hybrid
 * @subpackage Template
 * @deprecated 0.9.0 Users should no longer be using this template. 'home.php' is used to show posts.
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // Before content hook ?>

		<?php
			$wp_query = new WP_Query();
			$wp_query->query( array( 'posts_per_page' => get_option( 'posts_per_page' ), 'paged' => $paged ) );
			$more = 0;
		?>

		<?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // Before entry hook ?>

				<div class="entry-content">
					<?php the_content( sprintf( __( 'Continue reading %1$s', hybrid_get_textdomain() ), the_title( ' "', '"', false ) ) ); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', hybrid_get_textdomain() ), 'after' => '</p>' ) ); ?>
				</div><!-- .entry-content -->

				<?php do_atomic( 'after_entry' ); // After entry hook ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

			<?php do_atomic( 'after_singular' ); // After singular hook ?>

		<?php else: ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', hybrid_get_textdomain() ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>