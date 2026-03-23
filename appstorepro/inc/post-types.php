<?php
// inc/post-types.php — Register App CPT

function appstorepro_register_app_cpt() {
	$labels = [
		'name'                  => _x( 'Apps', 'Post type general name', 'appstorepro' ),
		'singular_name'         => _x( 'App', 'Post type singular name', 'appstorepro' ),
		'menu_name'             => _x( 'Apps', 'Admin Menu text', 'appstorepro' ),
		'name_admin_bar'        => _x( 'App', 'Add New on Toolbar', 'appstorepro' ),
		'add_new'               => __( 'Add New', 'appstorepro' ),
		'add_new_item'          => __( 'Add New App', 'appstorepro' ),
		'new_item'              => __( 'New App', 'appstorepro' ),
		'edit_item'             => __( 'Edit App', 'appstorepro' ),
		'view_item'             => __( 'View App', 'appstorepro' ),
		'all_items'             => __( 'All Apps', 'appstorepro' ),
		'search_items'          => __( 'Search Apps', 'appstorepro' ),
		'parent_item_colon'     => __( 'Parent Apps:', 'appstorepro' ),
		'not_found'             => __( 'No apps found.', 'appstorepro' ),
		'not_found_in_trash'    => __( 'No apps found in Trash.', 'appstorepro' ),
		'featured_image'        => __( 'App Cover Image', 'appstorepro' ),
		'set_featured_image'    => __( 'Set cover image', 'appstorepro' ),
		'remove_featured_image' => __( 'Remove cover image', 'appstorepro' ),
		'use_featured_image'    => __( 'Use as cover image', 'appstorepro' ),
		'archives'              => __( 'App archives', 'appstorepro' ),
		'insert_into_item'      => __( 'Insert into app', 'appstorepro' ),
		'uploaded_to_this_item' => __( 'Uploaded to this app', 'appstorepro' ),
		'items_list'            => __( 'Apps list', 'appstorepro' ),
		'items_list_navigation' => __( 'Apps list navigation', 'appstorepro' ),
		'filter_items_list'     => __( 'Filter apps list', 'appstorepro' ),
	];

	$args = [
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => [ 'slug' => 'apps', 'with_front' => false ],
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-smartphone',
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'show_in_rest'       => true,
		'taxonomies'         => [ 'app-category' ],
	];

	register_post_type( 'app', $args );
}
add_action( 'init', 'appstorepro_register_app_cpt' );
