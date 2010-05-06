<?php
/**
 * The core functions file for the Hybrid framework. Functions defined here are generally
 * used across the entire framework to make various tasks faster. This file should be loaded
 * prior to any other files because its functions are needed to run the framework.
 *
 * @package Hybrid
 * @subpackage Functions
 */

/**
 * Defines the theme prefix. This allows developers to infinitely change the theme. In theory,
 * one could use the Hybrid core to create their own theme or filter 'hybrid_prefix' with a 
 * plugin to make it easier to use hooks across multiple themes without having to figure out
 * each theme's hooks (assuming other themes used the same system).
 *
 * @since 0.7
 * @uses get_template() Defines the theme prefix, which is generally 'hybrid'.
 * @global object $hybrid The global Hybrid object.
 * @return string $hybrid->prefix The prefix of the theme.
 */
function hybrid_get_prefix() {
	global $hybrid;

	/* If the global prefix isn't set, define it. Plugin/theme authors may also define a custom prefix. */
	if ( empty( $hybrid->prefix ) )
		$hybrid->prefix = apply_filters( 'hybrid_prefix', get_template() );

	return $hybrid->prefix;
}

/**
 * Defines the theme textdomain. This allows the framework to recognize the proper textdomain 
 * of the theme. Theme developers building from the framework should use their template name 
 * (i.e., directory name) as their textdomain within template files.
 *
 * @since 0.7
 * @uses get_template() Defines the theme textdomain, which is generally 'hybrid'.
 * @global object $hybrid The global Hybrid object.
 * @return string $hybrid->textdomain The textdomain of the theme.
 */
function hybrid_get_textdomain() {
	global $hybrid;

	/* If the global textdomain isn't set, define it. Plugin/theme authors may also define a custom textdomain. */
	if ( empty( $hybrid->textdomain ) )
		$hybrid->textdomain = apply_filters( hybrid_get_prefix() . '_textdomain', get_template() );

	return $hybrid->textdomain;
}

/**
 * Adds contextual action hooks to the theme.  This allows users to easily add context-based content 
 * without having to know how to use WordPress conditional tags.  The theme handles the logic.
 *
 * An example of a basic hook would be 'hybrid_header'.  The do_atomic() function extends that to 
 * give extra hooks such as 'hybrid_singular_header', 'hybrid_singular-post_header', and 
 * 'hybrid_singular-post-ID_header'.
 *
 * Major props to Ptah Dunbar for the do_atomic() function.
 * @link http://ptahdunbar.com/wordpress/smarter-hooks-context-sensitive-hooks
 *
 * @since 0.7
 * @uses hybrid_get_prefix() Gets the theme prefix.
 * @uses hybrid_get_context() Gets the context of the current page.
 * @param string $tag Usually the location of the hook but defines what the base hook is.
 */
function do_atomic( $tag = '' ) {
	if ( !$tag )
		return false;

	/* Get the theme prefix. */
	$pre = hybrid_get_prefix();

	/* Do actions on the basic hook. */
	do_action( "{$pre}_{$tag}" );

	/* Loop through context array and fire actions on a contextual scale. */
	foreach ( (array)hybrid_get_context() as $context )
		do_action( "{$pre}_{$context}_{$tag}" );
}

/**
 * Adds contextual filter hooks to the theme.  This allows users to easily filter context-based content 
 * without having to know how to use WordPress conditional tags.  The theme handles the logic.
 *
 * An example of a basic hook would be 'hybrid_entry_meta'.  The apply_atomic() function extends 
 * that to give extra hooks such as 'hybrid_singular_entry_meta', 'hybrid_singular-post_entry_meta', 
 * and 'hybrid_singular-post-ID_entry_meta'.
 *
 * @since 0.7
 * @uses hybrid_get_prefix() Gets the theme prefix.
 * @uses hybrid_get_context() Gets the context of the current page.
 * @param string $tag Usually the location of the hook but defines what the base hook is.
 * @param mixed $value The value to be filtered.
 * @return mixed $value The value after it has been filtered.
 */
function apply_atomic( $tag = '', $value = '' ) {
	if ( !$tag )
		return false;

	/* Get theme prefix. */
	$pre = hybrid_get_prefix();

	/* Apply filters on the basic hook. */
	$value = apply_filters( "{$pre}_{$tag}", $value );

	/* Loop through context array and apply filters on a contextual scale. */
	foreach ( (array)hybrid_get_context() as $context )
		$value = apply_filters( "{$pre}_{$context}_{$tag}", $value );

	/* Return the final value once all filters have been applied. */
	return $value;
}

/**
 * Wraps the output of apply_atomic() in a call to do_shortcode(). This allows developers to use 
 * context-aware functionality alongside shortcodes. Rather than adding a lot of code to the 
 * function itself, developers can create individual functions to handle shortcodes.
 *
 * @since 0.7
 * @param string $tag Usually the location of the hook but defines what the base hook is.
 * @param mixed $value The value to be filtered.
 * @return mixed $value The value after it has been filtered.
 */
function apply_atomic_shortcode( $tag = '', $value = '' ) {
	return do_shortcode( apply_atomic( $tag, $value ) );
}

/**
 * Loads the Hybrid theme settings once and allows the input of the specific field the user would 
 * like to show.  Hybrid theme settings are added with 'autoload' set to 'yes', so the settings are 
 * only loaded once on each page load.
 *
 * @since 0.7
 * @uses get_option() Gets an option from the database.
 * @uses hybrid_get_prefix() Gets the prefix of the theme.
 * @global object $hybrid The global Hybrid object.
 * @global array $hybrid_settings Deprecated. Developers should use hybrid_get_setting().
 * @param string $option The specific theme setting the user wants.
 * @return string|int|array $settings[$option] Specific setting asked for.
 */
function hybrid_get_setting( $option = '' ) {
	global $hybrid, $hybrid_settings;

	if ( !$option )
		return false;

	if ( !is_array( $hybrid->settings ) )
		$hybrid->settings = $hybrid_settings = get_option( hybrid_get_prefix() . '_theme_settings' );

	return $hybrid->settings[$option];
}

/**
 * The theme can save multiple things in a transient to help speed up page load times. We're
 * setting a default of 12 hours or 43,200 seconds (60 * 60 * 12).
 *
 * @since 0.8
 * @return int Transient expiration time in seconds.
 */
function hybrid_get_transient_expiration() {
	return apply_filters( hybrid_get_prefix() . '_transient_expiration', 43200 );
}

/**
 * Function for formatting a hook name if needed. It automatically adds the theme's prefix to 
 * the hook, and it will add a context (or any variable) if it's given.
 *
 * @since 0.7
 * @param string $tag The basic name of the hook (e.g., 'before_header').
 * @param string $context A specific context/value to be added to the hook.
 */
function hybrid_format_hook( $tag, $context = '' ) {
	return hybrid_get_prefix() . ( ( !empty( $context ) ) ? "_{$context}" : "" ). "_{$tag}";
}

?>