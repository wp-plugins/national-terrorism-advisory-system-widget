<?php
/**
 * Plugin Name: National Terrorism Advisory System Widget
 * Plugin URI: http://wordpress.eagleflint.com/plugins/ntas.php
 * Description: A widget that populates the current National Terrorism Advisory System widget on your website.
 * Version: 0.1.0
 * Date: 2011-05-02
 * Author: Flint Gatrell, N0FHG
 * Author URI: http://eagleflint.com
 * Copyright: 2011 by Flint Gatrell
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'ntas_load_widgets' );

/**
 * Register our widget.
 * 'NTAS_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function ntas_load_widgets() {
	register_widget( 'NTAS_Widget' );
}

/**
 * National Terrorism Advisory System Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class NTAS_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function NTAS_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ntas', 'description' => __('A widget that populates the current National Terrorism Advisory System widget on your website.', 'ntas') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ntas-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'ntas-widget', __('National Terrorism Advisory System Widget', 'ntas'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$ntastitle = apply_filters('widget_title', $instance['ntastitle'] );
		$ntaswidgetheight = $instance['ntaswidgetheight'];
		$ntaswidgetwidth = $instance['ntaswidgetwidth'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $ntastitle )
			echo $before_title . $ntastitle . $after_title;

		/* Display control from widget settings. */
		if ($ntaswidgetwidth && $ntaswidgetheight) {
			printf( '<iframe name="National Terrorism Advisory System" border="0" width="'.__('%1$s', 'ntas').'"', $ntaswidgetwidth );
			printf( 'height="'.__('%1$s', 'ntas').'"', $ntaswidgetheight );
			echo('scrolling="no" src="http://www.dhs.gov/ntas/" align="center"></iframe>');
		} else {
			echo('Widget settings not defined! Navigate to the "Plugins" page in your dashboard to define these settings.');
		}
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['ntastitle'] = strip_tags( $new_instance['ntastitle'] );
		$instance['ntaswidgetheight'] = strip_tags( $new_instance['ntaswidgetheight'] );
		$instance['ntaswidgetwidth'] = strip_tags( $new_instance['ntaswidgetwidth'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'ntastitle' => __('Terror Advisory', 'ntas'), 'ntaswidgetheight' => __('180', 'ntas'), 'ntaswidgetwidth' => __('170', 'ntas') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ntastitle' ); ?>"><?php _e('Title:', 'ntas'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ntastitle' ); ?>" name="<?php echo $this->get_field_name( 'ntastitle' ); ?>" value="<?php echo $instance['ntastitle']; ?>" style="width:100%;" />
		</p>

		<!-- Widget Width: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ntaswidgetwidth' ); ?>"><?php _e('Widget Width:', 'ntas'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ntaswidgetwidth' ); ?>" name="<?php echo $this->get_field_name( 'ntaswidgetwidth' ); ?>" value="<?php echo $instance['ntaswidgetwidth']; ?>" style="width:100%;" />
		</p>

		<!-- Widget Height: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ntaswidgetheight' ); ?>"><?php _e('Widget Height:', 'ntas'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ntaswidgetheight' ); ?>" name="<?php echo $this->get_field_name( 'ntaswidgetheight' ); ?>" value="<?php echo $instance['ntaswidgetheight']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>