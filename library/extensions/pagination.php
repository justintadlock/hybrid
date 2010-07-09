<?php
/**
 * Functions for displaying a series of posts linked together
 * by a custom field called 'Series'.  Each post is listed that
 * belong to the same series of posts.
 *
 * @copyright 2010
 * @version 0.1
 * @author Justin Tadlock
 * @link http://justintadlock.com/archives/2007/11/01/wordpress-custom-fields-listing-a-series-of-posts
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package Pagination
 */


function pagination( $args = array() ) {
	global $wp_rewrite, $wp_query, $post;

	if ( 1 >= $wp_query->max_num_pages )
		return;
	
	$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

	$max_page = intval( $wp_query->max_num_pages );

	/* Set up some default arguments for the paginate_links() function. */
	$defaults = array(
		'base' => add_query_arg( 'page', '%#%' ),
		'format' => '',
		'total' => $max_page,
		'current' => $current,
		'echo' => true,
		'prev_next' => true,
		'prev_text' => __( '&laquo; Previous' ),
		'next_text' => __( 'Next &raquo;' ),
		'end_size' => 1,
		'mid_size' => 1,
		'add_fragment' => ''
	);

	/* Add the $base argument to the array if the user is using permalinks. */
	if ( $wp_rewrite->using_permalinks() )
		$defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );

	/* Merge the arguments input with the defaults. */
	$args = wp_parse_args( $args, $defaults );

	/* Get the paginated links. */
	$page_links = paginate_links( $args );

	/* Remove 'page/1' from the entire output since it's not needed. */
	$page_links = str_replace( 'page/1\'', '\'', $page_links );

	/* Wrap the paginated links in a wrapper element. */
	$page_links = "<div class='pagination wp-pagenavi'>" . $page_links . "</div>";

	/* Return the paginated links for use in themes. */
	echo $page_links;
}
















?>