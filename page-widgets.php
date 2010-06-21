<?php
/**
 * Template Name: Widgets
 *
 * The Widgets template is a page template that is completely widgetized. It houses the 
 * 'Widgets Template' widget area. Customizations to this page should be done through widgets.
 * @link http://themehybrid.com/themes/hybrid/page-templates/widgets
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<?php dynamic_sidebar( 'utility-widgets-template' ); ?>

		<?php wp_reset_query(); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php edit_post_link( __( 'Edit', 'hybrid' ), '<p class="entry-meta"><span class="edit">', '</span></p>' ); ?>

			<?php hybrid_after_singular(); // After singular hook ?>

			<?php comments_template( '/comments.php', true ); ?>

			<?php endwhile; ?>

		<?php else: ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', 'hybrid' ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>