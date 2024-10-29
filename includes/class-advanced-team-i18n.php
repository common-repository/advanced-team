<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.codeincept.com
 * @since      1.0.0
 *
 * @package    Advanced_Team
 * @subpackage Advanced_Team/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Advanced_Team
 * @subpackage Advanced_Team/includes
 * @author     CodeIncept <codeincept@gmail.com>
 */
class ciat_Advanced_Team_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function ciat_load_plugin_textdomain() {

		load_plugin_textdomain(
			'advanced-team',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
