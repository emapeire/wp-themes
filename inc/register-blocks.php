<?php
/**
 * Registro de bloques personalizados 
 *
 * Utilizamos la estructura de Advance Custom Fields para poder registrar bloques personalizados
 * Se debe habilitar desde functions
 * 
 */

function register_acf_block_types() {
	
    /*
	// Bloque personalizado
	acf_register_block_type( array(
		// Ajustar estas variables según el bloque necesario
		'name' => 'Bloque personalizado',
		'title'  => __('Bloque personalizado'),
		'description'  => __('Un bloque personalizado.'),
		'render_template'  => 'components/custom-block.php',
		'category' => 'formatting',
		'icon' => 'block-default',
		'keywords' => array( 'Bloque personalizado', 'bloque-personalizado' ),
        'supports' => array(
			// https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
            'align' => false,
            'align_text' => false,
            'anchor' => true,
       		),		
		)
	);

	// Slider logos
	acf_register_block_type( array(
		// Ajustar estas variables según el bloque necesario
		'name' => 'Slider logos',
		'title'  => __('Slider logos'),
		'description'  => __('Un Slider logos.'),
		'render_template'  => 'components/slider-logos.php',
		'category' => 'formatting',
		'icon' => 'block-default',
		'keywords' => array( 'Slider logos', 'bloque-personalizado' ),
        'supports' => array(
			// https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
            'align' => false,
            'align_text' => false,
            'anchor' => true,
       		),		
		)
	);
    */

}

if ( function_exists('acf_register_block_type') ) {
	add_action('acf/init', 'register_acf_block_types');
}
?>