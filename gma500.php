<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.kubiiks.com
 * @since             1.0.0
 * @package           Gma500
 *
 * @wordpress-plugin
 * Plugin Name:       Materiel GMA500
 * Plugin URI:        http://www.kubiiks.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Sergi Redorta
 * Author URI:        http://www.kubiiks.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gma500
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gma500-activator.php
 */
function activate_gma500() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gma500-activator.php';
	Gma500_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gma500-deactivator.php
 */
function deactivate_gma500() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gma500-deactivator.php';
	Gma500_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gma500' );
register_deactivation_hook( __FILE__, 'deactivate_gma500' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gma500.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gma500() {

	$plugin = new Gma500();
	$plugin->run();

}
run_gma500();
