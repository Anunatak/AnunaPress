<?php

class AnunaPress_Login {

    public static function init() {
        add_action( 'login_enqueue_scripts', array(__CLASS__, 'scripts') );
    }

    public static function scripts() {
        wp_enqueue_style( 'anunapress/login', plugins_url( 'assets/css/login.css', __FILE__ ), array(), AnunaPress()->version );
    }

}

AnunaPress_Login::init();
