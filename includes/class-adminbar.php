<?php

class AnunaPress_AdminBar {

    public static function init() {
        add_action( 'wp_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        add_action( 'admin_bar_menu', array(__CLASS__, 'remove_wp_logo'), 999 );
        add_action( 'admin_bar_menu', array(__CLASS__, 'add_anunatak_logo'), 1 );
    }

    public static function script() {
        if(is_user_logged_in() && is_admin_bar_showing()) {
            wp_enqueue_style( 'anunapress/css/adminbar' );
        }
    }

    public static function remove_wp_logo() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_node('wp-logo');
    }

    public static function add_anunatak_logo() {
        global $wp_admin_bar;
        $wp_admin_bar->add_node(array(
            'id'    => 'anunatak-logo',
            'title' => '<span class="ab-icon"></span><span class="screen-reader-text">' . __( 'Anunatak' ) . '</span>',
            'href'  => 'https://anunatak.no',
        ));
    }

}

AnunaPress_AdminBar::init();
