<?php
/**
 * After Singular Sidebar Template
 *
 * The After Singular sidebar template houses the HTML used for the 'Utility: After Singular' 
 * sidebar. It will first check if the sidebar is active before displaying anything.
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