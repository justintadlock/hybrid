<?php
/**
 * User/Author Template
 *
 * The user template is used when a reader is viewing an user's archive page.  The template 
 * displays the user's biographical information, avatar, and latests posts in excerpt format.
 * @link http://codex.wordpress.org/Author_Templates
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php hybrid_before_content(); // Before content hook ?>

		<?php $id = get_query_var( 'author' ); ?>

		<div id="hcard-<?php the_author_meta( 'user_nicename', $id ); ?>" class="archive-info user-info user-profile author-info author-profile vcard">

			<h1 class="archive-title user-title author-title fn n"><?php the_author_meta( 'display_name', $id ); ?></h1>

			<div class="archive-description user-description author-description">
				<?php echo get_avatar( get_the_author_meta( 'user_email', $id ), '100', '', get_the_author_meta( 'display_name', $id ) ); ?>

				<div class="user-bio author-bio">
					<?php the_author_meta( 'description', $id ); ?>
				</div><!-- .user-bio .author-bio -->
			</div><!-- .archive-description -->

		</div><!-- .archive-info -->

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

		<?php endif; ?>

		<?php hybrid_after_content(); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>