<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the top of the file. It is used mostly as an opening
 * wrapper, which is closed with the footer.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package Hybrid
 * @subpackage Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php hybrid_document_title(); ?></title>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
<link rel="pingback" href="http://localhost/xmlrpc.php" />

<?php do_atomic( 'head' ); // @deprecated 0.9. Use 'wp_head'. ?>
<?php wp_head(); // WP head hook ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

<?php do_atomic( 'before_html' ); // Before HTML hook ?>

<div id="body-container">

	<?php do_atomic( 'before_header' ); // Before header hook ?>

	<div id="header-container">

		<div id="header">

			<?php do_atomic( 'header' ); // Header hook ?>

		</div><!-- #header -->

	</div><!-- #header-container -->

	<?php do_atomic( 'after_header' ); // After header hook ?>

	<div id="container">

		<?php do_atomic( 'before_container' ); // Before container hook ?>