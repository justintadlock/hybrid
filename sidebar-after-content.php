<?php
/**
 * After Content Utility
 *
 * The After Content Utility template houses the HTML used for the 'Utility: After Content' 
 * widget area. It will first check if the widget area is active before displaying anything.
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 *
 * @package Hybrid
 * @subpackage Template
 */

	if ( is_active_sidebar( 'utility-after-content' ) ) : ?>

		<div id="utility-after-content" class="sidebar utility">

			<?php dynamic_sidebar( 'utility-after-content' ); ?>

		</div><!-- #utility-after-content .utility -->

	<?php endif; ?>