<?php
/**
 * Template Name: Archives
 *
 * This will list your categories and monthly archives by default.
 * @link http://themehybrid.com/themes/hybrid/page-templates/archives
 *
 * Alternately, you can activate an archives plugin.
 * @link http://justinblanton.com/projects/smartarchives
 * @link http://wordpress.org/extend/plugins/clean-archives-reloaded
 * @link http://www.geekwithlaptop.com/projects/clean-archives
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

					<?php if ( function_exists( 'clean_my_archives' ) ) : echo clean_my_archives(); ?>

					<?php elseif ( function_exists( 'smartArchives' ) ) : smartArchives( 'both', '' ); ?>

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