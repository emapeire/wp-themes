<?php
/**
 * Custom post types
 *
 */

function register_post_types() {

    // Products
    register_post_type(
        'producto', array( // Usamos el nombre en singular para evitar problemas con los slugs de las páginas
            'public' => true,
            'labels' => array(
                'name' => __('Productos', 'theme'),
                'singular_name' => __('Producto', 'theme'),
            ),
            'rewrite' => array(
                'slug' => 'producto'
            ),
            'has_archive' => true, // Si lo cambiamos a true puede generar problemas con los slugs de las páginas
            'menu_icon' => 'dashicons-editor-aligncenter',
            'menu_position' => 5,
            'supports' => array(
                'title',
                'thumbnail',
                'editor'
            ),
            'taxonomies' => array('post_tag', 'category'),
        )
    );

    return;

}

add_action( 'init', 'register_post_types' );
