<?php

class AnunaPress_Public {

    /**
     * Hook everything up
     * @return void
     */
    public static function init() {
        add_action( 'after_setup_theme', array(__CLASS__, 'prepare_theme') );
    }

    /**
     * Prepares the theme for AnunaPress'ing
     * @return void
     */
    public static function prepare_theme() {
        $theme = wp_get_theme();
        if($theme->get('TextDomain') === 'sage' || $theme->get('TextDomain') === 'anunasage') {

            // Set the correct image path
            add_filter('anuna_img_args_parsed', function($settings) {
                if ( is_array( $settings ) ) {
                    $settings['theme_folder'] = '/assets/images/';
                }

                return $settings;
            });
        }
    }

}

AnunaPress_Public::init();
