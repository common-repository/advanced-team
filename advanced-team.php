<?php
/**
 * Plugin Name:       Advanced Team
 * Plugin URI:        https://www.codeincept.com/demo/team
 * Description:       Design awesome team members showcase easily
 * Version:           1.0.0
 * Author:            CodeIncept
 * Author URI:        https://www.codeincept.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-team
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CI_ADVANCED_TEAM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-team-activator.php
 */
function ciat_activate_advanced_team() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-team-activator.php';
	ciat_Advanced_Team_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-team-deactivator.php
 */
function ciat_deactivate_advanced_team() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-team-deactivator.php';
	ciat_Advanced_Team_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ciat_activate_advanced_team' );
register_deactivation_hook( __FILE__, 'ciat_deactivate_advanced_team' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-team.php';

function run_ciat_advanced_team() {

	$plugin = new ciat_Advanced_Team();
	$plugin->run();

}
run_ciat_advanced_team();
