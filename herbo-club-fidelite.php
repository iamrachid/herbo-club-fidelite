<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              rachidox2k.wordpress.com/
 * @since             1.0.0
 * @package           Herbo_Club_Fidelite
 *
 * @wordpress-plugin
 * Plugin Name:       HERBO CLUB FIDÉLITÉ
 * Plugin URI:        herbo-club-fidelite.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Rachid El Aissaoui
 * Author URI:        rachidox2k.wordpress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       herbo-club-fidelite
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
define( 'HERBO_CLUB_FIDELITE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-herbo-club-fidelite-activator.php
 */
function activate_herbo_club_fidelite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-herbo-club-fidelite-activator.php';
	Herbo_Club_Fidelite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-herbo-club-fidelite-deactivator.php
 */
function deactivate_herbo_club_fidelite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-herbo-club-fidelite-deactivator.php';
	Herbo_Club_Fidelite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_herbo_club_fidelite' );
register_deactivation_hook( __FILE__, 'deactivate_herbo_club_fidelite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-herbo-club-fidelite.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_herbo_club_fidelite() {

	$plugin = new Herbo_Club_Fidelite();
	$plugin->run();

}
run_herbo_club_fidelite();
