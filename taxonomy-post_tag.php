<?php
/**
 * Post Tag Taxonomy Template
 *
 * This template is loaded when viewing a post tag archive and replaces the default tag.php template.
 * It can also be overwritten for individual post tags using taxonomy-post_tag-$term.php.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<div class="archive-info post_tag-info tag-info">

			<h1 class="archive-title post_tag-title tag-title"><?php single_tag_title(); ?></h1>

			<div class="archive-description post_tag-description tag-description">
				<?php echo tag_description(); ?>
			</div><!-- .post_tag-description -->

		</div><!-- .post_tag-info -->

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