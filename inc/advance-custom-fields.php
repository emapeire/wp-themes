<?php
/**
 * Configuración por defecto para Advance Custom Fields
 *
 */

 // Limite a el query que hacen los relationships para mostrar los posts del lado del panel
add_filter('acf/fields/relationship/query', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query( $args, $field, $post_id ) {

    // Show 5 posts per AJAX call.
    $args['posts_per_page'] = 5;

    return $args;
}
