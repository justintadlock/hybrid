<?php
/**
 * Template Name: Sitemap
 *
 * The Sitemap template is a page template that creates and HTML-based sitemap of your
 * site, listing nearly every page of your site. It lists your feeds, pages, archives, and posts.
 *
 * @package Hybrid
 * @subpackage Template
 * @link http://themehybrid.com/themes/hybrid/page-templates/sitemap
 * @deprecated 0.9.0 This template will eventually be moved to the Hybrid page templates pack.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>

				<div class="entry-content">

					<?php the_content(); ?>

					<h2><?php _e( 'Feeds', 'hybrid' ); ?></h2>

					<ul class="xoxo feeds">
						<li><a href="<?php bloginfo( 'rdf_url' ); ?>" title="<?php esc_attr_e( 'RDF/RSS 1.0 feed', 'hybrid' ); ?>"><?php _e( '<acronym title="Resource Description Framework">RDF</acronym> <acronym title="Really Simple Syndication">RSS</acronym> 1.0 feed', 'hybrid' ); ?></a></li>
						<li><a href="<?php bloginfo( 'rss_url' ); ?>" title="<?php esc_attr_e( 'RSS 0.92 feed', 'hybrid' ); ?>"><?php _e( '<acronym title="Really Simple Syndication">RSS</acronym> 0.92 feed', 'hybrid' ); ?></a></li>
						<li><a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php esc_attr_e( 'RSS 2.0 feed', 'hybrid' ); ?>"><?php _e( '<acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed', 'hybrid' ); ?></a></li>
						<li><a href="<?php bloginfo( 'atom_url' ); ?>" title="<?php esc_attr_e( 'Atom feed', 'hybrid' ); ?>"><?php _e( 'Atom feed', 'hybrid' ); ?></a></li>
						<li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" title="<?php esc_attr_e( 'Comments RSS 2.0 feed', 'hybrid' ); ?>"><?php _e( 'Comments <acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed', 'hybrid' ); ?></a></li>
					</ul><!-- .xoxo .feeds -->

					<h2><?php _e( 'Pages', 'hybrid' ); ?></h2>

					<ul class="xoxo pages">
						<?php wp_list_pages( array( 'title_li' => false ) ); ?>
					</ul><!-- .xoxo .pages -->

					<h2><?php _e( 'Category Archives', 'hybrid' ); ?></h2>

					<ul class="xoxo category-archives">
						<?php wp_list_categories( array( 'feed' => __( 'RSS', 'hybrid' ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
					</ul><!-- .xoxo .category-archives -->

					<h2><?php _e( 'Author Archives', 'hybrid' ); ?></h2>

					<ul class="xoxo author-archives">
						<?php wp_list_authors( array( 'exclude_admin' => false, 'show_fullname' => true, 'feed' => __( 'RSS', 'hybrid' ), 'optioncount' => true, 'title_li' => false ) ); ?>
					</ul><!-- .xoxo .author-archives -->

					<h2><?php _e( 'Yearly Archives', 'hybrid' ); ?></h2>

					<ul class="xoxo yearly-archives">
						<?php wp_get_archives( array( 'type' => 'yearly', 'show_post_count' => true ) ); ?>
					</ul><!-- .xoxo .yearly-archives -->

					<h2><?php _e( 'Monthly Archives', 'hybrid' ); ?></h2>

					<ul class="xoxo monthly-archives">
						<?php wp_get_archives( array( 'type' => 'monthly', 'show_post_count' => true ) ); ?>
					</ul><!-- .xoxo .monthly-archives -->

					<h2><?php _e( 'Weekly Archives', 'hybrid' ); ?></h2>

					<ul class="xoxo weekly-archives">
						<?php wp_get_archives( array( 'type' => 'weekly', 'show_post_count' => true ) ); ?>
					</ul><!-- .xoxo .weekly-archives -->

					<h2><?php _e( 'Daily Archives', 'hybrid' ); ?></h2>

					<ul class="xoxo daily-archives">
						<?php wp_get_archives( array( 'type' => 'daily', 'show_post_count' => true ) ); ?>
					</ul><!-- .xoxo .daily-archives -->

					<h2><?php _e( 'Tag Archives', 'hybrid' ); ?></h2>

					<p class="tag-cloud">
						<?php wp_tag_cloud( array( 'number' => 0 ) ); ?>
					</p><!-- .tag-cloud -->

					<h2><?php _e( 'Blog Posts', 'hybrid' ); ?></h2>

					<ul class="xoxo post-archives">
						<?php wp_get_archives( array( 'type' => 'postbypost' ) ); ?>
					</ul><!-- .xoxo .post-archives -->

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