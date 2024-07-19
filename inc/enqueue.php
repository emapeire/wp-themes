<?php
/**
 * Enqueue
 *
 * https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 *
 */

if (! function_exists('enqueue_scripts')) {
    // Load theme's JavaScript & CSS sources
    function enqueue_scripts() {

        // Agregar slug-page de la pagina en la que se muestra el slider (hacer lo mismo con las distintas librerias)
        /*
        // Swiper
        if ( is_front_page() || is_page('slug-page') ) {
            wp_enqueue_style( 'swiper-style', get_stylesheet_directory_uri() . '/vendor/css/swiper.min.css', array(), '1.0.0' );
            wp_enqueue_script( 'swiper-scripts', get_template_directory_uri() . '/vendor/js/swiper.min.js', array(), '', true);
        } 
        
        // GLightbox
        if ( is_front_page() || is_page('slug-page') ) {
            wp_enqueue_style( 'glightbox-style', get_stylesheet_directory_uri() . '/vendor/css/glightbox.min.css', array(), '1.0.0' );
            wp_enqueue_script( 'glightbox-scripts', get_template_directory_uri() . '/vendor/js/glightbox.min.js', array(), '', true);
        }
        */
        

        // Get the custom theme CSS
        wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/css/styles.css', array(), '1.0.0' );

        // Get the custom theme JS
        wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '', true);

        wp_localize_script('theme-scripts', 'config', array(
            'ajax_url'	=>	admin_url('admin-ajax.php'),
            'site_url'	=>	get_bloginfo('url'),
            'theme_url'	=>	get_bloginfo('template_url'),
        ));
    }
} // endif function_exists( 'enqueue_scripts' ).

add_action('wp_enqueue_scripts', 'enqueue_scripts');

add_filter('style_loader_tag', 'remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'remove_type_attr', 10, 2);

function remove_type_attr($tag, $handle) {
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}

function add_type_attribute($tag, $handle, $src) {
    // Si no es el script del theme no hace nada
    if ( 'theme-scripts' !== $handle ) {
        return $tag;
    }
    // Si no es el script del theme no hace nada agrega type="module"
    $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute' , 10, 3);
