<?php
/**
 * Bloque personalizado
 *
 *  
 */
?>

<?php /* <style></style> */ ?>
<div class="custom-block-content"> <?php // En el caso de querer mostrarlo en el editor cambiar la clase a custom-block-content-visible ?>

    <!-- Contenido del bloque-->
    <p>Contenido de ejemplo</p>
    
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
            Bloque personalizado
        </div>
        <div class="components-placeholder__instructions">
            El contenido de este bloque es editable en otra sección del sitio.
        </div>
        <a type="submit" class="components-button is-primary" href="#">
            Editar bloque
        </a>

    </div>
    
<?php } ?>