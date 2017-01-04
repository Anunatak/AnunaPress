<?php

class AnunaPress_Enqueue {

    public static function init() {
        // Register styles
        add_action( 'wp_enqueue_scripts', array(__CLASS__, 'register_styles'), 2 );
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'register_styles'), 2 );

        // Register scripts
        add_action( 'wp_enqueue_scripts', array(__CLASS__, 'register_scripts'), 2 );
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'register_scripts'), 2 );
    }

    public static function register_styles() {
        wp_register_style( 'anunapress/css/lato', '//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext', array(), AnunaPress()->version );
        wp_register_style( 'anunapress/css/login', plugins_url( 'assets/css/login.css', __FILE__ ), array('anunapress/css/lato'), AnunaPress()->version );
        wp_register_style( 'anunapress/css/dashboard', plugins_url( 'assets/css/dashboard.css', ANUNAPRESS_FILE ), array('anunapress/css/lato'), AnunaPress()->version  );
        wp_register_style( 'anunapress/css/adminbar', plugins_url( 'assets/css/adminbar.css', ANUNAPRESS_FILE ), array(), AnunaPress()->version );
    }

    public static function register_scripts() {
        wp_register_script( 'anunapress/js/dashboard', plugins_url( 'assets/js/dashboard.js', ANUNAPRESS_FILE ), array('jquery'), AnunaPress()->version );
    }

}

AnunaPress_Enqueue::init();
