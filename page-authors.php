<?php
/**
 * Template Name: Authors
 *
 * The Authors page template is for listing the authors of your site.  It shows each author's 
 * biographical information and avatar while linking the author's archive page.
 * @link http://themehybrid.com/themes/hybrid/page-templates/authors
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

					<?php foreach ( get_users_of_blog() as $author ) : ?>

						<?php $user = new WP_User( $author->ID ); ?>

						<?php if ( $user->has_cap( 'publish_posts' ) || $user->has_cap( 'edit_posts' ) || $user->has_cap( 'publish_pages' ) || $user->has_cap( 'edit_pages' ) ) : ?>

							<div id="hcard-<?php echo str_replace( ' ', '-', get_the_author_meta( 'user_nicename', $author->ID ) ); ?>" class="author-profile vcard clear">

								<a href="<?php echo get_author_posts_url( $author->ID ); ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>">
									<?php echo get_avatar( get_the_author_meta( 'user_email', $author->ID ), '100', '', get_the_author_meta( 'display_name', $author->ID ) ); ?>
								</a>
								<h2 class="author-name fn n">
									<a href="<?php echo get_author_posts_url( $author->ID ); ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php the_author_meta( 'display_name', $author->ID ); ?></a>
								</h2>
								<p class="author-bio">
									<?php the_author_meta( 'description', $author->ID ); ?>
								</p><!-- .author-bio -->

							</div><!-- .author-profile .vcard -->

						<?php endif; ?>

					<?php endforeach; ?>

					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', 'hybrid' ), 'after' => '</p>' ) ); ?>

				</div><!-- .entry-content -->

				<?php hybrid_after_entry(); // After entry hook ?>

			</div><!-- .hentry -->

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