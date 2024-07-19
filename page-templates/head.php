<?php
/**
 * Head
 *
 * Estructura y funciones generales de cada pantalla.
 *
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<title><?php wp_title(); ?></title>

	<?php wp_head(); ?>
</head>