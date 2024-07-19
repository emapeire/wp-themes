<?php
/**
 * Dashbord personalizado
 *
 */

// Remover el mensaje de bienvenida del escritorio del panel
remove_action('welcome_panel', 'wp_welcome_panel');

// Remove dashboard widgets
function remove_dashboard_meta() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal');
}
add_action( 'admin_init', 'remove_dashboard_meta' );

// Logo personalizado en wp-login.php
function wpexplorer_login_logo() { ?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/inc/dashboard/logo-onlines.svg );
            margin-bottom: 50px;
            width: 100%;
            background-size: 100%;
            max-width: 150px;
            height: 36px;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'wpexplorer_login_logo' );

function wpexplorer_login_logo_url() {
	return esc_url( 'https://onlines.com.ar' );
}
add_filter( 'login_headerurl', 'wpexplorer_login_logo_url' );

function wpexplorer_login_logo_url_title() {
	return 'Onlines.';
}
add_filter( 'login_headertext', 'wpexplorer_login_logo_url_title' );

// Footer personalizado en el panel
add_filter('admin_footer_text', 'customlogin_footer_admin');
function customlogin_footer_admin () {
    echo '<span id="footer-thankyou">Desarrollado por <a href="https://onlines.com.ar" target="_blank">Onlines.</a></span>';
}

// Añadir el widget de Onlines.
add_action( 'wp_dashboard_setup', 'my_dashboard_setup_function' );
function my_dashboard_setup_function() {
    add_meta_box( 'my_dashboard_widget', '¡Bienvenido!', 'my_dashboard_widget_function', 'dashboard', 'normal', 'high' );
}
function my_dashboard_widget_function() {
    echo '<p>En el menú lateral vas a encontrar las opciones disponibles para que puedas editar el contenido de tu sitio web. Te recomendamos no instalar plugins que no hayan sido aprobados por nuestro equipo ya que pueden afectar el rendimiento general del sitio.</p>';
    echo '<p>Recordá que por cualquier duda podés contactarte con nosotros escribiéndonos a <a href="mailto:contacto@onlines.com.ar">contacto@onlines.com.ar</a></p>';
}