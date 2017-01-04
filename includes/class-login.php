<?php

class AnunaPress_Login {

    public static function init() {
        add_action( 'login_enqueue_scripts', array(__CLASS__, 'scripts') );
    }

    public static function scripts() {
        if( apply_filters( 'anunapress_enable_login_theme', true ) ) {
            wp_enqueue_style( 'anunapress/css/login' );
        }
    }

}

AnunaPress_Login::init();
