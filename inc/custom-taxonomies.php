<?php
/**
 * Custom taxonomies
 *
 */

function register_taxonomies() {

	// Taxonomia para productos
	$labels = array(
		'name'                       => 'Categorías de productos',
		'singular_name'              => 'Categoría de producto',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'category_product', array( 'producto' ), $args );

}

add_action( 'init', 'register_taxonomies' );
