<?php
/**
 * Template Name: Biography
 *
 * A page template for listing the page author's avatar, biographical info, and other links set in their profile.
 * Should make it easy to create an about page or biography for single-author blogs.
 *
 * @package Hybrid
 * @subpackage Template
 * @link http://themehybrid.com/themes/hybrid/page-templates/biography
 * @deprecated 0.9.0 This template will eventually be moved to the Hybrid page templates pack.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>

				<div class="entry-content">

					<div id="hcard-<?php the_author_meta( 'user_nicename' ); ?>" class="author-profile vcard">

						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author_meta( 'display_name' ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '100', '', get_the_author_meta( 'display_name' ) ); ?>
						</a>

						<p class="author-bio">
							<?php the_author_meta( 'description' ); ?>
						</p><!-- .author-bio -->

						<ul class="xoxo clear">

						<?php if ( get_the_author_meta( 'nickname' ) ) : ?>
							<li><strong><?php _e( 'Nickname:', 'hybrid' ); ?></strong> <span class="nickname"><?php the_author_meta( 'nickname' ); ?></span></li>
						<?php endif; ?>

						<?php if ( get_the_author_meta( 'user_url' ) ) : ?>
							<li><strong><?php _e( 'Website:', 'hybrid' ); ?></strong> <a class="url" href="<?php the_author_meta( 'user_url' ); ?>" title="<?php the_author_meta( 'user_url' ); ?>"><?php the_author_meta( 'user_url' ); ?></a></li>
						<?php endif; ?>

						<?php if ( get_the_author_meta( 'aim' ) ) : ?>
							<li><strong><?php _e( 'AIM:', 'hybrid' ); ?></strong> <a class="url" href="aim:goim?screenname=<?php the_author_meta( 'aim' ); ?>" title="<?php printf( __( 'IM with %1$s', 'hybrid' ), get_the_author_meta( 'aim' ) ); ?>"><?php the_author_meta( 'aim' ); ?></a></li>
						<?php endif; ?>

						<?php if ( get_the_author_meta( 'jabber' ) ) : ?>
							<li><strong><?php _e( 'Jabber:', 'hybrid' ); ?></strong> <a class="url" href="xmpp:<?php the_author_meta( 'jabber' ); ?>@jabberservice.com" title="<?php printf( __( 'IM with %1$s', 'hybrid' ), get_the_author_meta( 'jabber' ) ); ?>"><?php the_author_meta( 'jabber' ); ?></a></li>
						<?php endif; ?>

						<?php if ( get_the_author_meta( 'yim' ) ) : ?>
							<li><strong><?php _e( 'Yahoo:', 'hybrid' ); ?></strong> <a class="url" href="ymsgr:sendIM?<?php the_author_meta( 'yim' ); ?>" title="<?php printf( __( 'IM with %1$s', 'hybrid' ), get_the_author_meta( 'yim' ) ); ?>"><?php the_author_meta( 'yim' ); ?></a></li>
						<?php endif; ?>

						</ul><!-- .xoxo -->

					</div><!-- .author-profile .vcard -->

					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', 'hybrid' ), 'after' => '</p>' ) ); ?>

				</div><!-- .entry-content -->

				<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

			</div><!-- .hentry -->

			<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>

			<?php comments_template( '/comments.php', true ); // Loads the comments.php template ?>

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); // Loads the footer.php template. ?>