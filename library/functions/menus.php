<?php
/**
 * Functions for dealing with menus and menu items within the theme. WP menu items must be 
 * unregistered. Hybrid menu items must be registered in their place. All menus are loaded 
 * and registered with WP.
 *
 * @package Hybrid
 * @subpackage Functions
 */

/**
 * Add theme support for menus.
 * @since 0.8
 */
add_theme_support( 'nav-menus' );

/**
 * Register menus.
 * @since 0.8
 */
add_action( 'init', 'hybrid_register_menus' );

/**
 * Add post types to menus.
 * @since 0.8
 */
//add_filter( 'post_types_allowed_in_menus', 'hybrid_post_types_allowed_in_menus' );

/**
 * Add taxonomies to menus.
 * @since 0.8
 */
//add_filter( 'taxonomies_allowed_in_menus', 'hybrid_taxonomies_allowed_in_menus' );

/**
 * Validate menus.
 * @since 0.8
 */
add_filter( 'wp_nav_menu', 'hybrid_validate_nav_menus' );

/**
 * Registers the theme's menus.
 *
 * @since 0.8
 * @uses is_nav_menu() Checks if a menu exists.
 * @uses locate_template() Checks for template in child and parent theme.
 */
function hybrid_register_menus() {

	/* Check if Primary menu exists before creating it. */
	if ( is_admin() && !is_nav_menu( 'primary-menu' ) && locate_template( array( 'menu-primary.php' ), false ) )
		wp_create_nav_menu( __( 'Primary Menu', hybrid_get_textdomain() ), array( 'slug' => 'primary-menu' ) );
}

/**
 * Loads the 'Primary Menu' template file.  Users can overwrite menu-primary.php in their child
 * theme folder.
 *
 * @since 0.8
 * @uses locate_template() Checks for template in child and parent theme.
 */
function hybrid_get_primary_menu() {
	locate_template( array( 'menu-primary.php', 'menu.php' ), true );
}

/**
 * Checks if a nav menu has menu items.
 *
 * @since 0.8
 * @uses wp_get_nav_menu_object() Gets the nav menu object.
 * @uses get_objects_in_term() Checks to see if there are any associated menu items.
 * @return bool Whether the menu has menu items.
 */
function is_nav_menu_active( $menu ) {

	$cache = wp_cache_get( 'active', 'nav_menus' );
	if ( !is_array( $cache ) )
		$cache = array();

	if ( isset( $cache[$menu] ) )
		return $cache[$menu];

	$menu_object = wp_get_nav_menu_object( $menu );

	if ( !empty( $menu_object ) )
		$menu_items = get_objects_in_term( $menu_object->term_id, 'nav_menu' );

	if ( !empty( $menu_items ) ) {
		$cache[$menu] = true;
		wp_cache_set( 'active', $cache, 'nav_menus' );
		return true;
	}
	else {
		$cache[$menu] = false;
		wp_cache_set( 'active', $cache, 'nav_menus' );
	}

	return false;
}

/**
 * Allow all public post types in menus.
 *
 * @since 0.8
 */
function hybrid_post_types_allowed_in_menus( $post_types ) {
	return get_post_types( array( 'public' => true ), 'names' );
}

/**
 * Allow all public taxonomies in menus.
 *
 * @since 0.8
 */
function hybrid_taxonomies_allowed_in_menus( $taxonomies ) {
	return get_taxonomies( array( 'public' => true ), 'names' );
}

/**
 * Removes the 'target' attribute from menu items so that site's have valid HTML.
 *
 * @since 0.8
 */
function hybrid_validate_nav_menus( $menu ) {
	return preg_replace( "/target=\".*?\"/", '', $menu );
}

?>