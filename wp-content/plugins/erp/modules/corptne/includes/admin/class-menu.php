<?php
namespace WeDevs\ERP\Corptne\Admin;
use WeDevs\ERP\Corptne\Companyview;
use WeDevs\ERP\Corptne\Masteradminview;
use WeDevs\ERP\Corptne\TravelAgentview;

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
        if ( current_user_can( 'superadmin' ) ) {
           add_menu_page(__( 'Dashboard', 'superadmin' ),  __( 'Dashboard', 'superadmin' ), 'superadmin', 'superadmin-dashboard', array( $this, 'dashboard_page'),'dashicons-welcome-view-site' );

           //add_menu_page( 'Master Admin Menu', 'Master Admin', 'superadmin', 'masteradminmenu', 'masteradminmenu_init', array( $this, 'masteradmin_list'),'dashicons-building' );
          add_menu_page( __( 'Master Admin Menu', 'superadmin' ), __( 'Master Admin', 'superadmin' ), 'superadmin', 'masteradminmenu', array( $this, 'masteradmin_list'),'dashicons-building' );
		   $overview = add_submenu_page( 'masteradminmenu', 'Overview', 'Overview', 'superadmin', 'masteradminmenu', array( $this, 'masteradmin_list'));
		   //add_submenu_page( 'masteradminmenu', 'Add Master Admin', 'Add Master Admin', 'superadmin', 'masteradminadd', 'masteradminadd');
           //add_submenu_page( 'masteradminmenu', 'View / Edit / Delete Master Admin', 'View / Edit / Delete Master Admin', 'superadmin', 'masteradminview', array( $this, 'masteradminview_page'));

           add_menu_page( __( 'Companies', 'superadmin' ), __( 'Companies', 'superadmin' ), 'superadmin', 'companiesmenu', array( $this, 'companies_list'),'dashicons-building' );
           $overview = add_submenu_page('companiesmenu', 'Overview', 'Overview', 'superadmin', 'companiesmenu', array( $this, 'companies_list'));

           //add_submenu_page( 'companiesmenu', 'Create Company', 'Create Company', 'superadmin', 'mastercompaniesnew', 'mastercompaniesnew');
           //add_submenu_page( 'companiesmenu', 'View / Edit Company', 'View / Edit Company', 'superadmin', 'mastercompaniesview',array( $this, 'companyview_page' ));
           add_submenu_page( 'companiesmenu', 'Company Admins', 'Company Admins', 'superadmin', 'companies-admin',  array( $this, 'companiesadmin')); 

           add_menu_page( 'Travelagents', 'Travelagents', 'superadmin', 'travelagentsmenu',array( $this, 'travelagent_create'),'dashicons-building');
		   //$overview = add_submenu_page( 'travelagentsmenu', 'Overview', 'Overview', 'superadmin', 'travelagentsmenu','travelagentsmenu_init',array( $this, 'travelagent_create'));
		   //add_submenu_page( 'travelagentsmenu', 'Add Travel Agents', 'Add Travel Agents', 'superadmin', 'superadmintravelagentsadd', 'superadmintravelagentsadd');
           //add_submenu_page( 'travelagentsmenu', 'travelagentadd', 'View / Edit / Delete Travel Agents ', 'superadmin', 'travelagents',array( $this, 'travelagentsview_page' ));
           //add_submenu_page( 'travelagentsmenu', 'Travel Desk Logs', 'Travel Desk Logs', 'superadmin', 'superadmintravelagentslogs', 'superadmintravelagentslogs');

           add_menu_page(__( 'WorkFlow', 'superadmin' ), __( 'WorkFlow', 'superadmin' ),  'superadmin', 'workflowsmenu', array( $this, 'workflow'),'dashicons-products' );
           $overview = add_submenu_page( 'workflowsmenu', 'Overview', 'Overview', 'superadmin', 'workflowsmenu', array( $this, 'workflow'));
		   //add_submenu_page( 'workflowsmenu', 'Add / Edit / Delete Workflow', 'Add / Edit / Delete Workflow', 'superadmin', 'mastercompaniesworkflow', 'mastercompaniesworkflow');

//           add_menu_page( 'reportscharts Menu', 'Reports & Charts', 'superadmin', 'reportschartsmenu', 'reportschartsmenu_init','dashicons-chart-bar');
//           $overview = add_submenu_page( 'reportschartsmenu', 'Overview', 'Overview', 'superadmin', 'reportschartsmenu', 'reportschartsmenu_init');
//		   add_submenu_page( 'reportschartsmenu', 'Chart 1', 'Chart 1', 'superadmin', '', '');
//           add_submenu_page( 'reportschartsmenu', 'Chart 2', 'Chart 2', 'superadmin', '', '');
//           add_submenu_page( 'reportschartsmenu', 'Chart 3', 'Chart 3', 'superadmin', '', '');
//           add_submenu_page( 'reportschartsmenu', 'Chart 4', 'Chart 4', 'superadmin', '', '');

           add_menu_page( 'Expense Category Menu', 'Expense Category', 'superadmin', 'expensecategorymenu', array( $this, 'expensecategory_list'));
           $overview = add_submenu_page( 'expensecategorymenu', 'Overview', 'Overview', 'superadmin', 'expensecategorymenu', array( $this, 'expensecategory_list'));
		   add_submenu_page( 'expensecategorymenu', 'Default Expense Category', 'Default Expense Category', 'superadmin', 'masterexpensecategory', array( $this, 'expensecategory_list'));
           add_submenu_page( 'expensecategorymenu', 'Company Expense Category', 'Company Expense Category', 'superadmin', 'mastercompanyexpcat',  array( $this, 'companyexpensecategory_list')); 

//           add_menu_page( 'Help Docs Menu', 'Help Docs', 'superadmin', 'helpdocsmenu', 'helpdocsmenu_init' );
//           $overview = add_submenu_page( 'helpdocsmenu', 'Overview', 'Overview', 'superadmin', 'helpdocsmenu', 'helpdocsmenu_init');
//		   add_submenu_page( 'helpdocsmenu', 'Create Topic', 'Create Topic', 'superadmin', '', '');
//           add_submenu_page( 'helpdocsmenu', 'View /Edit Topic', 'View /Edit Topic', 'superadmin', '', ''); 

//           add_menu_page( 'Settings Menu', 'Settings', 'superadmin', 'settingsmenu', 'settingsmenu_init','dashicons-editor-ul');
//           $overview = add_submenu_page( 'settingsmenu', 'Overview', 'Overview', 'superadmin', 'settingsmenu', 'settingsmenu_init');
//		   add_submenu_page( 'settingsmenu', 'Change Password', 'Change Password', 'superadmin', 'masterchangepassword', 'masterchangepassword');
//           add_submenu_page( 'settingsmenu', 'Hide User Panel', 'Hide User Panel', 'superadmin', '', ''); 
//           add_submenu_page( 'settingsmenu', 'Show & Hide', 'Show & Hide', 'superadmin', '', '');  
//           add_submenu_page( 'settingsmenu', 'Top Menu', 'Top Menu', 'superadmin', '', ''); 
//           add_submenu_page( 'settingsmenu', 'Footer Show', 'Footer Show', 'superadmin', '', ''); 
//           add_submenu_page( 'settingsmenu', 'Footer with menu', 'Footer with menu', 'superadmin', '', ''); 
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
        include WPERP_CORPTNE_VIEWS . '/dashboard.php';
    }
    
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function travelagent_create() {
        include WPERP_CORPTNE_VIEWS . '/superadmin/travel-agent-create.php';
    }
    public function masteradmin_list() {
        include WPERP_CORPTNE_VIEWS . '/superadmin/masteradmin_list.php';
    }
	
    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function companies_list() {
        include WPERP_CORPTNE_VIEWS . '/superadmin/companies_list.php';
    }

    public function workflow(){
        
        include WPERP_CORPTNE_VIEWS . '/superadmin/workflow.php';
	}
    
	 /**
     * Handles the expense category list page
     *
     * @return void
     */
    public function expensecategory_list() {
        include WPERP_CORPTNE_VIEWS . '/superadmin/expensecategory_list.php';
    }
    
	/**
     * Handles the company expense category list page
     *
     * @return void
     */
    public function companyexpensecategory_list() {
        include WPERP_CORPTNE_VIEWS . '/superadmin/companyexpensecategory_list.php';
    }
	
    /**
     * Handles the companyDashboard page
     *
     * @return void
     */
    public function company_dashboard() {
        include WPERP_CORPTNE_VIEWS . '/company/dashboard.php';
    }
    
    /**
     * Handles company admin page
     *
     * @return void
     */
    public function companiesadmin() {
        include WPERP_CORPTNE_VIEWS . '/companyadmin/view.php';
    }

	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function companyview_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
		
        switch ($action) {
            case 'view':
                $companyview = new Companyview( $id );
                if ( !$id ) {
                    wp_die( __( 'Company not found!', 'erp' ) );
                }  
                $template = WPERP_CORPTNE_VIEWS . '/company/companyview.php';
                break;

            default:
                $template = WPERP_CORPTNE_VIEWS . '/companyview.php';
                break;
        }

        $template = apply_filters( 'erp_hr_company_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

	/**
     * Handles the travelagentsview_page
     *
     * @return void
     */
    public function travelagentsview_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
		
        switch ($action) {
           
            case 'view':
                $travelagentview = new TravelAgentview( $id );
                if ( !$id ) {
                    wp_die( __( 'Travel Agent not found!', 'erp' ) );
                }  
                $template = WPERP_CORPTNE_VIEWS . '/superadmin/travelagentview.php';
                break;

            default:
                $template = WPERP_CORPTNE_VIEWS . '/travelagentview.php';
                break;
        }

        $template = apply_filters( 'erp_hr_travelagents_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
    /**
     * Employee my profile page template
     *
     * @since 0.1
     *
     * @return void
     */
    public function employee_my_profile_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : intval( get_current_user_id() );

        switch ($action) {
            case 'view':
                $employee = new Employee( $id );
                if ( ! $employee->id ) {
                    wp_die( __( 'Employee not found!', 'erp' ) );
                }

                $template = WPERP_HRM_VIEWS . '/employee/single.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/employee/single.php';
                break;
        }

        $template = apply_filters( 'erp_hr_employee_my_profile_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function department_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':
                $template = WPERP_HRM_VIEWS . '/departments/single.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/departments.php';
                break;
        }

        $template = apply_filters( 'erp_hr_department_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Render the designation page
     *
     * @return void
     */
    public function designation_page() {
        include WPERP_HRM_VIEWS . '/designation.php';
    }

    /**
     * Renders ERP HR Reporting Page
     *
     * @return void
     */
    public function reporting_page() {

        $action = isset( $_GET['type'] ) ? $_GET['type'] : 'main';

        switch ( $action ) {
            case 'age-profile':
                $template = WPERP_HRM_VIEWS . '/reporting/age-profile.php';
                break;

            case 'gender-profile':
                $template = WPERP_HRM_VIEWS . '/reporting/gender-profile.php';
                break;

            case 'headcount':
                $template = WPERP_HRM_VIEWS . '/reporting/headcount.php';
                break;

            case 'salary-history':
                $template = WPERP_HRM_VIEWS . '/reporting/salary-history.php';
                break;

            case 'years-of-service':
                $template = WPERP_HRM_VIEWS . '/reporting/years-of-service.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/reporting.php';
                break;
        }

        $template = apply_filters( 'erp_hr_reporting_pages', $template, $action );

        if ( file_exists( $template ) ) {

            include $template;
        }
    }

    /**
     * Render the leave policy page
     *
     * @return void
     */
    public function leave_policy_page() {
        include WPERP_HRM_VIEWS . '/leave/leave-policies.php';
    }

    /**
     * Render the holiday page
     *
     * @return void
     */
    public function holiday_page() {
        include WPERP_HRM_VIEWS . '/leave/holiday.php';
    }

    /**
     * Render the leave entitlements page
     *
     * @return void
     */
    public function leave_entitilements() {
        include WPERP_HRM_VIEWS . '/leave/leave-entitlements.php';
    }

    /**
     * Render the leave entitlements calendar
     *
     * @return void
     */
    public function leave_calendar_page() {
        include WPERP_HRM_VIEWS . '/leave/calendar.php';
    }

    /**
     * Render the leave requests page
     *
     * @return void
     */
    public function leave_requests() {
        $view = isset( $_GET['view'] ) ? $_GET['view'] : 'list';

        switch ($view) {
            case 'new':
                include WPERP_HRM_VIEWS . '/leave/new-request.php';
                break;

            default:
                include WPERP_HRM_VIEWS . '/leave/requests.php';
                break;
        }
    }

	
	/**
     * Handles the dashboard page
     *
     * @return void
     */
    public function masteradminview_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'view';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
		
        switch ($action) {
            case 'view':
                $masteradminview = new Masteradminview( $id );
                if ( !$id ) {
                    wp_die( __( 'Company not found!', 'erp' ) );
                }  
                $template = WPERP_CORPTNE_VIEWS . '/superadmin/masteradminview.php';
                break;

            default:
                $template = WPERP_CORPTNE_VIEWS . '/masteradminview.php';
                break;
        }

        $template = apply_filters( 'erp_hr_company_templates', $template, $action, $id );

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
