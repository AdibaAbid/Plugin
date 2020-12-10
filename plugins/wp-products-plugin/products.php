<?php
/*
Plugin Name: Movie Reviews
Plugin URI: http://wp.tutsplus.com/
Description: Declares a plugin that will create a custom post type displaying movie reviews.
Author: Soumitra Chakraborty
Author URI: http://wp.tutsplus.com/
*/



function create_movie_review() {
    register_post_type( 'movie_reviews',
        array(
            'labels' => array(
                'name' => 'Movie Reviews',
                'singular_name' => 'Movie Review',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Movie Review',
                'edit' => 'Edit',
                'edit_item' => 'Edit Movie Review',
                'new_item' => 'New Movie Review',
                'view' => 'View',
                'view_item' => 'View Movie Review',
                'search_items' => 'Search Movie Reviews',
                'not_found' => 'No Movie Reviews found',
                'not_found_in_trash' => 'No Movie Reviews found in Trash',
                'parent' => 'Parent Movie Review'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title','editor','author', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

add_action( 'init', 'create_movie_review' );
function usp_modify_post_type($post_type) { 
	return 'post'; // edit post type as needed
}
add_filter('register_post_type', 'usp_modify_post_type');