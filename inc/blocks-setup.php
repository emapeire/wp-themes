<?php
/**
 * Setup para el desarrollo en bloques
 *
 */

// Agrega soporte para desarrollo en bloques
function emptytheme_support()  {

    add_theme_support( 'block-templates' );
    add_theme_support( 'block-template-parts' );

    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-spacing' );

    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'html5', array('style','script', ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'editor-font-sizes', array() );	
    add_theme_support( 'custom-line-height' );	
    add_theme_support( 'editor-color-palette', array() );
    add_theme_support( 'editor-gradient-presets', array() );	
    add_theme_support( 'custom-units', array() );	

    add_editor_style( 'editor-style.css' );

}
add_action( 'after_setup_theme', 'emptytheme_support' );

// Remover patterns por defecto
function remove_default_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'init', 'remove_default_patterns' );


// De todos modos algunos generales siguen quedando
// Los eliminamos con las siguientes funciones
// Lista de todos los patterns registrados
function get_block_pattern_names_list() {
    $get_patterns  = WP_Block_Patterns_Registry::get_instance()->get_all_registered();
    $pattern_names = array_map(
        function ( array $pattern ) {
            return $pattern['name'];
        },
        $get_patterns
    );
    return $pattern_names;
}

// Eliminar los patters registrados
function remove_all_core_block_patterns() {
    // Eliminar core patterns
    $registered_patterns = get_block_pattern_names_list();
    foreach ( $registered_patterns as $pattern_name ) {
        // Si comienza con core lo elimina
        if ( substr( $pattern_name, 0, strlen( 'core' ) ) === 'core' ) {
            unregister_block_pattern( $pattern_name );
        }
    }
}

add_action( 'init', 'remove_all_core_block_patterns' );

// Estilos personalizados para bloques
// Crea una hoja de estilos solo para el editor
add_theme_support('editor-styles');
add_editor_style( 'css/block-editor.css');