<?php
/**
 * Navigation Links Template
 *
 * This template is used to show your your next/previous post links on singular pages and
 * the next/previous posts links on the home/posts page and archive pages. It also integrates
 * with the WP PageNavi plugin if activated.
 *
 * @package Hybrid
 * @subpackage Template
 */
?>

	<?php if ( is_attachment() ) : ?>

		<div class="navigation-links">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '&laquo; Return to entry', 'hybrid' ) . '</span>' ); ?>
		</div>

	<?php elseif ( is_singular( 'post' ) ) : ?>

		<div class="navigation-links">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '&laquo; Previous', 'hybrid' ) . '</span>' ); ?>
			<?php next_post_link( '%link', '<span class="next">' . __( 'Next &raquo;', 'hybrid' ) . '</span>' ); ?>
		</div><!-- .navigation-links -->

	<?php elseif ( !is_singular() && function_exists( 'wp_pagenavi' ) ) : wp_pagenavi(); ?>

	<?php elseif ( !is_singular() && current_theme_supports( 'loop-pagination' ) ) : loop_pagination(); ?>

	<?php elseif ( !is_singular() && $nav = get_posts_nav_link( array( 'sep' => '', 'prelabel' => '<span class="previous">' . __( '&laquo; Previous', 'hybrid' ) . '</span>', 'nxtlabel' => '<span class="next">' . __( 'Next &raquo;', 'hybrid' ) . '</span>' ) ) ) : ?>

		<div class="navigation-links">
			<?php echo $nav; ?>
		</div><!-- .navigation-links -->

	<?php endif; ?>