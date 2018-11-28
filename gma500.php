<?php

/**
 * 
 * @link              http://example.com
 * @since             1.0.0
 * @package           GMA500
 * 
 * @wordpress-plugin
 * Plugin Name: Géstion matériel GMA500
 * Plugin URI:  https://www.kubiiks.com
 * Author:      Sergi Redorta
 * Author URI:  https://www.kubiiks.com
 * License:     GPLv2 or later
 * License URI: https://www.kubiiks.com
 * Description: Permet la géstion du matériel du club
 * Version:     1.0.0
 */


 
// Exit if accessed directly
//defined( 'ABSPATH' ) || exit;

/*
//Sends variable to console for debug
function gma500_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function gma500_test() {
	$myvar = "Hello from gma500";
	gma500_console($myvar);
    return "<h1 id='gma500head'>". $myvar . "</h1>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'wp_footer', 'gma500_test' );

// We need some CSS to position the paragraph
function gma500_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#gma500head {
		color: red;
	}
	</style>
	";
}

add_action( 'wp_footer', 'gma500_css' );



//Hook the menu
add_action( 'admin_menu', 'gma500_admin_menu' );

//Menu definition
function gma500_admin_menu() {
	add_menu_page( 'Géstion du matériel', 'Matériel GMA500', 'manage_options', 'gma500_admin_menu_top', 'gma500_admin_main_page_options' );
	add_submenu_page( 'gma500_admin_menu_top', 'Ajouter', 'Ajouter', 'manage_options', 'gma500_admin_menu_add', 'my_plugin_options');
	add_submenu_page( 'gma500_admin_menu_top', 'Supprimer', 'Supprimer', 'manage_options', 'gma500_admin_menu_remove', 'my_plugin_options');
	add_submenu_page( 'gma500_admin_menu_top', 'Modifier', 'Modifier', 'manage_options', 'gma500_admin_menu_update', 'my_plugin_options');
}

function gma500_admin_main_page_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<h1>Géstion du matériel</h1>';
	echo '</div>';
}
//Pages that we go
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}
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
define( 'GMA500_VERSION', '1.0.0' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_gma500() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gma500-activator.php';
	GMA500_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_gma500() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gma500-deactivator.php';
	GMA500_Deactivator::deactivate();
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
	$plugin = new GMA500();
	$plugin->run();
}
run_gma500();





















?>