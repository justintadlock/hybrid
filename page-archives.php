<?php
/**
 * Template Name: Archives
 *
 * This will list your categories and monthly archives by default.  Alternatively, you can activate 
 * an archives plugin.
 *
 * @package Hybrid
 * @subpackage Template
 * @deprecated 0.9.0 Template will be renamed page-template-archives.php to comply with theme repo guidelines.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>

				<div class="entry-content">

					<?php the_content(); ?>

					<?php if ( function_exists( 'smartArchives' ) ) : smartArchives( 'both', '' ); ?>

					<?php elseif ( function_exists( 'wp_smart_archives' ) ) : wp_smart_archives(); ?>

					<?php elseif ( function_exists( 'srg_clean_archives' ) ) : srg_clean_archives(); ?>

					<?php else : ?>

						<h2><?php _e( 'Archives by category', 'hybrid' ); ?></h2>

						<ul class="xoxo category-archives">
							<?php wp_list_categories( array( 'feed' => __( 'RSS', 'hybrid' ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
						</ul><!-- .xoxo .category-archives -->

						<h2><?php _e( 'Archives by month', 'hybrid' ); ?></h2>

						<ul class="xoxo monthly-archives">
							<?php wp_get_archives( array( 'show_post_count' => true, 'type' => 'monthly' ) ); ?>
						</ul><!-- .xoxo .monthly-archives -->

					<?php endif; ?>

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