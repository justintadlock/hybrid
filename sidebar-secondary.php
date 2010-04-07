<?php
/**
 * Secondary Aside Template
 *
 * The Secondary Aside template houses the HTML used for the 'Secondary' widget area.
 * It will first check if the widget area is active before displaying anything.
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 *
 * @package Hybrid
 * @subpackage Template
 */

if ( is_active_sidebar( 'secondary' ) ) : ?>

	<div id="secondary" class="sidebar aside">

		<?php hybrid_before_secondary(); // Before Secondary hook ?>

		<?php dynamic_sidebar( 'secondary' ); ?>

		<?php hybrid_after_secondary(); // After Secondary hook ?>

	</div><!-- #secondary .aside -->

<?php endif; ?>