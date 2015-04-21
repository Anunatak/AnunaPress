<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Anunapress
 *
 * @wordpress-plugin
 * Plugin Name:       AnunaPress
 * Plugin URI:        https://github.com/Anunatak/AnunaPress
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.5
 * Author:            Tor Morten Jensen
 * Author URI:        http://anunatak.no
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       anunapress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-anunapress-activator.php
 */
function activate_anunapress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anunapress-activator.php';
	Anunapress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-anunapress-deactivator.php
 */
function deactivate_anunapress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anunapress-deactivator.php';
	Anunapress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_anunapress' );
register_deactivation_hook( __FILE__, 'deactivate_anunapress' );

/**
 * The updater class which utilizes the GitHub Updates Class
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-anunapress-updater.php';

/**
 * Creates an update instance
 *
 * @since    1.0.0
 */
function update_anunapress() {

	// initate update
	Anunapress_Update::init( __FILE__ );

}

update_anunapress();

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-anunapress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_anunapress() {

	// initate update
	Anunapress_Update::init( __FILE__ );

	$plugin = new Anunapress();
	$plugin->run();

}
run_anunapress();
