<?php
/**
 * Template Name: Logged In
 *
 * The Logged In template is a page template that allows only logged-in users to view the content
 * of the page and its comments. If the user isn't logged in, a message to log in with a link to the 
 * WordPress login page will be displayed. If the site has open registration, a link to register will
 * also be displayed.
 * @link http://themehybrid.com/themes/hybrid/page-templates/logged-in
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<?php if ( have_posts() && is_user_logged_in() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php hybrid_before_entry(); // Before entry hook ?>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', 'hybrid' ), 'after' => '</p>' ) ); ?>
				</div><!-- .entry-content -->

				<?php hybrid_after_entry(); // After entry hook ?>

			</div><!-- .hentry -->

			<?php hybrid_after_singular(); // After singular hook ?>

			<?php comments_template( '/comments.php', true ); ?>

			<?php endwhile; ?>

		<?php elseif ( have_posts() && !is_user_logged_in() ) : // If user is not logged in ?>

			<div id="post-0" class="<?php hybrid_entry_class(); ?>">

				<?php hybrid_before_entry(); // Before entry hook ?>

				<div class="entry-content">

					<p class="alert">
						<?php printf( __( 'You must be <a href="%1$s" title="Log in">logged in</a> to view the content of this page.', 'hybrid' ), wp_login_url( get_permalink() ) ); ?>

						<?php if ( get_option( 'users_can_register' ) ) printf( __( 'If you\'re not currently a member, please take a moment to <a href="%1$s" title="Register">register</a>.', 'hybrid' ), site_url( 'wp-login.php?action=register', 'login' ) ); ?>
					</p><!-- .alert -->

				</div><!-- .entry-content -->

				<?php hybrid_after_entry(); // After entry hook ?>

			</div><!-- #post-0 .hentry -->

			<?php hybrid_after_singular(); // After singular hook ?>

		<?php else: ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', 'hybrid' ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>