<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Anunapress
 * @subpackage Anunapress/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Anunapress
 * @subpackage Anunapress/admin
 * @author     Tor Morten Jensen <tormorten@anunatak.no>
 */
class Anunapress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $anunapress    The ID of this plugin.
	 */
	private $anunapress;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $anunapress       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $anunapress, $version ) {

		$this->anunapress = $anunapress;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anunapress_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anunapress_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->anunapress, plugin_dir_url( __FILE__ ) . 'css/anunapress-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anunapress_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anunapress_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->anunapress, plugin_dir_url( __FILE__ ) . 'js/anunapress-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adds custom text to the admin footer
	 *
	 * @since    1.0.0
	 */
	public function dashboard_footer() {
		
		echo sprintf( __( '<a href="%s">WordPress</a> delievered by <a href="%s">Anunatak</a>', 'anunapress' ), 'http://wordpress.org', 'http://anunatak.no' );

	}

	/**
	 * Registers a custom admin color scheme
	 *
	 * @since    1.0.0
	 */
	public function admin_color_sceme() {

		wp_admin_css_color( 'anunatak', __( 'Anunatak', 'anunapress' ),  
	        plugin_dir_url( __FILE__ ) . '/css/anunapress-color-scheme.css',  
	 		array( '#b43c38', '#cf4944', '#dd823b', '#ccaf0b' )
	    );

	}

}




