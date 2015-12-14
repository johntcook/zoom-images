<?php

add_shortcode('dite_zoom', 'dite_zoom_shortcode');
/*
 * @function project_page_shortcode
 * @desc	 Show project details in page/post
 * @param	 integer post_id
 * @return 	 none
 */
function dite_zoom_shortcode($arg) {
	global $wpdb,$post;
	wp_enqueue_script('jquery');
	wp_deregister_script('jquery-zoom');
	wp_enqueue_script('jquery-zoom' , dite_zoom_pluginurl('js') . '/jquery.jqzoom-core.js');
	wp_enqueue_style('jquery-zoom', dite_zoom_pluginurl('css') . '/jquery.jqzoom.css');
	wp_head();
	$id = $arg['id'];
	include_once( dite_zoom_pluginpath().'/views/shortcode.php' );
}
?>