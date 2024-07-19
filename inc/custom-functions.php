<?php
/**
 * Custom functions
 *
 */

// Función que ejecuta el plugin de SEO para poder cambiar el <title> en cada página
function theme_slug_setup() {
add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );

function truncarTextoPorPalabras($texto, $cantidad_maxima_palabras = 20) {
    // Divide el texto en palabras
    $palabras = preg_split('/\s+/', $texto);
    
    // Verifica la cantidad de palabras
    if (count($palabras) <= $cantidad_maxima_palabras) {
        return $texto; // No es necesario truncar
    } else {
        // Trunca el texto y agrega "..."
        $texto_truncado = implode(' ', array_slice($palabras, 0, $cantidad_maxima_palabras)) . '[...]';
        return $texto_truncado;
    }
}

// Tiempo humano
function curated_human_time_diff( $from, $to = '', $format = '' ) {
    if ( empty( $to ) ) {
        $to = time();
    }
    $diff = (int) abs( $to - $from );
    if ( $diff < HOUR_IN_SECONDS ) {
        $mins = round( $diff / MINUTE_IN_SECONDS );
        if ( $mins <= 1 ) $mins = 1;
        if($format == 'clear') {
            $since = sprintf( _n( 'Hoy', 'Hoy', $mins ), $mins );
        } else {
            $since = sprintf( _n( 'Hoy', 'Hoy', $mins ), $mins );
        }
    } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
        $hours = round( $diff / HOUR_IN_SECONDS );
        if ( $hours <= 1 ) $hours = 1;
        if($format == 'clear') {
          $since = sprintf( _n( 'Hoy', 'Hoy', $hours ), $hours );
        } else {
          $since = sprintf( _n( 'Hoy', 'Hoy', $hours ), $hours );
        }
    } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
        $days = round( $diff / DAY_IN_SECONDS );
        if ( $days <= 1 ) $days = 1;
        if($format == 'clear') {
          $format = get_the_date('d').'/'.get_the_date('m').'/'.get_the_date('y');
          $since = sprintf( _n( 'ayer', $format, $days ), $days );
        } else {
          $format = get_the_date('d').'/'.get_the_date('m').'/'.get_the_date('y');
          $since = sprintf( _n( 'Ayer', $format, $days ), $days );
        }
    } else {
      $since = get_the_date('d').'/'.get_the_date('m').'/'.get_the_date('y');
    }
  return $since;
}

// Filtrar post type en el buscador
function search_only_blog_posts( $query ) {
    if ( $query->is_search ) {
        $query->set( 'post_type', 'post' );
        $query->set( 'posts_per_page',10);
    }
    return $query;
}
add_filter( 'pre_get_posts','search_only_blog_posts' );


// Link youtube → Link youtube embebido. Por defecto Wordpress lo hace.
function youtube_embed($link) {
	$link_embed = str_replace("watch?v=", "embed/", $link);
	return $link_embed;
}


// Link youtube → código del video
function youtube_code($url) {
    $id = parse_url($url, PHP_URL_QUERY);
    $id = explode("&", $id);
    $id = $id[0];
    $id = substr($id, 2);
    return $id;
}


// Link youtube → Un array con dos url de resoluciones de la imagen del video
function youtube_img($link) {
    $code = youtube_code($link);
    $src[0] = 'https://i3.ytimg.com/vi/' . $code . '/hqdefault.jpg';
    $src[1] = 'https://i3.ytimg.com/vi/' . $code . '/maxresdefault.jpg';
    return $src;
}

// Saca al string los caracteres no numéricos
function tel_limpio($tel) {
    return preg_replace('/[^0-9]/', '', $tel);
}

function whatsapp_url($tel, $msj) {

    // Si no hay teléfono, retorna un string vacio.
    if ($tel == '') {
      return '';
    }

    // Saco a $tel los espacios y guiones
    $tel_new = tel_limpio($tel);

    // Si no hay mensaje
    if ($msj == '') {
        return 'https://wa.me/' . $tel_new;
    }
    else {

      // En $msj cambio los espacios por %20
      $msj_new = str_replace(' ', '%20', $msj);

      return 'https://wa.me/' . $tel_new .'?text=' . $msj_new;

    }

}

// Traer Gravity Form por titulo

    // Función para obtener el ID de un Gravity Form por su título. Usa la API.
    function obtener_id_gravity_form_por_titulo($titulo_formulario) {
        $forms = GFAPI::get_forms();
        
        foreach ($forms as $form) {
            if ($form['title'] === $titulo_formulario) {
                return $form['id'];
            }
        }

        // Si el formulario no se encuentra, puedes devolver false o cualquier otro valor según tu necesidad.
        return false;
    }

    // Función para mostrar un formulario de Gravity Forms utilizando su título como parámetro
    function gravityForm( $form_title ) {

        // Obtener el ID del formulario a partir del título utilizando la función que creamos antes
        $id_formulario = obtener_id_gravity_form_por_titulo( $form_title );

        if ($id_formulario) {
            // Devolver el shortcode para mostrar el formulario con el ID obtenido
            return do_shortcode('[gravityform id="' . $id_formulario . '" title="false" description="false"]');
        } else {
            return 'El formulario "' . $titulo_formulario . '" no se encontró.';
        }
    }
//

// Reemplaza etiquetas HTML
function replaceTag($content, $tagOld, $tagNew) {
    $return = str_replace('<'.$tagOld, '<'.$tagNew, $content );
    $return = str_replace('</'.$tagOld.'>', '</'.$tagNew.'>', $return );
    return $return;
}