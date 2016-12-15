<?php
namespace WeDevs\ERP\Traveldesk\Admin;
use WeDevs\ERP\Traveldesk\Traveldeskview;

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
        * 
        * Company Admin
        * 
        *  **********************************/
       if ( current_user_can( 'traveldesk' ) ) {
        add_menu_page(__( 'Dashboard', 'traveldesk' ), __( 'Dashboard', 'traveldesk' ), 'traveldesk','traveldesk-dashboard', array( $this, 'traveldesk_dashboard'),'dashicons-dashboard');

        add_menu_page('View-Edit-Request', 'Request Without Approval', 'traveldesk','View-Edit-Request', array( $this, 'view_req_withoutappr'),'dashicons-admin-users');
        
        $overview = add_submenu_page('View-Edit-Request', 'Overview', 'Overview', 'traveldesk', 'View-Edit-Request', array( $this,'view_req_withoutappr'));

        add_submenu_page('View-Edit-Request', 'Create Request', 'Create Request', 'traveldesk', 'Request-Without-Approval', array( $this,'traveldeskrequest_withoutapp'),'dashicons-admin-users');
        
        add_submenu_page('', 'Edit Request', 'Edit Request', 'traveldesk', 'Edit-Request', array( $this,'traveldeskrequest_edit_withoutapp'),'dashicons-admin-users');
        
        add_submenu_page('', 'View Request', 'View Request', 'traveldesk', 'View-Request', array( $this,'traveldeskrequest_withoutapp_view'),'dashicons-admin-users');
        
        
        add_menu_page('View-Edit-appRequest', 'Request With Approval', 'traveldesk','View-Edit-appRequest', array( $this, 'view_req_withappr'),'dashicons-admin-users');
        
        $overview = add_submenu_page('View-Edit-appRequest', 'Overview', 'Overview', 'traveldesk', 'View-Edit-appRequest', array( $this,'view_req_withappr'));

        add_submenu_page('View-Edit-appRequest', 'Create Request', 'Create Request', 'traveldesk', 'Request-With-Approval', array( $this,'traveldeskrequest_withapp'),'dashicons-admin-users');
 
        add_submenu_page('', 'Edit Appr Request', 'Edit Appr Request', 'traveldesk', 'Edit-Appr-Request', array( $this,'traveldeskrequest_edit_withapp'),'dashicons-admin-users');
        
        add_submenu_page('', 'View Appr Request', 'View Appr Request', 'traveldesk', 'View-Appr-Request', array( $this,'traveldeskrequest_withapp_view'),'dashicons-admin-users');
        
        add_submenu_page('', 'Download File', 'Download File', 'traveldesk', 'Download-File', array( $this,'download_file'),'dashicons-admin-users');
//        add_menu_page('ExpenseManagment', 'Expense Managment', 'traveldesk', 'Expense', 'expense','dashicons-money');
//        add_submenu_page('Expense', 'action', 'Expense Policy', 'traveldesk', 'ExpenseP', 'Expense');
//        add_submenu_page('Expense', 'Policy', 'Upload/View Policy', 'traveldesk', 'Policy', 'Expense');
//        add_submenu_page('Expense', 'Grades', 'Define Grade Limits(set/Edit Limits)', 'traveldesk', 'GradeLimits', 'Expense');
//        add_submenu_page('Expense', 'categeory', 'Expense Category', 'traveldesk', 'categeory', 'Expense');
//        add_submenu_page('Expense', 'Mileage', 'Mileage', 'traveldesk', 'Mileage', 'Expense');
//
//        add_menu_page('WorkFlow', 'WorkFlow', 'traveldesk', 'WorkFlow', 'workflow','dashicons-networking');
//
//        add_menu_page(__( 'Travel Desk', 'traveldesk' ), __( 'Traveldesk', 'traveldesk' ), 'traveldesk','travel-dashboard', array( $this, 'travel_dashboard'),'dashicons-dashboard');        
//        $overview =add_submenu_page('travel-dashboard', 'Action', 'View/Edit/Delete Travel Desk', 'traveldesk', 'Action', 'TravelDesk');
//        add_submenu_page('travel-dashboard', 'Invoice', 'Travel Desk Invoices', 'traveldesk', 'Invoice', array( $this, 'travelinvoice_dashboard'));
//        add_submenu_page('travel-dashboard', 'DeskLogs', 'Travel Desk Logs', 'traveldesk', 'DeskLogs', 'TravelDesk');
//        add_submenu_page('travel-dashboard', 'ToleranceLimits', 'Tolerance Limits', 'traveldesk', 'Tolerance', 'TravelDesk');
//
//        add_menu_page('Requests', 'Expense Requests', 'traveldesk', 'Requests', 'Requests','dashicons-money');
//        add_submenu_page('Requests', 'Pre', 'Pre Travel Expense Requests', 'traveldesk', 'Pre Travel', 'Requests');
//        add_submenu_page('Requests', 'post', 'Post Travel Expense Requests', 'traveldesk', 'Post tarvel', 'Requests');
//        add_submenu_page('Requests', 'general', 'General Expenses', 'traveldesk', 'GeneralExpenses', 'Requests');
//        add_submenu_page('Requests', 'mileage', 'Mileage Requests', 'traveldesk', 'mileage', 'Requests');
//        add_submenu_page('Requests', 'utility', 'Utility Expense Requests', 'traveldesk', 'utility', 'Requests');
//
//        add_menu_page('BudgetController', 'Budget Control', 'traveldesk', 'Budget', 'BudgetController','dashicons-portfolio');
//        add_submenu_page('Budget', 'Project', 'Project Code', 'traveldesk', 'Project', 'BudgetController');
//        add_submenu_page('Budget', 'Center', 'Cost Center', 'traveldesk', 'Center', 'BudgetController');
//
//        add_menu_page('ReportsGraphs', 'ReportsGraphs', 'traveldesk', 'Graphs', 'ReportsGraphs','dashicons-chart-bar');
//        add_submenu_page('Graphs', 'Estimated', ' Estimated Cost Vs Actual Spend ', 'traveldesk', 'Estimated', 'ReportsGraphs ');
//        add_submenu_page('Graphs', 'Department', 'Department Wise', 'traveldesk', 'DepartmentWise', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'EmployeeWise', 'Employee Wise', 'traveldesk', 'EmployeeWise', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'Hotels', 'Hotels - Budget limit Vs Actual Spend ', 'traveldesk', 'Hotels', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'Compare', 'Compare Travel Spends across Departments', 'traveldesk', 'Compare', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'All', 'All Travel Category', 'traveldesk', 'Travel Category', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'Tracker', 'Travel Spend Tracker related to Air / Car / Hotels / Bus', 'traveldesk', 'Tracker', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'Lowest', 'Air / Bus - Lowest Fare Vs Actual Booked ', 'traveldesk', 'Lowest', 'ReportsGraphs');
//        add_submenu_page('Graphs', 'Approved', 'Pre Approved Travel Vs Post Travel Request','traveldesk', 'Approved', 'ReportsGraphs');
//
//        add_menu_page('Settings', 'Settings', 'traveldesk', 'Settings', 'Settings','dashicons-menu');
//        add_submenu_page('Settings', 'Always', 'Always Left menu', 'traveldesk', 'Always', 'Settings');
//        add_submenu_page('Settings', 'Show', 'Show & Hide Left menu', 'traveldesk', 'Show', 'Settings');
add_menu_page   ('Group Request', 'Group Request', 'traveldesk', ' Group Request', 'Group Request','dashicons-migrate');
add_submenu_page('Group Request', 'Create Request', 'Create Request', 'traveldesk','Create Request'.'/ Create Request', 'Create Request');
add_submenu_page('Group Request', 'View / Edit Request', 'View / Edit Request', 'traveldesk','View / Edit Request'.'/ View / Edit Request', 'View / Edit Request');

add_menu_page('claims', 'claims', 'traveldesk', 'claims', 'claims','dashicons-media-spreadsheet');
add_submenu_page('claims', 'View Invoices', 'View Invoices', 'traveldesk','View Invoices'.'/ View Invoices',array( $this, 'traveldeskClaims'));
add_submenu_page('claims', 'Bank Details', 'Bank Details', 'traveldesk','Bank Details'.'/ Bank Details', array( $this, 'traveldeskBankDetails'));

add_menu_page('Settings', 'Settings', 'traveldesk', 'Settings', 'setting','dashicons-admin-generic');
add_submenu_page('Settings', 'Change Password', 'Change Password', 'traveldesk','Change Password'.'/Change Password', 'setting');
add_submenu_page('Settings', 'Always Left menu', 'Always Left menu', 'traveldesk','Always Left menu'.'/Always Left menu', 'setting');
add_submenu_page('Settings', 'Show & Hide Left menu', 'Show & Hide Left menu', 'traveldesk','Show & Hide Left menu'.'/Show & Hide Left menu', 'setting');
add_menu_page('Download Company Expense Policy', 'Download Company Expense Policy', 'traveldesk', 'Download Company Expense Policy', 'setting');

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
    
    public function travel_dashboard() {
        include WPERP_COMPANY_VIEWS . '/traveldashboard.php';
    }
    
    public function travelinvoice_dashboard() {
        include WPERP_COMPANY_VIEWS . '/travelinvoicedashboard.php';
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
    public function traveldesk_dashboard() {
        include WPERP_TRAVELDESK_VIEWS . '/dashboard.php';
    }
    public function traveldeskrequest_withoutapp() {
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-individual-without-approval-add.php';
    }
    public function traveldeskrequest_edit_withoutapp(){
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-individual-without-approval-edit.php';
    }
    public function traveldeskrequest_edit_withapp(){
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-individual-with-approval-edit.php';
    }
    public function traveldeskrequest_withapp_view(){
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-individual-with-approval-view.php';
    }
    public function download_file(){
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-download-file.php';
    }
    public function traveldeskrequest_withoutapp_view(){
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-individual-without-approval-view.php';
    }
    public function traveldeskrequest_withapp() {
        include WPERP_TRAVELDESK_VIEWS . '/travel-desk-individual-with-approval-add.php';
    }
    public function view_req_withoutappr(){
        include WPERP_TRAVELDESK_VIEWS . '/view-request-withoutapproval.php';
    }
    public function view_req_withappr(){
        include WPERP_TRAVELDESK_VIEWS . '/view-request-withapproval.php';
    }
    public function traveldeskrequestedit() {
        include WPERP_TRAVELDESK_VIEWS . '/traveldeskview.php';
    }
	
	public function tvClaims() {
        include WPERP_TRAVELDESK_VIEWS . '/traveldesk_claims.php';
    }
    
    public function traveldeskClaims() {
        include WPERP_TRAVELDESK_VIEWS . '/traveldesk_claims.php';
    }
    
    public function traveldeskBankDetails() {
        include WPERP_TRAVELDESK_VIEWS . '/traveldesk_bank_details.php';
    }
    
    /**
     * Handles company admin page
     *
     * @return void
     */
    public function companiesadmin() {
        include WPERP_CORPTNE_VIEWS . '/traveldesk/view.php';
    }
    

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function employee_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':
                $employee = new Employee( $id );
                if ( ! $employee->id ) {
                    wp_die( __( 'Employee not found!', 'erp' ) );
                }

                $template = WPERP_HRM_VIEWS . '/employee/single.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/employee.php';
                break;
        }

        $template = apply_filters( 'erp_hr_employee_templates', $template, $action, $id );

        if ( file_exists( $template ) ) {
            include $template;
        }
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
     * An empty page for testing purposes
     *
     * @return void
     */
    public function empty_page() {

    }

}
