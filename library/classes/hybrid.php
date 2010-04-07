<?php
/**
 * The Hybrid class launches the framework.  It's the organizational structure behind the
 * entire theme.  This class should be initialized before anything else in the theme is called.
 *
 * @package Hybrid
 * @subpackage Classes
 */

class Hybrid {

	/**
	 * Theme prefix (mostly used for hooks).
	 *
	 * @since 0.7
	 * @var string
	 */
	var $prefix;

	/**
	 * Initializes the theme framework, loads the required files, and calls the
	 * functions needed to run the theme.
	 *
	 * @since 0.7
	 */
	function init() {

		/* Define theme constants. */
		$this->constants();

		/* Load theme functions. */
		$this->functions();

		/* Load theme extensions. */
		$this->extensions();

		/* Load legacy files and functions. */
		$this->legacy();

		/* Load admin files. */
		$this->admin();

		/* Theme prefix for creating things such as filter hooks (i.e., "$prefix_hook_name"). */
		$this->prefix = hybrid_get_prefix();

		/* Load theme textdomain. */
		$domain = hybrid_get_textdomain();
		$locale = get_locale();
		load_textdomain( $domain, locate_template( array( "languages/{$domain}-{$locale}.mo", "{$domain}-{$locale}.mo" ) ) );

		/* Initialize the theme's default actions. */
		$this->actions();

		/* Initialize the theme's default filters. */
		$this->filters();

		/* Theme init hook. */
		do_action( "{$this->prefix}_init" );
	}

	/**
	 * Defines the constant paths for use within the theme.
	 *
	 * @since 0.7
	 */
	function constants() {
		define( 'THEME_DIR', get_template_directory() );
		define( 'THEME_URI', get_template_directory_uri() );
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		define( 'THEME_LIBRARY', THEME_DIR . '/library' );
		define( 'THEME_ADMIN', THEME_LIBRARY . '/admin' );
		define( 'THEME_CLASSES', THEME_LIBRARY . '/classes' );
		define( 'THEME_EXTENSIONS', THEME_LIBRARY . '/extensions' );
		define( 'THEME_FUNCTIONS', THEME_LIBRARY . '/functions' );
		define( 'THEME_LEGACY', THEME_LIBRARY . '/legacy' );
		define( 'THEME_IMAGES', THEME_URI . '/library/images' );
		define( 'THEME_CSS', THEME_URI . '/library/css' );
		define( 'THEME_JS', THEME_URI . '/library/js' );
	}

	/**
	 * Loads the core theme functions.
	 *
	 * @since 0.7
	 */
	function functions() {
		require_once( THEME_FUNCTIONS . '/core.php' );
		require_once( THEME_FUNCTIONS . '/hooks-actions.php' );
		require_once( THEME_FUNCTIONS . '/hooks-filters.php' );
		require_once( THEME_FUNCTIONS . '/comments.php' );
		require_once( THEME_FUNCTIONS . '/context.php' );
		require_once( THEME_FUNCTIONS . '/media.php' );
		require_once( THEME_FUNCTIONS . '/shortcodes.php' );
		require_once( THEME_FUNCTIONS . '/template.php' );
		require_once( THEME_FUNCTIONS . '/widgets.php' );

		/* Menus compatibility. */
		if ( hybrid_get_setting( 'use_menus' ) )
			require_once( THEME_FUNCTIONS . '/menus.php' );
	}

	/**
	 * Load extensions (external projects).
	 *
	 * @since 0.7
	 */
	function extensions() {
		require_once( THEME_EXTENSIONS . '/breadcrumb-trail.php' );
		require_once( THEME_EXTENSIONS . '/custom-field-series.php' );
		require_once( THEME_EXTENSIONS . '/get-the-image.php' );
		require_once( THEME_EXTENSIONS . '/get-the-object.php' );
	}

	/**
	 * Load legacy functions for backwards compatibility.
	 *
	 * @since 0.7
	 */
	function legacy() {
		require_once( THEME_LEGACY . '/deprecated.php' );
	}

	/**
	 * Load admin files.
	 *
	 * @since 0.7
	 */
	function admin() {
		if ( is_admin() ) {
			require_once( THEME_ADMIN . '/admin.php' );
			require_once( THEME_ADMIN . '/meta-box.php' );
			require_once( THEME_ADMIN . '/settings-page.php' );
		}
	}

