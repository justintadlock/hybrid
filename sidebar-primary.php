<?php
/**
 * Primary Aside Template
 *
 * The Primary Aside template houses the HTML used for the 'Primary' widget area.
 * It will first check if the widget area is active before displaying anything.
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 *
 * @package Hybrid
 * @subpackage Template
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<div id="primary" class="sidebar aside">

		<?php hybrid_before_primary(); // Before Primary hook ?>

		<?php dynamic_sidebar( 'primary' ); ?>

		<?php hybrid_after_primary(); // After Primary hook ?>

	</div><!-- #primary .aside -->

<?php endif; ?>