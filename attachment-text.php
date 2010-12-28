<?php
/**
 * Text Attachment Template
 *
 * This text attachment template is used when a reader is viewing a single text attachment. 
 * Texts are uploads (i.e., attachments) that have a mime type of 'text'.
 * @link http://themehybrid.com/themes/hybrid/attachments/text
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // Before content hook ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // Before entry hook ?>

				<div class="entry-content">

					<?php hybrid_attachment(); ?>

					<?php the_content( sprintf( __( 'Continue reading %1$s', hybrid_get_textdomain() ), the_title( ' "', '"', false ) ) ); ?>

					<p class="download">
						<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="enclosure" type="<?php echo get_post_mime_type(); ?>"><?php printf( __( 'Download &quot;%1$s&quot;', hybrid_get_textdomain() ), the_title( '<span class="fn">', '</span>', false) ); ?></a>
					</p><!-- .download -->

					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', hybrid_get_textdomain() ), 'after' => '</p>' ) ); ?>

				</div><!-- .entry-content -->

				<?php do_atomic( 'after_entry' ); // After entry hook ?>

			</div><!-- .hentry -->

			<?php do_atomic( 'after_singular' ); // After singular hook ?>

			<?php comments_template( '/comments.php', true ); ?>

			<?php endwhile; ?>

		<?php else: ?>

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', hybrid_get_textdomain() ); ?>
			</p><!-- .no-data -->

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>