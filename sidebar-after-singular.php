<?php
/**
 * After Singular Utility
 *
 * The After Singular Utility template houses the HTML used for the 'Utility: After Singular' 
 * widget area. It will first check if the widget area is active before displaying anything.
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 *
 * @package Hybrid
 * @subpackage Template
 */

	if ( is_active_sidebar( 'utility-after-singular' ) ) : ?>

		<div id="utility-after-singular" class="sidebar utility">

			<?php dynamic_sidebar( 'utility-after-singular' ); ?>

		</div><!-- #utility-after-singular .utility -->

	<?php endif; ?>