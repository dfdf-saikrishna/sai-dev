<?php
namespace WeDevs\ERP\Travelagent\Admin;

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
		//add_submenu_page('ClientM', 'ClientMActions', 'View /Edit Client', 'travelagent', 'ClientActions', 'ClientManagement');
        add_submenu_page('ClientM', 'ClientAlloc', 'Client Allocations', 'travelagent', 'ClientAllocations',array( $this,'travel_agent_client_allocation'));
        
    add_menu_page('InvoiceM', 'Invoice Management', 'travelagent','InvoiceM', 'InvoiceManagement','dashicons-id-alt');
		$overview = add_submenu_page( 'InvoiceM', 'Overview', 'Overview', 'travelagent', 'InvoiceM', array( $this,'InvoiceManagement'));
		//add_submenu_page('InvoiceM', 'Create', 'Create Invoice', 'travelagent', 'AddInvoice', 'InvoiceManagement');
       // add_submenu_page('InvoiceM', 'ViewInv', 'View Invoice ', 'travelagent', 'ViewInvoice', 'InvoiceManagement');
        
    add_menu_page('BankM', 'Bank Management', 'travelagent','BankM', array( $this,'travel_agent_bank_details'),'dashicons-money');
		$overview = add_submenu_page( 'BankM', 'Overview', 'Overview', 'travelagent', 'BankM', array( $this,'travel_agent_bank_details'));
		//add_submenu_page('BankM', 'BankActions', 'View /Edit Bank Details', 'travelagent', 'BankActions', 'BankrManagement');
    
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
     * Handles the bank details page
     *
     * @return void
     */
    public function travel_agent_bank_details() {
        include WPERP_TRAVELAGENT_VIEWS . '/travelagent/travel_agent_bank_details.php';
    }
    /**
     * An empty page for testing purposes
     *
     * @return void
     */
    public function empty_page() {

    }

}
