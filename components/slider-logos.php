<?php
/**
 * Slider logos
 *
 *  
 */
?>

<?php /* <style></style> */ ?>
<?php // En el caso de querer mostrarlo en el editor cambiar la clase a custom-block-content-visible ?>
<div class="custom-block-content"> 

    <?php 
    $nombre_repeater = get_field('nombre_repeater', 'option');
    $slider = $nombre_repeater;
    $slider_count = $slider ? count($slider) : 0;
    $NoSlider = $slider_count == 1;
    $slider_conEnlace = true; 

    // Agrega no-slider si hay un solo item
    $sliderClass= 'slider slider--logos';
    $sliderClass .= $NoSlider ? ' no-slider' : '';


    if ( $slider_count > 0 ) : ?>

        <div class="<?php echo $sliderClass; ?> ">

            <div class="swiper <?php if ( $NoSlider ) { echo ''; } else { echo ' js-slider-logos'; } ?>" data-count="<?php echo $slider_count; ?>">

                <div class="swiper-wrapper">

                    <?php for ( $i = 0; $i < $slider_count; $i++) :

                            $slide_img = $slider[$i]['img_repeat'];
                            if ( $slide_img ) {

                                $slide_img_url = $slide_img['url'];

                                $slide_enlace = $slider[$i]['enlace_repeat'];
                                if ( $slide_enlace ) {
                                    $slide_url = $slide_enlace['url'];
                                    $slide_enlace_title = $slide_enlace['title'] ?: 'Aliado';
                                }
                                else {
                                    $slider_conEnlace = false;
                                    $slide_enlace_title = 'Aliado';
                                }

                                $slide_name = $slide_img['alt'] ?: $slide_enlace_title;

                            }
                            
                    ?>

                        <?php if ( $slide_img ) : ?>

                            <div class="swiper-slide">

                                <div class="slide__wrapper">

                                    <?php if ( $slider_conEnlace ) : ?>
                                    
                                        <a 
                                            href="<?php echo $slide_url; ?>" 
                                            class="slide__box" 
                                            aria-label="Ir a <?php echo $slide_name; ?>" 
                                            target="_blank" 
                                            rel="nofollow noopener noreferrer"
                                        >
                                            <picture class="slide__picture">
                                                <source srcset="<?php echo $slide_img_url; ?>" media="(min-width: 1024px)">
                                                <img
                                                    class="slide__picture__img"
                                                    src="<?php echo $slide_img_url; ?>"
                                                    alt="<?php echo $slide_name; ?>"
                                                    width="200"
                                                    height="200"
                                                    loading="lazy"
                                                >
                                            </picture>
                                        </a>
                                    <?php else : ?>
                                    
                                        <div class="slide__box">
                                            <picture class="slide__picture">
                                                <source srcset="<?php echo $slide_img_url; ?>" media="(min-width: 1024px)">
                                                <img
                                                    class="slide__picture__img"
                                                    src="<?php echo $slide_img_url; ?>"
                                                    alt="<?php echo $slide_name; ?>"
                                                    width="200"
                                                    height="200"
                                                    loading="lazy"
                                                >
                                            </picture>
                                        </div>
                                    
                                    <?php endif; ?>

                                </div>

                            </div>     

                        <?php endif; ?>

                    <?php endfor; ?>

                </div>

                <?php if ( ! $NoSlider ) : ?>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                <?php endif; ?>

                </div>
                
        </div>

    <?php endif; ?>
    
</div>
<?php /* <script></script> */ ?>

<?php
// Placeholder para el editor
// Mostramos esta información en el editor en lugar del bloque personalizados
// Comentar en caso de que no necesitemos usarlo
// Modificar la información para que sea más relevante
if ( is_admin() ) { ?>

    <div class="components-placeholder is-large">

        <div class="components-placeholder__label">
            Carrusel de logos
        </div>
        <div class="components-placeholder__instructions">
            El contenido de este bloque es editable en otra sección del sitio.
        </div>
        <a type="submit" class="components-button is-primary" href="#">
            Editar bloque
        </a>

    </div>
    
<?php } ?>