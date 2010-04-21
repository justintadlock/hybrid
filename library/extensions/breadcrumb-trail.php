<?php
/**
 * A script for showing a breadcrumb menu within template files.
 * Use the template tag breadcrumb_trail() to get it to display.
 * Two filter hooks are available for developers to change the
 * output: breadcrumb_trail_args and breadcrumb_trail.
 *
 * @copyright 2008 - 2010
 * @version 0.3
 * @author Justin Tadlock
 * @link http://justintadlock.com/archives/2009/04/05/breadcrumb-trail-wordpress-plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Localized to match the Hybrid theme
 * _e( 'Text', $textdomain )
 * __( 'Text', $textdomain )
 *
 * @package BreadcrumbTrail
 */

/**
 * Shows a breadcrumb for all types of pages.  Themes and 
 * plugins can filter $args or input directly.  Allow filtering of 
 * only the $args using get_the_breadcrumb_args.
 *
 * @since 0.1
 * @param array $args Mixed arguments for the menu.
 * @return string Output of the breadcrumb menu.
 */
function breadcrumb_trail( $args = array() ) {
	global $wp_query;

	/* Get the textdomain. */
	$textdomain = hybrid_get_textdomain();

	/* Create an empty array for the trail. */
	$trail = array();

	/* Set up the default arguments for the breadcrumb. */
	$defaults = array(
		'separator' => '/',
		'before' => '<span class="breadcrumb-title">' . __( 'Browse:', $textdomain ) . '</span>',
		'after' => false,
		'front_page' => true,
		'show_home' => __( 'Home', $textdomain ),
		'single_tax' => false,
		'format' => 'flat', // Implement later
		'echo' => true
	);

	/* Allow singular post views to have a taxonomy's terms prefixing the trail. */
	if ( is_singular() )
		$defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;

	/* Apply filters to the arguments. */
	$args = apply_filters( 'breadcrumb_trail_args', $args );

	/* Parse the arguments and extract them for easy variable naming. */
	extract( wp_parse_args( $args, $defaults ) );

	/* For backwards compatibility, set $single_tax if it's explicitly given. */
	if ( $single_tax )
		$args['singular_post_taxonomy'] = $single_tax;

	/* Format the separator. */
	if ( $separator )
		$separator = '<span class="sep">' . $separator . '</span>';

	/* If $show_home is set and we're not on the front page of the site, link to the home page. */
	if ( !is_front_page() && $show_home )
		$trail[] = '<a href="' . home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="home" class="trail-begin">' . $show_home . '</a>';

	/* If viewing the front page of the site. */
	if ( is_front_page() ) {
		if ( !$front_page )
			$trail = false;
		elseif ( $show_home )
			$trail['trail_end'] = "{$show_home}";
	}

	/* If viewing the "home"/posts page. */
	elseif ( is_home() ) {
		$home_page = get_page( $wp_query->get_queried_object_id() );
		$trail = array_merge( $trail, breadcrumb_trail_get_parents( $home_page->post_parent, '' ) );
		$trail['trail_end'] = get_the_title( $home_page->ID );
	}

	/* If viewing a singular post (page, attachment, etc.). */
	elseif ( is_singular() ) {

		/* Get singular post variables needed. */
		$post_id = absint( $wp_query->post->ID );
		$post_type = $wp_query->post->post_type;
		$parent = $wp_query->post->post_parent;

		/* Display terms for specific post type taxonomy if requested. */
		if ( $args["singular_{$post_type}_taxonomy"] && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) )
			$trail[] = $terms;

		/* If the post type is hierarchical or is an attachment, get its parents. */
		if ( is_post_type_hierarchical( $post_type ) || is_attachment() )
			$trail = array_merge( $trail, breadcrumb_trail_get_parents( $parent, '' ) );

		/* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
		if ( !is_post_type( array( 'post', 'page', 'attachment' ), $post_id ) ) {

			$post_type_object = get_post_type_object( $post_type );

			if ( !empty( $post_type_object->rewrite['slug'] ) )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $post_type_object->rewrite['slug'] ) );
		}

		/* End with the post title. */
		$trail['trail_end'] = get_the_title();
	}

	/* If we're viewing any type of archive. */
	elseif ( is_archive() ) {

		/* If viewing a taxonomy term archive. */
		if ( is_tax() || is_category() || is_tag() ) {

			/* Get some taxonomy and term variables. */
			$term = $wp_query->get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );

			/* Get the path to the term archive. Use this to determine if a page is present with it. */
			if ( is_category() )
				$path = get_option( 'category_base' );
			elseif ( is_tag() )
				$path = get_option( 'tag_base' );
			else
				$path = $taxonomy->rewrite['slug'];

			/* Get parent pages by path if they exist. */
			if ( $path )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $path ) );

			/* If the taxonomy is hierarchical, list its parent terms. */
			if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent )
				$trail = array_merge( $trail, breadcrumb_trail_get_term_parents( $term->parent, $term->taxonomy ) );

			/* Add the term name to the trail end. */
			$trail['trail_end'] = $term->name;
		}

		elseif ( is_author() ) {
			global $wp_rewrite;

			/* Get parent pages by path if they exist. */
			if ( $wp_rewrite->author_base )
				$trail = array_merge( $trail, breadcrumb_trail_get_parents( '', $wp_rewrite->author_base ) );

			$trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
		}

		elseif ( is_time() ) {

			if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
				$trail['trail_end'] = get_the_time( __( 'g:i a', $textdomain ) );

			elseif ( get_query_var( 'minute' ) )
				$trail['trail_end'] = sprintf( __( 'Minute %1$s', $textdomain ), get_the_time( __( 'i', $textdomain ) ) );

			elseif ( get_query_var( 'hour' ) )
				$trail['trail_end'] = get_the_time( __( 'g a', $textdomain ) );
		}

		elseif ( is_date() ) {

			if ( is_day() ) {
				$trail[] = '<a href="' . get_year_link( get_the_time( __( 'Y', $textdomain ) ) ) . '" title="' . get_the_time( __( 'Y', $textdomain ) ) . '">' . get_the_time( __( 'Y', $textdomain ) ) . '</a>';
				$trail[] = '<a href="' . get_month_link( get_the_time( __( 'Y', $textdomain ) ), get_the_time( __( 'm', $textdomain ) ) ) . '" title="' . get_the_time( __( 'F', $textdomain ) ) . '">' . get_the_time( __( 'F', $textdomain ) ) . '</a>';
				$trail['trail_end'] = get_the_time( __( 'j', $textdomain ) );
			}

			elseif ( get_query_var( 'w' ) ) {
				$trail[] = '<a href="' . get_year_link( get_the_time( __( 'Y', $textdomain ) ) ) . '" title="' . get_the_time( __( 'Y', $textdomain ) ) . '">' . get_the_time( __( 'Y', $textdomain ) ) . '</a>';
				$trail['trail_end'] = sprintf( __( 'Week %1$s', 'hybrid' ), get_the_time( __( 'W', $textdomain ) ) );
			}

			elseif ( is_month() ) {
				$trail[] = '<a href="' . get_year_link( get_the_time( __( 'Y', $textdomain ) ) ) . '" title="' . get_the_time( __( 'Y', $textdomain ) ) . '">' . get_the_time( __( 'Y', $textdomain ) ) . '</a>';
				$trail['trail_end'] = get_the_time( __( 'F', $textdomain ) );
			}

			elseif ( is_year() ) {
				$trail['trail_end'] = get_the_time( __( 'Y', $textdomain ) );
			}
		}
	}

	elseif ( is_search() )
		$trail['trail_end'] = sprintf( __( 'Search results for &quot;%1$s&quot;', $textdomain ), esc_attr( get_search_query() ) );

	elseif ( is_404() )
		$trail['trail_end'] = __( '404 Not Found', $textdomain );

	/* BuddyPress check. */
	elseif ( function_exists( 'bp_core_setup_globals' ) ) {
		global $bp;

	if ( !empty( $bp->displayed_user->fullname ) ) { // looking at a user or self
		$trail[] = '<a href="' . $bp->root_domain . '/' . BP_MEMBERS_SLUG . '">Members</a>';

		//if ( $bp->current_component !== $bp->default_component )
			$trail[] = '<a href="'. $bp->displayed_user->domain .'" title="'. strip_tags( $bp->displayed_user->userdata->display_name) .'">'. strip_tags( $bp->displayed_user->userdata->display_name ) .'</a>';
		//else
		//	$trail[] = strip_tags( $bp->displayed_user->userdata->display_name );

		if ( is_numeric( $bp->current_action ) )
			$trail[] = ucwords( $bp->current_component );
		else {
			$trail[] = '<a href="'. $bp->displayed_user->domain . $bp->current_component .'" title="'. ucwords($bp->current_component) .'">'. ucwords($bp->current_component) .'</a>';
			//if($bp->current_action == 'just-me') {
			//	$trail[] = __('Personal', 'buddypress');
			//} else {
				$trail[] = ucwords( str_replace('-', ' ', $bp->current_action ) );
			//}
		}

	} else if ( $bp->is_single_item ) { // we're on a single item page
		$trail[] = '<a href="/'. $bp->current_component .'" title="'. ucwords( $bp->current_component ) .'">'. ucwords( $bp->current_component ) .'</a>';
		$trail[] = '<a href="/'. $bp->current_component .'/'. $bp->current_item .'" title="'.$bp->bp_options_title.'">'. $bp->bp_options_title .'</a>';
		// this *should* contain the name but it seems that the nav array hasn't yet been sorted so we need to resort to looking for the name value ourselves
		$trail_name = $bp->bp_options_nav[$bp->current_component][$bp->current_action]['name'];
		if(!$trail_name) {
			foreach($bp->bp_options_nav[$bp->current_component] as $value) {
				if ($value['slug'] == $bp->current_action) {
					$trail_name = $value['name'];
					break;
				}
			}
		}
		if ($bp->action_variables) {
			$trail[] = '<a href="/'. $bp->current_component . '/' . $bp->current_item . '/' . $bp->current_action .'" title="'. ucwords($bp->current_action) .'">'. ucwords($bp->current_action) .'</a>';
			$trail_end = ucwords( str_replace('-', ' ', $bp->action_variables[0]) );
		} else {
			$trail_end = $trail_name;
		}
	} else if ( $bp->is_directory ) { // this is a top level directory page
		if ( !$bp->current_component )
			$trail_end = ucwords( BP_MEMBERS_SLUG );
		else
			 $trail_end = ucwords( $bp->current_component );
	} else if ( bp_is_register_page() ) {
		$trail_end = __( 'Create an Account', 'buddypress' );
	} else if ( bp_is_activation_page() ) {
		$trail_end = __( 'Activate your Account', 'buddypress' );
	} else if ( bp_is_group_create() ) {
		$trail[] = '<a href="/'. $bp->current_component .'" title="'. ucwords($bp->current_component) .'">'. ucwords($bp->current_component) .'</a>';
		if ($bp->action_variables) {
			$trail[] = '<a href="/'. $bp->current_component . '/' . $bp->current_action .'" title="'. __( 'Create a Group', 'buddypress' ) .'">'. __( 'Create a Group', 'buddypress' ) .'</a>';
			$trail_end = ucwords( str_replace('-', ' ', $bp->action_variables[1]) );
		} else {
			$trail_end = __( 'Create a Group', 'buddypress' );
		}
	} else if ( bp_is_create_blog() ) {
		$trail[] = '<a href="/'. $bp->current_component .'" title="'. ucwords($bp->current_component) .'">'. ucwords($bp->current_component) .'</a>';
		$trail_end = __( 'Create a Blog', 'buddypress' );
	}
	if ($trail_end)
		$trail['trail_end'] = '<span class="trail-end">'. $trail_end .'</span>';

	}

	/* Connect the breadcrumb trail. */
	if ( is_array( $trail ) ) {
		$breadcrumb = '<div class="breadcrumb breadcrumbs"><div class="breadcrumb-trail">';
		$breadcrumb .= " {$before} ";
		$breadcrumb .= join( " {$separator} ", $trail );
		$breadcrumb .= '</div></div>';
	}

	$breadcrumb = apply_filters( 'breadcrumb_trail', $breadcrumb );

	/* Output the breadcrumb. */
	if ( $echo )
		echo $breadcrumb;
	else
		return $breadcrumb;
}

