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
		<?php hybrid_after_container(); // After container hook ?>

	</div><!-- #container -->

	<div id="footer-container">

		<?php hybrid_before_footer(); // Before footer hook ?>

		<div id="footer">

			<?php hybrid_footer(); // Hybrid footer hook ?>

		</div><!-- #footer -->

		<?php hybrid_after_footer(); // After footer hook ?>

	</div><!-- #footer-container -->

</div><!-- #body-container -->

<?php wp_footer(); // WordPress footer hook ?>
<?php hybrid_after_html(); // After HTML hook ?>

</body>
</html>