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

	function log( $data ) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);
	
		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
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

	public function change_footer() {
		echo '<div style="width:100%;border-top:1px solid;"><p>GMA500 un club pas comme les autres</p></div>';
	}

	function gma500_admin_main_page_options() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-main.php';
	}

	function gma500_admin_product_add() {		
		//Block any intents of members to be here
		if(!is_admin()) {
			wp_redorect(home_url());
		}
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-add-product.php';	
	}


	//AJAX ADD PRODUCT
	//Adds product in SQL DB
	function insertproduct() {
		//Add product action
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare (
			"INSERT INTO ".$table . " (idGMA,cathegory,brand,utilization,serialNumber,doc,isEPI,location,description,image,bought,time) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
			$_POST['idGMA'],$_POST['cathegory'],$_POST['brand'],$_POST['utilization'],$_POST['serialNumber'],$_POST['doc'],$_POST['isEPI'],$_POST['location'],$_POST['description'],$_POST['image'],$_POST['bought'], current_time('mysql') );
		$wpdb->query($sql);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} else {
			echo json_encode(["success" => "Metériel rajouté dans la base de donnés"]);
			die();
		}
	}

	//AJAX GET PRODUCTS
	//Gets products from SQL
	function getproducts() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table);
		$products = $wpdb->get_results($sql);
		foreach ($products as $product) {
			require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-product-item.php';
		}
		die();
	}

	//AJAX SEARCH PRODUCTS
	function searchproducts() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$filter = strtolower($_POST['filter']);
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE lower(idGMA) RLIKE '". $filter . "' OR lower(cathegory) RLIKE '". $filter . "' OR lower(brand) RLIKE '". $filter . "' OR lower(location) RLIKE '". $filter . "';");
		$products = $wpdb->get_results($sql);
		if (sizeof($products) == 0) {
			echo "<p>Pas des resultats pour votre recherche</p>";
			die();
		}
		foreach ($products as $product) {
			require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-product-item.php';
		}
		die();
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
		//Get font awesome
		wp_register_style("gma500_font_awesome","https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
		wp_enqueue_style("gma500_font_awesome");
		wp_register_style($this->plugin_name,plugin_dir_url( __FILE__ ) . 'css/gma500-admin.css');
		wp_enqueue_style($this->plugin_name);
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
		// pass Ajax Url to script.js
		wp_localize_script('gma500-admin', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
		wp_enqueue_script($this->plugin_name);

	}

}