/**
 * Gets parent pages of any post type or taxonomy by the ID or Path.  The goal of this 
 * function is to create a clear path back to home given what would normally be a "ghost"
 * directory.  If any page matches the given path, it'll be added.  But, it's also just a way
 * to check for a hierarchy with hierarchical post types.
 *
 * @since 0.3
 * @param int $post_id ID of the post whose parents we want.
 * @param string $path Path of a potential parent page.
 * @return array $trail Array of parent page links.
 */
function breadcrumb_trail_get_parents( $post_id = '', $path = '' ) {

	$trail = array();

	if ( empty( $post_id ) && empty( $path ) )
		return $trail;

	if ( empty( $post_id ) ) {
		$parent_page = get_page_by_path( $path );
		$post_id = $parent_page->ID;
	}

	if ( $post_id == 0 ) {
		preg_match_all( "/\/.*?\z/", $path, $matches );

		if ( isset( $matches ) ) {
			$matches = array_reverse( $matches );

			foreach ( $matches as $match ) {

				$path = str_replace( $match[0], '', $path );
				$parent_page = get_page_by_path( $path );

				if ( $parent_page->ID > 0 ) {
					$post_id = $parent_page->ID;
					break;
				}
			}
		}
	}

	while ( $post_id ) {
		$page = get_page( $post_id );
		$parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
		$post_id = $page->post_parent;
	}

	if ( $parents )
		$trail = array_reverse( $parents );

	return $trail;
}

/**
 * Searches for term parents of hierarchical taxonomies.  This function is similar to
 * the WordPress function get_category_parents() but handles any type of taxonomy.
 *
 * @since 0.3
 * @param int $parent_id The ID of the first parent.
 * @param object|string $taxonomy The taxonomy of the term whose parents we want.
 * @return array $trail Array of links to parent terms.
 */
function breadcrumb_trail_get_term_parents( $parent_id = '', $taxonomy = '' ) {
	$trail = array();
	$parents = array();

	if ( empty( $parent_id ) || empty( $taxonomy ) )
		return $trail;

	while ( $parent_id ) {
		$parent = get_term( $parent_id, $taxonomy );
		$parents[] = '<a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a>';
		$parent_id = $parent->parent;
	}

	if ( $parents )
		$trail = array_reverse( $parents );

	return $trail;
}

?>