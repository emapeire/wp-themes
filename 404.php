<?php
/**
 * 404
 * 
 * Hacemos una redirección 301 de las página de error al home
 * También está en template-redirects.php
 *
 */

wp_redirect( home_url() ); exit;

?>