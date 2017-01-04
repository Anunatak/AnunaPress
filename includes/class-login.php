<?php
/**
 * Modifies the WordPress login screen
 */
class AnunaPress_Login {

    /**
     * Hook everything up
     * @return void
     */
    public static function init() {
        add_action( 'login_enqueue_scripts', array(__CLASS__, 'scripts') );
    }

    /**
     * Enqueue styles
     * @return void
     */
    public static function scripts() {
        if( apply_filters( 'anunapress_enable_login_theme', true ) ) {
            wp_enqueue_style( 'anunapress/css/login' );
        }
    }

}

AnunaPress_Login::init();
