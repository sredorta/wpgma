<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.kubiiks.com
 * @since      1.0.0
 *
 * @package    Gma500
 * @subpackage Gma500/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gma500
 * @subpackage Gma500/admin
 * @author     Sergi Redorta <sergi.redorta@kubiiks.com>
 */
class Gma500_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


    //Create admin menus
    public function create_menu() {
        //Hook the menu
       // add_action( 'admin_menu', 'gma500_admin_menu' );
		add_menu_page( 'Géstion du matériel', 'Matériel GMA500', 'manage_options', 'gma500_admin_menu_top', array($this,'gma500_admin_main_page_options'), plugin_dir_url(__FILE__) . 'assets/icon_menu.jpg',50);
	    add_submenu_page( 'gma500_admin_menu_top', 'Ajouter', 'Ajouter', 'manage_options', 'gma500_admin_menu_add', array($this, 'gma500_admin_product_add'));
	    add_submenu_page( 'gma500_admin_menu_top', 'Supprimer', 'Supprimer', 'manage_options', 'gma500_admin_menu_remove', array($this,'my_plugin_options'));
	    add_submenu_page( 'gma500_admin_menu_top', 'Modifier', 'Modifier', 'manage_options', 'gma500_admin_menu_update', array($this,'my_plugin_options'));
	}

	function gma500_admin_main_page_options() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-main.php';
	}
	function gma500_admin_product_add() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-add-product.php';		
	}

	function my_plugin_options() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-add-product.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gma500_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gma500_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style($this->plugin_name,plugin_dir_url( __FILE__ ) . 'css/gma500-admin.css');
		wp_enqueue_style($this->plugin_name);
		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gma500-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gma500_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gma500_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//Form validator plugin
		wp_register_script('jquery-validate-min', plugin_dir_url( __FILE__ ) . '/js/jquery.validate.min.js', array( 'jquery' ) );
		wp_enqueue_script('jquery-validate-min');

		wp_register_script('jquery-validate-lang-fr', plugin_dir_url( __FILE__ ) . '/js/messages_fr.min.js', array( 'jquery' ) );
		wp_enqueue_script('jquery-validate-lang-fr');



		wp_register_script($this->plugin_name,plugin_dir_url( __FILE__ ) . 'js/gma500-admin.js', array( 'jquery' ));
		wp_enqueue_script($this->plugin_name);
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gma500-admin.js', array( 'jquery' ), $this->version, false );

	}

}
