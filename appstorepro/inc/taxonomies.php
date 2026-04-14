<?php
// inc/taxonomies.php — Register App Category taxonomy

function appstorepro_register_taxonomies() {
	$labels = [
		'name'                       => _x( 'App Categories', 'taxonomy general name', 'appstorepro' ),
		'singular_name'              => _x( 'App Category', 'taxonomy singular name', 'appstorepro' ),
		'search_items'               => __( 'Search App Categories', 'appstorepro' ),
		'popular_items'              => __( 'Popular App Categories', 'appstorepro' ),
		'all_items'                  => __( 'All App Categories', 'appstorepro' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit App Category', 'appstorepro' ),
		'update_item'                => __( 'Update App Category', 'appstorepro' ),
		'add_new_item'               => __( 'Add New App Category', 'appstorepro' ),
		'new_item_name'              => __( 'New App Category Name', 'appstorepro' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'appstorepro' ),
		'add_or_remove_items'        => __( 'Add or remove app categories', 'appstorepro' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'appstorepro' ),
		'not_found'                  => __( 'No app categories found.', 'appstorepro' ),
		'menu_name'                  => __( 'App Categories', 'appstorepro' ),
	];

	$args = [
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => [ 'slug' => 'app-category', 'with_front' => false ],
		'show_in_rest'          => true,
	];

	register_taxonomy( 'app-category', 'app', $args );
}
add_action( 'init', 'appstorepro_register_taxonomies' );
