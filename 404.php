<?php
/**
 * 404 Template
 *
 * The 404 template is used when a reader visits an invalid URL on your site. By default,
 * the template will display a generic message. However, if the '404 Template' widget area
 * is active, its widgets will be displayed instead. This allows users to customize their error
 * pages in any way they want.
 *
 * For more information on how WordPress handles 404 errors:
 * @link http://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Hybrid
 * @subpackage Template
 */

@header( 'HTTP/1.1 404 Not found', true, 404 );

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<?php if ( is_active_sidebar( 'utility-404' ) ) : ?>

			<div id="utility-404" class="sidebar utility">
				<?php dynamic_sidebar( 'utility-404' ); ?>
			</div><!-- #utility-404 .utility -->

		<?php else: ?>

			<div id="post-0" class="<?php hybrid_entry_class(); ?>">

				<h1 class="error-404-title entry-title"><?php _e( 'Not Found', 'hybrid' ); ?></h1>

				<div class="entry-content">

					<p>
					<?php printf( __( 'You tried going to %1$s, and it doesn\'t exist. All is not lost! You can search for what you\'re looking for.', 'hybrid' ), '<code>' . site_url( esc_url( $_SERVER['REQUEST_URI'] ) ) . '</code>' ); ?>
					</p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->

			</div><!-- .hentry -->

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>