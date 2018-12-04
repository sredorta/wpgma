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
		add_menu_page( 'Géstion du matériel', 'Matériel GMA500', 'manage_options', 'gma500_admin_menu_top', array($this,'gma500_admin_main_page_options'), plugin_dir_url(__FILE__) . 'assets/icon_menu.jpg',50);
	}

	//Change all admin footer
	public function change_footer() {
		echo '<div style="width:100%;border-top:1px solid;"><p>GMA500 un club pas comme les autres</p></div>';
	}

	function gma500_admin_main_page_options() {
		//Block any intents of members to be here
		if(!is_admin()) {
			wp_redirect(home_url());
		}
		//ADD PRODUCT
		if ($_POST['action'] == "gma500_admin_addproduct_page") {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-add-update-product.php';	
			echo "<div class='wrap'>";
			echo "
			<div style='display:flex;flex-flow:row wrap;justify-content:space-between;max-width:400px;min-width:200px;margin:0 auto'>
				<div id='gma500-submit-add-product' class='button button-primary'>
					<i class='fa fa-plus-circle fa-lg'></i> Enregistrer
				</div>
				<div id='gma500-reset-add-product' class='button button-secondary'> Effacer formulaire</div>
				<form id='gma500-reset-add-product-form' class='gma500-form-hidden' action='?page=gma500_admin_menu_top' method='post'> 
					<input name='action' value='gma500_admin_addproduct_page'/>
				</form>
			  </div>";
			echo "<div style='display:flex;flex-flow:row wrap;justify-content:space-between;max-width:400px;min-width:200px;margin:0 auto;box-sizing:border-box'>
				<form id='gma500-back-to-main-form' class='gma500-form-hidden' action='?page=gma500_admin_menu_top' method='post'> 
				</form>
				<div id='gma500-back-to-admin-button' class='button button-secondary' style='width:100%'>
					<i class='fa fa-chevron-left fa-lg'></i> Retour à la page principale
				</div>				
			</div>";    	
			echo "</div>";
			die();
		}
		//UPDATE PRODUCT
		if ($_POST['action'] == "gma500_admin_updateproduct_page") {
			$product = $this->getProductById($_POST['id']);
			$idGMA = $product->idGMA;
			$brand = $product->brand;
			$serialNumber = $product->serialNumber;
			$image = $product->image;
			$cathegory = $product->cathegory;
			$utilization = $product->utilization;
			$isEPI = $product->isEPI;
			$location = $product->location;
			$description = $product->description;
			$bought = $product->bought;
			$isRental = $product->isRental;
			
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-add-update-product.php';	
			echo "<div class='wrap'>";
			echo "
			<div style='display:flex;flex-flow:row wrap;justify-content:space-between;max-width:400px;min-width:200px;margin:0 auto'>
				<div id='gma500-submit-update-product' class='button button-primary'>
					<i class='fa fa-plus-circle fa-lg'></i> Enregistrer
				</div>
				<div id='gma500-reset-update-product' class='button button-secondary'><i class='fa fa-undo fa-lg'></i> Annuler</div>
				<form id='gma500-reset-update-product-form' class='gma500-form-hidden' action='?page=gma500_admin_menu_top' method='post'> 
					<input name='action' value='gma500_admin_updateproduct_page'>
					<input name='id' value=".$product->id.">
					<div id='gma500-update-product-id' data-idproduct=".$product->id."></div>
				</form>
			  </div>"; 	
			echo "<div style='display:flex;flex-flow:row wrap;justify-content:space-between;max-width:400px;min-width:200px;margin:0 auto;box-sizing:border-box'>
			  <form id='gma500-back-to-main-form' class='gma500-form-hidden' action='?page=gma500_admin_menu_top' method='post'> 
			  </form>
			  <div id='gma500-back-to-admin-button' class='button button-secondary' style='width:100%'>
				  <i class='fa fa-chevron-left fa-lg'></i> Retour à la page principale
			  </div>				
		  	</div>";    	
		  	echo "</div>";
			die();
		}
		//DELETE PRODUCT
		if ($_POST['action'] == "gma500_admin_deleteproduct_page") {
			global $wpdb;
			$table = $wpdb->prefix.'gma500_products';
			$where = array('id'=> $_POST['id']);
			$wpdb->delete($table, $where);
		}

		//VIEW PRODUCT DETAILS
		if ($_POST['action'] == "gma500_admin_viewproductdetails") {
			$product_id = $_POST['id'];
			$product = $this->getProductById($product_id);
			$user = get_userdata($product->user_id);
			$avatar = $this->getAvatar($product->user_id);
			if ($avatar != null)
			   $user->avatar = $avatar;
			$historics = $this->getHistoric($product_id);
			$controls = $this->getControls($product_id);
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-product-details-header.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-product-details.php';
			die();
		}
		//NO ACTION - MAIN PAGE
		$products = $this->getProductsInUse();
		$products_all = $this->getproducts();
		foreach ($products as $product) {
			$user_id = $product->user_id;
			$meta = get_user_meta($user_id);
			$product->user_name = $meta['first_name'][0] . " " . $meta['last_name'][0];
		}
		$controls = $this->getHotControls();
		$historics_last = $this->getHistoricLast();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-main.php';
	}

	function getAvatar($user_id) {
		$avatar = null;
		$meta = get_user_meta($user_id);
		$avatars = explode(";",$meta['wp_user_avatars'][0]); 
		foreach ($avatars as $avatar_tmp) {
			if (strpos($avatar_tmp, "52x52")!== false) {
				preg_match('/\".*\"/',$avatar_tmp,$avatar);
				$avatar = $avatar[0];
			}
		}
		return $avatar;
	}

	function getProductById($id) {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		return  $wpdb->get_row ("SELECT * FROM  $table  WHERE id = $id;");	
	}

	function getProductsInUse() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE user_id <> 0 ORDER BY id;", $dummy);
		return $wpdb->get_results($sql);		
	}

	//Gets last 10 historic from a product
	function getHistoric($product_id) {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_historic';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE product_id = '". $product_id . "' ORDER BY id DESC LIMIT 10;", $dummy);
		$historics = $wpdb->get_results($sql);
		return $historics;
	}

	//Gets last historic from each product
	function getHistoricLast() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_historic';
		$sql = $wpdb->prepare ("SELECT * FROM (SELECT * FROM ". $table . " ORDER BY id DESC) AS x GROUP BY product_id;", $dummy);
		$historics = $wpdb->get_results($sql);
		return $historics;
	}	

	function getControls($product_id) {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_controls';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE product_id = '". $product_id . "' ORDER BY id DESC;", $dummy);
		$controls = $wpdb->get_results($sql);
		return $controls;
	}

	//Gets comming controls
	//We get all and filter after
	function getHotControls() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_controls';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " ORDER BY id DESC;", $dummy);
		$controls = $wpdb->get_results($sql);
		return $controls;		
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// AJAX CALLS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Adds product in SQL DB
	function insertproduct() {
		//Add product action
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare (
			"INSERT INTO ".$table . " (idGMA,cathegory,brand,utilization,serialNumber,doc,isEPI,location,description,image,bought,time,isRental) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
			$_POST['idGMA'],$_POST['cathegory'],$_POST['brand'],$_POST['utilization'],$_POST['serialNumber'],$_POST['doc'],$_POST['isEPI'],$_POST['location'],$_POST['description'],$_POST['image'],$_POST['bought'], current_time('mysql'),$_POST['isRental'] );
		$wpdb->query($sql);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} else {
			echo json_encode(["success" => "Metériel rajouté dans la base de donnés"]);
			die();
		}
	}
	//Updates product in SQLDB
	function updateproduct() {
		//Add product action
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$where = array('id'=> $_POST['id']);
		$data = array('idGMA'=>$_POST['idGMA'],
					  'cathegory'=>$_POST['cathegory'],
					  'brand'=>$_POST['brand'],
					  'utilization'=>$_POST['utilization'],
					  'serialNumber'=>$_POST['serialNumber'],
					  'doc'=>$_POST['doc'],
					  'isEPI'=>$_POST['isEPI'],
					  'location'=>$_POST['location'],
					  'description'=>$_POST['description'],
					  'image'=>$_POST['image'],
					  'bought'=>$_POST['bought']					  					  
		);
		$wpdb->update ($table, $data, $where);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} else {
			echo json_encode(["success" => "Matériel mis a jour correctement"]);
			die();
		}
	}	


	//AJAX GET PRODUCTS
	//Gets products from SQL
	function getproducts() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_products';
		$sql = $wpdb->prepare ("SELECT * FROM ". $table, $toto);
		$products = $wpdb->get_results($sql);
		return $products;
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
		echo "<div class='gma500-products-search-list-wrapper gma500-header' style='display:flex'>
        <div>IMAGE</div>
        <div>IDGMA</div>
        <div>CATHEGORIE</div>
        <div>MARQUE</div>
        <div>DISPONIBLE:</div>
    	</div>";
		foreach ($products as $product) {
			require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/template-admin-product-item.php';
		}
		die();
	}
	//AJAX SEARCH USERS
	function searchusers() {
		global $wpdb;
		$table = $wpdb->prefix.'gma500_users';
		$filter_o = strtolower($_POST['filter']);
		$filters = explode(" ", $filter_o);
		$users = get_users();
		$result = [];
		foreach ($users as $user) {
			$tmp  = "";
			$meta = "";
			$tmp->email = $user->user_email;
			$meta = get_user_meta($user->ID);
			$tmp->id = $user->ID;
			$tmp->first_name = $meta['first_name'][0];
			$tmp->last_name = $meta['last_name'][0];
			if ($filter_o != "") {
				//Do the filter
				$found = false;
				foreach ($filters as $filter) {
					if (strpos(strtolower($tmp->first_name), $filter) !== false) $found = true;
					if (strpos(strtolower($tmp->last_name), $filter) !== false) $found = true;
					if (strpos(strtolower($tmp->email), $filter) !== false) $found = true;
				}
			} else {
				$found = true;
			}
			if ($found) array_push($result,$tmp);
		}
		if (sizeof($result) == 0) {
			echo "Pas de membre trouvé qui contient : " . $filter_o;
			die();
		}
		//Create the html with the users found
		foreach ($result as $tmp) {
			$avatar = $this->getAvatar($tmp->id);
			echo "<div class='gma500-user-list-item' data-iduser=\"".$tmp->id."\">";

			echo "<div style='display:flex;width:100%;padding:5px' class='gma500-user-wrapper'>";
			echo "<div>";
			if ($avatar != null)
				echo "<img src=".$avatar." alt_text='avatar' style='width:50px;height:50px'>";
			echo "</div>";    
			echo "<div style='margin-left:20px'>";
			echo "<p class='gma500-product-admin-value' style='margin-bottom:2px;font-weight:bold'>" .$tmp->first_name." ". $tmp->last_name ."</p>";
			echo "<p class='gma500-product-admin-value'>" .$tmp->email."</p>";
			echo "</div>";
			echo "</div>";

			//echo "<div class='gma500-user-list-item-first'><p>".$tmp->first_name."</p></div>";
			//echo "<div class='gma500-user-list-item-last'><p>".$tmp->last_name."</p></div>";
			//echo "<div class='gma500-user-list-item-email'><p>".$tmp->email."</p></div>";
			echo "</div>";
		}
		echo "<div id ='gma500-assign-final-wrapper'>";
		echo "<p>DATE DE RETOUR:<br /><input  id='gma500-assign-back-date' name='back' type='date' required style='width:170px' value=".current_time('mysql')."></p>";
		echo "<div id='gma500-assign-ajax-result'></div>";
		echo "<div id='gma500-assign-button' class='button button-primary'>Assigner</div>";
		echo "</div>";
		die();
	}

	//Assigns a product to a user
	function assignproduct() {
		global $wpdb;
		$product_id = $_POST['product_id'];
		$user_id = $_POST['user_id'];
		$due = $_POST['due'];
		$myuser = get_user_by('ID', $user_id);
		$email = $myuser->user_email;
		$meta = get_user_meta($myuser->ID);
		$first = $meta['first_name'][0];
		$last = $meta['last_name'][0];

		//Update the table products
		$table = $wpdb->prefix.'gma500_products';
		$where = array('id'=> $product_id);
		$data = array('user_id'=>$user_id);
		$wpdb->update ($table, $data, $where);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} 

		$table = $wpdb->prefix.'gma500_historic';
		$sql = $wpdb->prepare (
			"INSERT INTO ".$table . " (product_id,first_name,last_name,email,start,end) VALUES (%s,%s,%s,%s,%s,%s)",
			$product_id,$first, $last,$email,current_time('mysql'), $due );
		$wpdb->query($sql);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} else {
			echo json_encode(["success" => "Matériel correctement assigné"]);
			die();
		}		
		die();
	}

	//Unassigns product from user
	function unassignproduct() {
		global $wpdb;
		$product_id = $_POST['product_id'];
		$comment = $_POST['comment'];
		if ($comment == "") $comment = "Pas de commentaire";
		//Update the table products
		$table = $wpdb->prefix.'gma500_products';
		$where = array('id'=> $product_id);
		$data = array('user_id'=>0);
		$wpdb->update ($table, $data, $where);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} 
		//Add comment on last historic entry and update end with today's date
		$table = $wpdb->prefix.'gma500_historic';
		//Get last id from the product to insert comment
		$sql = $wpdb->prepare ("SELECT * FROM ". $table . " WHERE product_id = '". $product_id . "' ORDER BY ID DESC LIMIT 1;");
		$historics = $wpdb->get_results($sql);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} 		
		$where = array('id'=> $historics[0]->id);
		$data = array('comment'=>$comment, 'end'=>current_time('mysql'));
		$wpdb->update ($table, $data, $where);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} 
		echo json_encode(["success" => "Matériel correctement deassigné"]);
		die();
	}

	//add control
	function addcontrol() {
		global $wpdb;
		$product_id = $_POST['product_id'];
		$type = $_POST['type'];
		$description = $_POST['description'];
		$due = $_POST['due'];


		$table = $wpdb->prefix.'gma500_controls';
		$sql = $wpdb->prepare (
			"INSERT INTO ".$table . " (product_id,status,type,description,created,due) VALUES (%s,%s,%s,%s,%s,%s)",
			$product_id,"ouvert", $type,$description,current_time('mysql'), $due );
		$wpdb->query($sql);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} else {
			echo json_encode(["success" => "Matériel correctement assigné"]);
			die();
		}		
		die();
	}

	//close control
	function closecontrol() {
		global $wpdb;
		$control_id = $_POST['control_id'];
		//Update the table products
		$table = $wpdb->prefix.'gma500_controls';
		$where = array('id'=> $control_id);
		$data = array('status'=> 'férmé');
		$wpdb->update ($table, $data, $where);
		if($wpdb->last_error !== '') {
			echo json_encode(["error" => $wpdb->last_error]); //return json error
			die();
		} 
		echo json_encode(["success" => "Controle correctement fermé"]);
		die();
	}	



/////////////////////////////////////////////////// AJAX END ///////////////////////////////////////////////////



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
