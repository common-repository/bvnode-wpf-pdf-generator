<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bvnode.com
 * @since             1.0.0
 * @package           bvnode_wpf_pdf_Generator
 *
 * @wordpress-plugin
 * Plugin Name:       PDF Generator Add-on for WPForms
 * Plugin URI:        https://bvnode.com/plugins/wpf-pdf-generator-plugin/
 * Description:       This add-on automatically generates PDFs from submissions made via WPForms, enabling effortless documentation and data management.
 * Version:           1.0.7
 * Author:            BVNode
 * Author URI:        https://bvnode.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bvnode-wpf-pdf-generator
 * Domain Path:       /languages
 * 
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
if ( function_exists( 'bvnode_wpf_pdf' ) ) {
    bvnode_wpf_pdf()->set_basename( false, __FILE__ );
} else {
    if ( !function_exists( 'bvnode_wpf_pdf' ) ) {
        // Create a helper function for easy SDK access.
        function bvnode_wpf_pdf() {
            global $bvnode_wpf_pdf;
            if ( !isset( $bvnode_wpf_pdf ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $bvnode_wpf_pdf = fs_dynamic_init( array(
                    'id'             => '14961',
                    'slug'           => 'bvnode-wpf-pdf-generator',
                    'premium_slug'   => 'bvnode-wpf-pdf-generator-premium',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_7d6a930cfe245d0dd7028a36a1e56',
                    'is_premium'     => false,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                        'days'               => 14,
                        'is_require_payment' => false,
                    ),
                    'menu'           => array(
                        'slug'    => 'bvnode-wpf-pdf-generator',
                        'contact' => false,
                        'support' => false,
                    ),
                    'is_live'        => true,
                ) );
            }
            return $bvnode_wpf_pdf;
        }

        // Init Freemius.
        bvnode_wpf_pdf();
        // Signal that SDK was initiated.
        do_action( 'bvnode_wpf_pdf_loaded' );
    }
    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define( 'bvnode_wpf_pdf_VERSION', '1.0.7' );
    define( 'bvnode_wpf_pdf_PATH', plugin_dir_path( __FILE__ ) );
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-wpfpdf-generator-activator.php
     */
    function bvnode_wpf_pdf_activate_generator() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpfpdf-generator-activator.php';
        bvnode_wpf_pdf_Generator_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-wpfpdf-generator-deactivator.php
     */
    function bvnode_wpf_pdf_deactivate_generator() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpfpdf-generator-deactivator.php';
        bvnode_wpf_pdf_Generator_Deactivator::deactivate();
    }

    register_activation_hook( __FILE__, 'bvnode_wpf_pdf_activate_generator' );
    register_deactivation_hook( __FILE__, 'bvnode_wpf_pdf_deactivate_generator' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-wpfpdf-generator.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function bvnode_wpf_pdf_run_generator() {
        $plugin = new bvnode_wpf_pdf_Generator();
        $plugin->run();
    }

    bvnode_wpf_pdf_run_generator();
}