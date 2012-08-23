<?php
/**
 * Attachment Template
 *
 * The attachment template is a general template that displays attachments if no other 
 * attachment-type template is found.  Also see application.php, audio.php, image.php, 
 * text.php, and video.php.
 *
 * @package Hybrid
 * @subpackage Template
 * @link http://themehybrid.com/themes/hybrid/attachments
 * @link http://codex.wordpress.org/Using_Image_and_File_Attachments
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>

				<div class="entry-content">

					<?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>

						<p class="attachment-image">
							<?php echo wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) ); ?>
						</p><!-- .attachment-image -->

					<?php else : ?>

						<?php hybrid_attachment(); // Function for handling non-image attachments. ?>

						<p class="download">
							<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="enclosure" type="<?php echo get_post_mime_type(); ?>"><?php printf( __( 'Download &quot;%1$s&quot;', 'hybrid' ), the_title( '<span class="fn">', '</span>', false) ); ?></a>
						</p><!-- .download -->

					<?php endif; ?>

					<?php the_content( sprintf( __( 'Continue reading %1$s', 'hybrid' ), the_title( ' "', '"', false ) ) ); ?>

					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', 'hybrid' ), 'after' => '</p>' ) ); ?>

				</div><!-- .entry-content -->

				<?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>
					<p class="navigation-attachment">
						<span class="alignleft"><?php previous_image_link(); ?></span>
						<span class="alignright"><?php next_image_link(); ?></span>
					</p><!-- .navigation-attachment -->
				<?php endif; ?>

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