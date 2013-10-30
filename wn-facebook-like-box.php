<?php
/*
 * Plugin Name: WN Facebook Like Box 
 * Plugin URI: http://waister.me
 * Description: This widget is for you to add the Facebook Like Box plugin to your site.
 * Version: 1.1
 * Author: Waister Nunes
 * Author URI: http://waister.me
 * License: GPL2
 */
$wn_facebook_defaults = array(
	'title' => 'Facebook',
	'url' => 'https://www.facebook.com/facebook',
	'width' => '300',
	'height' => '271',
	'colorscheme' => 'light',
	'show_border' => 'true',
	'show_header' => 'false',
	'show_faces' => 'true',
	'show_stream' => 'false'
);
$theme->options['widgets_options']['facebook'] = isset($theme->options['widgets_options']['facebook']) ? array_merge($wn_facebook_defaults, $theme->options['widgets_options']['facebook']) : $wn_facebook_defaults;
add_action('widgets_init', create_function('', 'return register_widget("Wn_Facebook");'));


class Wn_Facebook extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_options = array('description' => __('This widget is for you to add the Facebook Like Box plugin to your site.', 'wn_facebook'));
		$control_options = array('width' => 430);
		$this->WP_Widget('wn_facebook', 'WN Facebook Like Box', $widget_options, $control_options);
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		global $wpdb, $theme;
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$url = $instance['url'];
		$width = $instance['width'];
		$height = $instance['height'];
		$colorscheme = $instance['colorscheme'];
		$show_faces = ($instance['show_faces'] == 'true') ? 'true' : 'false';
		$show_stream = ($instance['show_stream'] == 'true') ? 'true' : 'false';
		$show_header = ($instance['show_header'] == 'true') ? 'true' : 'false';
		$show_border = ($instance['show_border'] == 'true') ? 'true' : 'false';

		echo $args['before_widget'];
			if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			echo "<div class=\"fb-like-box\" data-href=\"{$url}\" data-width=\"{$width}\" data-height=\"{$height}\" data-colorscheme=\"{$colorscheme}\" data-show-faces=\"{$show_faces}\" data-header=\"{$show_header}\" data-stream=\"{$show_stream}\" data-show-border=\"{$show_border}\"></div>";

			echo "<div id=\"fb-root\"></div>";

			echo "<script>";
				echo "(function(d, s, id) {";
					echo "var js, fjs = d.getElementsByTagName(s)[0];";
					echo "if (d.getElementById(id)) return;";
					echo "js = d.createElement(s); js.id = id;";
					echo "js.src = '//connect.facebook.net/en_US/all.js#xfbml=1&appId=177837319002328';";
					echo "fjs.parentNode.insertBefore(js, fjs);";
				echo "}(document, 'script', 'facebook-jssdk'));";
			echo "</script>";

		echo $args['after_widget'];
	}


	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['colorscheme'] = strip_tags($new_instance['colorscheme']);
		$instance['show_faces'] = strip_tags($new_instance['show_faces']);
		$instance['show_stream'] = strip_tags($new_instance['show_stream']);
		$instance['show_header'] = strip_tags($new_instance['show_header']);
		$instance['show_border'] = strip_tags($new_instance['show_border']);
		return $instance;
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form($instance) {
		global $theme;
		$instance = wp_parse_args((array)$instance, $theme->options['widgets_options']['facebook']);
		?>
		<div class="tt-widget">
			<style>
			.tt-widget-label {
				width: 30%;
				text-align: right;
				padding: 2px 5px 2px 0;
				margin: 0;
			}
			.tt-widget-content {
				width: 70%;
				padding: 2px 0 2px 0;
				margin: 0;
			}
			.tt-widget-content input,
			.tt-widget-content select {
				margin: 0;
			}
			</style>
			<table width="100%">
				<tr>
					<td class="tt-widget-label"><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label></td>
					<td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></td>
				</tr>
				<tr>
					<td class="tt-widget-label"><label for="<?php echo $this->get_field_id('url'); ?>">Facebook Page URL:</label></td>
					<td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($instance['url']); ?>" /></td>
				</tr>
				<tr>
					<td class="tt-widget-label"><label for="<?php echo $this->get_field_id('width'); ?>">Width:</label></td>
					<td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($instance['width']); ?>" style="width: 50px;" /> px</td>
				</tr>
				<tr>
					<td class="tt-widget-label"><label for="<?php echo $this->get_field_id('height'); ?>">Height:</label></td>
					<td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($instance['height']); ?>" style="width: 50px;" /> px</td>
				</tr>

				<tr>
					<td class="tt-widget-label"><label for="<?php echo $this->get_field_id('colorscheme'); ?>">Color Scheme:</label></td>
					<td class="tt-widget-content">
						<select id="<?php echo $this->get_field_id('colorscheme'); ?>" name="<?php echo $this->get_field_name('colorscheme'); ?>">
							<option value="light" <?php selected('alignleft', $instance['colorscheme']); ?> >Light</option>
							<option value="dark" <?php selected('alignright', $instance['colorscheme']); ?>>Dark</option>
						 </select>
					</td>
				</tr>
				<tr>
					<td class="tt-widget-label">Options:</td>
					<td class="tt-widget-content">
						<label><input type="checkbox" name="<?php echo $this->get_field_name('show_border'); ?>" <?php checked('true', $instance['show_border']); ?> value="true" /> <?php _e('Show Border', 'wn_facebook'); ?></label><br />
						<label><input type="checkbox" name="<?php echo $this->get_field_name('show_header'); ?>" <?php checked('true', $instance['show_header']); ?> value="true" /> <?php _e('Show Header', 'wn_facebook'); ?></label><br />
						<label><input type="checkbox" name="<?php echo $this->get_field_name('show_faces'); ?>" <?php checked('true', $instance['show_faces']); ?> value="true" /> <?php _e('Show Faces', 'wn_facebook'); ?></label><br />
						<label><input type="checkbox" name="<?php echo $this->get_field_name('show_stream'); ?>" <?php checked('true', $instance['show_stream']); ?> value="true" /> <?php _e('Show Stream', 'wn_facebook'); ?></label><br />
					</td>
				</tr>
			</table>
		</div>
		<?php
	}
} 
