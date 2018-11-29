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
				utilization varchar(50) NOT NULL DEFAULT 'Inconu',
				serialNumber varchar(50) NOT NULL DEFAULT 'Inconu',
				doc varchar(200) NOT NULL DEFAULT 'toto',
				isEPI boolean NOT NULL DEFAULT '0',
				location varchar(50) NOT NULL DEFAULT 'Local',
				description varchar(500) NOT NULL DEFAULT 'Pas de description',
				image varchar(14000) NOT NULL DEFAULT '../wp-content/plugins/gma500/admin/assets/default-product.jpg',
				bought datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				user_id bigint(20) UNSIGNED DEFAULT '0'
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
			require_once(get_home_path() . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}


	}
}
