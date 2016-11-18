<?php
namespace WeDevs\ERP\Company\Admin;
use WeDevs\ERP\Company\Companyview;

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
       if ( current_user_can( 'companyadmin' ) ) {
        add_menu_page(__( 'Dashboard', 'companyadmin' ), __( 'Dashboard', 'companyadmin' ), 'companyadmin','company-dashboard', array( $this, 'company_dashboard'),'dashicons-dashboard');

        add_menu_page('Employeemanagement', 'Employee management', 'companyadmin','menu', 'employee','dashicons-admin-users');

        add_submenu_page('menu', 'Upload', 'Upload Employees', 'companyadmin', 'submenu', 'employee');
        add_submenu_page('menu', 'Individual', 'Add Individual Employees', 'companyadmin', 'individual', 'employee');
        add_submenu_page('menu', 'Action', 'View/Edit/Delete employee', 'companyadmin', 'action', 'employee');
        add_submenu_page('menu', 'Profile', 'View Employee Profile', 'companyadmin', 'Profile', 'employee');
        add_submenu_page('menu', 'Logs', 'View  Employees Logs', 'companyadmin', 'Logs', 'employee');
        add_submenu_page('menu', 'Grades', ' Employees Grades', 'companyadmin', 'Grades', 'employee');
        add_submenu_page('menu', 'Des', 'Employees Designation', 'companyadmin', 'Des', 'employee');
        add_submenu_page('menu', 'dep', 'Employees Departments', 'companyadmin', 'Dep', 'employee');
        add_submenu_page('menu', 'Delegation', 'View Delegation', 'companyadmin', 'delegation', 'employee');

        add_menu_page(__('Finance Approvers','companyadmin'), __('Finance Approvers','companyadmin'), 'companyadmin', 'financemenu', array( $this, 'addfinance'),'dashicons-money');
      
       // add_submenu_page('finance', 'action', 'View/Edit/Delete employee', 'companyadmin', 'finaceEmp', 'finance');
        add_submenu_page('financemenu', __('finance','companyadmin'), __('Define Approval Limits(set/Edit Limits)'), 'companyadmin','limitsmenu',array( $this, 'financelimits'));

        add_menu_page('ExpenseManagment', 'Expense Managment', 'companyadmin', 'Expense', 'expense','dashicons-money');
        add_submenu_page('Expense', 'action', 'Expense Policy', 'companyadmin', 'ExpenseP', 'Expense');
        add_submenu_page('Expense', 'Policy', 'Upload/View Policy', 'companyadmin', 'Policy', 'Expense');
        add_submenu_page('Expense', 'Grades', 'Define Grade Limits(set/Edit Limits)', 'companyadmin', 'GradeLimits', 'Expense');
        add_submenu_page('Expense', 'categeory', 'Expense Category', 'companyadmin', 'categeory', 'Expense');
        add_submenu_page('Expense', 'Mileage', 'Mileage', 'companyadmin', 'Mileage', 'Expense');

        add_menu_page('WorkFlow', 'WorkFlow', 'companyadmin', 'WorkFlow', 'workflow','dashicons-networking');

        add_menu_page('TravelDesk', 'Travel Desk', 'companyadmin', 'Travel', 'TravelDesk','dashicons-location');
        add_submenu_page('Travel', 'Action', 'View/Edit/Delete Travel Desk', 'companyadmin', 'Action', 'TravelDesk');
        add_submenu_page('Travel', 'Invoice', 'Travel Desk Invoices', 'companyadmin', 'Invoice', 'TravelDesk','');
        add_submenu_page('Travel', 'DeskLogs', 'Travel Desk Logs', 'companyadmin', 'DeskLogs', 'TravelDesk');
        add_submenu_page('Travel', 'ToleranceLimits', 'Tolerance Limits', 'companyadmin', 'Tolerance', 'TravelDesk');

        add_menu_page('Requests', 'Expense Requests', 'companyadmin', 'Requests', 'Requests','dashicons-money');
        add_submenu_page('Requests', 'Pre', 'Pre Travel Expense Requests', 'companyadmin', 'Pre Travel', 'Requests');
        add_submenu_page('Requests', 'post', 'Post Travel Expense Requests', 'companyadmin', 'Post tarvel', 'Requests');
        add_submenu_page('Requests', 'general', 'General Expenses', 'companyadmin', 'GeneralExpenses', 'Requests');
        add_submenu_page('Requests', 'mileage', 'Mileage Requests', 'companyadmin', 'mileage', 'Requests');
        add_submenu_page('Requests', 'utility', 'Utility Expense Requests', 'companyadmin', 'utility', 'Requests');

        add_menu_page('BudgetController', 'Budget Control', 'companyadmin', 'Budget', 'BudgetController','dashicons-portfolio');
        add_submenu_page('Budget', 'Project', 'Project Code', 'companyadmin', 'Project', 'BudgetController');
        add_submenu_page('Budget', 'Center', 'Cost Center', 'companyadmin', 'Center', 'BudgetController');

        add_menu_page('ReportsGraphs', 'ReportsGraphs', 'companyadmin', 'Graphs', 'ReportsGraphs','dashicons-chart-bar');
        add_submenu_page('Graphs', 'Estimated', ' Estimated Cost Vs Actual Spend ', 'companyadmin', 'Estimated', 'ReportsGraphs ');
        add_submenu_page('Graphs', 'Department', 'Department Wise', 'companyadmin', 'DepartmentWise', 'ReportsGraphs');
        add_submenu_page('Graphs', 'EmployeeWise', 'Employee Wise', 'companyadmin', 'EmployeeWise', 'ReportsGraphs');
        add_submenu_page('Graphs', 'Hotels', 'Hotels - Budget limit Vs Actual Spend ', 'companyadmin', 'Hotels', 'ReportsGraphs');
        add_submenu_page('Graphs', 'Compare', 'Compare Travel Spends across Departments', 'companyadmin', 'Compare', 'ReportsGraphs');
        add_submenu_page('Graphs', 'All', 'All Travel Category', 'companyadmin', 'Travel Category', 'ReportsGraphs');
        add_submenu_page('Graphs', 'Tracker', 'Travel Spend Tracker related to Air / Car / Hotels / Bus', 'companyadmin', 'Tracker', 'ReportsGraphs');
        add_submenu_page('Graphs', 'Lowest', 'Air / Bus - Lowest Fare Vs Actual Booked ', 'companyadmin', 'Lowest', 'ReportsGraphs');
        add_submenu_page('Graphs', 'Approved', 'Pre Approved Travel Vs Post Travel Request','companyadmin', 'Approved', 'ReportsGraphs');

        add_menu_page('Settings', 'Settings', 'companyadmin', 'Settings', 'Settings','dashicons-menu');
        add_submenu_page('Settings', 'Always', 'Always Left menu', 'companyadmin', 'Always', 'Settings');
        add_submenu_page('Settings', 'Show', 'Show & Hide Left menu', 'companyadmin', 'Show', 'Settings');
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
     * Handles the companyDashboard page
     *
     * @return void
     */
    public function company_dashboard() {
        include WPERP_COMPANY_VIEWS . '/company/dashboard.php';
    }
    
    /**
     * Handles company admin page
     *
     * @return void
     */
    public function companiesadmin() {
        include WPERP_COMPANY_VIEWS . '/companyadmin/view.php';
    }
    
    public function addfinance() {
          include WPERP_COMPANY_VIEWS . '/company/addfinance.php';
      }

       public function financelimits() {
          include WPERP_COMPANY_VIEWS . '/company/financelimits.php';
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
