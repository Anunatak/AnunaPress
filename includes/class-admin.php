<?php
/**
 * Modifies some of the behavior in admin
 */
class AnunaPress_Admin {

    public static function init() {
        add_action('admin_footer_text', array(__CLASS__, 'dashboard_footer'));
        add_action('admin_menu', array(__CLASS__, 'hide_update_nag'));
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        add_action( 'admin_head', array(__CLASS__, 'custom_fonts') );
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'custom_logo') );
        add_action( 'admin_menu', array(__CLASS__, 'admin_menu') );
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    }

    public static function admin_menu() {
        if( apply_filters( 'anunapress_enable_admin_theme', true ) ) {
            global $menu;
            $url = apply_filters( 'anunapress_custom_logo_url', 'https://anunatak.no/' );
            $menu[0] = array(
                __('Anunatak', 'anunapress'),
                'read',
                $url,
                'anunapress-logo',
                'anunapress-logo'
            );
        }
    }

    public static function script() {
        if( apply_filters( 'anunapress_enable_admin_theme', true ) ) {
            wp_enqueue_style( 'anunapress/css/dashboard' );
        }
    }

    public static function custom_fonts() {
        if( apply_filters( 'anunapress_enable_admin_theme', true ) ) {
        }
    }

    public static function custom_logo() {
        if( apply_filters( 'anunapress_enable_admin_theme', true ) ) {
            $logo = apply_filters( 'anunapress_custom_logo', plugins_url( 'assets/img/anunatak-logo.png', ANUNAPRESS_FILE ) );
            wp_add_inline_style( 'anunapress/css/dashboard', '#adminmenu a.anunapress-logo { background-image: url('. $logo .') }' );
        }
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
