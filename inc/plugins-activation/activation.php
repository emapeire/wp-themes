<?php
require_once(get_template_directory().'/inc/plugins-activation/class-tgm-plugin-activation.php');

function tgm_plugins(){
	
  	$plugins = array(

		// Plugins base

		// Gutenberg
		array(
			'name' => 'Gutenberg',
			'slug' => 'gutenberg',
			'source' => 'https://downloads.wordpress.org/plugin/gutenberg.zip',
			'required' => true,
          ),

		// Advanced Custom Fields
		array(
			'name' => 'Advanced Custom Fields PRO',
			'slug' => 'advanced-custom-fields-pro',
			'source' => 'https://onlines.com.ar/plugins/advanced-custom-fields-pro.zip',
			'required' => true,
          ),
		  
		// Extender las capacidades de desarrollo en bloque  

		// Create Block Theme
		array(
			'name' => 'Create Block Theme',
			'slug' => 'create-block-theme',
			'source' => 'https://downloads.wordpress.org/plugin/create-block-theme.zip',
			'required' => true,
          ),		

		// Blocks Animation
		array(
			'name' => 'Blocks Animation',
			'slug' => 'blocks-animation',
			'source' => 'https://downloads.wordpress.org/plugin/blocks-animation.zip', 
               'required' => false,
               'force_activation'   => false,
          ),
		  
		// Block Visibility
		array(
			'name' => 'Block Visibility',
			'slug' => 'block-visibility',
			'source' => 'https://downloads.wordpress.org/plugin/block-visibility.zip',
               'required' => false,
               'force_activation'   => false,
          ),		
		  
		
		// WPcode
		array(
			'name' => 'WPcode',
			'slug' => 'wp-code',
			'source' => 'https://downloads.wordpress.org/plugin/insert-headers-and-footers.zip', 
               'required' => false,
               'force_activation'   => false,
          ),

		// Other plugins 

		// WP Super Cache
		array(
			'name' => 'WP Super Cache',
			'slug' => 'wp-super-cache',
			'source' => 'https://downloads.wordpress.org/plugin/wp-super-cache.zip',
               'required' => false,
               'force_activation'   => false,
          ),
		  
		// The SEO Framework
		array(
			'name' => 'The SEO Framework',
			'slug' => 'the-seo-framework',
			'source' => 'https://downloads.wordpress.org/plugin/autodescription.zip',
               'required' => false,
               'force_activation'   => false,
          ),  
		  
          // Gravity Forms
          array(
              'name' => 'Gravity Forms',
              'slug' => 'gravity-forms',
              'source' => 'https://onlines.com.ar/plugins/gravityforms.zip',
                 'required' => false,
                 'force_activation'   => false,
            ),  		  
	);

   	$config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => get_template_directory_uri().'/plugins/', // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Instalación de plugins', 'theme-slug' ),
			'menu_title'                      => __( 'Plugins', 'theme-slug' ),
		)		
   );
	
	tgmpa($plugins,$config);
	
}
add_action('tgmpa_register','tgm_plugins');

// Traducción
function load_langs_tgmpa() {
    load_theme_textdomain( 'tgmpa', get_template_directory() . 'inc/plugins-activation/languages' );
}
add_action( 'init', 'load_langs_tgmpa' , 1 );