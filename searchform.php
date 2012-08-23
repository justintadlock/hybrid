<?php
/**
 * Search Form Template
 *
 * The search form template displays the search form.
 *
 * @package Hybrid
 * @subpackage Template
 */

	global $search_num;
	++$search_num;
?>
			<div id="search<?php if ( $search_num ) echo "-{$search_num}"; ?>" class="search">

				<form method="get" class="search-form" id="search-form<?php if ( $search_num ) echo "-{$search_num}"; ?>" action="<?php echo trailingslashit( home_url() ); ?>">
				<div>
					<input class="search-text" type="text" name="s" id="search-text<?php if ( $search_num)  echo "-{$search_num}"; ?>" value="<?php if ( is_search() ) echo esc_attr( get_search_query() ); else esc_attr_e( 'Search this site...', 'hybrid' ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
					<input class="search-submit button" name="submit" type="submit" id="search-submit<?php if ( $search_num ) echo "-{$search_num}"; ?>" value="<?php esc_attr_e( 'Search', 'hybrid' ); ?>" />
				</div>
				</form><!-- .search-form -->

			</div><!-- .search -->