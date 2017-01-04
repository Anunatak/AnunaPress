<?php
/**
 * Modifies the wordpress admin bar
 */
class AnunaPress_AdminBar {

    /**
     * Hook everything up
     * @return void
     */
    public static function init() {
        add_action( 'wp_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        add_action( 'admin_enqueue_scripts', array(__CLASS__, 'script'), 99999 );
        add_action( 'admin_bar_menu', array(__CLASS__, 'remove_wp_logo'), 999 );
        add_action( 'admin_bar_menu', array(__CLASS__, 'add_anunatak_logo'), 1 );
    }

    /**
     * Modifies the admin bar
     * @return void
     */
    public static function script() {
        if(is_user_logged_in() && is_admin_bar_showing()) {
            wp_enqueue_style( 'anunapress/css/adminbar' );
        }
    }

    /**
     * Removes the WordPress logo
     * @return void
     */
    public static function remove_wp_logo() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_node('wp-logo');
    }

    /**
     * Adds branding to the admin bar
     *
     * Only applies to front-end unless the admin theme is disabled
     *
     * @return void
     */
    public static function add_anunatak_logo() {
        if(!is_admin() || !apply_filters( 'anunapress_enable_admin_theme', true )) {
            global $wp_admin_bar;
            $wp_admin_bar->add_node(array(
                'id'    => 'anunatak-logo',
                'title' => '<span class="ab-icon"></span><span class="screen-reader-text">' . __( 'Anunatak' ) . '</span>',
                'href'  => 'https://anunatak.no',
            ));
        }
    }

}

AnunaPress_AdminBar::init();