	/**
	 * Adds the default theme actions.
	 *
	 * @since 0.7
	 */
	function actions() {

		/* Remove WP and plugin functions. */
		remove_action( 'wp_head', 'wp_generator' );
		add_action( 'wp_print_styles', 'hybrid_disable_styles' );

		/* Head actions. */
		$actions[] = 'hybrid_meta_content_type';
		$actions[] = 'wp_generator';
		$actions[] = 'hybrid_meta_template';
		if ( !hybrid_get_setting( 'seo_plugin' ) ) {
			$actions[] = 'hybrid_meta_robots';
			$actions[] = 'hybrid_meta_author';
			$actions[] = 'hybrid_meta_copyright';
			$actions[] = 'hybrid_meta_revised';
			$actions[] = 'hybrid_meta_description';
			$actions[] = 'hybrid_meta_keywords';
		}
		$actions[] = 'hybrid_head_pingback';
		$actions[] = 'hybrid_favicon';

		foreach ( $actions as $action )
			add_action( "{$this->prefix}_head", $action );

		/* WP print scripts and styles. */
		add_action( 'template_redirect', 'hybrid_enqueue_style' );
		add_action( 'template_redirect', 'hybrid_enqueue_script' );

		/* Header. */
		add_action( "{$this->prefix}_header", 'hybrid_site_title' );
		add_action( "{$this->prefix}_header", 'hybrid_site_description' );

		/* Load the correct menu. */
		if ( hybrid_get_setting( 'use_menus' ) )
			add_action( "{$this->prefix}_after_header", 'hybrid_get_primary_menu' );
		else
			add_action( "{$this->prefix}_after_header", 'hybrid_page_nav' );

		/* After container. */
		add_action( "{$this->prefix}_after_container", 'hybrid_get_primary' );
		add_action( "{$this->prefix}_after_container", 'hybrid_get_secondary' );

		/* Before content. */
		add_action( "{$this->prefix}_before_content", 'hybrid_breadcrumb' );
		add_action( "{$this->prefix}_before_content", 'hybrid_get_utility_before_content' );

		/* Entry actions. */
		add_action( "{$this->prefix}_before_entry", 'hybrid_entry_title' );
		add_action( "{$this->prefix}_before_entry", 'hybrid_byline' );
		add_action( "{$this->prefix}_after_entry", 'hybrid_entry_meta' );

		/* After singular views. */
		add_action( "{$this->prefix}_after_singular", 'hybrid_get_utility_after_singular' );
		add_action( "{$this->prefix}_after_singular", 'custom_field_series' );

		/* After content. */
		add_action( "{$this->prefix}_after_content", 'hybrid_get_utility_after_content' );
		add_action( "{$this->prefix}_after_content", 'hybrid_navigation_links' );

		/* Before footer. */
		add_action( "{$this->prefix}_before_footer", 'hybrid_get_subsidiary' );

		/* Hybrid footer. */
		add_action( "{$this->prefix}_footer", 'hybrid_footer_insert' );

		/* Comments */
		add_action( "{$this->prefix}_before_comment", 'hybrid_avatar' );
		add_action( "{$this->prefix}_before_comment", 'hybrid_comment_meta' );
	}

	/**
	 * Adds the default theme filters.
	 *
	 * @since 0.7
	 */
	function filters() {
		/* Remove WP and plugin functions. */
		remove_filter( 'pre_user_description', 'wp_filter_kses' );
		remove_filter( 'pre_term_description', 'wp_filter_kses' );
		remove_filter( 'term_description', 'wp_kses_data' );

		/* Add same filters to user description as term descriptions. */
		add_filter( 'get_the_author_description', 'wptexturize' );
		add_filter( 'get_the_author_description', 'convert_chars' );
		add_filter( 'get_the_author_description', 'wpautop' );
		add_filter( 'get_the_author_description', 'shortcode_unautop' );

		/* Make text widgets, term descriptions, and user descriptions shortcode aware. */
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'term_description', 'do_shortcode' );
		add_filter( 'get_the_author_description', 'do_shortcode' );

		/* Template filters. */
		add_filter( 'date_template', 'hybrid_date_template' );
		add_filter( 'author_template', 'hybrid_user_template' );
		add_filter( 'tag_template', 'hybrid_taxonomy_template' );
		add_filter( 'category_template', 'hybrid_taxonomy_template' );
		add_filter( 'single_template', 'hybrid_singular_template' );
		add_filter( 'page_template', 'hybrid_singular_template' );
		add_filter( 'attachment_template', 'hybrid_singular_template' );

		/* Feed links. */
		add_filter( 'feed_link', 'hybrid_feed_link', 1, 2 );
		add_filter( 'category_feed_link', 'hybrid_other_feed_link' );
		add_filter( 'author_feed_link', 'hybrid_other_feed_link' );
		add_filter( 'tag_feed_link', 'hybrid_other_feed_link' );
		add_filter( 'search_feed_link', 'hybrid_other_feed_link' );
	}
}

?>