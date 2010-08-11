<?php
/**
 * Entry views is a script for calculating the number of views a post gets.  It is meant to be basic and 
 * not a full-featured solution.  The idea is to allow theme/plugin authors to quickly load this file and 
 * build functions on top of it to suit their project needs.  The script supports all post types.
 *
 * It should be noted that any links with rel="next" or rel="prefetch" will cause some browsers to prefetch
 * the data for that particular page.  This can cause the view count to be skewed.  To try and avoid this 
 * issue, this extension disables adjacent_posts_rel_link_wp_head().  However, this is not bullet-proof as 
 * it cannot control links it doesn't know about.
 * @link http://core.trac.wordpress.org/ticket/14568
 *
 * @todo Write an AJAX solution as JavaScript isn't prefetched.
 *
 * @copyright 2010
 * @version 0.1
 * @author Justin Tadlock
 * @link http://justintadlock.com
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package EntryViews
 */

/* Add the update_entry_views function to the template_redirect hook. */
add_action( 'template_redirect', 'entry_views_update' );

/* Disable prev/next links because some browsers prefetch them and skew the results. */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/* Add the [entry-views] shortcode. */
add_shortcode( 'entry-views', 'entry_views_get' );

/**
 * Updates the number of views when on a singular view of a post.  This function uses post meta to store
 * the number of views per post.  The meta key is 'Views'.
 *
 * Developers can filter which post types they want to show this on with the 'entry_views_post_types' filter
 * hook.  While it's okay to return a string, the recommendation is to return an array of post types.  If not 
 * filtered, all publicly-viewable posts will get a view count.
 *
 * @since 0.1
 */
function entry_views_update() {
	global $wp_query;

	/* If we're on a singular view of a post, calculate the number of views. */
	if ( is_singular( apply_filters( 'entry_views_post_types', '' ) ) ) {

		/* Allow devs to override the meta key used. By default, this is 'Views'. */
		$meta_key = apply_filters( 'entry_views_meta_key', 'Views' );

		/* Get the ID of the current post being viewed. */
		$post_id = $wp_query->get_queried_object_id();

		/* Get the number of views the post currently has. */
		$old_views = get_post_meta( $post_id, $meta_key, true );

		/* Add +1 to the number of current views. */
		$new_views = absint( $old_views ) + 1;

		/* Update the view count with the new view count. */
		update_post_meta( $post_id, $meta_key, $new_views, $old_views );
	}
}

/**
 * Gets the number of views a specific post has.  It also doubles as a shortcode, which is called with the 
 * [entry-views] format.
 *
 * @since 0.1
 * @param array $attr Attributes for use in the shortcode.
 */
function entry_views_get( $attr = '' ) {
	global $post;

	/* Merge the defaults and the given attributes. */
	$attr = shortcode_atts( array( 'before' => '', 'after' => '', 'post_id' => $post->ID ), $attr );

	/* Allow devs to override the meta key used. */
	$meta_key = apply_filters( 'entry_views_meta_key', 'Views' );

	/* Get the number of views the post has. */
	$views = intval( get_post_meta( $attr['post_id'], $meta_key, true ) );

	/* Returns the formatted number of views. */
	return $attr['before'] . number_format_i18n( $views ) . $attr['after'];
}

?>