<?php
/**
 * Before Content Utility
 *
 * The Before Content Utility template houses the HTML used for the 'Utility: Before Content' 
 * widget area. It will first check if the widget area is active before displaying anything.
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 *
 * @package Hybrid
 * @subpackage Template
 */

	if ( is_active_sidebar( 'utility-before-content' ) ) : ?>

		<div id="utility-before-content" class="sidebar utility">

			<?php dynamic_sidebar( 'utility-before-content' ); ?>

		</div><!-- #utility-before-content .utility -->

	<?php endif; ?>