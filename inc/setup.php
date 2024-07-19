<?php
/**
 * Setup básico del theme
 *
 */


// Se establece el ancho del contenido
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'theme_setup' ) ) :
	/**
	 * Se establecen opciones por default en el theme
	 *
	 * Tener en cuenta que esta función tiene hook en after_setup_theme,
	 * que se ejecuta antes del hook init. El hook init es demasiado tarde
	 * para algunas funciones, como indicar soporte para miniaturas de publicaciones.
	 */
	function theme_setup() {

		// Agrega enlaces de fuentes RSS de publicaciones y comentarios predeterminados al head
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Cambiar algunos elementos por otros soportados en HTML5
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Agrega soporte a thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Tamaño de thumbnails utilizados en el theme
		 *
		 * @var array
		 */
		static $thumb_sizes = array(
			//'500x300' => array( 500, 300, true ),
		);
		foreach ( $thumb_sizes as $name => $size ) {
			add_image_size( $name, $size[0], $size[1], $size[2] );
		}

		/*
		 * Habilitar formato de posts
		 * Ver http://codex.wordpress.org/Post_Formats
		 */
		// add_theme_support( 'post-formats', array(
		// 	'aside',
		// 	'image',
		// 	'video',
		// 	'quote',
		// 	'link',
		// ) );

		// Habilitar excepts en pages
		add_post_type_support( 'page', 'excerpt' );

		// Remueve la versión de Wordpress
		// Es importante por cuestiones de seguridad
		remove_action( 'wp_head', 'wp_generator' );

	}
endif; // theme_setup.
add_action( 'after_setup_theme', 'theme_setup' );


// Deshabilita XML-RPC Pingback
// Detiene posibles ataques por este medio
add_filter( 'xmlrpc_methods', 'sar_block_xmlrpc_attacks' );

function sar_block_xmlrpc_attacks( $methods ) {
   unset( $methods['pingback.ping'] );
   unset( $methods['pingback.extensions.getPingbacks'] );
   return $methods;
}

add_filter( 'wp_headers', 'sar_remove_x_pingback_header' );

function sar_remove_x_pingback_header( $headers ) {
   unset( $headers['X-Pingback'] );
   return $headers;
}

// Muestra mensaje genérico por errores de inicio de sesión
function login_errors_message() {
	return 'Datos de acceso incorrectos';
}
add_filter('login_errors', 'login_errors_message');

// Remueve wp_head title
// Luego lo agregamos de forma personalizada
remove_action( 'wp_head', '_wp_render_title_tag', 1 );

// Remueve tildes en nombres de archivos
add_filter('sanitize_file_name', 'sa_sanitize_spanish_chars', 10);
function sa_sanitize_spanish_chars ($filename) {
  return remove_accents( $filename );
}

// Remueve tags de la descripción de las categorías
remove_filter('term_description','wpautop');

// Remueve la barra superior de edición para los usuarios
add_filter( 'show_admin_bar', '__return_false' );

// Remueve la posibilidad de utilizar Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link');

// Remueve comentarios del páginas y entradas
add_action('init', 'remove_comment_support', 100);

function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

// Remueve comentarios de la barra de admin
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
	//$wp_admin_bar->remove_menu('new-content');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

// Remover elementos del menú
if (!current_user_can('administrator')) { //Si el user no es administrator
	add_action( 'admin_menu', 'my_remove_admin_menus' );
	function my_remove_admin_menus() {
		//remove_menu_page( 'edit.php' ); // Entradas
		//remove_menu_page( 'edit.php?post_type=page' ); // Páginas
		remove_menu_page( 'tools.php' ); // Herramientas
		//remove_menu_page( 'uplooad.php' ); // Medios
		remove_menu_page( 'edit-comments.php' ); // Comentarios
		remove_menu_page( 'edit.php?post_type=producto'); // Productos
	}
}

// Remover opciones del editor Wysiwyg
add_filter( 'mce_buttons', 'jivedig_remove_tiny_mce_buttons_from_editor');
function jivedig_remove_tiny_mce_buttons_from_editor( $buttons ) {

    $remove_buttons = array(
        //'bold',
        //'italic',
        //'strikethrough',
        //'bullist',
        //'numlist',
        //'blockquote',
        //'hr', // horizontal line
        //'alignleft',
        //'aligncenter',
        //'alignright',
        //'link',
        //'unlink',
        'wp_more', // read more link
        //'spellchecker',
        //'dfw', // distraction free writing mode
        //'wp_adv', // kitchen sink toggle (if removed, kitchen sink will always display)
    );
    foreach ( $buttons as $button_key => $button_value ) {
        if ( in_array( $button_value, $remove_buttons ) ) {
            unset( $buttons[ $button_key ] );
        }
    }
    return $buttons;
}

// Quitar estilos de emojis en el header
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Eliminar los posts y pages de ejemplo que se generan en la instalación de Wordpress
// Eliminar plugins por defecto de Wordpress
function clean_content() {

    // Comprobar si el tema actual es el que se acaba de activar
    if (get_option('theme_switched')) {
		
        // Array con las IDs de los posts y páginas a eliminar
        $clean_content = array(1, 2, 3);
        foreach ($clean_content as $id) {
            // Comprobar si existe el post o la página con la ID especificada
            if (get_post($id)) {
                // Eliminar el post o la página con la ID especificada
                wp_delete_post($id, true);
            }
        }
		
		// Lista de plugins a eliminar
		$clean_plugins = array('akismet/akismet.php', 'hello.php');
        foreach ($clean_plugins as $plugin) {
            // Comprobar si el plugin está activado
            if (is_plugin_active($plugin)) {
                // Desactivar el plugin
                deactivate_plugins($plugin);
            }
			// Comprobar si el archivo existe
			if( file_exists( WP_PLUGIN_DIR . '/' . $plugin) ) {
				// Eliminar el plugin
				unlink( WP_PLUGIN_DIR . '/' . $plugin);	
			}	
        }
    }
}
add_action('after_switch_theme', 'clean_content');