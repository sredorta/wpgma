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
				image varchar(14000) NOT NULL DEFAULT '../wp-content/plugins/gma500/admin/assets/default-product.jpg',
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
	}
}
