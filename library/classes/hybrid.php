<?php
/**
 * The Hybrid class launches the framework.  It's the organizational structure behind the
 * entire theme.  This class should be initialized before anything else in the theme is called.
 *
 * @package HybridCore
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
	 * Constructor method for the Hybrid class.  Just calls the init() method.
	 *
	 * @since 0.9
	 */
	function Hybrid() {
		$this->init();
	}

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

		/* Load legacy files and functions. */
		$this->legacy();

		/* Load admin files. */
		$this->admin();

		/* Theme prefix for creating things such as filter hooks (i.e., "$prefix_hook_name"). */
		$this->prefix = hybrid_get_prefix();

		/* Initialize the theme's default actions. */
		$this->actions();

		/* Initialize the theme's default filters. */
		$this->filters();

		/* Load theme extensions later since we need to check if they're supported. */
		add_action( 'after_setup_theme', array( &$this, 'extensions' ), 12 );

		/* Load theme textdomain. */
		$domain = hybrid_get_textdomain();
		$locale = get_locale();
		load_theme_textdomain( $domain );

		/* Load locale-specific functions file. */
		$locale_functions = locate_template( array( "languages/{$locale}.php", "{$locale}.php" ) );
		if ( !empty( $locale_functions ) && is_readable( $locale_functions ) )
			require_once( $locale_functions );

		/* Theme init hook. */
		do_action( "{$this->prefix}_init" );
	}

	/**
	 * Defines the constant paths for use within the core framework, parent theme, and
	 * child theme.  Constants prefixed with 'HYBRID_' are for use only within the core
	 * framework and don't reference other areas of the theme.
	 *
	 * @since 0.7
	 */
	function constants() {
		/* Sets the path to the parent theme directory. */
		define( 'THEME_DIR', get_template_directory() );

		/* Sets the path to the parent theme directory URI. */
		define( 'THEME_URI', get_template_directory_uri() );

		/* Sets the path to the child theme directory. */
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

		/* Sets the path to the child theme directory URI. */
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		/* Sets the path to the core framework directory. */
		define( 'HYBRID_DIR', THEME_DIR . '/library' );

		/* Sets the path to the core framework directory URI. */
		define( 'HYBRID_URI', THEME_URI . '/library' );

		/* Sets the path to the core framework admin directory. */
		define( 'HYBRID_ADMIN', HYBRID_DIR . '/admin' );

		/* Sets the path to the core framework classes directory. */
		define( 'HYBRID_CLASSES', HYBRID_DIR . '/classes' );

		/* Sets the path to the core framework extensions directory. */
		define( 'HYBRID_EXTENSIONS', HYBRID_DIR . '/extensions' );

		/* Sets the path to the core framework functions directory. */
		define( 'HYBRID_FUNCTIONS', HYBRID_DIR . '/functions' );

		/* Sets the path to the core framework legacy directory. */
		define( 'HYBRID_LEGACY', HYBRID_DIR . '/legacy' );

		/* Sets the path to the core framework images directory URI. */
		define( 'HYBRID_IMAGES', HYBRID_URI . '/images' );

		/* Sets the path to the core framework CSS directory URI. */
		define( 'HYBRID_CSS', HYBRID_URI . '/css' );

		/* Sets the path to the core framework JavaScript directory URI. */
		define( 'HYBRID_JS', HYBRID_URI . '/js' );
	}

	/**
	 * Loads the core theme functions.
	 *
	 * @since 0.7
	 */
	function functions() {
		require_once( HYBRID_FUNCTIONS . '/core.php' );
		require_once( HYBRID_FUNCTIONS . '/hooks-actions.php' );
		require_once( HYBRID_FUNCTIONS . '/hooks-filters.php' );
		require_once( HYBRID_FUNCTIONS . '/comments.php' );
		require_once( HYBRID_FUNCTIONS . '/context.php' );
		require_once( HYBRID_FUNCTIONS . '/media.php' );
		require_once( HYBRID_FUNCTIONS . '/shortcodes.php' );
		require_once( HYBRID_FUNCTIONS . '/template.php' );
		require_once( HYBRID_FUNCTIONS . '/widgets.php' );

		/* Load the Hybrid theme functions if it's the parent theme. */
		if ( 'hybrid' == get_template() )
			require_once( HYBRID_FUNCTIONS . '/defaults.php' );

		/* Menus compatibility. */
		if ( hybrid_get_setting( 'use_menus' ) || 'hybrid' !== get_template() )
			require_once( HYBRID_FUNCTIONS . '/menus.php' );
	}

	/**
	 * Load extensions (external projects).  Themes must use add_theme_support( $extension ) to
	 * use a specific extension within the theme.  This should be declared on 'after_setup_theme' no
	 * later than the default priority of 10.
	 *
	 * @since 0.7
	 */
	function extensions() {

		/* Load the Breadcrumb Trail extension if supported. */
		if ( current_theme_supports( 'breadcrumb-trail' ) )
			require_once( HYBRID_EXTENSIONS . '/breadcrumb-trail.php' );

		/* Load the Custom Field Series extension if supported. */
		if ( current_theme_supports( 'custom-field-series' ) )
			require_once( HYBRID_EXTENSIONS . '/custom-field-series.php' );

		/* Load the Get the Image extension if supported. */
		if ( current_theme_supports( 'get-the-image' ) )
			require_once( HYBRID_EXTENSIONS . '/get-the-image.php' );

		/* Load the Get the Object extension if supported. */
		if ( current_theme_supports( 'get-the-object' ) )
			require_once( HYBRID_EXTENSIONS . '/get-the-object.php' );

		/* Load the Pagination extension if supported. */
		if ( current_theme_supports( 'loop-pagination' ) )
			require_once( HYBRID_EXTENSIONS . '/pagination.php' );

		/* Load the Entry Views extension if supported. */
		if ( current_theme_supports( 'entry-views' ) )
			require_once( HYBRID_EXTENSIONS . '/entry-views.php' );
	}

	/**
	 * Load legacy functions for backwards compatibility.
	 *
	 * @since 0.7
	 */
	function legacy() {
		require_once( HYBRID_LEGACY . '/deprecated.php' );
	}

	/**
	 * Load admin files.
	 *
	 * @since 0.7
	 */
	function admin() {
		if ( is_admin() ) {
			require_once( HYBRID_ADMIN . '/admin.php' );
			require_once( HYBRID_ADMIN . '/meta-box.php' );
			require_once( HYBRID_ADMIN . '/settings-page.php' );
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
		if ( current_theme_supports( 'hybrid-core-seo' ) ) {
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
	}

	/**
	 * Adds the default theme filters.
	 *
	 * @since 0.7
	 */
	function filters() {
		/* Filter the textdomain mofile to allow child themes to load the parent theme translation. */
		add_filter( 'load_textdomain_mofile', 'hybrid_load_textdomain', 10, 2 );

		/* Add same filters to user description as term descriptions. */
		add_filter( 'get_the_author_description', 'wptexturize' );
		add_filter( 'get_the_author_description', 'convert_chars' );
		add_filter( 'get_the_author_description', 'wpautop' );
		add_filter( 'get_the_author_description', 'shortcode_unautop' );

		/* Make text widgets, term descriptions, and user descriptions shortcode aware. */
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'term_description', 'do_shortcode' );
		add_filter( 'get_the_author_description', 'do_shortcode' );

		/* Stylesheet filters. */
		add_filter( 'stylesheet_uri', 'hybrid_post_stylesheets', 10, 2 );

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