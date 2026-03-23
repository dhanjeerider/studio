<?php
// inc/taxonomies.php — Register App Category taxonomy

function appstorepro_register_taxonomies() {
	$labels = [
		'name'                       => _x( 'App & Game Categories', 'taxonomy general name', 'appstorepro' ),
		'singular_name'              => _x( 'Category', 'taxonomy singular name', 'appstorepro' ),
		'search_items'               => __( 'Search Categories', 'appstorepro' ),
		'popular_items'              => __( 'Popular Categories', 'appstorepro' ),
		'all_items'                  => __( 'All Categories', 'appstorepro' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Category', 'appstorepro' ),
		'update_item'                => __( 'Update Category', 'appstorepro' ),
		'add_new_item'               => __( 'Add New Category', 'appstorepro' ),
		'new_item_name'              => __( 'New Category Name', 'appstorepro' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'appstorepro' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'appstorepro' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'appstorepro' ),
		'not_found'                  => __( 'No categories found.', 'appstorepro' ),
		'menu_name'                  => __( 'Categories', 'appstorepro' ),
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

	register_taxonomy( 'app-category', [ 'app', 'game' ], $args );
}
add_action( 'init', 'appstorepro_register_taxonomies' );
