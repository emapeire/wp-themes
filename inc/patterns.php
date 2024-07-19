<?php

namespace blocks_patterns;

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! function_exists( 'register_block_pattern' ) ) return;

define( 'BLOCK_PATTERNS_PT_SLUG', 'wp_block' );
define( 'BLOCK_PATTERNS_TAX_SLUG', 'wp_block-category' );

add_action( 'plugins_loaded', function() {
	$cbp_path = plugin_dir_path( __FILE__ );

	load_plugin_textdomain( 'wp_block' );

} );

/**
 * Registro de patrones de bloques
 */
add_action( 'init', __NAMESPACE__ . '\register_block_patterns', 20 );
function register_block_patterns() {

	// Establecer la categoría de patrones
	register_block_pattern_category(BLOCK_PATTERNS_PT_SLUG, [
		'label' => '',
	] );
	$all_terms = get_terms( BLOCK_PATTERNS_TAX_SLUG );
	foreach ( $all_terms as $term ) {
		register_block_pattern_category(
			BLOCK_PATTERNS_PT_SLUG . $term->term_id,
			[ 'label' => '' . $term->name ]
		);
	}

	// Obtener todos los patrones personalizados
	$the_query = new \WP_Query( [
		'post_type'              => BLOCK_PATTERNS_PT_SLUG,
		'posts_per_page'         => -1,
		'no_found_rows'          => true,
	] );
	wp_reset_postdata();

	// Tamaño de la ventana gráfica predeterminada
	$viewport = apply_filters( 'loos_cbp_default_viewport_width', 1200 );

	// Registrar los patrones
	foreach ( $the_query->posts as $parts ) {
		$pid = $parts->ID;

		// Clasificar por categoría
		$categories = [];
		$the_terms  = get_the_terms( $pid, BLOCK_PATTERNS_TAX_SLUG );

		if ( empty( $the_terms ) ) {
			$categories = [ BLOCK_PATTERNS_PT_SLUG ];
		} else {
			foreach ( $the_terms as $term ) {
				$categories[] = BLOCK_PATTERNS_PT_SLUG . $term->term_id;
			}
		}

		// Datos del patrón
		$options = [
			'title'         => $parts->post_title,
			'content'       => $parts->post_content,
			'categories'    => $categories,
			'viewportWidth' => $viewport,
		];

		// Otros ajustes personalizables a través de campos personalizados
		// $viewport = apply_filters( 'loos_cbp_viewport_width', 1200, $pid );
		// $block_types = apply_filters( 'loos_cbp_block_types', [], $pid );
		// if ( $viewport ) $options['viewportWidth'] = $viewport;
		// if ( ! empty( $block_types ) ) $options['blockTypes'] = $block_types;

		register_block_pattern( "wp_block/pattern-$pid", $options );
	}
}

// Agregar acción para registrar el tipo de publicación personalizada para patrones de bloques
add_action('init', __NAMESPACE__ . '\cbp_register_post_type', 11);

// Agregar acción para otorgar capacidades personalizadas para la creación de patrones de bloques a los roles de administrador, editor y autor
add_action('admin_init', __NAMESPACE__ . '\cbp_admin_init');

/**
 * Registrar un tipo de publicación personalizada para patrones de bloques
 */
function cbp_register_post_type() {
    $parts_name = __('Patrones de bloques', 'wp_block');
    register_post_type(
        BLOCK_PATTERNS_PT_SLUG,
        [
            'labels' => [
                'name' => $parts_name,
                'singular_name' => $parts_name,
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'capabilities' => ['create_posts' => 'create_loos_cbp'],
            'map_meta_cap' => true, // Necesario para utilizar capacidades
            'has_archive' => false,
            'menu_icon' => 'dashicons-screenoptions',
            'show_in_rest' => true, // Compatible con el editor de bloques
            'supports' => ['title', 'editor'],
        ]
    );
}

/**
 * Otorgar capacidades personalizadas para la creación de patrones de bloques a los roles de administrador, editor y autor
 * Tenga en cuenta que add_cap() otorga permisos de manera permanente hasta que se eliminen con remove_cap().
 */
function cbp_admin_init() {
    global $wp_roles;
    $wp_roles->add_cap('administrator', 'create_loos_cbp');
    $wp_roles->add_cap('editor', 'create_loos_cbp');
    $wp_roles->add_cap('author', 'create_loos_cbp');
}

// Añadir acción en la inicialización
add_action( 'init', __NAMESPACE__ . '\add_parts_tax' );

/**
 * Registra una taxonomía personalizada para el tipo de publicación de partes del blog
 */
function add_parts_tax() {
	$tax = __( 'Categoría de patrón', 'wp_block' );
	register_taxonomy(
		BLOCK_PATTERNS_TAX_SLUG, // Slug de la taxonomía personalizada
		[ BLOCK_PATTERNS_PT_SLUG ], // Slug del tipo de publicación personalizado al que se aplica la taxonomía
		[
			'public'             => false, // No mostrar en la página del usuario
			'hierarchical'       => true, // Jerárquico, como las categorías en WordPress
			'labels'             => [
				'name'                => $tax, // Nombre de la taxonomía personalizada
				'singular_name'       => $tax, // Nombre singular de la taxonomía personalizada
				'menu_name'           => $tax, // Nombre que aparece en el menú de WordPress
			],
			'show_ui'            => true, // Mostrar en la interfaz de usuario
			'capabilities'       => [
				// 'manage_terms' => false,
				'edit_terms'   => 'manage_options', // Los usuarios con capacidad de administración pueden editar términos
				'delete_terms' => 'manage_options', // Los usuarios con capacidad de administración pueden eliminar términos
				// 'assign_terms' => false, // Los usuarios no pueden asignar términos en la página de publicación
			],
			'show_admin_column'  => true, // Mostrar en la columna de la tabla de la página de publicación
			'query_var'          => true, // Habilitar búsqueda por taxonomía personalizada
			'show_in_rest'       => true, // Mostrar en el editor de bloques de Gutenberg
			// 'rewrite'            => [ 'slug' => BLOCK_PATTERNS_TAX_SLUG ], // Personalizar la URL de la taxonomía
		]
	);
}

/**
 * Añade un menú desplegable para filtrar por la taxonomía personalizada en la página de partes del blog
 */
add_filter( 'restrict_manage_posts', __NAMESPACE__ . '\add_search_by_tax' );
function add_search_by_tax( $post_type ) {
	if ( BLOCK_PATTERNS_PT_SLUG !== $post_type ) return;

	$options = '<option value="">' . esc_html__( 'Categoría de patrón', 'wp_block' ) . '</option>';

	// Obtener todas las categorías de la taxonomía personalizada
	wp_dropdown_categories( [
		'show_option_all' => __( 'Categoría', 'wp_block' ),
		// 'orderby'         => 'name',
		'hide_empty'      => false,
		'selected'        => get_query_var( BLOCK_PATTERNS_TAX_SLUG ),
		'name'            => BLOCK_PATTERNS_TAX_SLUG,
		'taxonomy'        => BLOCK_PATTERNS_TAX_SLUG,
		'value_field'     => 'slug',
	] );
}