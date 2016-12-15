<?php
namespace WeDevs\ERP\Travelagent\Admin;
use WeDevs\ERP\Travelagent\Invoiceview;
use WeDevs\ERP\Travelagent\Riseinvoiceview;
use WeDevs\ERP\Travelagent\clientview;
use WeDevs\ERP\Travelagent\requestview;
/**
 * Admin Menu
 */
class Admin_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {
        
        /* *********************************
        * Super Admin Dashboard
        *  **********************************/
	if ( current_user_can( 'travelagent' ) ) {
    add_menu_page('agent Dashboard', 'Travelagent DashBoard', 'travelagent', 'travelagent-dashboard', array( $this, 'dashboard_page'),'dashicons-dashboard');  
		  
    add_menu_page('User', 'User Management', 'travelagent','UserM', array( $this,'travel_agent_user_listing'),'dashicons-admin-users');
        $overview = add_submenu_page( 'UserM', 'Overview', 'Overview', 'travelagent', 'UserM', array( $this,'travel_agent_user_listing'));
		//add_submenu_page('UserM', 'Add', 'Add User', 'travelagent', 'Add', 'UserManagement');
        //add_submenu_page('UserM', 'UserActions', 'View /Edit/Delete user', 'travelagent', 'UserActions', 'UserManagement');
        
   add_menu_page('Client', 'Client Management', 'travelagent','ClientM', array( $this, 'travel_agent_client_listing'),'dashicons-admin-users');
		$overview = add_submenu_page( 'ClientM', 'Overview', 'Overview', 'travelagent', 'ClientM', array( $this,'travel_agent_client_listing'));
		add_submenu_page('', 'ClientMActions', 'View /Edit Client', 'travelagent', 'Clientview', array($this, 'clientview_page'));
        add_submenu_page('ClientM', 'ClientAlloc', 'Client Allocations', 'travelagent', 'ClientAllocations',array( $this,'travel_agent_client_allocation'));
        add_submenu_page('', 'request', 'requestview', 'travelagent', 'requestview', array($this, 'requestview_page'));
        
    add_menu_page('InvoiceM', 'Invoice Management', 'travelagent','InvoiceM', array( $this,'company_invoicemanagement'),'dashicons-id-alt');
		$overview = add_submenu_page( 'InvoiceM', 'Overview', 'Overview', 'travelagent', 'InvoiceM', array( $this,'company_invoicemanagement'));
		add_submenu_page('InvoiceM', 'Create', 'Create Invoice', 'travelagent', 'createinvoice', array( $this,'company_invoicecreate'));
        add_submenu_page('', 'ViewInv', 'View Invoice ', 'travelagent', 'ViewInvoice', array( $this,'view_invoice'));
        add_submenu_page('', 'RiseInv', 'RiseInvoice', 'travelagent', 'RiseInvoice',  array( $this, 'riseinvoiceview_page' ));
       
    add_menu_page('BankM', 'Bank Management', 'travelagent','BankM', array( $this,'travel_agent_bank_details'),'dashicons-money');
		$overview = add_submenu_page( 'BankM', 'Overview', 'Overview', 'travelagent', 'BankM', array( $this,'travel_agent_bank_details'));
		//add_submenu_page('BankM', 'BankActions', 'View /Edit Bank Details', 'travelagent', 'BankActions', 'BankrManagement');
    
	   }

    }

	
		/**
     * Handles the employeeview page
     *
     * @return void
     */
    public function riseinvoiceview_page() {
       $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
	   $id     = $_GET['id'];
		 switch ($action) {
            case 'view':
                $riseinvoiceview = new Riseinvoiceview($id);
                 if ( !$id ) {
                    wp_die( __( 'not found!', 'erp' ) );
                }
			
                $template = WPERP_TRAVELAGENT_VIEWS . '/travelagent/travelagentriseinvoice-create.php';
                break;
            default:
            $template = WPERP_TRAVELAGENT_VIEWS . '/travelagentriseinvoice-create.php';
                break;
        }

        $template = apply_filters( 'erp_travelagent_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
    /**
     * Handles HR calendar script
     *
     * @return void
     */
    function hr_calendar_script() {
        wp_enqueue_script( 'erp-momentjs' );
        wp_enqueue_script( 'erp-fullcalendar' );
        wp_enqueue_style( 'erp-fullcalendar' );
    }

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function dashboard_page() {
        include WPERP_TRAVELAGENT_VIEWS . '/dashboard.php';
    }
    
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function travel_agent_client_listing() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel-agent-client-listing.php';
    }
	
	/**
     * Handles the travelagent clientallocation page
     *
     * @return void
     */
    public function travel_agent_client_allocation() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel-agent-client-allocation.php';
    }
    
	/**
     * Handles the travelagent user listing list Page
     *
     * @return void
     */
    public function travel_agent_user_listing() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel_agent_user_listing.php';
    }
	
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function company_invoicemanagement() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel_agent_companyinvoice_details.php';
    }
	
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function company_invoicecreate() {
		
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel_agent_companyinvoice_create.php';
    }
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function InvoiceManagement() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/invoicemanagement.php';
    }
	/**
     * Handles the bank details page
     *
     * @return void
     */
    public function travel_agent_bank_details() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel_agent_bank_details.php';
    }
	
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function view_invoice() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $id     = isset( $_GET['tdcid'] ) ? intval( $_GET['tdcid'] ) : 0;
		
        switch ($action) {
            case 'view':
                $invoiceview = new Invoiceview( $id );
                if ( !$id ) {
                    wp_die( __( 'Invoice id not found!', 'erp' ) );
                }  
                $template = WPERP_TRAVELAGENT_VIEWS . '/travelagent/invoiceview.php';
                break;

            default:
                $template = WPERP_TRAVELAGENT_VIEWS . '/invoiceview.php';
                break;
        }

        $template = apply_filters( 'erp_hr_company_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

	/**
     * Handles the clientview page
     *
     * @return void
     */
    public function clientview_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
		
        switch ($action) {
            case 'view':
                $clientview = new clientview( $id );
                if ( !$id ) {
                    wp_die( __( 'Client not found!', 'erp' ) );
                }  
                $template = WPERP_TRAVELAGENT_VIEWS . '/travelagent/clientview.php';
                break;

            default:
                $template = WPERP_TRAVELAGENT_VIEWS . '/clientview.php';
                break;
        }

        $template = apply_filters( 'erp_travelagent_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
	
	/**
     * Handles the clientview page
     *
     * @return void
     */
    public function requestview_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $comid     = $_GET['id'];
		$selFilter     = $_GET['selFilter'];
		
        switch ($action) {
            case 'view':
                $requestview = new requestview( $comid,$selFilter );
                if ( !$comid ) {
                    wp_die( __( 'Client not found!', 'erp' ) );
                }  
                $template = WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel-agent-request-listing.php';
                break;

            default:
                $template = WPERP_TRAVELAGENT_VIEWS . '/requestview.php';
                break;
        }

        $template = apply_filters( 'erp_travelagent_templates', $template, $action, $comid,$selFilter );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

	
	
    /**
     * An empty page for testing purposes
     *
     * @return void
     */
    public function empty_page() {

    }

}
