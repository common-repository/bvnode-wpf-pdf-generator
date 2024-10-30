<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bvnode.com
 * @since      1.0.0
 *
 * @package    bvnode_wpf_pdf_Generator
 * @subpackage bvnode_wpf_pdf_Generator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    bvnode_wpf_pdf_Generator
 * @subpackage bvnode_wpf_pdf_Generator/includes
 * @author     BVNode <developer@bvnode.com>
 */
class bvnode_wpf_pdf_Generator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bvnode-wpf-pdf-generator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
