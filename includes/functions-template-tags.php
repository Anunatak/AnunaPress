<?php

/**
 * Template Tags
 *
 * These functions are pluggable if defined before the 'wp'
 * action hook e.g. on 'after_theme_setup'. None of the functions
 * works in code before the 'wp' action hook.
 *
 * @link       https://github.com/Anunatak/AnunaPress
 * @since      1.0.0
 *
 * @package    Anunapress
 * @subpackage Anunapress/includes
 */

if( !function_exists( 'anuna_img' ) && class_exists('AnunaPress_Image') ) :


    /**
     * Resizing of images on the fly
     *
     * @param   string  $img    (required) The source of the image (full URL if not in theme's 'images'-folder)
     * @param   array   $args   (optional) The arguments for creating the image
     *
     * @return  mixed   Depending of arguments, it will either return or output the image URL or markup
     **/
    function anuna_img( $img = '', $args = '' ) {
        $image = new AnunaPress_Image($img, $args);
        return $image->process();
    }

endif;
