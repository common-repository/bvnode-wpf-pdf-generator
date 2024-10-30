<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://bvnode.com
 * @since      1.0.0
 *
 * @package    bvnode_wpf_pdf_Generator
 * @subpackage bvnode_wpf_pdf_Generator/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    bvnode_wpf_pdf_Generator
 * @subpackage bvnode_wpf_pdf_Generator/includes
 * @author     BVNode <developer@bvnode.com>
 */
class bvnode_wpf_pdf_Generator {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      bvnode_wpf_pdf_Generator_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'bvnode_wpf_pdf_VERSION' ) ) {
            $this->version = bvnode_wpf_pdf_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'bvnode-wpf-pdf-generator';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - bvnode_wpf_pdf_Generator_Loader. Orchestrates the hooks of the plugin.
     * - bvnode_wpf_pdf_Generator_i18n. Defines internationalization functionality.
     * - bvnode_wpf_pdf_Generator_Admin. Defines all hooks for the admin area.
     * - bvnode_wpf_pdf_Generator_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpfpdf-generator-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpfpdf-generator-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpfpdf-generator-admin.php';
        //require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpfpdf-generator-bvpdf.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpfpdf-generator-template.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpfpdf-generator-pdf.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpfpdf-generator-public.php';
        $this->loader = new bvnode_wpf_pdf_Generator_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the bvnode_wpf_pdf_Generator_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new bvnode_wpf_pdf_Generator_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new bvnode_wpf_pdf_Generator_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action( 'wpforms_builder_enqueues', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'wpforms_builder_enqueues', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_pages' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'settings_init' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_filter(
            'wpforms_emails_send_email_data',
            $plugin_admin,
            'prepare_file',
            10,
            2
        );
        $this->loader->add_action(
            'wpforms_emails_mailer_send_after',
            $plugin_admin,
            'attach_file',
            10,
            4
        );
        $this->loader->add_filter(
            'wpforms_entry_table_actions',
            $plugin_admin,
            'add_table_reaction',
            10,
            2
        );
        $this->loader->add_filter(
            'wpforms_entry_details_sidebar_actions_link',
            $plugin_admin,
            'add_sidebar_reaction',
            10,
            2
        );
        $this->loader->add_filter(
            'wpforms_builder_settings_sections',
            $plugin_admin,
            'settings_section',
            20,
            2
        );
        $this->loader->add_action(
            'wpforms_form_settings_panel_content',
            $plugin_admin,
            'settings_section_content',
            10,
            4
        );
        $this->loader->add_filter(
            'wpforms_smarttags_process_value',
            $plugin_admin,
            'process_value',
            10,
            6
        );
        $this->loader->add_action( 'wp_ajax_wpforms_get_pdf_template_fields', $plugin_admin, 'load_pdf_fields' );
        $this->loader->add_action( 'wp_ajax_wpforms_get_pdf_notifications', $plugin_admin, 'get_pdf_notifications' );
        $this->loader->add_action(
            'wpforms_entries_init',
            $plugin_admin,
            'view_entry_pdf',
            1,
            1
        );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'preview_template' );
        $this->loader->add_filter(
            'bvnode_wpf_pdf_smart_tags_field_types',
            $plugin_admin,
            'bvnode_wpf_smarttags_fields_list',
            10,
            1
        );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new bvnode_wpf_pdf_Generator_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    bvnode_wpf_pdf_Generator_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
