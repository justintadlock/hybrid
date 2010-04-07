<?php
/**
 * Bookmarks Widget Class
 *
 * The Bookmarks widget replaces the default WordPress Links widget. This version gives total
 * control over the output to the user by allowing the input of all the arguments typically seen
 * in the wp_list_bookmarks() function.
 *
 * @since 0.6
 * @link http://codex.wordpress.org/Template_Tags/wp_list_bookmarks
 * @link http://themehybrid.com/themes/hybrid/widgets
 *
 * @package Hybrid
 * @subpackage Classes
 */

class Hybrid_Widget_Bookmarks extends WP_Widget {

	var $prefix;
	var $textdomain;

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.6
	 */
	function Hybrid_Widget_Bookmarks() {
		$this->prefix = hybrid_get_prefix();
		$this->textdomain = hybrid_get_textdomain();

		$widget_ops = array( 'classname' => 'bookmarks', 'description' => __( 'An advanced widget that gives you total control over the output of your bookmarks (links).', $this->textdomain ) );
		$control_ops = array( 'width' => 800, 'height' => 350, 'id_base' => "{$this->prefix}-bookmarks" );
		$this->WP_Widget( "{$this->prefix}-bookmarks", __( 'Bookmarks', $this->textdomain ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 * @since 0.6
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$title_li = apply_filters( 'widget_title', $instance['title_li'] );
		$category = $instance['category'];
		$category_name = $instance['category_name'];
		$category_order = $instance['category_order'];
		$category_orderby = $instance['category_orderby'];
		$exclude_category = $instance['exclude_category'];
		$limit = (int)$instance['limit'];
		$include = $instance['include'];
		$exclude = $instance['exclude'];
		$orderby = $instance['orderby'];
		$order = $instance['order'];
		$between = $instance['between'];
		$class = $instance['class'];
		$link_before = $instance['link_before'];
		$link_after = $instance['link_after'];
		$search = $instance['search'];

		$categorize = isset( $instance['categorize'] ) ? $instance['categorize'] : false;
		$show_description = isset( $instance['show_description'] ) ? $instance['show_description'] : false;
		$hide_invisible = isset( $instance['hide_invisible'] ) ? $instance['hide_invisible'] : false;
		$show_rating = isset( $instance['show_rating'] ) ? $instance['show_rating'] : false;
		$show_updated = isset( $instance['show_updated'] ) ? $instance['show_updated'] : false;
		$show_images = isset( $instance['show_images'] ) ? $instance['show_images'] : false;
		$show_name = isset( $instance['show_name'] ) ? $instance['show_name'] : false;
		$show_private = isset( $instance['show_private'] ) ? $instance['show_private'] : false;

		if ( $categorize )
			$before_widget = preg_replace( '/id="[^"]*"/','id="%id"', $before_widget );
		if ( $class )
			$before_widget = str_replace( 'class="', 'class="' . $class . ' ', $before_widget );

		if ( !$limit )
			$limit = -1;

		if ( $category_name )
			$category = intval( $category_name );

		$args = array(
			'orderby' => $orderby,
			'order' => $order,
			'limit' => $limit,
			'include' => $include,
			'exclude' => $exclude,
			'hide_invisible' => $hide_invisible,
			'show_rating' => $show_rating,
			'show_updated' => $show_updated,
			'show_description' => $show_description,
			'show_images' => $show_images,
			'show_name' => $show_name,
			'between' => ' ' . $between,
			'categorize' => $categorize,
			'category' => $category,
			'exclude_category' => $exclude_category,
			'show_private' => $show_private,
			'category_orderby' => $category_orderby,
			'category_order' => $category_order,
			'title_li' => $title_li,
			'title_before' => $before_title,
			'title_after' => $after_title,
			'category_before' => $before_widget,
			'category_after' => $after_widget,
			'link_before' => $link_before,
			'link_after' => $link_after,
			'class' => $class,
			'category_name' => false,	// Uses category instead
			'search' => $search,
			'echo' => 0,
		);

		echo str_replace( array( "\r", "\n", "\t" ), '', wp_list_bookmarks( $args ) );
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 * @since 0.6
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title_li'] = strip_tags( $new_instance['title_li'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['exclude_category'] = strip_tags( $new_instance['exclude_category'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['class'] = strip_tags( $new_instance['class'] );
		$instance['include'] = strip_tags( $new_instance['include'] );
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['search'] = strip_tags( $new_instance['search'] );
		$instance['category_name'] = $new_instance['category_name'];
		$instance['category_order'] = $new_instance['category_order'];
		$instance['category_orderby'] = $new_instance['category_orderby'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['between'] = $new_instance['between'];
		$instance['link_before'] = $new_instance['link_before'];
		$instance['link_after'] = $new_instance['link_after'];

		$instance['categorize'] = ( isset( $new_instance['categorize'] ) ? 1 : 0 );
		$instance['hide_invisible'] = ( isset( $new_instance['hide_invisible'] ) ? 1 : 0 );
		$instance['show_private'] = ( isset( $new_instance['show_private'] ) ? 1 : 0 );
		$instance['show_rating'] = ( isset( $new_instance['show_rating'] ) ? 1 : 0 );
		$instance['show_updated'] = ( isset( $new_instance['show_updated'] ) ? 1 : 0 );
		$instance['show_images'] = ( isset( $new_instance['show_images'] ) ? 1 : 0 );
		$instance['show_name'] = ( isset( $new_instance['show_name'] ) ? 1 : 0 );
		$instance['show_description'] = ( isset( $new_instance['show_description'] ) ? 1 : 0 );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 * @since 0.6
	 */
	function form( $instance ) {

		//Defaults
		$defaults = array( 'title_li' => __( 'Bookmarks', $this->textdomain ), 'categorize' => true, 'hide_invisible' => true, 'show_description' => false, 'show_image' => false, 'show_rating' => false, 'show_updated' => false, 'show_private' => false, 'show_name' => false, 'class' => 'linkcat', 'link_before' => '<span>', 'link_after' => '</span>' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$link_cats = get_categories( array( 'type' => 'link' ) );
		$link_cats[] = false; ?>

		<div style="float:left;width:31%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title_li' ); ?>"><?php _e( 'Title:', $this->textdomain ); ?> <code>title_li</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title_li' ); ?>" name="<?php echo $this->get_field_name( 'title_li' ); ?>" value="<?php echo $instance['title_li']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Categories:', $this->textdomain ); ?> <code>category</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo $instance['category']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_category' ); ?>"><?php _e( 'Exclude categories:', $this->textdomain ); ?> <code>category</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'exclude_category' ); ?>" name="<?php echo $this->get_field_name( 'exclude_category' ); ?>" value="<?php echo $instance['exclude_category']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category_name' ); ?>"><?php _e( 'Category:',$this->textdomain ); ?> <code>category_name</code>	</label>
			<select id="<?php echo $this->get_field_id( 'category_name' ); ?>" name="<?php echo $this->get_field_name( 'category_name' ); ?>" class="widefat" style="width:100%;">
			<?php foreach ( $link_cats as $cat ) { ?>
				<option <?php if ( $cat->term_id == $instance['category_name'] ) echo ' selected="selected"'; ?> value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category_order' ); ?>"><?php _e( 'Category Order:',$this->textdomain ); ?> <code>category_order</code></label> 
			<select id="<?php echo $this->get_field_id( 'category_order' ); ?>" name="<?php echo $this->get_field_name( 'category_order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['category_order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['category_order'] ) echo 'selected="selected"'; ?>>DESC</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category_orderby' ); ?>"><?php _e( 'Category Orderby:',$this->textdomain ); ?> <code>category_orderby</code></label> 
			<select id="<?php echo $this->get_field_id( 'category_orderby' ); ?>" name="<?php echo $this->get_field_name( 'category_orderby' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'name' == $instance['category_orderby'] ) echo 'selected="selected"'; ?>>name</option>
				<option <?php if ( 'id' == $instance['category_orderby'] ) echo 'selected="selected"'; ?>>id</option>
				<option <?php if ( 'slug' == $instance['category_orderby'] ) echo 'selected="selected"'; ?>>slug</option>
				<option <?php if ( 'count' == $instance['category_orderby'] ) echo 'selected="selected"'; ?>>count</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'Class:', $this->textdomain ); ?> <code>class</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" value="<?php echo $instance['class']; ?>" style="width:100%;" />
		</p>

		</div>

		<div style="float:left;width:31%;margin-left:3.5%;">

		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', $this->textdomain ); ?> <code>limit</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo $instance['limit']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e( 'Include Bookmarks:', $this->textdomain ); ?> <code>include</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e( 'Exclude Bookmarks:', $this->textdomain ); ?> <code>exclude</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Bookmarks Order:',$this->textdomain ); ?> <code>order</code></label> 
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo 'selected="selected"'; ?>>DESC</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Bookmarks Orderby:',$this->textdomain ); ?> <code>orderby</code></label> 
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'name' == $instance['orderby'] ) echo 'selected="selected"'; ?>>name</option>
				<option <?php if ( 'id' == $instance['orderby'] ) echo 'selected="selected"'; ?>>id</option>
				<option <?php if ( 'url' == $instance['orderby'] ) echo 'selected="selected"'; ?>>url</option>
				<option <?php if ( 'target' == $instance['orderby'] ) echo 'selected="selected"'; ?>>target</option>
				<option <?php if ( 'description' == $instance['orderby'] ) echo 'selected="selected"'; ?>>description</option>
				<option <?php if ( 'owner' == $instance['orderby'] ) echo 'selected="selected"'; ?>>owner</option>
				<option <?php if ( 'rating' == $instance['orderby'] ) echo 'selected="selected"'; ?>>rating</option>
				<option <?php if ( 'updated' == $instance['orderby'] ) echo 'selected="selected"'; ?>>updated</option>
				<option <?php if ( 'rel' == $instance['orderby'] ) echo 'selected="selected"'; ?>>rel</option>
				<option <?php if ( 'notes' == $instance['orderby'] ) echo 'selected="selected"'; ?>>notes</option>
				<option <?php if ( 'rss' == $instance['orderby'] ) echo 'selected="selected"'; ?>>rss</option>
				<option <?php if ( 'length' == $instance['orderby'] ) echo 'selected="selected"'; ?>>length</option>
				<option <?php if ( 'rand' == $instance['orderby'] ) echo 'selected="selected"'; ?>>rand</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'between' ); ?>"><?php _e( 'Between:', $this->textdomain ); ?> <code>between</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'between' ); ?>" name="<?php echo $this->get_field_name( 'between' ); ?>" value="<?php echo $instance['between']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'search' ); ?>"><?php _e( 'Search:', $this->textdomain ); ?> <code>search</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" value="<?php echo $instance['search']; ?>" style="width:100%;" />
		</p>

		</div>

		<div style="float:right;width:31%;margin-left:3.5%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'link_before' ); ?>"><?php _e( 'Before Link:', $this->textdomain ); ?> <code>link_before</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'link_before' ); ?>" name="<?php echo $this->get_field_name( 'link_before' ); ?>" value="<?php echo $instance['link_before']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_after' ); ?>"><?php _e( 'After Link:', $this->textdomain ); ?> <code>link_after</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'link_after' ); ?>" name="<?php echo $this->get_field_name( 'link_after' ); ?>" value="<?php echo $instance['link_after']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'categorize' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['categorize'], true ); ?> id="<?php echo $this->get_field_id( 'categorize' ); ?>" name="<?php echo $this->get_field_name( 'categorize' ); ?>" /> <?php _e( 'Categorize?', $this->textdomain ); ?> <code>categorize</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_description' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_description'], true ); ?> id="<?php echo $this->get_field_id( 'show_description' ); ?>" name="<?php echo $this->get_field_name( 'show_description' ); ?>" /> <?php _e( 'Show description?', $this->textdomain ); ?> <code>show_description</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_invisible' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hide_invisible'], true ); ?> id="<?php echo $this->get_field_id( 'hide_invisible' ); ?>" name="<?php echo $this->get_field_name( 'hide_invisible' ); ?>" /> <?php _e( 'Hide invisible?', $this->textdomain ); ?> <code>hide_invisible</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_rating' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_rating'], true ); ?> id="<?php echo $this->get_field_id( 'show_rating' ); ?>" name="<?php echo $this->get_field_name( 'show_rating' ); ?>" /> <?php _e( 'Show rating?', $this->textdomain ); ?> <code>show_rating</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_updated' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_updated'], true ); ?> id="<?php echo $this->get_field_id( 'show_updated' ); ?>" name="<?php echo $this->get_field_name( 'show_updated' ); ?>" /> <?php _e( 'Show updated?', $this->textdomain ); ?> <code>show_updated</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> <?php _e( 'Show images?', $this->textdomain ); ?> <code>show_images</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_name' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_name'], true ); ?> id="<?php echo $this->get_field_id( 'show_name' ); ?>" name="<?php echo $this->get_field_name( 'show_name' ); ?>" /> <?php _e( 'Show name?', $this->textdomain ); ?> <code>show_name</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_private' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_private'], true ); ?> id="<?php echo $this->get_field_id( 'show_private' ); ?>" name="<?php echo $this->get_field_name( 'show_private' ); ?>" /> <?php _e( 'Show private?', $this->textdomain ); ?> <code>show_private</code></label>
		</p>

		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>