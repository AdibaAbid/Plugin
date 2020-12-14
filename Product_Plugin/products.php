<?php
/**
 * Plugin Name:     Product Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Adiba Abid
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 * 
 * 
 * 
 */

function crunchify_deals_custom_post_type() {
$labels = array(
'name' => __( 'Products' ),
'singular_name' => __( 'Deal'),
'menu_name' => __( 'Products'),
'parent_item_colon' => __( 'Parent Deal'),
'all_items' => __( 'All Products'),
'view_item' => __( 'View Deal'),
'add_new_item' => __( 'Add New Deal'),
'add_new' => __( 'Add New'),
'edit_item' => __( 'Edit Deal'),
'update_item' => __( 'Update Deal'),
'search_items' => __( 'Search Deal'),
'not_found' => __( 'Not Found'),
'not_found_in_trash' => __( 'Not found in Trash')
);
$args = array(
'label' => __( 'Products'),
'description' => __( 'Best Crunchify Deals'),
'labels' => $labels,
'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'hcf_register_meta_boxes'),
'public' => true,
'hierarchical' => false,
'show_ui' => true,
'show_in_menu' => true,
'show_in_nav_menus' => true,
'show_in_admin_bar' => true,
'has_archive' => true,
'can_export' => true,
'exclude_from_search' => false,
'yarpp_support' => true,
'taxonomies' => array('post_tag'),
'publicly_queryable' => true,
'capability_type' => 'page',
'rewrite' => array('slug' => 'shop'));
register_post_type( 'Products', $args );
}
add_action( 'init', 'crunchify_deals_custom_post_type', 0 );



// Let us create Taxonomy for Custom Post Type
add_action( 'init', 'crunchify_create_deals_custom_taxonomy', 0 );

//create a custom taxonomy name it "type" for your posts
function crunchify_create_deals_custom_taxonomy() {

$labels = array(
'name' => _x( 'Products categories', 'taxonomy general name' ),
'singular_name' => _x( 'Type', 'taxonomy singular name' ),
'search_items' => __( 'Search Types' ),
'all_items' => __( 'All Types' ),
'parent_item' => __( 'Parent Type' ),
'parent_item_colon' => __( 'Parent Type:' ),
'edit_item' => __( 'Edit Type' ),
'update_item' => __( 'Update Type' ),
'add_new_item' => __( 'Add New Type' ),
'new_item_name' => __( 'New Type Name' ),
'taxonomies' => array('post_tag'),
'menu_name' => __( 'Products categories' ),
);

//Product Categories
register_taxonomy('prodcuts Categories',array('products'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'type' ),
));

add_action( 'load-post-new.php', 'hcf_register_meta_boxes' );

function hcf_register_meta_boxes() {
    add_meta_box( 'smashing-post-class',      // Unique ID
    esc_html__( 'Product Attribute', 'example' ),    // Title
    'hcf_display_callback',   // Callback function
    'Products',         // Admin page (or post type)
    'side',         // Context
    'default'   );
}
add_action( 'add_meta_boxes', 'hcf_register_meta_boxes' );



function hcf_display_callback( $post ) {
 include plugin_dir_path( __FILE__ ) . './form.php';
}


function hcf_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'hcf_sku',
        'hcf_price',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}
add_action( 'save_post', 'hcf_save_meta_box' );

//Short Code for render
add_shortcode("show-products", "get_all_products");

function get_all_products($attr){
$products_type = $attr['type'];
$get_all_products = get_posts(array("post_type" => $products_type));
echo "<pre>";
	//  print_r($get_all_products);
	foreach($get_all_products as $index=> $post){
		echo "<h2>".$post->post_title."</h2>" ;
		echo "<p>".$post->post_content."</p>" ;
	    echo "<p><strong>Price</strong> $".get_post_meta( $post->ID, 'hcf_price', true )."</p>" ;
        echo "<p><strong>SKU</strong> $" . get_post_meta( $post->ID, 'hcf_sku', true )."</p>" ;
	}
	
}
}