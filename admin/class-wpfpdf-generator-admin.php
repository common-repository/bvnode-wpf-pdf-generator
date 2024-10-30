<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bvnode.com
 * @since      1.0.0
 *
 * @package    bvnode_wpf_pdf_Generator
 * @subpackage bvnode_wpf_pdf_Generator/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    bvnode_wpf_pdf_Generator
 * @subpackage bvnode_wpf_pdf_Generator/admin
 * @author     BVNode <developer@bvnode.com>
 */
class bvnode_wpf_pdf_Generator_Admin {
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in bvnode_wpf_pdf_Generator_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The bvnode_wpf_pdf_Generator_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/wpfpdf-generator-admin.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style(
            $this->plugin_name . '-template-editor-app-css',
            plugin_dir_url( __FILE__ ) . 'css/template-editor.app.min.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style(
            $this->plugin_name . '-templates-app-css',
            plugin_dir_url( __FILE__ ) . 'css/templates.app.min.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function add_menu_pages() {
        add_menu_page(
            'BVNode PDF Generator Add-on for WPForms',
            'PDF Generator',
            'manage_options',
            'bvnode-wpf-pdf-generator',
            array($this, 'bvnode_wpf_pdf_generator_page_html'),
            'data:image/svg+xml;base64,' . esc_attr( base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 110.7 112" enable-background="new 0 0 110.7 112" xml:space="preserve" fill="white"><path d="M109.5,34.7c2.5-12.3-0.5-23.3-8.6-28.9c-4.2-2.9-9.2-4.5-14.6-4.6h-0.4c-5,0-10.3,1.4-15.7,4.5  c-11.5,6.4-43.3,33.3-43.3,33.3s40.7-20.4,46.3-23.6c3.4-1.9,8.7-3.5,13.5-3.5c3.2,0,6.2,0.7,8.3,2.4c5.3,4.3,6.5,8.6,5.6,14.7  c-1.3,9.2-4.4,19.7-4.4,19.7l7.8,8.9h0C104.1,57.1,107,46.7,109.5,34.7z"/><path d="M15.3,39.2c-3.2-5.6-5.4-16.5-1.1-21.9c3.4-4.3,6.9-5.9,11.3-5.9l3.4,0.3c9.2,1.3,19.7,4.4,19.7,4.4l8.9-7.8  c0,0-10.6-2.9-22.8-5.5L26.4,2C17.5,2,10,5.2,5.7,11.5c-2.9,4.2-4.6,9.3-4.6,14.8v0.1c0,5,1.4,10.4,4.5,15.9  c6.4,11.5,33.1,43,33.3,43.2h0C38.7,85,18.5,44.7,15.3,39.2z"/><path d="M38.3,97.3c-3.4,1.9-8.7,3.5-13.5,3.5c-3.2,0-6.2-0.7-8.3-2.4c-5.4-4.3-6.5-8.7-5.6-14.7c1.3-9.2,4.4-19.7,4.4-19.7  l-7.8-8.9c0,0-2.9,10.6-5.5,22.8c-2.6,12.3,0.5,23.3,8.6,28.9c4.2,2.9,9.2,4.6,14.7,4.6v0h0.2c5,0,10.3-1.4,15.8-4.5  c11.5-6.4,43.2-33.3,43.2-33.3S43.9,94.2,38.3,97.3z"/><path d="M110.3,86.3c0-5-1.4-10.4-4.5-15.8C99.4,59,72.6,27.2,72.6,27.2S93,68,96.1,73.5c3.1,5.6,5.3,16.5,1.1,21.9  c-3.4,4.3-6.9,5.9-11.3,5.9l-3.4-0.3c-9.2-1.3-19.7-4.4-19.7-4.4l-8.9,7.8c0,0,10.6,2.9,22.8,5.5l8.2,0.9l0,0  c8.8,0,16.4-3.2,20.7-9.5c2.9-4.2,4.6-9.2,4.6-14.7V86.3z"/><path d="M47,57.1c0.6,2.9,3,5.2,6.5,6l1.2,0.1v0h0c5,0,8.9-4.5,7.7-9.7c-0.7-2.9-3-5.3-5.9-5.9l-1.2-0.2h-0.8  C49.7,47.5,45.9,52,47,57.1z"/></svg>' ) )
        );
        add_submenu_page(
            'bvnode-wpf-pdf-generator',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'bvnode-wpf-pdf-generator'
        );
        add_submenu_page(
            'bvnode-wpf-pdf-generator',
            'Template',
            'Template',
            'manage_options',
            'wpfpdf-generator-template',
            array($this, 'bvnode_wpf_pdf_generator_page_template_html')
        );
    }

    public function page_header() {
        ?>


        <div class="wrap-header">
            <svg class="bvnode" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600"
                zoomAndPan="magnify" viewBox="0 0 450 93.749996" height="125" preserveAspectRatio="xMidYMid meet" version="1.0"
                style="width:200px; height: auto; display: block;">
                <defs>
                    <g></g>
                    <clipPath id="8f9413e177">
                        <path d="M 25 5 L 88 5 L 88 49 L 25 49 Z M 25 5 " clip-rule="nonzero"></path>
                    </clipPath>
                    <clipPath id="0b6c990748">
                        <path
                            d="M 83.195312 48.132812 L 77.367188 41.488281 C 77.367188 41.488281 79.644531 33.652344 80.65625 26.742188 C 81.324219 22.183594 80.472656 18.894531 76.460938 15.699219 C 74.871094 14.4375 72.613281 13.925781 70.21875 13.925781 C 66.578125 13.925781 62.589844 15.089844 60.058594 16.519531 C 55.863281 18.882812 25.335938 34.195312 25.335938 34.195312 C 25.335938 34.195312 49.117188 14.054688 57.78125 9.226562 C 61.859375 6.949219 65.859375 5.914062 69.585938 5.882812 L 69.878906 5.882812 C 73.945312 5.914062 77.683594 7.15625 80.832031 9.316406 C 86.933594 13.511719 89.210938 21.792969 87.304688 31.003906 C 85.398438 40.210938 83.207031 48.132812 83.207031 48.132812 Z M 83.195312 48.132812 "
                            clip-rule="nonzero"></path>
                    </clipPath>
                    <linearGradient x1="-0.0000173945"
                        gradientTransform="matrix(62.621889, 0, 0, 62.621889, 25.338704, 27.008008)" y1="0" x2="1.019995"
                        gradientUnits="userSpaceOnUse" y2="0" id="fe806c4cf7">
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.312256%, 72.247314%, 98.753357%)" offset="0.00390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.426697%, 71.99707%, 98.709106%)" offset="0.0078125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.539612%, 71.7453%, 98.66333%)" offset="0.0117187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.654053%, 71.495056%, 98.61908%)" offset="0.015625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.768494%, 71.243286%, 98.573303%)" offset="0.0195312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.882935%, 70.991516%, 98.529053%)" offset="0.0234375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.99585%, 70.739746%, 98.483276%)" offset="0.0273437"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.110291%, 70.489502%, 98.439026%)" offset="0.03125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.223206%, 70.237732%, 98.39325%)" offset="0.0351562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.337646%, 69.985962%, 98.348999%)" offset="0.0390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.452087%, 69.734192%, 98.303223%)" offset="0.0429687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.566528%, 69.483948%, 98.258972%)" offset="0.046875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.679443%, 69.232178%, 98.213196%)" offset="0.0507812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.793884%, 68.980408%, 98.168945%)" offset="0.0546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.908325%, 68.728638%, 98.123169%)" offset="0.0585937"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.022766%, 68.478394%, 98.078918%)" offset="0.0625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.135681%, 68.226624%, 98.033142%)" offset="0.0664062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.250122%, 67.974854%, 97.988892%)" offset="0.0703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.363037%, 67.723083%, 97.943115%)" offset="0.0742187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.477478%, 67.471313%, 97.898865%)" offset="0.078125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.591919%, 67.219543%, 97.853088%)" offset="0.0820312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.70636%, 66.969299%, 97.808838%)" offset="0.0859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.819275%, 66.717529%, 97.763062%)" offset="0.0898437"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.933716%, 66.465759%, 97.718811%)" offset="0.09375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.046631%, 66.213989%, 97.673035%)" offset="0.0976562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.161072%, 65.963745%, 97.628784%)" offset="0.101562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.275513%, 65.711975%, 97.583008%)" offset="0.105469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.389954%, 65.460205%, 97.538757%)" offset="0.109375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.502869%, 65.208435%, 97.492981%)" offset="0.113281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.61731%, 64.958191%, 97.44873%)" offset="0.117187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.730225%, 64.706421%, 97.402954%)" offset="0.121094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.844666%, 64.454651%, 97.358704%)" offset="0.125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.959106%, 64.202881%, 97.312927%)" offset="0.128906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.073547%, 63.952637%, 97.268677%)" offset="0.132812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.186462%, 63.700867%, 97.2229%)" offset="0.136719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.300903%, 63.449097%, 97.17865%)" offset="0.140625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.413818%, 63.197327%, 97.132874%)" offset="0.144531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.528259%, 62.947083%, 97.088623%)" offset="0.148437"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.6427%, 62.695312%, 97.042847%)" offset="0.152344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.757141%, 62.443542%, 96.998596%)" offset="0.15625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.870056%, 62.191772%, 96.95282%)" offset="0.160156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.984497%, 61.941528%, 96.908569%)" offset="0.164062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.098938%, 61.689758%, 96.862793%)" offset="0.167969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.213379%, 61.437988%, 96.818542%)" offset="0.171875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.326294%, 61.186218%, 96.772766%)" offset="0.175781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.440735%, 60.934448%, 96.728516%)" offset="0.179687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.55365%, 60.682678%, 96.682739%)" offset="0.183594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.668091%, 60.432434%, 96.638489%)" offset="0.1875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.782532%, 60.180664%, 96.592712%)" offset="0.191406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.896973%, 59.928894%, 96.548462%)" offset="0.195312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.009888%, 59.677124%, 96.502686%)" offset="0.199219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.124329%, 59.42688%, 96.458435%)" offset="0.203125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.237244%, 59.17511%, 96.412659%)" offset="0.207031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.351685%, 58.92334%, 96.368408%)" offset="0.210937"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.466125%, 58.67157%, 96.322632%)" offset="0.214844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.580566%, 58.421326%, 96.278381%)" offset="0.21875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.693481%, 58.169556%, 96.232605%)" offset="0.222656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.807922%, 57.917786%, 96.188354%)" offset="0.226562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.920837%, 57.666016%, 96.142578%)" offset="0.230469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.035278%, 57.415771%, 96.098328%)" offset="0.234375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.149719%, 57.164001%, 96.052551%)" offset="0.238281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.26416%, 56.912231%, 96.008301%)" offset="0.242187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.377075%, 56.660461%, 95.962524%)" offset="0.246094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.491516%, 56.410217%, 95.918274%)" offset="0.25"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.605957%, 56.158447%, 95.872498%)" offset="0.253906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.720398%, 55.906677%, 95.828247%)" offset="0.257812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.833313%, 55.654907%, 95.782471%)" offset="0.261719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.947754%, 55.404663%, 95.73822%)" offset="0.265625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.060669%, 55.152893%, 95.692444%)" offset="0.269531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.17511%, 54.901123%, 95.648193%)" offset="0.273438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.289551%, 54.649353%, 95.602417%)" offset="0.277344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.403992%, 54.397583%, 95.558167%)" offset="0.28125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.516907%, 54.145813%, 95.51239%)" offset="0.285156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.631348%, 53.895569%, 95.46814%)" offset="0.289062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.744263%, 53.643799%, 95.422363%)" offset="0.292969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.858704%, 53.392029%, 95.378113%)" offset="0.296875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.973145%, 53.140259%, 95.332336%)" offset="0.300781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.087585%, 52.890015%, 95.288086%)" offset="0.304688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.2005%, 52.638245%, 95.24231%)" offset="0.308594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.314941%, 52.386475%, 95.198059%)" offset="0.3125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.427856%, 52.134705%, 95.152283%)" offset="0.316406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.542297%, 51.88446%, 95.108032%)" offset="0.320312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.656738%, 51.63269%, 95.062256%)" offset="0.324219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.771179%, 51.38092%, 95.018005%)" offset="0.328125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.884094%, 51.12915%, 94.972229%)" offset="0.332031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.998535%, 50.878906%, 94.927979%)" offset="0.335938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.112976%, 50.627136%, 94.882202%)" offset="0.339844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.227417%, 50.375366%, 94.837952%)" offset="0.34375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.340332%, 50.123596%, 94.792175%)" offset="0.347656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.454773%, 49.873352%, 94.747925%)" offset="0.351562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.567688%, 49.621582%, 94.702148%)" offset="0.355469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.682129%, 49.369812%, 94.657898%)" offset="0.359375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.79657%, 49.118042%, 94.612122%)" offset="0.363281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.911011%, 48.867798%, 94.567871%)" offset="0.367188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.023926%, 48.616028%, 94.522095%)" offset="0.371094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.138367%, 48.364258%, 94.477844%)" offset="0.375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.251282%, 48.112488%, 94.432068%)" offset="0.378906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.365723%, 47.860718%, 94.387817%)" offset="0.382812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.480164%, 47.608948%, 94.342041%)" offset="0.386719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.594604%, 47.358704%, 94.297791%)" offset="0.390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.70752%, 47.106934%, 94.252014%)" offset="0.394531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.82196%, 46.855164%, 94.206238%)" offset="0.398438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.934875%, 46.603394%, 94.160461%)" offset="0.402344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.049316%, 46.353149%, 94.116211%)" offset="0.40625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.163757%, 46.101379%, 94.070435%)" offset="0.410156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.278198%, 45.849609%, 94.026184%)" offset="0.414062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.391113%, 45.597839%, 93.980408%)" offset="0.417969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.505554%, 45.347595%, 93.936157%)" offset="0.421875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.619995%, 45.095825%, 93.890381%)" offset="0.425781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.734436%, 44.844055%, 93.84613%)" offset="0.429688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.847351%, 44.592285%, 93.800354%)" offset="0.433594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.961792%, 44.342041%, 93.756104%)" offset="0.4375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.074707%, 44.090271%, 93.710327%)" offset="0.441406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.189148%, 43.838501%, 93.666077%)" offset="0.445312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.303589%, 43.586731%, 93.6203%)" offset="0.449219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.41803%, 43.336487%, 93.57605%)" offset="0.453125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.530945%, 43.084717%, 93.530273%)" offset="0.457031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.645386%, 42.832947%, 93.486023%)" offset="0.460938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.758301%, 42.581177%, 93.440247%)" offset="0.464844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.872742%, 42.330933%, 93.395996%)" offset="0.46875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.987183%, 42.079163%, 93.35022%)" offset="0.472656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.101624%, 41.827393%, 93.305969%)" offset="0.476562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.214539%, 41.575623%, 93.260193%)" offset="0.480469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.328979%, 41.325378%, 93.215942%)" offset="0.484375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.441895%, 41.073608%, 93.170166%)" offset="0.488281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.556335%, 40.821838%, 93.125916%)" offset="0.492187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.670776%, 40.570068%, 93.080139%)" offset="0.496094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.785217%, 40.318298%, 93.035889%)" offset="0.5"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.898132%, 40.066528%, 92.990112%)" offset="0.503906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.012573%, 39.816284%, 92.945862%)" offset="0.507812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.127014%, 39.564514%, 92.900085%)" offset="0.511719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.241455%, 39.312744%, 92.855835%)" offset="0.515625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.35437%, 39.060974%, 92.810059%)" offset="0.519531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.468811%, 38.81073%, 92.765808%)" offset="0.523438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.581726%, 38.55896%, 92.720032%)" offset="0.527344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.696167%, 38.30719%, 92.675781%)" offset="0.53125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.810608%, 38.05542%, 92.630005%)" offset="0.535156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.925049%, 37.805176%, 92.585754%)" offset="0.539062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.037964%, 37.553406%, 92.539978%)" offset="0.542969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.152405%, 37.301636%, 92.495728%)" offset="0.546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.26532%, 37.049866%, 92.449951%)" offset="0.550781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.379761%, 36.799622%, 92.405701%)" offset="0.554687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.494202%, 36.547852%, 92.359924%)" offset="0.558594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.608643%, 36.296082%, 92.315674%)" offset="0.5625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.721558%, 36.044312%, 92.269897%)" offset="0.566406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.835999%, 35.794067%, 92.225647%)" offset="0.570312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.948914%, 35.542297%, 92.179871%)" offset="0.574219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.063354%, 35.290527%, 92.13562%)" offset="0.578125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.177795%, 35.038757%, 92.089844%)" offset="0.582031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.292236%, 34.788513%, 92.045593%)" offset="0.585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.405151%, 34.536743%, 91.999817%)" offset="0.589844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.519592%, 34.284973%, 91.955566%)" offset="0.59375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.634033%, 34.033203%, 91.90979%)" offset="0.597656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.748474%, 33.781433%, 91.86554%)" offset="0.601562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.861389%, 33.529663%, 91.819763%)" offset="0.605469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.97583%, 33.279419%, 91.775513%)" offset="0.609375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.088745%, 33.027649%, 91.729736%)" offset="0.613281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.203186%, 32.775879%, 91.685486%)" offset="0.617187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.317627%, 32.524109%, 91.639709%)" offset="0.621094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.432068%, 32.273865%, 91.595459%)" offset="0.625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.544983%, 32.022095%, 91.549683%)" offset="0.628906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.659424%, 31.770325%, 91.505432%)" offset="0.632812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.772339%, 31.518555%, 91.459656%)" offset="0.636719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.88678%, 31.268311%, 91.415405%)" offset="0.640625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.001221%, 31.016541%, 91.369629%)" offset="0.644531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.115662%, 30.764771%, 91.325378%)" offset="0.648438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.228577%, 30.513%, 91.279602%)" offset="0.652344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.343018%, 30.262756%, 91.235352%)" offset="0.65625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.455933%, 30.010986%, 91.189575%)" offset="0.660156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.570374%, 29.759216%, 91.145325%)" offset="0.664062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.684814%, 29.507446%, 91.099548%)" offset="0.667969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.799255%, 29.257202%, 91.055298%)" offset="0.671875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.91217%, 29.005432%, 91.009521%)" offset="0.675781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.026611%, 28.753662%, 90.965271%)" offset="0.679687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.139526%, 28.501892%, 90.919495%)" offset="0.683594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.253967%, 28.251648%, 90.875244%)" offset="0.6875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.368408%, 27.999878%, 90.829468%)" offset="0.691406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.482849%, 27.748108%, 90.785217%)" offset="0.695312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.595764%, 27.496338%, 90.739441%)" offset="0.699219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.710205%, 27.244568%, 90.69519%)" offset="0.703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.824646%, 26.992798%, 90.649414%)" offset="0.707031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.939087%, 26.742554%, 90.605164%)" offset="0.710938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.052002%, 26.490784%, 90.559387%)" offset="0.714844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.166443%, 26.239014%, 90.515137%)" offset="0.71875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.279358%, 25.987244%, 90.46936%)" offset="0.722656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.393799%, 25.737%, 90.42511%)" offset="0.726562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.50824%, 25.485229%, 90.379333%)" offset="0.730469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.622681%, 25.233459%, 90.335083%)" offset="0.734375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.735596%, 24.981689%, 90.289307%)" offset="0.738281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.850037%, 24.731445%, 90.245056%)" offset="0.742187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.962952%, 24.479675%, 90.19928%)" offset="0.746094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.077393%, 24.227905%, 90.155029%)" offset="0.75"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.191833%, 23.976135%, 90.109253%)" offset="0.753906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.306274%, 23.725891%, 90.065002%)" offset="0.757812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.419189%, 23.474121%, 90.019226%)" offset="0.761719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.53363%, 23.222351%, 89.974976%)" offset="0.765625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.646545%, 22.970581%, 89.929199%)" offset="0.769531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.760986%, 22.720337%, 89.884949%)" offset="0.773438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.875427%, 22.468567%, 89.839172%)" offset="0.777344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.989868%, 22.216797%, 89.794922%)" offset="0.78125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.102783%, 21.965027%, 89.749146%)" offset="0.785156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.217224%, 21.714783%, 89.704895%)" offset="0.789062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.331665%, 21.463013%, 89.659119%)" offset="0.792969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.446106%, 21.211243%, 89.614868%)" offset="0.796875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.559021%, 20.959473%, 89.569092%)" offset="0.800781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.673462%, 20.707703%, 89.524841%)" offset="0.804687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.786377%, 20.455933%, 89.479065%)" offset="0.808594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.900818%, 20.205688%, 89.434814%)" offset="0.8125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.015259%, 19.953918%, 89.389038%)" offset="0.816406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.1297%, 19.702148%, 89.344788%)" offset="0.820312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.242615%, 19.450378%, 89.299011%)" offset="0.824219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.357056%, 19.200134%, 89.254761%)" offset="0.828125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.469971%, 18.948364%, 89.208984%)" offset="0.832031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.584412%, 18.696594%, 89.164734%)" offset="0.835938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.698853%, 18.444824%, 89.118958%)" offset="0.839844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.813293%, 18.19458%, 89.074707%)" offset="0.84375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.926208%, 17.94281%, 89.028931%)" offset="0.847656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.040649%, 17.69104%, 88.98468%)" offset="0.851562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.153564%, 17.43927%, 88.938904%)" offset="0.855469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.268005%, 17.189026%, 88.894653%)" offset="0.859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.382446%, 16.937256%, 88.848877%)" offset="0.863281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.496887%, 16.685486%, 88.804626%)" offset="0.867187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.609802%, 16.433716%, 88.75885%)" offset="0.871094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.724243%, 16.183472%, 88.7146%)" offset="0.875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.838684%, 15.931702%, 88.668823%)" offset="0.878906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.953125%, 15.679932%, 88.624573%)" offset="0.882812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.06604%, 15.428162%, 88.578796%)" offset="0.886719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.180481%, 15.177917%, 88.534546%)" offset="0.890625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.293396%, 14.926147%, 88.48877%)" offset="0.894531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.407837%, 14.674377%, 88.444519%)" offset="0.898438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.522278%, 14.422607%, 88.398743%)" offset="0.902344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.636719%, 14.170837%, 88.354492%)" offset="0.90625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.749634%, 13.919067%, 88.308716%)" offset="0.910156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.864075%, 13.668823%, 88.264465%)" offset="0.914062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.97699%, 13.417053%, 88.218689%)" offset="0.917969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.091431%, 13.165283%, 88.174438%)" offset="0.921875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.205872%, 12.913513%, 88.128662%)" offset="0.925781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.320312%, 12.663269%, 88.084412%)" offset="0.929687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.433228%, 12.411499%, 88.038635%)" offset="0.933594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.547668%, 12.159729%, 87.994385%)" offset="0.9375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.660583%, 11.907959%, 87.948608%)" offset="0.941406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.775024%, 11.657715%, 87.904358%)" offset="0.945312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.889465%, 11.405945%, 87.858582%)" offset="0.949219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.003906%, 11.154175%, 87.814331%)" offset="0.953125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.116821%, 10.902405%, 87.768555%)" offset="0.957031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.231262%, 10.652161%, 87.722778%)" offset="0.960938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.345703%, 10.400391%, 87.677002%)" offset="0.964844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.460144%, 10.148621%, 87.632751%)" offset="0.96875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.573059%, 9.896851%, 87.586975%)" offset="0.972656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.6875%, 9.646606%, 87.542725%)" offset="0.976562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.742432%, 9.52301%, 87.521362%)" offset="0.984375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="1"></stop>
                    </linearGradient>
                    <clipPath id="1d15664239">
                        <path d="M 6 6 L 49 6 L 49 70 L 6 70 Z M 6 6 " clip-rule="nonzero"></path>
                    </clipPath>
                    <clipPath id="87e1b21716">
                        <path
                            d="M 34.363281 69.101562 C 34.363281 69.101562 14.222656 45.324219 9.394531 36.660156 C 7.09375 32.539062 6.058594 28.507812 6.046875 24.746094 L 6.046875 24.679688 C 6.058594 20.574219 7.300781 16.789062 9.480469 13.609375 C 12.707031 8.910156 18.363281 6.480469 24.988281 6.480469 L 31.167969 7.144531 C 40.378906 9.054688 48.300781 11.242188 48.300781 11.242188 L 41.652344 17.074219 C 41.652344 17.074219 33.816406 14.796875 26.90625 13.78125 L 24.347656 13.574219 C 21.054688 13.574219 18.429688 14.765625 15.878906 17.980469 C 12.683594 21.988281 14.332031 30.183594 16.695312 34.378906 C 19.058594 38.578125 34.363281 69.101562 34.363281 69.101562 Z M 34.363281 69.101562 "
                            clip-rule="nonzero"></path>
                    </clipPath>
                    <linearGradient x1="-0.00000000915019"
                        gradientTransform="matrix(42.252974, 0, 0, 42.252974, 6.047577, 37.7919)" y1="0" x2="0.999996"
                        gradientUnits="userSpaceOnUse" y2="0" id="4f1e2e5bd2">
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.31073%, 72.251892%, 98.754883%)" offset="0.00390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.422119%, 72.006226%, 98.710632%)" offset="0.0078125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.533508%, 71.759033%, 98.666382%)" offset="0.0117188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.646423%, 71.513367%, 98.622131%)" offset="0.015625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.757812%, 71.266174%, 98.577881%)" offset="0.0195313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.869202%, 71.020508%, 98.535156%)" offset="0.0234375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.980591%, 70.773315%, 98.490906%)" offset="0.0273438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.093506%, 70.527649%, 98.446655%)" offset="0.03125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.204895%, 70.280457%, 98.402405%)" offset="0.0351562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.316284%, 70.03479%, 98.358154%)" offset="0.0390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.427673%, 69.787598%, 98.313904%)" offset="0.0429688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.540588%, 69.541931%, 98.269653%)" offset="0.046875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.651978%, 69.294739%, 98.225403%)" offset="0.0507812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.763367%, 69.049072%, 98.181152%)" offset="0.0546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.874756%, 68.80188%, 98.136902%)" offset="0.0585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.986145%, 68.556213%, 98.092651%)" offset="0.0625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.097534%, 68.309021%, 98.048401%)" offset="0.0664062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.210449%, 68.061829%, 98.00415%)" offset="0.0703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.321838%, 67.814636%, 97.9599%)" offset="0.0742188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.433228%, 67.56897%, 97.917175%)" offset="0.078125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.544617%, 67.321777%, 97.872925%)" offset="0.0820313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.657532%, 67.076111%, 97.828674%)" offset="0.0859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.768921%, 66.828918%, 97.784424%)" offset="0.0898438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.88031%, 66.583252%, 97.740173%)" offset="0.09375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.991699%, 66.33606%, 97.695923%)" offset="0.0976563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.104614%, 66.090393%, 97.651672%)" offset="0.101562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.216003%, 65.843201%, 97.607422%)" offset="0.105469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.327393%, 65.597534%, 97.563171%)" offset="0.109375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.438782%, 65.350342%, 97.518921%)" offset="0.113281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.550171%, 65.104675%, 97.47467%)" offset="0.117188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.66156%, 64.857483%, 97.43042%)" offset="0.121094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.774475%, 64.611816%, 97.386169%)" offset="0.125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.885864%, 64.364624%, 97.341919%)" offset="0.128906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.997253%, 64.118958%, 97.299194%)" offset="0.132812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.108643%, 63.871765%, 97.254944%)" offset="0.136719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.221558%, 63.626099%, 97.210693%)" offset="0.140625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.332947%, 63.378906%, 97.166443%)" offset="0.144531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.444336%, 63.13324%, 97.122192%)" offset="0.148438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.555725%, 62.886047%, 97.077942%)" offset="0.152344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.66864%, 62.640381%, 97.033691%)" offset="0.15625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.780029%, 62.393188%, 96.989441%)" offset="0.160156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.891418%, 62.147522%, 96.94519%)" offset="0.164063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.002808%, 61.90033%, 96.90094%)" offset="0.167969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.114197%, 61.654663%, 96.856689%)" offset="0.171875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.225586%, 61.407471%, 96.812439%)" offset="0.175781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.338501%, 61.160278%, 96.768188%)" offset="0.179688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.44989%, 60.913086%, 96.723938%)" offset="0.183594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.561279%, 60.667419%, 96.681213%)" offset="0.1875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.672668%, 60.420227%, 96.636963%)" offset="0.191406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.785583%, 60.174561%, 96.592712%)" offset="0.195313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.896973%, 59.927368%, 96.548462%)" offset="0.199219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.008362%, 59.681702%, 96.504211%)" offset="0.203125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.119751%, 59.434509%, 96.459961%)" offset="0.207031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.232666%, 59.188843%, 96.41571%)" offset="0.210938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.344055%, 58.94165%, 96.37146%)" offset="0.214844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.455444%, 58.695984%, 96.327209%)" offset="0.21875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.566833%, 58.448792%, 96.282959%)" offset="0.222656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.678223%, 58.203125%, 96.238708%)" offset="0.226563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.789612%, 57.955933%, 96.194458%)" offset="0.230469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.902527%, 57.710266%, 96.150208%)" offset="0.234375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.013916%, 57.463074%, 96.105957%)" offset="0.238281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.125305%, 57.217407%, 96.063232%)" offset="0.242188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.236694%, 56.970215%, 96.018982%)" offset="0.246094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.349609%, 56.724548%, 95.974731%)" offset="0.25"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.460999%, 56.477356%, 95.930481%)" offset="0.253906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.572388%, 56.231689%, 95.88623%)" offset="0.257812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.683777%, 55.984497%, 95.84198%)" offset="0.261719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.796692%, 55.738831%, 95.797729%)" offset="0.265625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.908081%, 55.491638%, 95.753479%)" offset="0.269531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.01947%, 55.245972%, 95.709229%)" offset="0.273438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.130859%, 54.998779%, 95.664978%)" offset="0.277344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.242249%, 54.753113%, 95.620728%)" offset="0.28125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.353638%, 54.50592%, 95.576477%)" offset="0.285156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.466553%, 54.258728%, 95.532227%)" offset="0.289062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.577942%, 54.011536%, 95.487976%)" offset="0.292969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.689331%, 53.765869%, 95.445251%)" offset="0.296875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.80072%, 53.518677%, 95.401001%)" offset="0.300781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.913635%, 53.27301%, 95.35675%)" offset="0.304688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.025024%, 53.025818%, 95.3125%)" offset="0.308594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.136414%, 52.780151%, 95.26825%)" offset="0.3125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.247803%, 52.532959%, 95.223999%)" offset="0.316406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.360718%, 52.287292%, 95.179749%)" offset="0.320313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.472107%, 52.0401%, 95.135498%)" offset="0.324219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.583496%, 51.794434%, 95.091248%)" offset="0.328125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.694885%, 51.547241%, 95.046997%)" offset="0.332031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.806274%, 51.301575%, 95.002747%)" offset="0.335938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.917664%, 51.054382%, 94.958496%)" offset="0.339844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.030579%, 50.808716%, 94.914246%)" offset="0.34375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.141968%, 50.561523%, 94.869995%)" offset="0.347656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.253357%, 50.315857%, 94.827271%)" offset="0.351563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.364746%, 50.068665%, 94.78302%)" offset="0.355469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.477661%, 49.822998%, 94.73877%)" offset="0.359375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.58905%, 49.575806%, 94.694519%)" offset="0.363281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.700439%, 49.330139%, 94.650269%)" offset="0.367188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.811829%, 49.082947%, 94.606018%)" offset="0.371094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.924744%, 48.83728%, 94.561768%)" offset="0.375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.036133%, 48.590088%, 94.517517%)" offset="0.378906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.147522%, 48.344421%, 94.473267%)" offset="0.382813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.258911%, 48.097229%, 94.429016%)" offset="0.386719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.371826%, 47.851562%, 94.384766%)" offset="0.390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.483215%, 47.60437%, 94.340515%)" offset="0.394531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.594604%, 47.357178%, 94.296265%)" offset="0.398438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.705994%, 47.109985%, 94.252014%)" offset="0.402344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.817383%, 46.864319%, 94.20929%)" offset="0.40625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.928772%, 46.617126%, 94.165039%)" offset="0.410156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.041687%, 46.37146%, 94.120789%)" offset="0.414063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.153076%, 46.124268%, 94.076538%)" offset="0.417969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.264465%, 45.878601%, 94.032288%)" offset="0.421875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.375854%, 45.631409%, 93.988037%)" offset="0.425781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.48877%, 45.385742%, 93.943787%)" offset="0.429688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.600159%, 45.13855%, 93.899536%)" offset="0.433594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.711548%, 44.892883%, 93.855286%)" offset="0.4375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.822937%, 44.645691%, 93.811035%)" offset="0.441406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.935852%, 44.400024%, 93.766785%)" offset="0.445312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.047241%, 44.152832%, 93.722534%)" offset="0.449219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.15863%, 43.907166%, 93.678284%)" offset="0.453125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.27002%, 43.659973%, 93.634033%)" offset="0.457031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.381409%, 43.414307%, 93.591309%)" offset="0.460938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.492798%, 43.167114%, 93.547058%)" offset="0.464844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.605713%, 42.921448%, 93.502808%)" offset="0.46875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.717102%, 42.674255%, 93.458557%)" offset="0.472656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.828491%, 42.428589%, 93.414307%)" offset="0.476562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.93988%, 42.181396%, 93.370056%)" offset="0.480469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.052795%, 41.93573%, 93.325806%)" offset="0.484375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.164185%, 41.688538%, 93.281555%)" offset="0.488281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.275574%, 41.442871%, 93.237305%)" offset="0.492188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.386963%, 41.195679%, 93.193054%)" offset="0.496094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.499878%, 40.950012%, 93.148804%)" offset="0.5"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.611267%, 40.70282%, 93.104553%)" offset="0.503906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.722656%, 40.457153%, 93.060303%)" offset="0.507812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.834045%, 40.209961%, 93.016052%)" offset="0.511719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.945435%, 39.962769%, 92.973328%)" offset="0.515625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.056824%, 39.715576%, 92.929077%)" offset="0.519531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.169739%, 39.46991%, 92.884827%)" offset="0.523438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.281128%, 39.222717%, 92.840576%)" offset="0.527344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.392517%, 38.977051%, 92.796326%)" offset="0.53125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.503906%, 38.729858%, 92.752075%)" offset="0.535156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.616821%, 38.484192%, 92.707825%)" offset="0.539062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.72821%, 38.237%, 92.663574%)" offset="0.542969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.8396%, 37.991333%, 92.619324%)" offset="0.546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.950989%, 37.744141%, 92.575073%)" offset="0.550781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.063904%, 37.498474%, 92.530823%)" offset="0.554687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.175293%, 37.251282%, 92.486572%)" offset="0.558594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.286682%, 37.005615%, 92.442322%)" offset="0.5625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.398071%, 36.758423%, 92.398071%)" offset="0.566406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.50946%, 36.512756%, 92.355347%)" offset="0.570312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.62085%, 36.265564%, 92.311096%)" offset="0.574219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.733765%, 36.019897%, 92.266846%)" offset="0.578125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.845154%, 35.772705%, 92.222595%)" offset="0.582031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.956543%, 35.527039%, 92.178345%)" offset="0.585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.067932%, 35.279846%, 92.134094%)" offset="0.589844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.180847%, 35.03418%, 92.089844%)" offset="0.59375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.292236%, 34.786987%, 92.045593%)" offset="0.597656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.403625%, 34.541321%, 92.001343%)" offset="0.601562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.515015%, 34.294128%, 91.957092%)" offset="0.605469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.62793%, 34.048462%, 91.912842%)" offset="0.609375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.739319%, 33.80127%, 91.868591%)" offset="0.613281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.850708%, 33.555603%, 91.824341%)" offset="0.617188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.962097%, 33.308411%, 91.78009%)" offset="0.621094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.073486%, 33.061218%, 91.737366%)" offset="0.625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.184875%, 32.814026%, 91.693115%)" offset="0.628906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.297791%, 32.568359%, 91.648865%)" offset="0.632812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.40918%, 32.321167%, 91.604614%)" offset="0.636719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.520569%, 32.0755%, 91.560364%)" offset="0.640625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.631958%, 31.828308%, 91.516113%)" offset="0.644531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.744873%, 31.582642%, 91.471863%)" offset="0.648438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.856262%, 31.335449%, 91.427612%)" offset="0.652344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.967651%, 31.089783%, 91.383362%)" offset="0.65625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.079041%, 30.84259%, 91.339111%)" offset="0.660156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.191956%, 30.596924%, 91.294861%)" offset="0.664062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.303345%, 30.349731%, 91.25061%)" offset="0.667969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.414734%, 30.104065%, 91.20636%)" offset="0.671875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.526123%, 29.856873%, 91.162109%)" offset="0.675781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.637512%, 29.611206%, 91.119385%)" offset="0.679687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.748901%, 29.364014%, 91.075134%)" offset="0.683594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.861816%, 29.118347%, 91.030884%)" offset="0.6875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.973206%, 28.871155%, 90.986633%)" offset="0.691406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.084595%, 28.625488%, 90.942383%)" offset="0.695312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.195984%, 28.378296%, 90.898132%)" offset="0.699219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.308899%, 28.132629%, 90.853882%)" offset="0.703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.420288%, 27.885437%, 90.809631%)" offset="0.707031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.531677%, 27.639771%, 90.765381%)" offset="0.710937"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.643066%, 27.392578%, 90.72113%)" offset="0.714844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.755981%, 27.146912%, 90.67688%)" offset="0.71875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.867371%, 26.899719%, 90.632629%)" offset="0.722656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.97876%, 26.654053%, 90.588379%)" offset="0.726562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.090149%, 26.40686%, 90.544128%)" offset="0.730469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.201538%, 26.159668%, 90.501404%)" offset="0.734375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.312927%, 25.912476%, 90.457153%)" offset="0.738281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.425842%, 25.666809%, 90.412903%)" offset="0.742188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.537231%, 25.419617%, 90.368652%)" offset="0.746094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.648621%, 25.17395%, 90.324402%)" offset="0.75"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.76001%, 24.926758%, 90.280151%)" offset="0.753906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.872925%, 24.681091%, 90.235901%)" offset="0.757812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.984314%, 24.433899%, 90.19165%)" offset="0.761719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.095703%, 24.188232%, 90.1474%)" offset="0.765625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.207092%, 23.94104%, 90.103149%)" offset="0.769531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.320007%, 23.695374%, 90.058899%)" offset="0.773438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.431396%, 23.448181%, 90.014648%)" offset="0.777344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.542786%, 23.202515%, 89.970398%)" offset="0.78125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.654175%, 22.955322%, 89.926147%)" offset="0.785156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.76709%, 22.709656%, 89.883423%)" offset="0.789062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.878479%, 22.462463%, 89.839172%)" offset="0.792969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.989868%, 22.216797%, 89.794922%)" offset="0.796875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.101257%, 21.969604%, 89.750671%)" offset="0.800781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.212646%, 21.723938%, 89.706421%)" offset="0.804687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.324036%, 21.476746%, 89.66217%)" offset="0.808594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.436951%, 21.231079%, 89.61792%)" offset="0.8125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.54834%, 20.983887%, 89.573669%)" offset="0.816406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.659729%, 20.73822%, 89.529419%)" offset="0.820312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.771118%, 20.491028%, 89.485168%)" offset="0.824219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.884033%, 20.245361%, 89.440918%)" offset="0.828125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.995422%, 19.998169%, 89.396667%)" offset="0.832031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.106812%, 19.752502%, 89.353943%)" offset="0.835937"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.218201%, 19.50531%, 89.309692%)" offset="0.839844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.331116%, 19.258118%, 89.265442%)" offset="0.84375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.442505%, 19.010925%, 89.221191%)" offset="0.847656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.553894%, 18.765259%, 89.176941%)" offset="0.851562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.665283%, 18.518066%, 89.13269%)" offset="0.855469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.776672%, 18.2724%, 89.08844%)" offset="0.859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.888062%, 18.025208%, 89.044189%)" offset="0.863281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.000977%, 17.779541%, 88.999939%)" offset="0.867188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.112366%, 17.532349%, 88.955688%)" offset="0.871094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.223755%, 17.286682%, 88.911438%)" offset="0.875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.335144%, 17.03949%, 88.867188%)" offset="0.878906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.448059%, 16.793823%, 88.822937%)" offset="0.882812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.559448%, 16.546631%, 88.778687%)" offset="0.886719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.670837%, 16.300964%, 88.735962%)" offset="0.890625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.782227%, 16.053772%, 88.691711%)" offset="0.894531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.895142%, 15.808105%, 88.647461%)" offset="0.898438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.006531%, 15.560913%, 88.60321%)" offset="0.902344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.11792%, 15.315247%, 88.55896%)" offset="0.90625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.229309%, 15.068054%, 88.514709%)" offset="0.910156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.340698%, 14.822388%, 88.470459%)" offset="0.914062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.452087%, 14.575195%, 88.426208%)" offset="0.917969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.565002%, 14.329529%, 88.381958%)" offset="0.921875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.676392%, 14.082336%, 88.337708%)" offset="0.925781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.787781%, 13.83667%, 88.293457%)" offset="0.929688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.89917%, 13.589478%, 88.249207%)" offset="0.933594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.012085%, 13.343811%, 88.204956%)" offset="0.9375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.123474%, 13.096619%, 88.160706%)" offset="0.941406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.234863%, 12.850952%, 88.117981%)" offset="0.945312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.346252%, 12.60376%, 88.07373%)" offset="0.949219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.459167%, 12.356567%, 88.02948%)" offset="0.953125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.570557%, 12.109375%, 87.985229%)" offset="0.957031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.681946%, 11.863708%, 87.940979%)" offset="0.960938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.793335%, 11.616516%, 87.896729%)" offset="0.964844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.904724%, 11.37085%, 87.852478%)" offset="0.96875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.016113%, 11.123657%, 87.808228%)" offset="0.972656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.129028%, 10.877991%, 87.763977%)" offset="0.976562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.240417%, 10.630798%, 87.719727%)" offset="0.980469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.351807%, 10.385132%, 87.675476%)" offset="0.984375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.463196%, 10.137939%, 87.631226%)" offset="0.988281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.576111%, 9.892273%, 87.586975%)" offset="0.992187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.6875%, 9.645081%, 87.542725%)" offset="0.996094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="1"></stop>
                    </linearGradient>
                    <clipPath id="6e95be8965">
                        <path d="M 6 46 L 69 46 L 69 89 L 6 89 Z M 6 46 " clip-rule="nonzero"></path>
                    </clipPath>
                    <clipPath id="76196fab02">
                        <path
                            d="M 24.203125 88.65625 C 20.105469 88.644531 16.347656 87.402344 13.175781 85.222656 C 7.070312 81.027344 4.792969 72.730469 6.710938 63.535156 C 8.628906 54.335938 10.808594 46.402344 10.808594 46.402344 L 16.640625 53.050781 C 16.640625 53.050781 14.363281 60.886719 13.347656 67.796875 C 12.683594 72.351562 13.535156 75.640625 17.546875 78.835938 C 19.136719 80.097656 21.390625 80.613281 23.789062 80.613281 C 27.429688 80.613281 31.417969 79.445312 33.949219 78.019531 C 38.144531 75.652344 68.660156 60.339844 68.660156 60.339844 C 68.660156 60.339844 44.890625 80.480469 36.234375 85.308594 C 32.128906 87.597656 28.105469 88.644531 24.367188 88.65625 Z M 24.203125 88.65625 "
                            clip-rule="nonzero"></path>
                    </clipPath>
                    <linearGradient x1="-1.024388"
                        gradientTransform="matrix(-11.327658, -28.581241, 28.581241, -11.327658, 37.324634, 67.195686)" y1="0"
                        x2="1.018632" gradientUnits="userSpaceOnUse" y2="0" id="cb59e3db74">
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0.5"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.385498%, 72.085571%, 98.724365%)" offset="0.503906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.573181%, 71.673584%, 98.651123%)" offset="0.507812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.800537%, 71.170044%, 98.561096%)" offset="0.511719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.029419%, 70.666504%, 98.471069%)" offset="0.515625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.256775%, 70.162964%, 98.381042%)" offset="0.519531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.485657%, 69.659424%, 98.291016%)" offset="0.523438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.714539%, 69.155884%, 98.200989%)" offset="0.527344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.94342%, 68.652344%, 98.110962%)" offset="0.53125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.170776%, 68.148804%, 98.019409%)" offset="0.535156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.399658%, 67.645264%, 97.929382%)" offset="0.539062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.627014%, 67.141724%, 97.839355%)" offset="0.542969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.855896%, 66.638184%, 97.749329%)" offset="0.546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.083252%, 66.134644%, 97.659302%)" offset="0.550781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.312134%, 65.631104%, 97.569275%)" offset="0.554688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.53949%, 65.127563%, 97.479248%)" offset="0.558594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.768372%, 64.624023%, 97.389221%)" offset="0.5625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.995728%, 64.120483%, 97.299194%)" offset="0.566406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.224609%, 63.616943%, 97.209167%)" offset="0.570313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.453491%, 63.113403%, 97.117615%)" offset="0.574219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.682373%, 62.609863%, 97.027588%)" offset="0.578125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.909729%, 62.106323%, 96.937561%)" offset="0.582031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.138611%, 61.602783%, 96.847534%)" offset="0.585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.365967%, 61.099243%, 96.757507%)" offset="0.589844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.594849%, 60.595703%, 96.66748%)" offset="0.59375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.822205%, 60.092163%, 96.577454%)" offset="0.597656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.051086%, 59.588623%, 96.487427%)" offset="0.601563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.278442%, 59.085083%, 96.3974%)" offset="0.605469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.507324%, 58.581543%, 96.307373%)" offset="0.609375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.73468%, 58.076477%, 96.21582%)" offset="0.613281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.963562%, 57.572937%, 96.125793%)" offset="0.617188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.192444%, 57.069397%, 96.035767%)" offset="0.621094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.421326%, 56.565857%, 95.94574%)" offset="0.625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.648682%, 56.062317%, 95.855713%)" offset="0.628906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.877563%, 55.558777%, 95.765686%)" offset="0.632813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.104919%, 55.055237%, 95.675659%)" offset="0.636719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.333801%, 54.551697%, 95.585632%)" offset="0.640625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.561157%, 54.048157%, 95.495605%)" offset="0.644531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.790039%, 53.544617%, 95.405579%)" offset="0.648438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.017395%, 53.041077%, 95.314026%)" offset="0.652344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.246277%, 52.537537%, 95.223999%)" offset="0.65625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.473633%, 52.033997%, 95.133972%)" offset="0.660156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.702515%, 51.530457%, 95.043945%)" offset="0.664063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.931396%, 51.026917%, 94.953918%)" offset="0.667969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.160278%, 50.523376%, 94.863892%)" offset="0.671875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.387634%, 50.019836%, 94.773865%)" offset="0.675781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.616516%, 49.516296%, 94.683838%)" offset="0.679688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.843872%, 49.012756%, 94.593811%)" offset="0.683594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.072754%, 48.509216%, 94.503784%)" offset="0.6875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.30011%, 48.005676%, 94.412231%)" offset="0.691406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.528992%, 47.502136%, 94.322205%)" offset="0.695313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.756348%, 46.998596%, 94.232178%)" offset="0.699219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.985229%, 46.495056%, 94.142151%)" offset="0.703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.212585%, 45.991516%, 94.052124%)" offset="0.707031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.441467%, 45.487976%, 93.962097%)" offset="0.710938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.670349%, 44.984436%, 93.87207%)" offset="0.714844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.899231%, 44.480896%, 93.782043%)" offset="0.71875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.126587%, 43.977356%, 93.692017%)" offset="0.722656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.355469%, 43.473816%, 93.60199%)" offset="0.726563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.582825%, 42.970276%, 93.510437%)" offset="0.730469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.811707%, 42.466736%, 93.42041%)" offset="0.734375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.039062%, 41.963196%, 93.330383%)" offset="0.738281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.267944%, 41.459656%, 93.240356%)" offset="0.742188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.4953%, 40.956116%, 93.15033%)" offset="0.746094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.724182%, 40.452576%, 93.060303%)" offset="0.75"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.951538%, 39.949036%, 92.970276%)" offset="0.753906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.18042%, 39.445496%, 92.880249%)" offset="0.757812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.409302%, 38.941956%, 92.790222%)" offset="0.761719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.638184%, 38.438416%, 92.700195%)" offset="0.765625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.86554%, 37.934875%, 92.608643%)" offset="0.769531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.094421%, 37.431335%, 92.518616%)" offset="0.773438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.321777%, 36.927795%, 92.428589%)" offset="0.777344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.550659%, 36.424255%, 92.338562%)" offset="0.78125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.778015%, 35.920715%, 92.248535%)" offset="0.785156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.006897%, 35.417175%, 92.158508%)" offset="0.789062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.234253%, 34.912109%, 92.068481%)" offset="0.792969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.463135%, 34.408569%, 91.978455%)" offset="0.796875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.690491%, 33.905029%, 91.888428%)" offset="0.800781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.919373%, 33.401489%, 91.798401%)" offset="0.804688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.148254%, 32.897949%, 91.706848%)" offset="0.808594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.377136%, 32.394409%, 91.616821%)" offset="0.8125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.604492%, 31.890869%, 91.526794%)" offset="0.816406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.833374%, 31.387329%, 91.436768%)" offset="0.820313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.06073%, 30.883789%, 91.346741%)" offset="0.824219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.289612%, 30.380249%, 91.256714%)" offset="0.828125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.516968%, 29.876709%, 91.166687%)" offset="0.832031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.74585%, 29.373169%, 91.07666%)" offset="0.835938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.973206%, 28.869629%, 90.986633%)" offset="0.839844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.202087%, 28.366089%, 90.896606%)" offset="0.84375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.429443%, 27.862549%, 90.805054%)" offset="0.847656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.658325%, 27.359009%, 90.715027%)" offset="0.851563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.887207%, 26.855469%, 90.625%)" offset="0.855469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.116089%, 26.351929%, 90.534973%)" offset="0.859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.343445%, 25.848389%, 90.444946%)" offset="0.863281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.572327%, 25.344849%, 90.354919%)" offset="0.867188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.799683%, 24.841309%, 90.264893%)" offset="0.871094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.028564%, 24.337769%, 90.174866%)" offset="0.875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.25592%, 23.834229%, 90.084839%)" offset="0.878906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.484802%, 23.330688%, 89.994812%)" offset="0.882813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.712158%, 22.827148%, 89.903259%)" offset="0.886719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.94104%, 22.323608%, 89.813232%)" offset="0.890625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.168396%, 21.820068%, 89.723206%)" offset="0.894531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.397278%, 21.316528%, 89.633179%)" offset="0.898438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.624634%, 20.812988%, 89.543152%)" offset="0.902344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.853516%, 20.309448%, 89.453125%)" offset="0.90625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.082397%, 19.805908%, 89.363098%)" offset="0.910156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.311279%, 19.302368%, 89.273071%)" offset="0.914063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.538635%, 18.798828%, 89.183044%)" offset="0.917969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.767517%, 18.295288%, 89.093018%)" offset="0.921875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.994873%, 17.791748%, 89.001465%)" offset="0.925781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.223755%, 17.288208%, 88.911438%)" offset="0.929688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.451111%, 16.784668%, 88.821411%)" offset="0.933594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.679993%, 16.281128%, 88.731384%)" offset="0.9375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.907349%, 15.777588%, 88.641357%)" offset="0.941406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.13623%, 15.274048%, 88.551331%)" offset="0.945313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.363586%, 14.770508%, 88.461304%)" offset="0.949219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.592468%, 14.266968%, 88.371277%)" offset="0.953125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.82135%, 13.763428%, 88.28125%)" offset="0.957031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.050232%, 13.259888%, 88.191223%)" offset="0.960938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.277588%, 12.756348%, 88.09967%)" offset="0.964844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.50647%, 12.252808%, 88.009644%)" offset="0.96875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.733826%, 11.749268%, 87.919617%)" offset="0.972656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.962708%, 11.245728%, 87.82959%)" offset="0.976563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.190063%, 10.740662%, 87.739563%)" offset="0.980469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.418945%, 10.237122%, 87.649536%)" offset="0.984375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.608154%, 9.817505%, 87.574768%)" offset="0.988281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="0.992188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="1"></stop>
                    </linearGradient>
                    <clipPath id="84b925d3a2">
                        <path d="M 45 25 L 88 25 L 88 89 L 45 89 Z M 45 25 " clip-rule="nonzero"></path>
                    </clipPath>
                    <clipPath id="6c719ccf1e">
                        <path
                            d="M 69.019531 88.054688 L 62.839844 87.390625 C 53.640625 85.484375 45.707031 83.292969 45.707031 83.292969 L 52.355469 77.460938 C 52.355469 77.460938 60.191406 79.738281 67.101562 80.753906 L 69.660156 80.960938 C 72.953125 80.960938 75.578125 79.773438 78.128906 76.558594 C 81.324219 72.546875 79.675781 64.351562 77.3125 60.15625 C 74.945312 55.960938 59.644531 25.433594 59.644531 25.433594 C 59.644531 25.433594 79.785156 49.214844 84.613281 57.878906 C 86.902344 61.984375 87.949219 66.007812 87.960938 69.746094 L 87.960938 69.898438 C 87.949219 73.996094 86.707031 77.757812 84.527344 80.925781 C 81.300781 85.625 75.644531 88.054688 69.019531 88.054688 Z M 69.019531 88.054688 "
                            clip-rule="nonzero"></path>
                    </clipPath>
                    <linearGradient x1="-1.293939"
                        gradientTransform="matrix(-11.327811, 27.361262, -27.361262, -11.327811, 69.758816, 59.370149)" y1="0"
                        x2="1.205659" gradientUnits="userSpaceOnUse" y2="0" id="5df8d35ce1">
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0.5"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0.515625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.405334%, 72.042847%, 98.716736%)" offset="0.519531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.612854%, 71.588135%, 98.635864%)" offset="0.523438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.89209%, 70.97168%, 98.524475%)" offset="0.527344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.171326%, 70.355225%, 98.414612%)" offset="0.53125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.450562%, 69.73877%, 98.304749%)" offset="0.535156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.729797%, 69.12384%, 98.194885%)" offset="0.539063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.009033%, 68.507385%, 98.083496%)" offset="0.542969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.288269%, 67.89093%, 97.973633%)" offset="0.546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.567505%, 67.274475%, 97.86377%)" offset="0.550781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.846741%, 66.659546%, 97.753906%)" offset="0.554688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.125977%, 66.043091%, 97.642517%)" offset="0.558594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.405212%, 65.426636%, 97.532654%)" offset="0.5625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.684448%, 64.810181%, 97.421265%)" offset="0.566406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.963684%, 64.193726%, 97.311401%)" offset="0.570312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.24292%, 63.577271%, 97.201538%)" offset="0.574219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.522156%, 62.962341%, 97.091675%)" offset="0.578125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.801392%, 62.345886%, 96.980286%)" offset="0.582031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.080627%, 61.729431%, 96.870422%)" offset="0.585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.359863%, 61.112976%, 96.760559%)" offset="0.589844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.639099%, 60.498047%, 96.650696%)" offset="0.59375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.918335%, 59.881592%, 96.539307%)" offset="0.597656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.197571%, 59.265137%, 96.429443%)" offset="0.601562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.476807%, 58.648682%, 96.318054%)" offset="0.605469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.756042%, 58.033752%, 96.208191%)" offset="0.609375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.035278%, 57.417297%, 96.098328%)" offset="0.613281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.314514%, 56.800842%, 95.988464%)" offset="0.617188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.59375%, 56.184387%, 95.877075%)" offset="0.621094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.872986%, 55.569458%, 95.767212%)" offset="0.625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.152222%, 54.953003%, 95.655823%)" offset="0.628906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.431458%, 54.336548%, 95.545959%)" offset="0.632813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.710693%, 53.720093%, 95.436096%)" offset="0.636719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.989929%, 53.105164%, 95.326233%)" offset="0.640625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.269165%, 52.488708%, 95.214844%)" offset="0.644531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.548401%, 51.872253%, 95.10498%)" offset="0.648438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.827637%, 51.255798%, 94.995117%)" offset="0.652344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.106873%, 50.639343%, 94.885254%)" offset="0.65625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.386108%, 50.022888%, 94.773865%)" offset="0.660156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.665344%, 49.407959%, 94.664001%)" offset="0.664063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.94458%, 48.791504%, 94.552612%)" offset="0.667969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.223816%, 48.175049%, 94.442749%)" offset="0.671875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.503052%, 47.558594%, 94.332886%)" offset="0.675781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.782288%, 46.943665%, 94.223022%)" offset="0.679688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.061523%, 46.327209%, 94.111633%)" offset="0.683594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.340759%, 45.710754%, 94.00177%)" offset="0.6875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.619995%, 45.094299%, 93.891907%)" offset="0.691406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.899231%, 44.47937%, 93.782043%)" offset="0.695313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.178467%, 43.862915%, 93.670654%)" offset="0.699219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.457703%, 43.24646%, 93.560791%)" offset="0.703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.736938%, 42.630005%, 93.449402%)" offset="0.707031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.016174%, 42.015076%, 93.339539%)" offset="0.710938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.29541%, 41.398621%, 93.229675%)" offset="0.714844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.574646%, 40.782166%, 93.119812%)" offset="0.71875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.853882%, 40.16571%, 93.008423%)" offset="0.722656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.133118%, 39.549255%, 92.89856%)" offset="0.726562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.412354%, 38.9328%, 92.78717%)" offset="0.730469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.691589%, 38.317871%, 92.677307%)" offset="0.734375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.970825%, 37.701416%, 92.567444%)" offset="0.738281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.250061%, 37.084961%, 92.457581%)" offset="0.742188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.529297%, 36.468506%, 92.346191%)" offset="0.746094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.808533%, 35.853577%, 92.236328%)" offset="0.75"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.087769%, 35.237122%, 92.126465%)" offset="0.753906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.367004%, 34.620667%, 92.016602%)" offset="0.757813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.64624%, 34.004211%, 91.905212%)" offset="0.761719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.925476%, 33.389282%, 91.795349%)" offset="0.765625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.204712%, 32.772827%, 91.68396%)" offset="0.769531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.483948%, 32.156372%, 91.574097%)" offset="0.773438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.763184%, 31.539917%, 91.464233%)" offset="0.777344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.042419%, 30.924988%, 91.35437%)" offset="0.78125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.321655%, 30.308533%, 91.242981%)" offset="0.785156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.600891%, 29.692078%, 91.133118%)" offset="0.789063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.880127%, 29.075623%, 91.023254%)" offset="0.792969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.159363%, 28.460693%, 90.913391%)" offset="0.796875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.438599%, 27.844238%, 90.802002%)" offset="0.800781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.717834%, 27.227783%, 90.692139%)" offset="0.804688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.99707%, 26.611328%, 90.58075%)" offset="0.808594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.276306%, 25.994873%, 90.470886%)" offset="0.8125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.555542%, 25.378418%, 90.361023%)" offset="0.816406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.834778%, 24.763489%, 90.25116%)" offset="0.820312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.114014%, 24.147034%, 90.139771%)" offset="0.824219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.39325%, 23.530579%, 90.029907%)" offset="0.828125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.672485%, 22.914124%, 89.918518%)" offset="0.832031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.953247%, 22.299194%, 89.808655%)" offset="0.835938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.232483%, 21.682739%, 89.698792%)" offset="0.839844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.511719%, 21.066284%, 89.588928%)" offset="0.84375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.790955%, 20.449829%, 89.477539%)" offset="0.847656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.07019%, 19.8349%, 89.367676%)" offset="0.851562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.349426%, 19.218445%, 89.257812%)" offset="0.855469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.628662%, 18.60199%, 89.147949%)" offset="0.859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.907898%, 17.985535%, 89.03656%)" offset="0.863281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.187134%, 17.370605%, 88.926697%)" offset="0.867188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.46637%, 16.75415%, 88.815308%)" offset="0.871094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.745605%, 16.137695%, 88.705444%)" offset="0.875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.024841%, 15.52124%, 88.595581%)" offset="0.878906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.304077%, 14.904785%, 88.485718%)" offset="0.882813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.583313%, 14.28833%, 88.374329%)" offset="0.886719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.862549%, 13.673401%, 88.264465%)" offset="0.890625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.141785%, 13.056946%, 88.153076%)" offset="0.894531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.421021%, 12.440491%, 88.043213%)" offset="0.898438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.700256%, 11.824036%, 87.93335%)" offset="0.902344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.979492%, 11.209106%, 87.823486%)" offset="0.90625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.258728%, 10.592651%, 87.712097%)" offset="0.910156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.537964%, 9.976196%, 87.602234%)" offset="0.914063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.667664%, 9.687805%, 87.550354%)" offset="0.917969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="0.921875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="0.9375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="1"></stop>
                    </linearGradient>
                    <clipPath id="450a7c31f0">
                        <path d="M 40 40 L 53 40 L 53 53 L 40 53 Z M 40 40 " clip-rule="nonzero"></path>
                    </clipPath>
                    <clipPath id="2cf3a97b88">
                        <path
                            d="M 46.242188 52.394531 L 45.347656 52.351562 C 42.710938 51.761719 40.945312 50.007812 40.464844 47.828125 C 39.605469 43.960938 42.523438 40.539062 46.242188 40.539062 L 46.6875 40.539062 L 47.601562 40.691406 C 49.78125 41.171875 51.539062 42.9375 52.027344 45.117188 C 52.886719 48.984375 49.96875 52.394531 46.25 52.394531 Z M 46.242188 52.394531 "
                            clip-rule="nonzero"></path>
                    </clipPath>
                    <linearGradient x1="-0.0597346" gradientTransform="matrix(11.858981, 0, 0, 11.858981, 40.311914, 46.46697)"
                        y1="0" x2="1.060519" gradientUnits="userSpaceOnUse" y2="0" id="846ace280f">
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0.03125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.199341%, 72.499084%, 98.799133%)" offset="0.046875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.220703%, 72.450256%, 98.789978%)" offset="0.0546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.368713%, 72.12677%, 98.731995%)" offset="0.0585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.493835%, 71.850586%, 98.683167%)" offset="0.0625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.618958%, 71.574402%, 98.632812%)" offset="0.0664062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.74408%, 71.298218%, 98.583984%)" offset="0.0703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.869202%, 71.022034%, 98.53363%)" offset="0.0742188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(1.994324%, 70.74585%, 98.484802%)" offset="0.078125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.119446%, 70.469666%, 98.434448%)" offset="0.0820312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.244568%, 70.193481%, 98.38562%)" offset="0.0859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.36969%, 69.917297%, 98.336792%)" offset="0.0898438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.494812%, 69.641113%, 98.287964%)" offset="0.09375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.619934%, 69.364929%, 98.23761%)" offset="0.0976562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.745056%, 69.088745%, 98.188782%)" offset="0.101563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.870178%, 68.812561%, 98.138428%)" offset="0.105469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(2.9953%, 68.536377%, 98.0896%)" offset="0.109375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.120422%, 68.260193%, 98.039246%)" offset="0.113281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.245544%, 67.984009%, 97.990417%)" offset="0.117188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.370667%, 67.707825%, 97.940063%)" offset="0.121094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.495789%, 67.433167%, 97.891235%)" offset="0.125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.620911%, 67.156982%, 97.842407%)" offset="0.128906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.746033%, 66.880798%, 97.793579%)" offset="0.132812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.871155%, 66.604614%, 97.743225%)" offset="0.136719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(3.996277%, 66.32843%, 97.694397%)" offset="0.140625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.121399%, 66.052246%, 97.644043%)" offset="0.144531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.246521%, 65.776062%, 97.595215%)" offset="0.148438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.371643%, 65.499878%, 97.544861%)" offset="0.152344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.496765%, 65.223694%, 97.496033%)" offset="0.15625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.621887%, 64.94751%, 97.445679%)" offset="0.160156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.747009%, 64.671326%, 97.396851%)" offset="0.164062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.872131%, 64.395142%, 97.348022%)" offset="0.167969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(4.997253%, 64.118958%, 97.299194%)" offset="0.171875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.122375%, 63.842773%, 97.24884%)" offset="0.175781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.247498%, 63.566589%, 97.200012%)" offset="0.179688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.37262%, 63.290405%, 97.149658%)" offset="0.183594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.497742%, 63.014221%, 97.10083%)" offset="0.1875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.622864%, 62.738037%, 97.050476%)" offset="0.191406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.747986%, 62.461853%, 97.001648%)" offset="0.195313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.873108%, 62.185669%, 96.951294%)" offset="0.199219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(5.99823%, 61.909485%, 96.902466%)" offset="0.203125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.123352%, 61.633301%, 96.852112%)" offset="0.207031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.248474%, 61.357117%, 96.803284%)" offset="0.210938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.373596%, 61.080933%, 96.754456%)" offset="0.214844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.498718%, 60.804749%, 96.705627%)" offset="0.21875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.62384%, 60.528564%, 96.655273%)" offset="0.222656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.748962%, 60.253906%, 96.606445%)" offset="0.226562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(6.874084%, 59.977722%, 96.556091%)" offset="0.230469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.000732%, 59.701538%, 96.507263%)" offset="0.234375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.125854%, 59.425354%, 96.456909%)" offset="0.238281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.250977%, 59.14917%, 96.408081%)" offset="0.242188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.376099%, 58.872986%, 96.357727%)" offset="0.246094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.501221%, 58.596802%, 96.308899%)" offset="0.25"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.626343%, 58.320618%, 96.260071%)" offset="0.253906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.751465%, 58.044434%, 96.211243%)" offset="0.257812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(7.876587%, 57.76825%, 96.160889%)" offset="0.261719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.001709%, 57.492065%, 96.112061%)" offset="0.265625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.126831%, 57.215881%, 96.061707%)" offset="0.269531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.251953%, 56.939697%, 96.012878%)" offset="0.273438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.377075%, 56.663513%, 95.962524%)" offset="0.277344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.502197%, 56.387329%, 95.913696%)" offset="0.28125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.627319%, 56.111145%, 95.863342%)" offset="0.285156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.752441%, 55.834961%, 95.814514%)" offset="0.289062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(8.877563%, 55.558777%, 95.765686%)" offset="0.292969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.002686%, 55.282593%, 95.716858%)" offset="0.296875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.127808%, 55.006409%, 95.666504%)" offset="0.300781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.25293%, 54.730225%, 95.617676%)" offset="0.304688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.378052%, 54.454041%, 95.567322%)" offset="0.308594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.503174%, 54.177856%, 95.518494%)" offset="0.3125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.628296%, 53.901672%, 95.46814%)" offset="0.316406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.753418%, 53.625488%, 95.419312%)" offset="0.320312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(9.87854%, 53.349304%, 95.368958%)" offset="0.324219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.003662%, 53.074646%, 95.320129%)" offset="0.328125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.128784%, 52.798462%, 95.269775%)" offset="0.332031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.253906%, 52.522278%, 95.220947%)" offset="0.335937"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.379028%, 52.246094%, 95.172119%)" offset="0.339844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.50415%, 51.96991%, 95.123291%)" offset="0.34375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.629272%, 51.693726%, 95.072937%)" offset="0.347656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.754395%, 51.417542%, 95.024109%)" offset="0.351562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(10.879517%, 51.141357%, 94.973755%)" offset="0.355469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.004639%, 50.865173%, 94.924927%)" offset="0.359375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.129761%, 50.588989%, 94.874573%)" offset="0.363281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.254883%, 50.312805%, 94.825745%)" offset="0.367187"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.380005%, 50.036621%, 94.775391%)" offset="0.371094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.505127%, 49.760437%, 94.726562%)" offset="0.375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.630249%, 49.484253%, 94.677734%)" offset="0.378906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.755371%, 49.208069%, 94.628906%)" offset="0.382813"></stop>
                        <stop stop-opacity="1" stop-color="rgb(11.880493%, 48.931885%, 94.578552%)" offset="0.386719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.005615%, 48.655701%, 94.529724%)" offset="0.390625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.130737%, 48.379517%, 94.47937%)" offset="0.394531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.255859%, 48.103333%, 94.430542%)" offset="0.398438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.380981%, 47.827148%, 94.380188%)" offset="0.402344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.506104%, 47.550964%, 94.33136%)" offset="0.40625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.631226%, 47.27478%, 94.281006%)" offset="0.410156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.756348%, 46.998596%, 94.232178%)" offset="0.414063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(12.88147%, 46.722412%, 94.18335%)" offset="0.417969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.008118%, 46.447754%, 94.134521%)" offset="0.421875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.13324%, 46.17157%, 94.084167%)" offset="0.425781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.258362%, 45.895386%, 94.035339%)" offset="0.429688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.383484%, 45.619202%, 93.984985%)" offset="0.433594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.508606%, 45.343018%, 93.936157%)" offset="0.4375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.633728%, 45.066833%, 93.885803%)" offset="0.441406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.75885%, 44.790649%, 93.836975%)" offset="0.445312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(13.883972%, 44.514465%, 93.786621%)" offset="0.449219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.009094%, 44.238281%, 93.737793%)" offset="0.453125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.134216%, 43.962097%, 93.687439%)" offset="0.457031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.259338%, 43.685913%, 93.638611%)" offset="0.460938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.38446%, 43.409729%, 93.589783%)" offset="0.464844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.509583%, 43.133545%, 93.540955%)" offset="0.46875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.634705%, 42.857361%, 93.490601%)" offset="0.472656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.759827%, 42.581177%, 93.441772%)" offset="0.476562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(14.884949%, 42.304993%, 93.391418%)" offset="0.480469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.010071%, 42.028809%, 93.34259%)" offset="0.484375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.135193%, 41.752625%, 93.292236%)" offset="0.488281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.260315%, 41.47644%, 93.243408%)" offset="0.492188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.385437%, 41.200256%, 93.193054%)" offset="0.496094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.510559%, 40.924072%, 93.144226%)" offset="0.5"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.635681%, 40.647888%, 93.095398%)" offset="0.503906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.760803%, 40.371704%, 93.04657%)" offset="0.507812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(15.885925%, 40.09552%, 92.996216%)" offset="0.511719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.011047%, 39.819336%, 92.947388%)" offset="0.515625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.136169%, 39.543152%, 92.897034%)" offset="0.519531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.261292%, 39.268494%, 92.848206%)" offset="0.523438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.386414%, 38.99231%, 92.797852%)" offset="0.527344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.511536%, 38.716125%, 92.749023%)" offset="0.53125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.636658%, 38.439941%, 92.698669%)" offset="0.535156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.76178%, 38.163757%, 92.649841%)" offset="0.539062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(16.886902%, 37.887573%, 92.601013%)" offset="0.542969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.012024%, 37.611389%, 92.552185%)" offset="0.546875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.137146%, 37.335205%, 92.501831%)" offset="0.550781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.262268%, 37.059021%, 92.453003%)" offset="0.554688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.38739%, 36.782837%, 92.402649%)" offset="0.558594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.512512%, 36.506653%, 92.353821%)" offset="0.5625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.637634%, 36.230469%, 92.303467%)" offset="0.566406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.762756%, 35.954285%, 92.254639%)" offset="0.570312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(17.887878%, 35.678101%, 92.204285%)" offset="0.574219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.013%, 35.401917%, 92.155457%)" offset="0.578125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.138123%, 35.125732%, 92.105103%)" offset="0.582031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.263245%, 34.849548%, 92.056274%)" offset="0.585938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.388367%, 34.573364%, 92.007446%)" offset="0.589844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.513489%, 34.29718%, 91.958618%)" offset="0.59375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.638611%, 34.020996%, 91.908264%)" offset="0.597656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.763733%, 33.744812%, 91.859436%)" offset="0.601562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(18.888855%, 33.468628%, 91.809082%)" offset="0.605469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.015503%, 33.192444%, 91.760254%)" offset="0.609375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.140625%, 32.91626%, 91.7099%)" offset="0.613281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.265747%, 32.640076%, 91.661072%)" offset="0.617188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.390869%, 32.363892%, 91.610718%)" offset="0.621094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.515991%, 32.089233%, 91.56189%)" offset="0.625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.641113%, 31.813049%, 91.513062%)" offset="0.628906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.766235%, 31.536865%, 91.464233%)" offset="0.632812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(19.891357%, 31.260681%, 91.413879%)" offset="0.636719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.016479%, 30.984497%, 91.365051%)" offset="0.640625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.141602%, 30.708313%, 91.314697%)" offset="0.644531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.266724%, 30.432129%, 91.265869%)" offset="0.648437"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.391846%, 30.155945%, 91.215515%)" offset="0.652344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.516968%, 29.879761%, 91.166687%)" offset="0.65625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.64209%, 29.603577%, 91.116333%)" offset="0.660156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.767212%, 29.327393%, 91.067505%)" offset="0.664062"></stop>
                        <stop stop-opacity="1" stop-color="rgb(20.892334%, 29.051208%, 91.017151%)" offset="0.667969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.017456%, 28.775024%, 90.968323%)" offset="0.671875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.142578%, 28.49884%, 90.919495%)" offset="0.675781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.2677%, 28.222656%, 90.870667%)" offset="0.679687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.392822%, 27.946472%, 90.820312%)" offset="0.683594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.517944%, 27.670288%, 90.771484%)" offset="0.6875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.643066%, 27.394104%, 90.72113%)" offset="0.691406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.768188%, 27.11792%, 90.672302%)" offset="0.695312"></stop>
                        <stop stop-opacity="1" stop-color="rgb(21.893311%, 26.841736%, 90.621948%)" offset="0.699219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.018433%, 26.565552%, 90.57312%)" offset="0.703125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.143555%, 26.289368%, 90.522766%)" offset="0.707031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.268677%, 26.013184%, 90.473938%)" offset="0.710937"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.393799%, 25.737%, 90.42511%)" offset="0.714844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.518921%, 25.460815%, 90.376282%)" offset="0.71875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.644043%, 25.184631%, 90.325928%)" offset="0.722656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.769165%, 24.909973%, 90.2771%)" offset="0.726562"></stop>
                        <stop stop-opacity="1" stop-color="rgb(22.894287%, 24.633789%, 90.226746%)" offset="0.730469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.019409%, 24.357605%, 90.177917%)" offset="0.734375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.144531%, 24.081421%, 90.127563%)" offset="0.738281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.269653%, 23.805237%, 90.078735%)" offset="0.742188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.394775%, 23.529053%, 90.028381%)" offset="0.746094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.519897%, 23.252869%, 89.979553%)" offset="0.75"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.64502%, 22.976685%, 89.930725%)" offset="0.753906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.770142%, 22.7005%, 89.881897%)" offset="0.757812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(23.895264%, 22.424316%, 89.831543%)" offset="0.761719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.020386%, 22.148132%, 89.782715%)" offset="0.765625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.145508%, 21.871948%, 89.732361%)" offset="0.769531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.27063%, 21.595764%, 89.683533%)" offset="0.773438"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.395752%, 21.31958%, 89.633179%)" offset="0.777344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.520874%, 21.043396%, 89.584351%)" offset="0.78125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.645996%, 20.767212%, 89.533997%)" offset="0.785156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.771118%, 20.491028%, 89.485168%)" offset="0.789063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(24.89624%, 20.214844%, 89.434814%)" offset="0.792969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.021362%, 19.93866%, 89.385986%)" offset="0.796875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.146484%, 19.662476%, 89.337158%)" offset="0.800781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.273132%, 19.386292%, 89.28833%)" offset="0.804688"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.398254%, 19.110107%, 89.237976%)" offset="0.808594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.523376%, 18.833923%, 89.189148%)" offset="0.8125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.648499%, 18.557739%, 89.138794%)" offset="0.816406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.773621%, 18.281555%, 89.089966%)" offset="0.820313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(25.898743%, 18.005371%, 89.039612%)" offset="0.824219"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.023865%, 17.730713%, 88.990784%)" offset="0.828125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.148987%, 17.454529%, 88.94043%)" offset="0.832031"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.274109%, 17.178345%, 88.891602%)" offset="0.835938"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.399231%, 16.902161%, 88.842773%)" offset="0.839844"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.524353%, 16.625977%, 88.793945%)" offset="0.84375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.649475%, 16.349792%, 88.743591%)" offset="0.847656"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.774597%, 16.073608%, 88.694763%)" offset="0.851563"></stop>
                        <stop stop-opacity="1" stop-color="rgb(26.899719%, 15.797424%, 88.644409%)" offset="0.855469"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.024841%, 15.52124%, 88.595581%)" offset="0.859375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.149963%, 15.245056%, 88.545227%)" offset="0.863281"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.275085%, 14.968872%, 88.496399%)" offset="0.867188"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.400208%, 14.692688%, 88.446045%)" offset="0.871094"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.52533%, 14.416504%, 88.397217%)" offset="0.875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.650452%, 14.14032%, 88.348389%)" offset="0.878906"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.775574%, 13.864136%, 88.299561%)" offset="0.882812"></stop>
                        <stop stop-opacity="1" stop-color="rgb(27.900696%, 13.587952%, 88.249207%)" offset="0.886719"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.025818%, 13.311768%, 88.200378%)" offset="0.890625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.15094%, 13.035583%, 88.150024%)" offset="0.894531"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.276062%, 12.759399%, 88.101196%)" offset="0.898437"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.401184%, 12.483215%, 88.050842%)" offset="0.902344"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.526306%, 12.207031%, 88.002014%)" offset="0.90625"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.651428%, 11.930847%, 87.95166%)" offset="0.910156"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.77655%, 11.654663%, 87.902832%)" offset="0.914063"></stop>
                        <stop stop-opacity="1" stop-color="rgb(28.901672%, 11.378479%, 87.852478%)" offset="0.917969"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.026794%, 11.102295%, 87.80365%)" offset="0.921875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.151917%, 10.826111%, 87.754822%)" offset="0.925781"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.277039%, 10.551453%, 87.705994%)" offset="0.929687"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.402161%, 10.275269%, 87.65564%)" offset="0.933594"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.527283%, 9.999084%, 87.606812%)" offset="0.9375"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.652405%, 9.7229%, 87.556458%)" offset="0.941406"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.777527%, 9.446716%, 87.507629%)" offset="0.945313"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.788208%, 9.422302%, 87.503052%)" offset="0.953125"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="0.96875"></stop>
                        <stop stop-opacity="1" stop-color="rgb(29.798889%, 9.399414%, 87.5%)" offset="1"></stop>
                    </linearGradient>
                </defs>
                <g clip-path="url(#8f9413e177)">
                    <g clip-path="url(#0b6c990748)">
                        <path fill="url(#fe806c4cf7)"
                            d="M 25.335938 5.882812 L 25.335938 48.132812 L 89.210938 48.132812 L 89.210938 5.882812 Z M 25.335938 5.882812 "
                            fill-rule="nonzero"></path>
                    </g>
                </g>
                <g clip-path="url(#1d15664239)">
                    <g clip-path="url(#87e1b21716)">
                        <path fill="url(#4f1e2e5bd2)"
                            d="M 6.046875 6.480469 L 6.046875 69.101562 L 48.300781 69.101562 L 48.300781 6.480469 Z M 6.046875 6.480469 "
                            fill-rule="nonzero"></path>
                    </g>
                </g>
                <g clip-path="url(#6e95be8965)">
                    <g clip-path="url(#76196fab02)">
                        <path fill="url(#cb59e3db74)"
                            d="M 13.464844 110.53125 L 83.132812 82.917969 L 59.988281 24.527344 L -9.679688 52.136719 Z M 13.464844 110.53125 "
                            fill-rule="nonzero"></path>
                    </g>
                </g>
                <g clip-path="url(#84b925d3a2)">
                    <g clip-path="url(#6c719ccf1e)">
                        <path fill="url(#5df8d35ce1)"
                            d="M 110.09375 34.597656 L 51.890625 10.5 L 23.574219 78.890625 L 81.777344 102.988281 Z M 110.09375 34.597656 "
                            fill-rule="nonzero"></path>
                    </g>
                </g>
                <g clip-path="url(#450a7c31f0)">
                    <g clip-path="url(#2cf3a97b88)">
                        <path fill="url(#846ace280f)"
                            d="M 39.605469 40.539062 L 39.605469 52.394531 L 52.886719 52.394531 L 52.886719 40.539062 Z M 39.605469 40.539062 "
                            fill-rule="nonzero"></path>
                    </g>
                </g>
                <g fill="#000000" fill-opacity="1">
                    <g transform="translate(108.54064, 72.51246)">
                        <g>
                            <path
                                d="M 11.484375 0 C 9.742188 0 8.410156 -0.457031 7.484375 -1.375 C 6.554688 -2.300781 6.09375 -3.640625 6.09375 -5.390625 L 6.09375 -50.4375 C 6.09375 -52.1875 6.554688 -53.519531 7.484375 -54.4375 C 8.410156 -55.363281 9.742188 -55.828125 11.484375 -55.828125 L 30.484375 -55.828125 C 34.390625 -55.828125 37.710938 -55.242188 40.453125 -54.078125 C 43.203125 -52.921875 45.300781 -51.257812 46.75 -49.09375 C 48.207031 -46.925781 48.9375 -44.335938 48.9375 -41.328125 C 48.9375 -37.953125 47.957031 -35.101562 46 -32.78125 C 44.050781 -30.457031 41.390625 -28.898438 38.015625 -28.109375 L 38.015625 -29.296875 C 41.921875 -28.710938 44.953125 -27.234375 47.109375 -24.859375 C 49.273438 -22.484375 50.359375 -19.394531 50.359375 -15.59375 C 50.359375 -10.632812 48.679688 -6.796875 45.328125 -4.078125 C 41.984375 -1.359375 37.328125 0 31.359375 0 Z M 15.84375 -7.6875 L 30.09375 -7.6875 C 33.675781 -7.6875 36.3125 -8.382812 38 -9.78125 C 39.695312 -11.175781 40.546875 -13.273438 40.546875 -16.078125 C 40.546875 -18.921875 39.695312 -21.03125 38 -22.40625 C 36.3125 -23.78125 33.675781 -24.46875 30.09375 -24.46875 L 15.84375 -24.46875 Z M 15.84375 -32.15625 L 28.75 -32.15625 C 32.226562 -32.15625 34.828125 -32.828125 36.546875 -34.171875 C 38.265625 -35.515625 39.125 -37.503906 39.125 -40.140625 C 39.125 -42.785156 38.265625 -44.78125 36.546875 -46.125 C 34.828125 -47.46875 32.226562 -48.140625 28.75 -48.140625 L 15.84375 -48.140625 Z M 15.84375 -32.15625 ">
                            </path>
                        </g>
                    </g>
                </g>
                <g fill="#000000" fill-opacity="1">
                    <g transform="translate(163.026394, 72.51246)">
                        <g>
                            <path
                                d="M 28.265625 0.640625 C 26.835938 0.640625 25.660156 0.3125 24.734375 -0.34375 C 23.816406 -1.007812 23.066406 -2.003906 22.484375 -3.328125 L 1.828125 -49.734375 C 1.242188 -51.046875 1.082031 -52.203125 1.34375 -53.203125 C 1.601562 -54.210938 2.15625 -55.003906 3 -55.578125 C 3.851562 -56.160156 4.859375 -56.453125 6.015625 -56.453125 C 7.546875 -56.453125 8.691406 -56.125 9.453125 -55.46875 C 10.222656 -54.8125 10.875 -53.820312 11.40625 -52.5 L 30.171875 -9.03125 L 26.765625 -9.03125 L 45.453125 -52.578125 C 46.035156 -53.847656 46.722656 -54.8125 47.515625 -55.46875 C 48.304688 -56.125 49.414062 -56.453125 50.84375 -56.453125 C 52 -56.453125 52.957031 -56.160156 53.71875 -55.578125 C 54.488281 -55.003906 54.976562 -54.210938 55.1875 -53.203125 C 55.40625 -52.203125 55.222656 -51.046875 54.640625 -49.734375 L 33.96875 -3.328125 C 33.382812 -2.003906 32.65625 -1.007812 31.78125 -0.34375 C 30.914062 0.3125 29.742188 0.640625 28.265625 0.640625 Z M 28.265625 0.640625 ">
                            </path>
                        </g>
                    </g>
                </g>
                <g fill="#000000" fill-opacity="1">
                    <g transform="translate(219.492019, 72.51246)">
                        <g>
                            <path
                                d="M 10.84375 0.640625 C 9.3125 0.640625 8.132812 0.21875 7.3125 -0.625 C 6.5 -1.476562 6.09375 -2.695312 6.09375 -4.28125 L 6.09375 -51.390625 C 6.09375 -53.023438 6.5 -54.273438 7.3125 -55.140625 C 8.132812 -56.015625 9.207031 -56.453125 10.53125 -56.453125 C 11.75 -56.453125 12.660156 -56.226562 13.265625 -55.78125 C 13.867188 -55.332031 14.59375 -54.582031 15.4375 -53.53125 L 45.765625 -14.171875 L 43.71875 -14.171875 L 43.71875 -51.625 C 43.71875 -53.15625 44.125 -54.34375 44.9375 -55.1875 C 45.757812 -56.03125 46.9375 -56.453125 48.46875 -56.453125 C 50 -56.453125 51.160156 -56.03125 51.953125 -55.1875 C 52.742188 -54.34375 53.140625 -53.15625 53.140625 -51.625 L 53.140625 -4.125 C 53.140625 -2.644531 52.769531 -1.476562 52.03125 -0.625 C 51.289062 0.21875 50.285156 0.640625 49.015625 0.640625 C 47.804688 0.640625 46.84375 0.398438 46.125 -0.078125 C 45.414062 -0.554688 44.640625 -1.320312 43.796875 -2.375 L 13.546875 -41.734375 L 15.515625 -41.734375 L 15.515625 -4.28125 C 15.515625 -2.695312 15.117188 -1.476562 14.328125 -0.625 C 13.535156 0.21875 12.375 0.640625 10.84375 0.640625 Z M 10.84375 0.640625 ">
                            </path>
                        </g>
                    </g>
                </g>
                <g fill="#000000" fill-opacity="1">
                    <g transform="translate(278.729442, 72.51246)">
                        <g>
                            <path
                                d="M 31.125 0.796875 C 25.738281 0.796875 21.023438 -0.390625 16.984375 -2.765625 C 12.941406 -5.140625 9.8125 -8.476562 7.59375 -12.78125 C 5.382812 -17.09375 4.28125 -22.148438 4.28125 -27.953125 C 4.28125 -32.335938 4.910156 -36.285156 6.171875 -39.796875 C 7.441406 -43.304688 9.25 -46.3125 11.59375 -48.8125 C 13.945312 -51.320312 16.769531 -53.25 20.0625 -54.59375 C 23.363281 -55.945312 27.050781 -56.625 31.125 -56.625 C 36.5625 -56.625 41.285156 -55.445312 45.296875 -53.09375 C 49.304688 -50.75 52.421875 -47.4375 54.640625 -43.15625 C 56.859375 -38.882812 57.96875 -33.84375 57.96875 -28.03125 C 57.96875 -23.644531 57.332031 -19.679688 56.0625 -16.140625 C 54.800781 -12.609375 52.992188 -9.578125 50.640625 -7.046875 C 48.285156 -4.515625 45.457031 -2.570312 42.15625 -1.21875 C 38.863281 0.125 35.1875 0.796875 31.125 0.796875 Z M 31.125 -7.921875 C 34.550781 -7.921875 37.460938 -8.710938 39.859375 -10.296875 C 42.265625 -11.878906 44.113281 -14.175781 45.40625 -17.1875 C 46.707031 -20.195312 47.359375 -23.785156 47.359375 -27.953125 C 47.359375 -34.285156 45.941406 -39.191406 43.109375 -42.671875 C 40.285156 -46.160156 36.289062 -47.90625 31.125 -47.90625 C 27.738281 -47.90625 24.832031 -47.125 22.40625 -45.5625 C 19.976562 -44.007812 18.117188 -41.738281 16.828125 -38.75 C 15.535156 -35.769531 14.890625 -32.171875 14.890625 -27.953125 C 14.890625 -21.671875 16.3125 -16.757812 19.15625 -13.21875 C 22.007812 -9.6875 26 -7.921875 31.125 -7.921875 Z M 31.125 -7.921875 ">
                            </path>
                        </g>
                    </g>
                </g>
                <g fill="#000000" fill-opacity="1">
                    <g transform="translate(340.897059, 72.51246)">
                        <g>
                            <path
                                d="M 11.484375 0 C 9.742188 0 8.410156 -0.457031 7.484375 -1.375 C 6.554688 -2.300781 6.09375 -3.640625 6.09375 -5.390625 L 6.09375 -50.4375 C 6.09375 -52.1875 6.554688 -53.519531 7.484375 -54.4375 C 8.410156 -55.363281 9.742188 -55.828125 11.484375 -55.828125 L 26.84375 -55.828125 C 36.1875 -55.828125 43.40625 -53.425781 48.5 -48.625 C 53.59375 -43.820312 56.140625 -36.929688 56.140625 -27.953125 C 56.140625 -23.460938 55.492188 -19.488281 54.203125 -16.03125 C 52.910156 -12.570312 51.007812 -9.65625 48.5 -7.28125 C 45.988281 -4.90625 42.925781 -3.097656 39.3125 -1.859375 C 35.695312 -0.617188 31.539062 0 26.84375 0 Z M 16.234375 -8.390625 L 26.21875 -8.390625 C 29.488281 -8.390625 32.320312 -8.796875 34.71875 -9.609375 C 37.125 -10.429688 39.128906 -11.644531 40.734375 -13.25 C 42.347656 -14.863281 43.550781 -16.898438 44.34375 -19.359375 C 45.132812 -21.816406 45.53125 -24.679688 45.53125 -27.953125 C 45.53125 -34.492188 43.921875 -39.375 40.703125 -42.59375 C 37.484375 -45.820312 32.65625 -47.4375 26.21875 -47.4375 L 16.234375 -47.4375 Z M 16.234375 -8.390625 ">
                            </path>
                        </g>
                    </g>
                </g>
                <g fill="#000000" fill-opacity="1">
                    <g transform="translate(401.243201, 72.51246)">
                        <g>
                            <path
                                d="M 11.484375 0 C 9.742188 0 8.410156 -0.457031 7.484375 -1.375 C 6.554688 -2.300781 6.09375 -3.640625 6.09375 -5.390625 L 6.09375 -50.4375 C 6.09375 -52.1875 6.554688 -53.519531 7.484375 -54.4375 C 8.410156 -55.363281 9.742188 -55.828125 11.484375 -55.828125 L 39.75 -55.828125 C 41.070312 -55.828125 42.085938 -55.484375 42.796875 -54.796875 C 43.515625 -54.109375 43.875 -53.132812 43.875 -51.875 C 43.875 -50.550781 43.515625 -49.53125 42.796875 -48.8125 C 42.085938 -48.101562 41.070312 -47.75 39.75 -47.75 L 15.84375 -47.75 L 15.84375 -32.390625 L 38.015625 -32.390625 C 39.378906 -32.390625 40.40625 -32.046875 41.09375 -31.359375 C 41.78125 -30.671875 42.125 -29.664062 42.125 -28.34375 C 42.125 -27.03125 41.78125 -26.03125 41.09375 -25.34375 C 40.40625 -24.65625 39.378906 -24.3125 38.015625 -24.3125 L 15.84375 -24.3125 L 15.84375 -8.078125 L 39.75 -8.078125 C 41.070312 -8.078125 42.085938 -7.734375 42.796875 -7.046875 C 43.515625 -6.359375 43.875 -5.351562 43.875 -4.03125 C 43.875 -2.71875 43.515625 -1.71875 42.796875 -1.03125 C 42.085938 -0.34375 41.070312 0 39.75 0 Z M 11.484375 0 ">
                            </path>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <div class="wrap-content">
            <?php 
    }

    public function page_footer( $aside ) {
        ?>
        </div>
        <aside class="wrap-aside">
            <?php 
        echo wp_kses( $aside, array(
            'div' => array(
                'class'              => array(),
                'data-bvnode-plugin' => array(),
                'data-bvnode-feed'   => array(),
            ),
            'h3'  => array(),
        ) );
        ?>
        </aside>

        <?php 
    }

    function bvnode_submit_button() {
        ob_start();
        ?>

        <button type="submit" class="button-bvnode">
            <svg class="button-bvnode__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path
                    d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
            </svg>
            <span class="button-bvnode__text">Save</span>
        </button>

        <?php 
        return ob_get_clean();
    }

    public function bvnode_wpf_pdf_generator_page_html() {
        // check user capabilities
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        // add error/update messages
        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error(
                'bvnode_wpf_pdf_generator_messages',
                'bvnode_wpf_pdf_generator_message',
                esc_html__( 'Settings Saved', 'bvnode-wpf-pdf-generator' ),
                'updated'
            );
        }
        // show error/update messages
        settings_errors( 'bvnode_wpf_pdf_generator_messages' );
        ?>
        <div class="wrap wrap--bvnode">
            <?php 
        $this->page_header();
        ?>
            <h1>
                <?php 
        echo esc_html( get_admin_page_title() );
        ?>
            </h1>



            <?php 
        ob_start();
        ?>
            <div class="wrap-aside-panel">
                <h3>Getting Started</h3>
                <div class="feed" data-bvnode-plugin="<?php 
        echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) );
        ?>"
                    data-bvnode-feed="<?php 
        echo esc_url( plugin_dir_url( __FILE__ ) . '/json/start-wpfpdf.json' );
        ?>"></div>
            </div>
            <div class="wrap-aside-panel">
                <h3>How to use</h3>
                <div class="feed" data-bvnode-plugin="<?php 
        echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) );
        ?>"
                    data-bvnode-feed="<?php 
        echo esc_url( plugin_dir_url( __FILE__ ) . '/json/howto-wpfpdf.json' );
        ?>"></div>
            </div>
            <?php 
        $this->page_footer( ob_get_clean() );
        ?>




        </div>
        <?php 
    }

    public function settings_init() {
        // Register a new setting for "bvnode_wpf_pdf_generator_template" page.
        register_setting( 'bvnode_wpf_pdf_generator_template', 'bvnode_wpf_pdf_generator_template_data' );
        // Register a new section in the "bvnode_wpf_pdf_generator_template" page.
        add_settings_section(
            'bvnode_wpf_pdf_generator_section_template',
            null,
            array($this, 'bvnode_wpf_pdf_generator_section_template_callback'),
            'bvnode_wpf_pdf_generator_template'
        );
        // Register a new field in the "bvnode_wpf_pdf_generator_section_template" section, inside the "bvnode_wpf_pdf_generator_template" page.
        add_settings_field(
            'bvnode_wpf_pdf_generator_template_template',
            esc_html__( 'Template', 'bvnode-wpf-pdf-generator' ),
            array($this, 'bvnode_wpf_pdf_generator_template_cb'),
            'bvnode_wpf_pdf_generator_template',
            'bvnode_wpf_pdf_generator_section_template',
            array(
                'label_for'                 => 'bvnode_wpf_pdf_generator_template_template',
                'index'                     => 0,
                'class'                     => 'bvnode_dki4wp_row',
                'bvnode_dki4wp_custom_data' => 'custom',
            )
        );
        add_settings_field(
            'bvnode_wpf_pdf_generator_template_settings',
            esc_html__( 'Settings', 'bvnode-wpf-pdf-generator' ),
            array($this, 'bvnode_wpf_pdf_generator_template_cb'),
            'bvnode_wpf_pdf_generator_template',
            'bvnode_wpf_pdf_generator_section_template',
            array(
                'label_for'                 => 'bvnode_wpf_pdf_generator_template_settings',
                'index'                     => 0,
                'class'                     => 'bvnode_dki4wp_row',
                'bvnode_dki4wp_custom_data' => 'custom',
            )
        );
        add_settings_field(
            'bvnode_wpf_pdf_generator_template_header',
            esc_html__( 'Header', 'bvnode-wpf-pdf-generator' ),
            array($this, 'bvnode_wpf_pdf_generator_template_cb'),
            'bvnode_wpf_pdf_generator_template',
            'bvnode_wpf_pdf_generator_section_template',
            array(
                'label_for'                 => 'bvnode_wpf_pdf_generator_template_header',
                'index'                     => 0,
                'class'                     => 'bvnode_dki4wp_row',
                'bvnode_dki4wp_custom_data' => 'custom',
            )
        );
        add_settings_field(
            'bvnode_wpf_pdf_generator_template_footer',
            esc_html__( 'Footer', 'bvnode-wpf-pdf-generator' ),
            array($this, 'bvnode_wpf_pdf_generator_template_cb'),
            'bvnode_wpf_pdf_generator_template',
            'bvnode_wpf_pdf_generator_section_template',
            array(
                'label_for'                 => 'bvnode_wpf_pdf_generator_template_footer',
                'index'                     => 0,
                'class'                     => 'bvnode_dki4wp_row',
                'bvnode_dki4wp_custom_data' => 'custom',
            )
        );
        add_settings_field(
            'bvnode_wpf_pdf_generator_template_css',
            esc_html__( 'CSS', 'bvnode-wpf-pdf-generator' ),
            array($this, 'bvnode_wpf_pdf_generator_template_cb'),
            'bvnode_wpf_pdf_generator_template',
            'bvnode_wpf_pdf_generator_section_template',
            array(
                'label_for'                 => 'bvnode_wpf_pdf_generator_template_css',
                'index'                     => 0,
                'class'                     => 'bvnode_dki4wp_row',
                'bvnode_dki4wp_custom_data' => 'custom',
            )
        );
    }

    public function bvnode_wpf_pdf_generator_section_template_callback( $args ) {
        return null;
        ?>
        <p id="<?php 
        echo esc_attr( $args['id'] );
        ?>">
            <?php 
        esc_html_e( 'Define sets of parameters that are comonly used together, you can select this sets as default value on certain page you need.', 'bvnode-wpf-pdf-generator' );
        ?>
        </p>
        <?php 
    }

    public function bvnode_wpf_pdf_generator_template_cb( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'bvnode_wpf_pdf_generator_template_data' );
        ?>


        <textarea id="<?php 
        echo esc_attr( $args['label_for'] );
        ?>"
            name="bvnode_wpf_pdf_generator_template_data[<?php 
        echo esc_attr( $args['label_for'] );
        ?>]"><?php 
        echo ( !empty( $options[$args['label_for']] ) ? esc_html( $options[$args['label_for']] ) : '' );
        ?></textarea>

        <?php 
    }

    public function bvnode_wpf_pdf_generator_page_template_html() {
        // check user capabilities
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        wp_enqueue_script(
            $this->plugin_name . 'template-page',
            plugin_dir_url( __FILE__ ) . 'js/template-editor.template-page.js',
            [],
            $this->version,
            false
        );
        // add error/update messages
        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error(
                'bvnode_wpf_pdf_generator_messages',
                'bvnode_wpf_pdf_generator_message',
                esc_html__( 'Template saved.', 'bvnode-wpf-pdf-generator' ),
                'updated'
            );
        }
        // show error/update messages
        settings_errors( 'bvnode_wpf_pdf_generator_messages' );
        ?>
        <div class="wrap wrap--bvnode">
            <?php 
        $this->page_header();
        ?>

            <h1 style="display: none">
                <?php 
        echo esc_html( get_admin_page_title() );
        ?>
            </h1>

            <form action="options.php" method="post">
                <?php 
        settings_fields( 'bvnode_wpf_pdf_generator_template' );
        // do_settings_sections('bvnode_wpf_pdf_generator_template');
        $options = get_option( 'bvnode_wpf_pdf_generator_template_data' );
        $value = $options['bvnode_wpf_pdf_generator_template_template'] ?? '';
        $value_settings = $options['bvnode_wpf_pdf_generator_template_settings'] ?? '{}';
        $value_header = $options['bvnode_wpf_pdf_generator_template_header'] ?? '';
        $value_footer = $options['bvnode_wpf_pdf_generator_template_footer'] ?? '';
        $value_css = $options['bvnode_wpf_pdf_generator_template_css'] ?? '';
        echo '<div data-bvnode-template data-bvnode-template-html="' . esc_attr( base64_encode( $value ) ) . '" data-bvnode-template-headerhtml="' . esc_attr( base64_encode( $value_header ) ) . '" data-bvnode-template-footerhtml="' . esc_attr( base64_encode( $value_footer ) ) . '" data-bvnode-template-config="' . esc_attr( base64_encode( $value_settings ) ) . '" data-bvnode-template-styles="' . esc_attr( base64_encode( $value_css ) ) . '"></div>';
        ?>




                <div class="buttons" style="display: flex; gap: 15px;">

                    <?php 
        echo wp_kses( $this->bvnode_submit_button(), array(
            'button' => array(
                'type'  => array(),
                'class' => array(),
            ),
            'svg'    => array(
                'class'   => array(),
                'xmlns'   => array(),
                'viewBox' => array(),
            ),
            'path'   => array(
                'd' => array(),
            ),
            'span'   => array(
                'class' => array(),
            ),
        ) );
        ?>

                    <?php 
        ?>

                </div>
            </form>

            <?php 
        ob_start();
        ?>
            <div class="wrap-aside-panel">
                <h3>Getting Started</h3>
                <div class="feed" data-bvnode-plugin="<?php 
        echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) );
        ?>"
                    data-bvnode-feed="<?php 
        echo esc_url( plugin_dir_url( __FILE__ ) . '/json/start-wpfpdf.json' );
        ?>"></div>
            </div>
            <div class="wrap-aside-panel">
                <h3>How to use</h3>
                <div class="feed" data-bvnode-plugin="<?php 
        echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) );
        ?>"
                    data-bvnode-feed="<?php 
        echo esc_url( plugin_dir_url( __FILE__ ) . '/json/howto-wpfpdf.json' );
        ?>"></div>
            </div>
            <?php 
        $this->page_footer( ob_get_clean() );
        ?>




        </div>
        <?php 
    }

    public function duplicate_post( int $post_id ) : array {
        $old_post = get_post( $post_id );
        if ( !$old_post ) {
            // Invalid post ID, return early.
            return 0;
        }
        $title = $old_post->post_title . ' (clone)';
        // Create new post array.
        $new_post = [
            'post_title'  => $title,
            'post_name'   => sanitize_title( $title ),
            'post_status' => 'publish',
            'post_type'   => $old_post->post_type,
        ];
        // Insert new post.
        $new_post_id = wp_insert_post( $new_post );
        // Copy post meta.
        $post_meta = get_post_custom( $post_id );
        foreach ( $post_meta as $key => $values ) {
            foreach ( $values as $value ) {
                add_post_meta( $new_post_id, $key, maybe_unserialize( $value ) );
            }
        }
        // Copy post taxonomies.
        $taxonomies = get_post_taxonomies( $post_id );
        foreach ( $taxonomies as $taxonomy ) {
            $term_ids = wp_get_object_terms( $post_id, $taxonomy, [
                'fields' => 'ids',
            ] );
            wp_set_object_terms( $new_post_id, $term_ids, $taxonomy );
        }
        // Return new post ID.
        return [
            "id"    => $new_post_id,
            "title" => $title,
        ];
    }

    public function get_config() {
        $config = [
            "slots" => 1,
        ];
        return $config;
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts( $hook_suffix ) {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in bvnode_wpf_pdf_Generator_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The bvnode_wpf_pdf_Generator_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/wpfpdf-generator-admin.js',
            array('jquery'),
            $this->version,
            false
        );
        if ( in_array( $hook_suffix, array('toplevel_page_wpfpdf-generator', 'pdf-generator_page_wpfpdf-generator-template', 'pdf-generator_page_wpfpdf-generator-templates') ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-template-editor-chunk',
                plugin_dir_url( __FILE__ ) . 'js/template-editor.chunk-vendors.min.js',
                array('jquery'),
                $this->version,
                true
            );
            wp_enqueue_script(
                $this->plugin_name . '-template-editor-app',
                plugin_dir_url( __FILE__ ) . 'js/template-editor.app.min.js',
                array('jquery'),
                $this->version,
                true
            );
            wp_enqueue_script(
                $this->plugin_name . '-feed-chunk',
                plugin_dir_url( __FILE__ ) . 'js/feed.chunk-vendors.min.js',
                array('jquery'),
                $this->version,
                true
            );
            wp_enqueue_script(
                $this->plugin_name . '-feed-app',
                plugin_dir_url( __FILE__ ) . 'js/feed.app.min.js',
                array('jquery'),
                $this->version,
                true
            );
        }
    }

    /**
     * Prepare file attachment.
     * 
     * @param  Array $data      Email Data.
     * @param  Obj   $email_obj Email Object.
     * 
     * @return Array The Email Data with attachment.
     */
    public function prepare_file( $data, $email_obj ) {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        if ( $email_obj->entry_id ) {
            $entry = wpforms()->entry->get( $email_obj->entry_id );
            $email_obj->form_data['entry_date'] = $entry->date;
        }
        $enabled = ( isset( $email_obj->form_data['settings']['bvnode_wpf_pdf_enable'] ) ? $email_obj->form_data['settings']['bvnode_wpf_pdf_enable'] : false );
        $enabled_notification = ( isset( $email_obj->form_data['settings']['be_notifications[' . $email_obj->notification_id . ']'] ) ? $email_obj->form_data['settings']['be_notifications[' . $email_obj->notification_id . ']'] : '' );
        $template = $email_obj->form_data['settings']['bvnode_wpf_pdf_template'] ?? false;
        if ( !isset( $enabled ) || empty( $enabled ) || !isset( $enabled_notification ) || empty( $enabled_notification ) || !isset( $template ) ) {
            return $data;
        }
        if ( $template && get_post_status( $template ) ) {
            $template_type = 'template';
            $template_id = $template;
        } else {
            $template_type = 'options';
            $template_id = null;
        }
        $template = new bvnode_wpf_pdf_Generator_Template(
            $template_type,
            $template_id,
            $email_obj->form_data,
            $email_obj->fields
        );
        $pdf = new bvnode_wpf_pdf_Generator_PDF($template);
        $file_name = $template->get_filename();
        file_put_contents( get_temp_dir() . $file_name, $pdf->pdf()->output() );
        $data['attachments'][] = get_temp_dir() . $file_name;
        return $data;
    }

    public function attach_file( $email_obj ) {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        $enabled = ( isset( $email_obj->form_data['settings']['bvnode_wpf_pdf_enable'] ) ? $email_obj->form_data['settings']['bvnode_wpf_pdf_enable'] : false );
        $enabled_notification = ( isset( $email_obj->form_data['settings']['be_notifications[' . $email_obj->notification_id . ']'] ) ? $email_obj->form_data['settings']['be_notifications[' . $email_obj->notification_id . ']'] : '' );
        $template = $email_obj->form_data['settings']['bvnode_wpf_pdf_template'] ?? false;
        if ( !isset( $enabled ) || empty( $enabled ) || !isset( $enabled_notification ) || empty( $enabled_notification ) || !isset( $template ) ) {
            return false;
        }
        if ( $template && get_post_status( $template ) ) {
            $template_type = 'template';
            $template_id = $template;
        } else {
            $template_type = 'options';
            $template_id = null;
        }
        $template = new bvnode_wpf_pdf_Generator_Template(
            $template_type,
            $template_id,
            $email_obj->form_data,
            $email_obj->fields
        );
        unlink( get_temp_dir() . $template->get_filename() );
    }

    public function add_table_reaction( $actions, $entry ) {
        $form = wpforms()->form->get( $entry->form_id );
        $settings = json_decode( $form->post_content, true )['settings'];
        if ( $settings['bvnode_wpf_pdf_enable'] ) {
            $actions = array_merge( [
                'view_pdf'     => '<a href="/wp-admin/admin.php?page=wpforms-entries&view=details&entry_id=' . $entry->entry_id . '&pdf" target="_blank">View PDF</a>',
                'download_pdf' => '<a href="/wp-admin/admin.php?page=wpforms-entries&view=details&entry_id=' . $entry->entry_id . '&pdf=download" target="_blank">Download PDF</a>',
            ], $actions );
        }
        return $actions;
    }

    public function add_sidebar_reaction( $action_links, $entry, $form_data = null ) {
        $form = wpforms()->form->get( $entry->form_id );
        $settings = json_decode( $form->post_content, true )['settings'];
        if ( isset( $settings['bvnode_wpf_pdf_enable'] ) && $settings['bvnode_wpf_pdf_enable'] ) {
            $action_links = array_merge( [
                'view_pdf'     => [
                    'url'    => '/wp-admin/admin.php?page=wpforms-entries&view=details&entry_id=' . $entry->entry_id . '&pdf',
                    'target' => '_blank',
                    'icon'   => 'dashicons-media-text',
                    'label'  => 'View PDF',
                ],
                'download_pdf' => [
                    'url'    => '/wp-admin/admin.php?page=wpforms-entries&view=details&entry_id=' . $entry->entry_id . '&pdf=download',
                    'target' => '_blank',
                    'icon'   => 'dashicons-media-text',
                    'label'  => 'Download PDF',
                ],
            ], $action_links );
        }
        return $action_links;
    }

    public function settings_section( $sections, $form_data ) {
        $sections['wpfpdf'] = esc_html__( 'Form to PDF', 'bvnode-wpf-pdf-generator' );
        return $sections;
    }

    public function settings_section_content( $instance ) {
        echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-wpfpdf">';
        echo '<div class="wpforms-panel-content-section-title">' . esc_html__( 'Form to PDF', 'bvnode-wpf-pdf-generator' ) . '</div>';
        wpforms_panel_field(
            'toggle',
            'settings',
            'bvnode_wpf_pdf_enable',
            $instance->form_data,
            esc_html__( 'Enable PDF generation for this form', 'bvnode-wpf-pdf-generator' )
        );
        $options = [];
        if ( function_exists( 'AdmissionTemplate' ) ) {
            $options['AdmissionTemplate'] = 'AdmissionTemplate';
        }
        if ( function_exists( 'RegistrationWinterRetreat2024Template' ) ) {
            $options['RegistrationWinterRetreat2024Template'] = 'RegistrationWinterRetreat2024Template';
        }
        if ( function_exists( 'ApplicationNew2Template' ) ) {
            $options['ApplicationNew2Template'] = 'ApplicationNew2Template';
        }
        if ( function_exists( 'AftercareRegistrationTemplate' ) ) {
            $options['AftercareRegistrationTemplate'] = 'AftercareRegistrationTemplate';
        }
        if ( function_exists( 'WorkshopTemplate' ) ) {
            $options['WorkshopTemplate'] = 'WorkshopTemplate';
        }
        if ( function_exists( 'ReunionTemplate' ) ) {
            $options['ReunionTemplate'] = 'ReunionTemplate';
        }
        wpforms_panel_field(
            'text',
            'settings',
            'bvnode_wpf_pdf_file_name',
            $instance->form_data,
            esc_html__( 'PDF File Name', 'bvnode-wpf-pdf-generator' ),
            array(
                'smarttags' => $this->bvnode_wpf_smarttags_fields_list(),
            )
        );
        echo '<div class="wpforms-pdf-notifications">
                    <div class="wpforms-panel-fields-group">
                        <div class="wpforms-panel-fields-group-border-top"></div>
                        <div class="wpforms-panel-fields-group-title">Notifications</div>
                        <div class="wpforms-panel-fields-group-description">Attach PDF File to selected notifications.</div>
                        <div class="wpforms-panel-fields-group-inner">';
        foreach ( $instance->form_data['settings']['notifications'] as $index => $notification ) {
            wpforms_panel_field(
                'toggle',
                'settings',
                'be_notifications[' . $index . ']',
                $instance->form_data,
                ( !empty( $notification['notification_name'] ) ? $notification['notification_name'] : esc_html__( 'Default Notification', 'bvnode-wpf-pdf-generator' ) )
            );
        }
        echo "</div>\n                    </div>\n                </div>";
        echo '<div class="wpforms-fields">';
        $this->get_template_fields( $instance->form_data );
        echo '</div>
        </div>';
    }

    public function get_template_fields( $form_data ) {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        $select_template = false;
        echo '<div class="wpforms-panel-fields-group">
                <div class="wpforms-panel-fields-group-border-top"></div>
                    <div class="wpforms-panel-fields-group-title">Template Fields</div>
                    <div class="wpforms-panel-fields-group-description">Map Smart Tags to available template fields.</div>
                    <div class="wpforms-panel-fields-group-inner">';
        $template_type = 'options';
        $template_id = null;
        $fields_added = [];
        if ( isset( $template_type ) ) {
            $template = new bvnode_wpf_pdf_Generator_Template($template_type, $template_id);
            $fields_added = $template->get_placeholders();
            foreach ( $template->get_placeholders() as $template_field ) {
                wpforms_panel_field(
                    'text',
                    'be_template_fields',
                    $template_field,
                    $form_data,
                    $template_field,
                    array(
                        'smarttags' => $this->bvnode_wpf_smarttags_fields_list(),
                    )
                );
            }
        }
        if ( !count( $fields_added ) && !$select_template ) {
            echo 'Template does not contains any fields.';
        }
        if ( $select_template ) {
            echo 'No template selected.';
        }
        // endif;
        echo '</div></div></div>';
    }

    public function view_entry_pdf( $view = null ) {
        if ( $view != 'details' ) {
            return;
        }
        $pdf = ( isset( $_GET['pdf'] ) ? true : false );
        // phpcs:ignore WordPress.Security.NonceVerification
        if ( !$pdf ) {
            return;
        }
        $entry_id = ( isset( $_GET['entry_id'] ) ? absint( $_GET['entry_id'] ) : 0 );
        // phpcs:ignore WordPress.Security.NonceVerification
        $pdf_action = ( $_GET['pdf'] == 'download' ? 'download' : 'view' );
        // phpcs:ignore WordPress.Security.NonceVerification
        $entry = wpforms()->entry->get( $entry_id );
        $fields = json_decode( $entry->fields, true );
        $form = wpforms()->form->get( $entry->form_id );
        $form_data = wpforms_decode( $form->post_content );
        $form_data['entry_date'] = $entry->date;
        $template_type = 'options';
        $template_id = null;
        $template = new bvnode_wpf_pdf_Generator_Template(
            $template_type,
            $template_id,
            $form_data,
            $fields
        );
        $pdf = new bvnode_wpf_pdf_Generator_PDF($template);
        if ( $pdf_action == 'download' ) {
            $pdf->pdf()->stream( $template->get_filename(), array(
                "Attachment" => true,
            ) );
            exit;
        } else {
            $pdf->pdf()->stream( $template->get_filename(), array(
                "Attachment" => false,
            ) );
            exit;
        }
    }

    public function process_value(
        $value,
        $tag_name = null,
        $form_data = null,
        $fields = null,
        $entry_id = null,
        $smart_tag_object = null
    ) {
        global $bvnode_wpf_pdf_ProccessSmartTags;
        if ( $bvnode_wpf_pdf_ProccessSmartTags ) {
            return $value;
        }
        if ( $tag_name == 'all_fields_table' ) {
            return $value;
        }
        $type = ( isset( $smart_tag_object->get_attributes()['field_id'] ) && isset( $form_data['fields'][$smart_tag_object->get_attributes()['field_id']]['type'] ) ? $form_data['fields'][$smart_tag_object->get_attributes()['field_id']]['type'] : 'text' );
        //TOSO what to add here?
        $supported_fields = explode( ',', $this->bvnode_wpf_smarttags_fields_list()['fields'] );
        if ( in_array( $type, $supported_fields ) ) {
            if ( $type == 'html' ) {
                return $form_data['fields'][$smart_tag_object->get_attributes()['field_id']]['code'];
            }
            return $value;
        }
        return 'This field is not supported.';
    }

    public function display_pdf( $entry_id = 0, $fields = null ) {
        $entry = wpforms()->entry->get( $entry_id );
        $fields = json_decode( $entry->fields, true );
        $form = wpforms()->form->get( $entry->form_id );
        $form_data = wpforms_decode( $form->post_content );
        $form_data['entry_date'] = $entry->date;
        $template_id = $form_data['settings']['bvnode_wpf_pdf_template'];
        $template = new bvnode_wpf_pdf_Generator_Template(
            'template',
            $template_id,
            $form_data,
            $fields
        );
        $pdf = new bvnode_wpf_pdf_Generator_PDF($template);
        return $pdf->pdf();
    }

    public function custom_field_function( $field ) {
        return 'something special';
    }

    public function show_X_value( $field, $expect ) {
        return ( strtoupper( $field['value'] ) == strtoupper( $expect ) ? 'X' : '' );
    }

    public function replaceAndEvaluate(
        $input,
        $entry_fields,
        $entry,
        $form_fields,
        $form
    ) {
        $pattern = '/\\{([^}]+):(\\d+)\\}/';
        $pattern = '/\\{([^}]+):(\\d+?)(:(.*))?(\\|(.*))?}/U';
        $result = preg_replace_callback( $pattern, function ( $matches ) use($entry_fields) {
            $name = $matches[1];
            $id = $matches[2];
            $prop = ( !empty( $matches[4] ) ? $matches[4] : 'value' );
            $arg = ( !empty( $matches[6] ) ? $matches[6] : null );
            function get_entry_field_by_key(  $fields, $key, $key_value  ) {
                foreach ( $fields as $field ) {
                    if ( $field[$key] == $key_value ) {
                        return $field;
                    }
                }
                return false;
            }

            $field = get_entry_field_by_key( $entry_fields, 'id', $id );
            if ( $field['name'] != $name ) {
                return $field['name'] . ' / SOMETHING GOES WRONG HERE';
            }
            if ( function_exists( array($this, $prop) ) ) {
                return $prop( $field, $arg );
            }
            return $field[$prop];
        }, $input );
        $result = preg_replace( '/\\{date\\}/', date( 'm/d/Y', strtotime( $entry->date ) ), $result );
        $result = preg_replace( '/http:/', 'https:', $result );
        return $result;
    }

    public function load_pdf_fields() {
        $data = $this->get_prepared_data( 'get_fields' );
        $this->get_template_fields( $data );
        exit;
    }

    private function get_prepared_data( string $action ) : array {
        // Run a security check.
        if ( !check_ajax_referer( 'wpforms-builder', 'nonce', false ) ) {
            wp_send_json_error( esc_html__( 'Most likely, your session expired. Please reload the page.', 'bvnode-wpf-pdf-generator' ) );
        }
        // Check for permissions.
        if ( !wpforms_current_user_can( 'edit_forms' ) ) {
            wp_send_json_error( esc_html__( 'You are not allowed to perform this action.', 'bvnode-wpf-pdf-generator' ) );
        }
        $data = [];
        if ( $action === 'get_fields' ) {
            // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
            $form_id = intval( $_POST['form_id'] );
            if ( !empty( $form_id ) ) {
                $form = wpforms()->form->get( $form_id );
                $form_data = json_decode( $form->post_content, true );
                $form_data['settings']['bvnode_wpf_pdf_template'] = ( !empty( $_POST['template'] ) ? sanitize_key( $_POST['template'] ) : '' );
                return $form_data;
            }
        }
        return $data;
    }

    public function preview_template() {
        if ( !is_admin() || empty( $_REQUEST['page'] ) || strpos( $_REQUEST['page'], 'wpfpdf-generator-templates' ) === false ) {
            return false;
        }
        // check user capabilities
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        if ( isset( $_GET['preview'] ) ) {
            $template = new bvnode_wpf_pdf_Generator_Template('template', sanitize_text_field( $_GET['preview'] ));
            $pdf = new bvnode_wpf_pdf_Generator_PDF($template);
            $pdf->pdf()->stream( $template->get_filename(), array(
                "Attachment" => false,
            ) );
            exit;
        }
    }

    public function bvnode_wpf_smarttags_fields_list( $types = [] ) {
        $fields = wpforms_get_builder_fields();
        foreach ( $fields as $id => $group ) {
            foreach ( $group['fields'] as $field ) {
                if ( $id == 'fancy' ) {
                    continue;
                }
                if ( isset( $field['class'] ) ) {
                    continue;
                }
                $types[] = $field['type'];
            }
        }
        return [
            'fields' => implode( ',', $types ),
        ];
    }

}
