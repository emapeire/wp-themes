<?php
/**
 * Template //name: Nombre del template page
 *
 */


add_filter('use_block_editor_for_post', '__return_false');


function remove_from_custom_page_templates() {    
    // Remueve los estilos y scripts cargados por defecto en el theme y pensados para bloques
    // Sumar a esta lista cualquier otra llamada que se haga desde en enqueue y no la necesitemos
    wp_dequeue_style('theme-style', get_stylesheet_directory_uri() . '/css/styles.css', array(), '1.0.0' ); // Style general del theme
    wp_dequeue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '', true); // Scripts generales del theme

    // En caso de necesitar utilizar bloques dentro de este custom page template comentar estas funciones que remueven estas llamadas genéricas
    wp_dequeue_style('wp-block-library'); // Estilo principal de wp-block-library
    wp_dequeue_style('wp-block-library-theme'); // Estilo del tema de wp-block-library
    wp_dequeue_style('wp-block-library-inline-css');
    wp_dequeue_style( 'global-styles'); // Estilos personalizados desde Apariencia > Editor > Estilos

}
add_action('wp_enqueue_scripts', 'remove_from_custom_page_templates'); 

function add_from_custom_page_templates() {
    // Agrega estilos y scripts puntualmente para los custom page templates
    wp_enqueue_style('theme-style-custom-page-templates', get_stylesheet_directory_uri() . '/page-templates/css/screen.css', array(), '1.0.0' ); // Style general del theme
    wp_enqueue_script('theme-scripts-custom-page-templates', get_template_directory_uri() . '/page-templates/js/scripts.js', array(), '', true); // Scripts generales del theme
}
add_action('wp_enqueue_scripts', 'add_from_custom_page_templates'); 

get_template_part('page-templates/header');  ?>



<?php get_template_part('page-templates/footer'); ?>