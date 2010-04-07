<?php
/**
 * Link Category Taxonomy Template
 *
 * This template is used when a link category is shown.  Individual link categories can also have
 * their own templates using taxonomy-link_category-$term.php.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<div class="archive-info taxonomy-info">

			<h1 class="archive-title taxonomy-title"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h1>

			<div class="archive-description taxonomy-description">
				<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>
			</div><!-- .archive-description -->

		</div><!-- .archive-info -->

		<div class="<?php hybrid_entry_class(); ?>">

			<?php hybrid_before_entry(); // Before entry hook ?>

			<div class="entry-content">

				<?php $args = array(
					'title_li' => false,
					'title_before' => false,
					'title_after' => false,
					'category_name' => $term->name,
					'category_before' => false,
					'category_after' => false,
					'categorize' => false,
					'show_description' => true,
					'between' => '<br />',
					'show_images' => false,
					'show_rating' => false,
				); ?>
				<ul class="xoxo bookmarks">
					<?php wp_list_bookmarks( $args ); ?>
				</ul><!-- .xoxo .bookmarks -->

			</div><!-- .entry-content -->

			<?php hybrid_after_entry(); // After entry hook ?>

		</div><!-- .hentry -->

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>