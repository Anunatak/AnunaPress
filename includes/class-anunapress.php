<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Anunapress
 * @subpackage Anunapress/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Anunapress
 * @subpackage Anunapress/includes
 * @author     Tor Morten Jensen <tormorten@anunatak.no>
 */
class Anunapress {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Anunapress_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $anunapress    The string used to uniquely identify this plugin.
	 */
	protected $anunapress;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->anunapress = 'anunapress';
		$this->version = '1.0.6';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Anunapress_Loader. Orchestrates the hooks of the plugin.
	 * - Anunapress_i18n. Defines internationalization functionality.
	 * - Anunapress_Admin. Defines all hooks for the dashboard.
	 * - Anunapress_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-anunapress-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-anunapress-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-anunapress-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-anunapress-public.php';

		$this->loader = new Anunapress_Loader();

		/**
		 * Loads up the template tags
		 */
<<<<<<< HEAD
		
		$this->loader->add_action( 'init', $this, 'load_template_tags' );
		$this->loader->add_action( 'wp_ajax_nopriv_anuna_img_multiply_async', 'Anuna_Image', 'asyncMultiply' );
		$this->loader->add_action( 'wp_ajax_anuna_img_multiply_async', 'Anuna_Image', 'asyncMultiply' );
=======

		$this->loader->add_action( 'init', $this, 'load_template_tags' );
>>>>>>> 2a0d749addc7d45d724025fe498ce2edbf416d92

	}

	/**
	 * Loads the template tags.
	 *
	 * The function loads up the template tags that is used by the plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function load_template_tags() {
<<<<<<< HEAD
=======

>>>>>>> 2a0d749addc7d45d724025fe498ce2edbf416d92
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/template-tags.php';

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Anunapress_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Anunapress_i18n();
		$plugin_i18n->set_domain( $this->get_anunapress() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Anunapress_Admin( $this->get_anunapress(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_color_sceme' );
		$this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'dashboard_footer' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Anunapress_Public( $this->get_anunapress(), $this->get_version() );

		$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'enqueue_login_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_anunapress() {
		return $this->anunapress;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Anunapress_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
