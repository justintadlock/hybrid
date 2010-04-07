<?php
/**
 * Subsidiary Aside Template
 *
 * The Subsidiary Aside template houses the HTML used for the 'Subsidiary' widget area.
 * It will first check if the widget area is active before displaying anything.
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 *
 * @package Hybrid
 * @subpackage Template
 */

if ( is_active_sidebar( 'subsidiary' ) ) : ?>

	<div id="subsidiary" class="sidebar aside">

		<?php hybrid_before_subsidiary(); // Before Subsidiary hook ?>

		<?php dynamic_sidebar( 'subsidiary' ); ?>

		<?php hybrid_after_subsidiary(); // After Subsidiary hook ?>

	</div><!-- #subsidiary .aside -->

<?php endif; ?>