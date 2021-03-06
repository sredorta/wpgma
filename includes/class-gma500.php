<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.kubiiks.com
 * @since      1.0.0
 *
 * @package    Gma500
 * @subpackage Gma500/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Gma500
 * @subpackage Gma500/includes
 * @author     Sergi Redorta <sergi.redorta@kubiiks.com>
 */
class Gma500 {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Gma500_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'gma500';

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
	 * - Gma500_Loader. Orchestrates the hooks of the plugin.
	 * - Gma500_i18n. Defines internationalization functionality.
	 * - Gma500_Admin. Defines all hooks for the admin area.
	 * - Gma500_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gma500-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gma500-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gma500-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-gma500-public.php';

		$this->loader = new Gma500_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Gma500_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Gma500_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		//ADMIN PART
		$plugin_admin = new Gma500_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_menu' ); //Create menu action !!!
		$this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'change_footer');
		//REGISTER ALL ADMIN AJAX CALLS HERE !
		$this->loader->add_action( 'wp_ajax_gma500_admin_addproduct', $plugin_admin, 'insertproduct'); //wp_ajax + name of the action 
		$this->loader->add_action( 'wp_ajax_gma500_admin_updateproduct', $plugin_admin, 'updateproduct'); //wp_ajax + name of the action 
		$this->loader->add_action( 'wp_ajax_gma500_getproducts', $plugin_admin, 'getproducts');
		$this->loader->add_action( 'wp_ajax_gma500_searchproducts', $plugin_admin, 'searchproducts');

		$this->loader->add_action( 'wp_ajax_gma500_searchusers', $plugin_admin, 'searchusers');
		$this->loader->add_action( 'wp_ajax_gma500_assign', $plugin_admin, 'assignproduct');
		$this->loader->add_action( 'wp_ajax_gma500_unassign', $plugin_admin, 'unassignproduct');
		$this->loader->add_action( 'wp_ajax_gma500_addcontrol', $plugin_admin, 'addcontrol');
		$this->loader->add_action( 'wp_ajax_gma500_closecontrol', $plugin_admin, 'closecontrol');
		$this->loader->add_action( 'wp_ajax_gma500_configremove', $plugin_admin, 'removeconfig');
		$this->loader->add_action( 'wp_ajax_gma500_configadd', $plugin_admin, 'addconfig');

		//PUBLIC PART
		$plugin_public = new Gma500_Public($this->get_plugin_name(), $this->get_version());
		//Add searchproducts as nopriv to allow all users to get it
		$this->loader->add_action( 'wp_ajax_nopriv_gma500_searchproducts', $plugin_admin, 'searchproducts');

//		$this->loader->add_filter( 'single_template', $plugin_public, 'gma500_template' );
//		$this->loader->add_filter( 'wp_nav_menu_items', $plugin_public, 'add_menu');
		//$this->loader->add_filter( 'page_template', $plugin_public, 'gma500_template');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Gma500_Public( $this->get_plugin_name(), $this->get_version() );

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
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Gma500_Loader    Orchestrates the hooks of the plugin.
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
