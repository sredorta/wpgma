<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.kubiiks.com
 * @since      1.0.0
 *
 * @package    Gma500
 * @subpackage Gma500/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Gma500
 * @subpackage Gma500/includes
 * @author     Sergi Redorta <sergi.redorta@kubiiks.com>
 */
class Gma500_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {		 
		GMA500_Activator::create_db();
	}


	public static function create_db() {
		global $wpdb;
		
		//Create all the tables
		$table = $wpdb->prefix . 'gma500_products';
		if ($wpdb->get_var("SHOW TABLES LIKE '$table'")!= $table) {
			$sql = "CREATE TABLE " . $table . " (
				id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				idGMA varchar(50) NOT NULL UNIQUE,
				cathegory varchar(50) NOT NULL DEFAULT 'Inconue',
				brand varchar(50) NOT NULL DEFAULT 'Inconue',
				serialNumber varchar(50) NOT NULL DEFAULT 'Inconu',
				doc varchar(200) NOT NULL DEFAULT 'toto',
				isEPI boolean NOT NULL DEFAULT '0',
				location varchar(50) NOT NULL DEFAULT 'Local',
				description varchar(500) NOT NULL DEFAULT 'Pas de description',
				image varchar(500) NOT NULL DEFAULT '../wp-content/plugins/gma500/admin/assets/default-product.jpg',
				bought datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				isRental boolean NOT NULL DEFAULT '0',
				user_id bigint(20) UNSIGNED DEFAULT '0'
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
			require_once(get_home_path() . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

			//Create historic table
			$table_h = $wpdb->prefix . 'gma500_historic';
			$sql = "CREATE TABLE " . $table_h . " (
				id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				product_id int(10) UNSIGNED,
				first_name varchar(50) NOT NULL,
				last_name varchar(50) NOT NULL,
				email varchar(255) NOT NULL,
				comment varchar(500) NOT NULL DEFAULT 'Pas de commentaire',
				start datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				end  datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				FOREIGN KEY(product_id) REFERENCES ".$table."(id) ON DELETE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
			dbDelta($sql);

			//Create controls table
			$table_c = $wpdb->prefix . 'gma500_controls';
			$sql = "CREATE TABLE " . $table_c . " (
				id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				product_id int(10) UNSIGNED,
				status varchar(50) NOT NULL DEFAULT 'en cours',
				type varchar(50) NOT NULL DEFAULT 'Rebut',
				description varchar(500) NOT NULL DEFAULT 'Pas de description',
				created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				due datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				closetime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				closecomment varchar(500) NOT NULL DEFAULT 'Pas de commentaire',
				closeuser varchar(100) NOT NULL DEFAULT 'unknown',
				FOREIGN KEY(product_id) REFERENCES ".$table."(id) ON DELETE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
			dbDelta($sql);

			//Config table
			$table_c = $wpdb->prefix . 'gma500_config';
			$sql = "CREATE TABLE " . $table_c . " (
				id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				meta_key varchar(100) NOT NULL DEFAULT 'unknown',
				meta_value varchar(100) NOT NULL DEFAULT 'unknown'
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
			dbDelta($sql);			
		}
		/*
		if ( ! function_exists('write_log')) {
			function write_log ( $log )  {
			   if ( is_array( $log ) || is_object( $log ) ) {
				  error_log( print_r( $log, true ) );
			   } else {
				  error_log( $log );
			   }
			}
		 }*/
				/*Patch the database by converting any base64 to file*/
		/*		global $wpdb;
				$table = $wpdb->prefix.'gma500_products';
				$sql = $wpdb->prepare("SELECT * FROM ". $table. " WHERE 1;", $dummy);
				$products = $wpdb->get_results($sql);
				foreach ($products as $product) {
					if (strpos($product->image, 'data:image/jpeg;base64') !== false) {
						write_log('Processing id : ' . $product->id);
						$image_part = str_replace('data:image/jpeg;base64,','', $product->image);
						//write_log('Image : '. plugin_dir_path( __FILE__ ));
						$image_base64 = base64_decode($image_part);
						//file_put_contents(plugin_dir_path( __FILE__ ) . '\assets\photos\\' . 'img_' .$product->id . '.jpg', $image_base64);
						file_put_contents('C:\xampp\htdocs\wpgma500\wp-content\plugins\gma500\admin\assets\photos\\' . 'img_' .$product->id . '.jpg', $image_base64);
						$product->image = '../wp-content/plugins/gma500/admin/assets/photos/img_'.$product->id . '.jpg';
						$where = array('id'=> $product->id);
						$data = array('image'=>$product->image);
						$wpdb->update ($table, $data, $where);						
					}
				}		
		*/
		//TEST TO ADD 1K products
/*		for ($i=0; $i< 300 ; ++$i) {
			global $wpdb;
			$table = $wpdb->prefix.'gma500_products';
			$sql = $wpdb->prepare (
				"INSERT INTO ".$table . " (idGMA,cathegory,brand,serialNumber,doc,isEPI,location,description,bought,time,isRental) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				'TEST4_'. $i,'categorie','marque','N/A','http://www.kubiiks.com',true,'maison','Voila un article qui vient est generée automatiquement pour test',current_time('mysql'), current_time('mysql'),true );
			$wpdb->query($sql);
			$image = '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';

			$image_part = $image;
			//write_log('Image : '. plugin_dir_path( __FILE__ ));
			$image_base64 = base64_decode($image_part);
			//file_put_contents(plugin_dir_path( __FILE__ ) . '\assets\photos\\' . 'img_' .$product->id . '.jpg', $image_base64);
			file_put_contents('C:\xampp\htdocs\wpgma500\wp-content\plugins\gma500\admin\assets\photos\\' . 'img_' .$wpdb->insert_id . '.jpg', $image_base64);
			$where = array('id'=> $wpdb->insert_id);
			$data = array('image'=>'../wp-content/plugins/gma500/admin/assets/photos/img_'.$wpdb->insert_id . '.jpg');
			$wpdb->update ($table, $data, $where);						
		}*/
	}
}
