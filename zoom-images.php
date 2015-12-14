<?php
/*
Plugin Name: Image Zoom
Description: Wordpress Plugin for Zooming Image
Version: 1.0
Author: John Cook
*/


add_action('init', 'dite_zoom_init'); 

// ==========================
// = Register the post type =
// ==========================

function dite_zoom_init() { 
	$labels = array(
		'name' => _x('Zoom Images', 'post type general name'),
		'singular_name' => _x('Image', 'post type singular name'),
		'add_new' => _x('Add New', 'Image'),
		'add_new_item' => __('Add New Image'),
		'edit_item' => __('Edit Image'),
		'new_item' => __('New Image'),
		'view_item' => __('View Image'),
		'search_items' => __('Search Images'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
//		'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail')
	  ); 
  
	register_post_type( 'dite_zoom' , $args );
    flush_rewrite_rules();

}

// Adds featured image functionality for Slides
	
add_action( 'after_setup_theme', 'dite_zoom_featured_image_array', '9999' );
function dite_zoom_featured_image_array() {
	global $_wp_theme_features;

	if ( !isset( $_wp_theme_features['post-thumbnails'] ) ) {		
		$_wp_theme_features['post-thumbnails'] = array( array( 'slide' ) );			
	}
	elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) ) {        
		$_wp_theme_features['post-thumbnails'][0][] = 'slide';			
	}		
}

// Customize and move featured image box to main column
	
add_action( 'do_meta_boxes', 'dite_zoom_image_box' );
function dite_zoom_image_box() {
	remove_meta_box( 'postimagediv', 'dite_zoom', 'side' );
	add_meta_box( 'postimagediv', 'Zoom Image', 'post_thumbnail_meta_box', 'dite_zoom', 'normal', 'high' );
}

add_action("manage_posts_custom_column",  "dite_zoom_custom_columns");
add_filter("manage_edit-dite_zoom_columns", "dite_zoom_edit_columns");
 
function dite_zoom_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Image Title",
		"dite_shortcode" => "Shortcode",
		"dite_image" => "Image"
	);
	return $columns;
}
function dite_zoom_custom_columns($column){
	global $post;
 
	switch ($column) {
		case "dite_shortcode":
			echo "[dite_zoom id=".$post->ID."]";
		break;
		case "dite_image":
			if (has_post_thumbnail( $post->ID ) ):
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				echo get_the_post_thumbnail($post->ID, 'thumbnail');
			endif;
		break;
  }
}


include( plugin_dir_path( __FILE__ ) . 'includes/functions.php');
include( plugin_dir_path( __FILE__ ) . 'controllers/shortcode.php');
?>