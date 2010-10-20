<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package Hybrid
 * @subpackage Template
 */
?>
		<?php do_atomic( 'after_container' ); // After container hook ?>

	</div><!-- #container -->

	<div id="footer-container">

		<?php do_atomic( 'before_footer' ); // Before footer hook ?>

		<div id="footer">

			<?php do_atomic( 'footer' ); // Hybrid footer hook ?>

		</div><!-- #footer -->

		<?php do_atomic( 'after_footer' ); // After footer hook ?>

	</div><!-- #footer-container -->

</div><!-- #body-container -->

<?php do_atomic( 'after_html' ); // After HTML hook ?>
<?php wp_footer(); // WordPress footer hook ?>

</body>
</html>