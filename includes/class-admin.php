<?php
/**
 * Modifies some of the behavior in admin
 */
class AnunaPress_Admin {

    public static function init() {
        add_action('admin_footer_text', array(__CLASS__, 'dashboard_footer'));
        add_action('admin_menu', array(__CLASS__, 'hide_update_nag'));
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    }

    public static function script() {
        wp_enqueue_style( 'anunapress/dashboard', plugins_url( 'assets/css/dashboard.css', ANUNAPRESS_FILE ) );
    }

    /**
     * Adds custom text to the admin footer
     *
     * @since    1.0.0
     */
    public static function dashboard_footer() {
        echo sprintf( __( '<a href="%s">WordPress</a> delievered by <a href="%s">Anunatak</a>', 'anunapress' ), 'http://wordpress.org', 'https://anunatak.no' );
    }

    public static function hide_update_nag() {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }

}

AnunaPress_Admin::init();
