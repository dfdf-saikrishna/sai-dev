<?php
namespace WeDevs\ERP\Travelagent;

use WeDevs\ERP\Framework\Traits\Hooker;

/**
 * The HRM Class
 *
 * This is loaded in `init` action hook
 */
class Travelagent {

    use Hooker;

    private $plugin;

    /**
     * Kick-in the class
     *
     * @param \WeDevs_ERP $plugin
     */
    public function __construct( \WeDevs_ERP $plugin ) {
        $this->plugin = $plugin;

        // Define constants
        $this->define_constants();

        // Include required files
        $this->includes();

        // Initialize the classes
        $this->init_classes();

        // Initialize the action hooks
        $this->init_actions();

        // Initialize the filter hooks
        $this->init_filters();

        do_action( 'erp_hrm_loaded' );
    }

    /**
     * Define the plugin constants
     *
     * @return void
     */
    private function define_constants() {
        define( 'WPERP_TRAVELAGENT_FILE', __FILE__ );
        define( 'WPERP_TRAVELAGENT_PATH', dirname( __FILE__ ) );
        define( 'WPERP_TRAVELAGENT_VIEWS', dirname( __FILE__ ) . '/views' );
        define( 'WPERP_TRAVELAGENT_JS_TMPL', WPERP_TRAVELAGENT_VIEWS . '/js-templates' );
        define( 'WPERP_TRAVELAGENT_ASSETS', plugins_url( '/assets', __FILE__ ) );
    }

    /**
     * Include the required files
     *
     * @return void
     */
    private function includes() {

        require_once WPERP_TRAVELAGENT_PATH . '/includes/functions-tadashboard.php';
        require_once WPERP_TRAVELAGENT_PATH . '/includes/actions-filters.php';
		require_once WPERP_TRAVELAGENT_PATH . '/includes/functions-travelagentuser.php';
		require_once WPERP_TRAVELAGENT_PATH . '/includes/functions-travelagentclient.php';
		require_once WPERP_TRAVELAGENT_PATH . '/includes/functions-travelagentbankdetails.php';
		require_once WPERP_TRAVELAGENT_PATH . '/includes/functions-invoice.php';
      }

    /**
     * Initialize WordPress action hooks
     *
     * @return void
     */
    private function init_actions() {
        $this->action( 'admin_enqueue_scripts', 'admin_scripts' );
        $this->action( 'admin_footer', 'admin_js_templates' );
    }

    /**
     * Initialize WordPress filter hooks
     *
     * @return void
     */
    private function init_filters() {
        add_filter( 'erp_settings_pages', array( $this, 'add_settings_page' ) );
    }

    /**
     * Init classes
     *
     * @return void
     */
    private function init_classes() {
        new Ajax_Handler();
        new Form_Handler();
       // new Announcement();
        new Admin\Admin_Menu();
        //new Admin\User_Profile();
        //new Hr_Log();
        new Emailer();
    }

    /**
     * Register HR settings page
     *
     * @param array
     */
    public function add_settings_page( $settings = [] ) {

        $settings[] = include __DIR__ . '/includes/class-settings.php';

        return $settings;
    }

    /**
     * Load admin scripts and styles
     *
     * @param  string
     *
     * @return void
     */
    public function admin_scripts( $hook ) {
        //var_dump( $hook );

        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

        wp_enqueue_media();
        wp_enqueue_script( 'erp-tiptip' );

        if ( 'hr-management_page_erp-hr-employee' == $hook ) {
            wp_enqueue_style( 'erp-sweetalert' );
            wp_enqueue_script( 'erp-sweetalert' );
        }

        wp_enqueue_script( 'wp-erp-ta', WPERP_TRAVELAGENT_ASSETS . "/js/travelagent$suffix.js", array( 'erp-script' ), date( 'Ymd' ), true );

        $localize_script = apply_filters( 'erp_hr_localize_script', array(
            'nonce'              => wp_create_nonce( 'wp-erp-ta-nonce' ),
            'popup'              => array(
            'travelagentuser_title'    => __( 'Create Travel Agent User', 'erp' ),
            'travelagentuser_update'    => __( 'Edit Travel Agent User', 'erp' ),
            'travelagentclient_title'    => __( 'Create Travel Agent Client', 'erp' ),   
            'travelagentclient_update'    => __( 'Edit Travel Agent Client', 'erp' ),
			'travelagentbankdetails_title'    => __( 'Create Travel Agent Bank Details', 'erp' ),
			'travelagentbankdetails_update'    => __( 'Edit Travel Agent Bank Details', 'erp' ),
            'update' => __( 'Update', 'erp' )
              ),
       ) );

		// if its an travel agent user page
        if ( 'toplevel_page_UserM' == $hook ) {
            wp_enqueue_script( 'post' );

            $travelagentuser                          = new Travelagentuser();
            $localize_script['travelagentuser_empty'] = $travelagentuser->to_array();
        }
		
		// if its an travel agent client  page
        if ( 'toplevel_page_ClientM' == $hook ) {
            wp_enqueue_script( 'post' );

            $travelagentclient                          = new Travelagentclient();
            $localize_script['travelagentclient_empty'] = $travelagentclient->to_array();
        }
		
		
        // if its an Bank Details page
        if ( 'toplevel_page_BankM' == $hook ) {
            wp_enqueue_script( 'post' );

            $travelagentbankdetails                          = new Travelagentbankdetails();
            $localize_script['travelagentbankdetails_empty'] = $travelagentbankdetails->to_array();
        }
		// if its an Bank Details page
        if ( 'invoice-management_page_ViewInvoice' == $hook ) {
            wp_enqueue_script( 'post' );

            $invoiceview                          = new Invoiceview();
            $localize_script['invoiceview_empty'] = $invoiceview->to_array();
        }

        wp_localize_script( 'wp-erp-ta', 'wpErpTa', $localize_script );

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'erp-select2' );
        wp_enqueue_style( 'erp-tiptip' );
        wp_enqueue_style( 'erp-style' );

        if ( 'hr-management_page_erp-hr-reporting' == $hook ) {
            wp_enqueue_script( 'erp-flotchart' );
            wp_enqueue_script( 'erp-flotchart-time' );
            wp_enqueue_script( 'erp-flotchart-pie' );
            wp_enqueue_script( 'erp-flotchart-orerbars' );
            wp_enqueue_script( 'erp-flotchart-axislables' );
            wp_enqueue_script( 'erp-flotchart-valuelabel' );
            wp_enqueue_style( 'erp-flotchart-valuelabel-css' );
        }
    }

    /**
     * Print JS templates in footer
     *
     * @return void
     */
    public function admin_js_templates() {
        global $current_screen;

        var_dump( $current_screen->base );
        switch ($current_screen->base) {
            case 'toplevel_page_UserM':
                erp_get_js_template( WPERP_TRAVELAGENT_JS_TMPL . '/travelagentuser-create.php', 'travelagentuser-create' );
                break;
			case 'toplevel_page_ClientM':
                erp_get_js_template( WPERP_TRAVELAGENT_JS_TMPL . '/travelagentclient-create.php', 'travelagentclient-create' );
                break;
			case 'toplevel_page_BankM':
                erp_get_js_template( WPERP_TRAVELAGENT_JS_TMPL . '/travelagentbankdetails-create.php', 'travelagentbankdetails-create' );
                break;	
				
            default:
                # code...
                break;
        }

    }
}

