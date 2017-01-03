<?php
/*
Plugin Name:   AnunaPress Deux
Description:   Plugin containing helpers for all Anunatak sites
Plugin URI:    http://anunatak.no
Author:        Tor Morten Jensen
Author URI:    http://anunatak.no
Version:       2.0.0
License:       GPL2
Text Domain:   anunapress
Domain Path:   languages/
*/

/*

    Copyright (C) 2017  Tor Morten Jensen  tormorten@anunatak.no

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('ANUNAPRESS_FILE', __FILE__);

final class AnunaPress {

    /**
     * AnunaPress version.
     *
     * @var string
     */
    public $version = '2.0.0';

    /**
     * The single instance of the class.
     *
     * @var AnunaPress
     * @since 2.0.0
     */
    protected static $_instance = null;

    /**
     * Holds the helpers
     * @var AnunaPress_Helpers
     */
    public $helpers = null;

    /**
     * Main AnunaPress Instance.
     *
     * Ensures only one instance of AnunaPress is loaded or can be loaded.
     *
     * @since 2.0.0
     * @static
     * @see AnunaPress()
     * @return AnunaPress
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 2.0.0
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'anunapress' ), '2.0' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 2.0.0
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'anunapress' ), '2.0' );
    }

    /**
     * Auto-load in-accessible properties on demand.
     *
     * @param mixed
     * @return mixed
     * @since 2.0.0
     */
    public function __get( $key ) {
    }

    /**
     * AnunaPress Constructor.
     */
    public function __construct() {

        // Helper functions
        require 'includes/class-helpers.php';
        $this->helpers = new AnunaPress_Helpers();

        // Load translations
        add_action('init', function() {
            load_plugin_textdomain('anunapress', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
        });

        // Mail changes
        require 'includes/class-mail.php';

        // Image resizing
        require 'includes/class-image.php';

        // Template tags
        require 'includes/functions-template-tags.php';

        // Modify the login screen
        require 'includes/class-login.php';

        // Adminbar modifications
        require 'includes/class-adminbar.php';

        // Public hacks
        if(!is_admin()) {
            require 'includes/class-public.php';
        }

        // Admin hacks
        if( is_admin() ) {
            require 'includes/class-admin.php';
            require 'includes/class-dashboard.php';
        }

    }
}

/**
 * Fetches the single AnunaPress instance
 */
function AnunaPress() {
    return AnunaPress::instance();
}

$GLOBALS['anunapress'] = AnunaPress();
