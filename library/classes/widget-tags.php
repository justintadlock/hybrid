<?php
/**
 * Tags Widget Class
 *
 * The Tags widget replaces the default WordPress Tag Cloud widget. This version gives total
 * control over the output to the user by allowing the input of all the arguments typically seen
 * in the wp_tag_cloud() function.
 *
 * @since 0.6
 * @link http://codex.wordpress.org/Template_Tags/wp_tag_cloud
 * @link http://themehybrid.com/themes/hybrid/widgets
 *
 * @package Hybrid
 * @subpackage Widgets
 */

class Hybrid_Widget_Tags extends WP_Widget {

	var $prefix;
	var $textdomain;

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.6
	 */
	function Hybrid_Widget_Tags() {
		$this->prefix = hybrid_get_prefix();
		$this->textdomain = hybrid_get_textdomain();

		$widget_ops = array( 'classname' => 'tags', 'description' => __( 'An advanced widget that gives you total control over the output of your tags.',$this->textdomain ) );
		$control_ops = array( 'width' => 800, 'height' => 350, 'id_base' => "{$this->prefix}-tags" );
		$this->WP_Widget( "{$this->prefix}-tags", __( 'Tags', $this->textdomain ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 * @since 0.6
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Set up some variables. */
		$largest = (int)$instance['largest'];
		$smallest = (int)$instance['smallest'];
		$number = (int)$instance['number'];
		$child_of = (int)$instance['child_of'];
		$parent = ( $instance['parent'] ) ? (int)$instance['parent'] : '';
		$separator = ( $instance['separator'] ) ? $instance['separator'] : "\n";
		$pad_counts = isset( $instance['pad_counts'] ) ? $instance['pad_counts'] : false;
		$hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : false;

		/* If no $largest or $smallest is given, set them to the default. */
		if ( !$largest )
			$largest = 22;
		if ( !$smallest )
			$smallest = 8;

		/* Set up the array of arguments to pass to wp_tag_cloud(). */
		$args = array(
			'taxonomy' => $instance['taxonomy'],
			'smallest' => $smallest,
			'largest' => $largest,
			'unit' => $instance['unit'],
			'number' => $number,
			'format' => $instance['format'],
			'orderby' => $instance['orderby'],
			'order' => $instance['order'],
			'exclude' => $instance['exclude'],
			'include' => $instance['include'],
			'link' => $instance['link'],
			'separator' => $separator,
			'search' => $instance['search'],
			'pad_counts' => $pad_counts,
			'child_of' => $child_of,
			'parent' => $parent,
			'name__like' => $instance['name__like'],
			'hide_empty' => $hide_empty,
			'echo' => 0,
		);

		/* Open the output of the widget. */
		echo $before_widget;

		/* If there is a title given, add it along with the $before_title and $after_title variables. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;

		/* If $format should be flat, wrap it in the <p> element. */
		if ( 'flat' == $instance['format'] ) {
			echo '<p class="' . $instance['taxonomy'] . '-cloud term-cloud">';
			echo str_replace( array( "\r", "\n", "\t" ), ' ', wp_tag_cloud( $args ) );
			echo '</p><!-- .term-cloud -->';
		}

		/* If $format is not flat, just output the terms list. */
		else {
			echo str_replace( array( "\r", "\n", "\t" ), ' ', wp_tag_cloud( $args ) );
		}

		/* Close the output of the widget. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 * @since 0.6
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['smallest'] = strip_tags( $new_instance['smallest'] );
		$instance['largest'] = strip_tags( $new_instance['largest'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['exclude'] = strip_tags( $new_instance['exclude'] );
		$instance['include'] = strip_tags( $new_instance['include'] );
		$instance['separator'] = strip_tags( $new_instance['separator'] );
		$instance['name__like'] = strip_tags( $new_instance['name__like'] );
		$instance['search'] = strip_tags( $new_instance['search'] );
		$instance['child_of'] = strip_tags( $new_instance['child_of'] );
		$instance['parent'] = strip_tags( $new_instance['parent'] );
		$instance['unit'] = $new_instance['unit'];
		$instance['format'] = $new_instance['format'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['taxonomy'] = $new_instance['taxonomy'];
		$instance['link'] = $new_instance['link'];
		$instance['pad_counts'] = ( isset( $new_instance['pad_counts'] ) ? 1 : 0 );
		$instance['hide_empty'] = ( isset( $new_instance['hide_empty'] ) ? 1 : 0 );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 * @since 0.6
	 */
	function form( $instance ) {

		/* Set up some defaults for the widget. */
		$defaults = array( 'title' => __( 'Tags', $this->textdomain ), 'format' => 'flat', 'unit' => 'pt', 'smallest' => 8, 'largest' => 22, 'link' => 'view', 'number' => 45, 'taxonomy' => 'post_tag', 'hide_empty' => 1 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:31%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $this->textdomain ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Taxonomy:', $this->textdomain ); ?> <code>taxonomy</code></label> 
			<select id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" class="widefat" style="width:100%;">
			<?php global $wp_taxonomies; ?>
			<?php if ( is_array( $wp_taxonomies ) ) : ?>
				<?php foreach( $wp_taxonomies as $tax ) : ?>
					<option <?php if ( $tax->name == $instance['taxonomy'] ) echo 'selected="selected"'; ?>><?php echo $tax->name; ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', $this->textdomain ); ?> <code>link</code></label> 
			<select id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'view' == $instance['link'] ) echo 'selected="selected"'; ?>>view</option>
				<option <?php if ( 'edit' == $instance['link'] ) echo 'selected="selected"'; ?>>edit</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'format' ); ?>"><?php _e( 'Format:', $this->textdomain ); ?> <code>format</code></label> 
			<select id="<?php echo $this->get_field_id( 'format' ); ?>" name="<?php echo $this->get_field_name( 'format' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'flat' == $instance['format'] ) echo 'selected="selected"'; ?>>flat</option>
				<option <?php if ( 'list' == $instance['format'] ) echo 'selected="selected"'; ?>>list</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', $this->textdomain ); ?> <code>order</code></label> 
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'ASC' == $instance['order'] ) echo 'selected="selected"'; ?>>ASC</option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo 'selected="selected"'; ?>>DESC</option>
				<option <?php if ( 'RAND' == $instance['order'] ) echo 'selected="selected"'; ?>>RAND</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', $this->textdomain ); ?> <code>orderby</code></label> 
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'name' == $instance['orderby'] ) echo 'selected="selected"'; ?>>name</option>
				<option <?php if ( 'count' == $instance['orderby'] ) echo 'selected="selected"'; ?>>count</option>
			</select>
		</p>
		</div>

		<div style="float:left;width:31%;margin-left:3.5%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number:', $this->textdomain ); ?> <code>number</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'largest' ); ?>"><?php _e( 'Largest:', $this->textdomain ); ?> <code>largest</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'largest' ); ?>" name="<?php echo $this->get_field_name( 'largest' ); ?>" value="<?php echo $instance['largest']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'smallest' ); ?>"><?php _e( 'Smallest:', $this->textdomain ); ?> <code>smallest</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'smallest' ); ?>" name="<?php echo $this->get_field_name( 'smallest' ); ?>" value="<?php echo $instance['smallest']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'unit' ); ?>"><?php _e( 'Unit:', $this->textdomain ); ?> <code>unit</code></label> 
			<select id="<?php echo $this->get_field_id( 'unit' ); ?>" name="<?php echo $this->get_field_name( 'unit' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'pt' == $instance['unit'] ) echo 'selected="selected"'; ?>>pt</option>
				<option <?php if ( 'px' == $instance['unit'] ) echo 'selected="selected"'; ?>>px</option>
				<option <?php if ( 'em' == $instance['unit'] ) echo 'selected="selected"'; ?>>em</option>
				<option <?php if ( '%' == $instance['unit'] ) echo 'selected="selected"'; ?>>%</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e( 'Exclude:', $this->textdomain ); ?> <code>exclude</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e( 'Include:', $this->textdomain ); ?> <code>include</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:100%;" />
		</p>
		</div>

		<div style="float:right;width:31%;margin-left:3.5%;">
		<p>
			<label for="<?php echo $this->get_field_id( 'separator' ); ?>"><?php _e( 'Separator:', $this->textdomain ); ?> <code>separator</code></label>
			<input type="text" id="<?php echo $this->get_field_id( 'separator' ); ?>" name="<?php echo $this->get_field_name( 'separator' ); ?>" value="<?php echo $instance['separator']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'search' ); ?>"><?php _e( 'Search:', $this->textdomain ); ?> <code>search</code></label>
			<input id="<?php echo $this->get_field_id( 'search' ); ?>" name="<?php echo $this->get_field_name( 'search' ); ?>" type="text" value="<?php echo $instance['search']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'name__like' ); ?>"><?php _e( 'Name Like:', $this->textdomain ); ?> <code>name__like</code></label>
			<input id="<?php echo $this->get_field_id( 'name__like' ); ?>" name="<?php echo $this->get_field_name( 'name__like' ); ?>" type="text" value="<?php echo $instance['name__like']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'child_of' ); ?>"><?php _e( 'Child Of:', $this->textdomain ); ?> <code>child_of</code></label>
			<input id="<?php echo $this->get_field_id( 'child_of' ); ?>" name="<?php echo $this->get_field_name( 'child_of' ); ?>" type="text" value="<?php echo $instance['child_of']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'parent' ); ?>"><?php _e( 'Parent:', $this->textdomain ); ?> <code>parent</code></label>
			<input id="<?php echo $this->get_field_id( 'parent' ); ?>" name="<?php echo $this->get_field_name( 'parent' ); ?>" type="text" value="<?php echo $instance['parent']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'pad_counts' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['pad_counts'], true ); ?> id="<?php echo $this->get_field_id( 'pad_counts' ); ?>" name="<?php echo $this->get_field_name( 'pad_counts' ); ?>" /> <?php _e( 'Pad counts?', $this->textdomain ); ?> <code>pad_counts</code></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
			<input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], true ); ?> id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" /> <?php _e( 'Hide empty?', $this->textdomain ); ?> <code>hide_empty</code></label>
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>