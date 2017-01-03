<?php

class AnunaPress_AdminBar {

    public static function init() {
        add_action( 'wp_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
    }

    public static function script() {
        if(is_user_logged_in() && is_admin_bar_showing()) {
            wp_enqueue_style( 'anunapress/adminbar', plugins_url( 'assets/css/adminbar.css', ANUNAPRESS_FILE ) );
        }
    }

}

AnunaPress_AdminBar::init();
