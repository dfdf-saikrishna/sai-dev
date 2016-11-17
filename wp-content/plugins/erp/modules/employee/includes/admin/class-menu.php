<?php
namespace WeDevs\ERP\Employee\Admin;
use WeDevs\ERP\Employee\Companyview;

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
        * Employee Menus
        * 
        *  **********************************/
        if ( current_user_can( 'employee' ) ) {
        add_menu_page('Employee Dashboard', 'Employee Dashboard', 'employee', 'employee', 'employeeDashboard','dashicons-admin-users');

        add_menu_page('Employee Profile', 'Employee Profile', 'employee', 'employee-profile', 'employement_details','dashicons-admin-users');

        add_submenu_page('employee-profile', ' Employement Details', ' Employement Details', 'employee',' Employement Details'.'/ Employement Details', 'employement_details');
        add_submenu_page('employee-profile', 'View / Edit emp Profile', ' View / Edit Profile', 'employee','View / Edit Profile'.'/ View / Edit Profile', 'employement_details');
        add_submenu_page('employee-profile', 'Personal Details', ' Personal Details', 'employee',' Personal Details'.'/ Personal Details', 'employement_details');
        add_submenu_page('employee-profile', 'View / Edit personalProfile', 'View / Edit personalProfile', 'employee',' View / Edit personalProfile'.'/ View / Edit personalProfile', 'employement_details');
        add_submenu_page('employee-profile', 'Medical Information ', ' Medical Information ', 'employee',' Medical Information '.'/  Medical Information ', 'employement_details');

        add_submenu_page('employee-profile', ' Add / View / Edit Family Members ', ' Add / View / Edit Family Members ', 'employee','  Add / View / Edit Family Members '.'/  Add / View / Edit Family Members ', 'employement_details');

        add_submenu_page('employee-profile', ' Bank Details ', 'Bank Details', 
        'employee',' Bank Details'.'/  Bank Details ', 'employement_details','dashicons-groups');

        add_submenu_page('employee-profile', ' Bank Account Details ', ' Bank Account Details ', 
        'employee',' Bank Account Details '.'/  Bank Account Details  ', 'employement_details','dashicons-groups');

        add_submenu_page('employee-profile', 'Travel Documents', ' Travel Documents ', 
        'employee',' Travel Documents'.'/ Travel Documents', 'employement_details','dashicons-analytics');

        add_submenu_page('employee-profile', ' Passport Details ', ' Passport Details ', 
        'employee',' Passport Details '.'/ Passport Details ', 'employement_details','dashicons-id-alt');

        add_submenu_page('employee-profile', ' Visa Details ', ' Visa Details ', 
        'employee',' Visa Details  '.'/  Visa Details  ', 'employement_details','dashicons-id');

        add_submenu_page('employee-profile', '  Frequent Flyers  ', ' Frequent Flyers ', 
        'employee',' Frequent Flyers  '.'/  Frequent Flyers  ', 'employement_details');

        add_submenu_page('employee-profile', '  Driving License  ', '  Driving License ', 
        'employee','  Driving License  '.'/   Driving License   ', 'employement_details');

        add_menu_page('  Travel Expense ', '  Travel Expense ', 'employee', 'Travel Expense', 'travel_expense','dashicons-tickets');
            add_submenu_page('Travel Expense', 'Pre Travel', ' Pre Travel', 'employee','Pre Travel'.'/ Pre Travel', 'travel_expense');
            add_submenu_page('Travel Expense', 'Create Request', 'Create Request', 'employee','Create Request'.'/Create Request', 'travel_expense');
            add_submenu_page('Travel Expense', 'View / Edit / Delete Requests', 'View / Edit / Delete Requests', 'employee','View / Edit / Delete Requests'.'/View / Edit / Delete Requests', 'travel_expense');
            add_submenu_page('Travel Expense', 'Post Travel', 'Post Travel', 'employee','Post Travel'.'/Post Travel', 'clivern_render_about_page');
            add_submenu_page('Travel Expense', 'Create Request PostTravel', 'Create Request', 'employee','Create Request'.'/Create Request', 'clivern_render_about_page');
            add_submenu_page('Travel Expense', 'View / Edit / Delete Requests PostTravel', 'View / Edit / Delete Requests', 'employee','View / Edit / Delete Requests'.'/View / Edit / Delete Requests', 'travel_expense');

        add_menu_page('General Expense', 'General Expense', 'employee', 'General Expense', 'general_expense','dashicons-migrate');
            add_submenu_page('General Expense', ' Mileage ', 'Mileage', 'employee','Mileage'.'/Mileage', 'general_expense');
            add_submenu_page('General Expense', 'Create Request', 'Create Request', 'employee','Create Request'.'/Create Request', 'general_expense');
            add_submenu_page('General Expense', 'View / Edit / Delete Requests', 'View / Edit / Delete Requests', 'employee','View / Edit / Delete Requests'.'/View / Edit / Delete Requests', 'general_expense');
            add_submenu_page('General Expense', 'Utilities', 'Utilities', 'employee','Utilities'.'/Utilities', 'general_expense');
            add_submenu_page('General Expense', 'Create Request PostTravel', 'Create Request', 'employee','Create Request'.'/Create Request', 'general_expense');
            add_submenu_page('General Expense', 'View / Edit / Delete Requests PostTravel', 'View / Edit / Delete Requests', 'employee','View / Edit / Delete Requests'.'/View / Edit / Delete Requests', 'general_expense');
            add_submenu_page('General Expense', 'others', 'others', 'employee','others'.'/others', 'general_expense');
            add_submenu_page('General Expense', 'Create Request PostTravel', 'Create Request', 'employee','Create Request'.'/Create Request', 'general_expense');
            add_submenu_page('General Expense', 'View / Edit / Delete Requests PostTravel', 'View / Edit / Delete Requests', 'employee','View / Edit / Delete Requests'.'/View / Edit / Delete Requests', 'general_expense');

        add_menu_page(' Reports', ' Reports', 'employee', ' Reports', 'reports','dashicons-media-spreadsheet');

        add_menu_page('My Team', 'My Team', 'employee', 'My Team', 'myteam','dashicons-groups');
            add_submenu_page('My Team', 'Approved Requests', 'Approved Requests', 'employee','Approved Requests'.'/Approved Requests', 'myteam');
            add_submenu_page('My Team', 'Pending Requests', 'Pending Requests', 'employee','Pending Requests'.'/Pending Requests', 'myteam');
            add_submenu_page('My Team', 'Rejected Requests', 'Rejected Requests', 'employee','Rejected Requests'.'/Rejected Requests', 'myteam');
            add_submenu_page('My Team', 'View My Team', 'View My Team', 'employee','View My Team'.'/View My Team', 'myteam');

        add_menu_page('Delegate', 'Delegate', 'employee', 'Delegate', 'delegate','dashicons-image-filter');
            add_submenu_page('Delegate', 'Set Delegate', 'Set Delegate', 'employee','Set Delegate'.'/Set Delegate', 'delegate');
            add_submenu_page('Delegate', 'View / Edit / Remove Delegate', 'View / Edit / Remove Delegate', 'employee','View / Edit / Remove Delegate'.'/View / Edit / Remove Delegate', 'delegate');
        add_menu_page('Download Company Expense Policy', 'Download Company Expense Policy', 'employee', 'Download Company Expense Policy', 'setting','dashicons-arrow-down-alt');
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
