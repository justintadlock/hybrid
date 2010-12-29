<?php
/**
 * Loop Error Template
 *
 * Displays an error message when no posts are found.
 *
 * @package Hybrid
 * @subpackage Template
 */
?>
	<div id="post-0" class="<?php hybrid_entry_class(); ?>">

		<div class="entry-content">

			<p class="no-data">
				<?php _e( 'Apologies, but no results were found.', hybrid_get_textdomain() ); ?>
			</p><!-- .no-data -->

		</div><!-- .entry-content -->

	</div><!-- .hentry .error -->