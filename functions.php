<?php

// Setup inicial
require get_template_directory() . '/inc/setup.php';

// Personalizaci�n del dashboard
require get_template_directory() . '/inc/dashboard.php';

// Plugins activation
require get_template_directory() . '/inc/plugins-activation/activation.php';

// Setup para desarrollo en bloques
require get_template_directory() . '/inc/blocks-setup.php';

// Patrones
require get_template_directory() . '/inc/patterns.php';

// Enqueue
require get_template_directory() . '/inc/enqueue.php';

// Plugins activation
require get_template_directory() . '/inc/advance-custom-fields.php';

// Personalizaci�n del theme
function mytheme_customize_register( $wp_customize ) {
	//All our sections, settings, and controls will be added here
}
add_action( 'customize_register', 'mytheme_customize_register' );

// Bloques personalizados
require get_template_directory() . '/inc/register-blocks.php';

// Custom functions
require get_template_directory() . '/inc/custom-functions.php';