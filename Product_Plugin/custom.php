<?php
add_action( 'load-post-new.php', 'hcf_register_meta_boxes' );

function hcf_register_meta_boxes() {
    add_meta_box( 'smashing-post-class',      // Unique ID
    esc_html__( 'Product Attribute', 'example' ),    // Title
    'hcf_display_callback',   // Callback function
    'product',         // Admin page (or post type)
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