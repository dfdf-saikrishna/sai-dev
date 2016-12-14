<?php

namespace WeDevs\ERP\Company\Admin;

use WeDevs\ERP\Company\Companyview;
use WeDevs\ERP\Company\Employeeview;

/**
 * Admin Menu
 */
class Admin_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /*         * ********************************
         * 
         * Company Admin
         * 
         *  ********************************* */
        if (current_user_can('companyadmin')) {
            add_menu_page(__('Dashboard', 'companyadmin'), __('Dashboard', 'companyadmin'), 'companyadmin', 'company-dashboard', array($this, 'company_dashboard'), 'dashicons-dashboard');

            // add_menu_page('Employeemanagement', 'Employee management', 'companyadmin','menu', 'employee','dashicons-admin-users');


            add_menu_page('Employeemanagement', 'Employee management', 'companyadmin', 'menu', array($this, 'employee_list'), 'dashicons-admin-users');

            $overview = add_submenu_page('menu', 'Overview', 'Overview', 'companyadmin', 'menu', array($this, 'employee_list'));
                add_submenu_page('menu', 'Upload', 'Upload Employees', 'companyadmin', 'Upload-Employees', array($this, 'upload_employees'));
                add_submenu_page('', 'Upload', 'Upload Employees', 'companyadmin', 'Export-Employees', array($this, 'export_employees'));
                add_submenu_page('menu', 'Profile', 'View Employee Profile', 'companyadmin', 'Profile', array($this, 'employeeview_page'));
                add_submenu_page('menu', 'Logs', 'View  Employees Logs', 'companyadmin', 'Logs', array($this, 'employeelogs_list'));
                add_submenu_page('menu', 'Grades', ' Employees Grades', 'companyadmin', 'Grades', array($this, 'Grades'));
                add_submenu_page('menu', 'Des', 'Employees Designation', 'companyadmin', 'Des', array($this, 'Designations'));
                add_submenu_page('menu', 'dep', 'Employees Departments', 'companyadmin', 'Dep', array($this, 'Departments'));
                add_submenu_page('menu', 'Delegation', 'View Delegation', 'companyadmin', 'delegation', array($this, 'empdelegates_list'));

            add_menu_page('Finance Approvers', 'Finance Approvers', 'companyadmin', 'finance', array($this, 'finance_approvers'), 'dashicons-money');
                add_submenu_page('finance', 'action', 'Overview', 'companyadmin', 'finance', array($this, 'finance_approvers'));
                //add_submenu_page('finance', 'action', 'View/Edit/Delete employee', 'companyadmin', 'finaceEmp', 'finance');
                add_submenu_page('finance', 'Limits', 'Define Approval Limits(set/Edit Limits)', 'companyadmin', 'Limits', array($this, 'approver_limits'));

            add_menu_page(__('ExpenseManagment', 'companyadmin'), __('Expense Managment', 'companyadmin'), 'companyadmin', 'expensemenu', array($this, 'ExpenseManagment'));
            //add_submenu_page('Expense', 'action', 'Expense Policy', 'companyadmin', 'ExpenseP', 'Expense');
            //add_submenu_page('Expense', 'Policy', 'Upload/View Policy', 'companyadmin', 'Policy', 'Expense');
            add_submenu_page('expensemenu', __('Expense', 'companyadmin'), __('Define Grade Limits', 'companyadmin'), 'companyadmin', 'gradeslimits', array($this, 'ExpenseGrades'));
            add_submenu_page('expensemenu', __('default', 'companyadmin'), __('Expense Category', 'companyadmin'), 'companyadmin', 'categeory', array($this, 'DefaultCategory'));
            add_submenu_page('expensemenu', __('Mileage', 'companyadmin'), __('Mileage', 'companyadmin'), 'companyadmin', 'Mileage', array($this, 'Mileage'));

            add_menu_page('WorkFlow', 'WorkFlow', 'companyadmin', 'WorkFlow', array($this, 'company_workflow'), 'dashicons-networking');

            add_menu_page('View/Edit/Delete Travel Desk', 'Travel Desk', 'companyadmin', 'Travel', array($this, 'TravelDesk'), 'dashicons-location');
            //add_submenu_page('Travel', 'Action', 'View/Edit/Delete Travel Desk', 'companyadmin', 'Action', 'TravelDesk');
            add_submenu_page('Travel', 'Claims', 'Travel Desk Claims', 'companyadmin', 'Claims', array($this, 'TdInvoiceDisplay'));
                add_submenu_page('Travel', 'Invoice', 'Travel Desk Invoices', 'companyadmin', 'Invoice', array($this, 'TravelDesk_Invoice'));
                add_submenu_page('Travel', 'DeskLogs', 'Travel Desk Logs', 'companyadmin', 'DeskLogs', array($this, 'TravelDesk_Logs'));
                add_submenu_page('Travel', 'ToleranceLimits', 'Tolerance Limits', 'companyadmin', 'Tolerance', array($this, 'TravelDesk_Tolerance'));

            add_menu_page('Requests', 'Expense Requests', 'companyadmin', 'Expense-Requests', array($this, 'expense_requests'), 'dashicons-money');
                add_submenu_page('Expense-Requests', 'Pre Travel', 'View Pre Travel Requests', 'companyadmin', 'pretravel', array($this, 'PreDisplay'));
                add_submenu_page('Expense-Requests', 'Post Travel', 'View Post Travel Requests', 'companyadmin', 'posttravel', array($this, 'PostDisplay'));
                add_submenu_page('Expense-Requests', 'Mileage Travel', 'View Mileage Travel Requests', 'companyadmin', 'mileage', array($this, 'MileageDisplay'));
                add_submenu_page('Expense-Requests', 'Other Travel', 'View Other Travel Requests', 'companyadmin', 'Other', array($this, 'OtherDisplay'));      
                add_submenu_page('Expense-Requests', 'Utility Travel', 'View Utility Travel Requests', 'companyadmin', 'utility', array($this, 'utilityDisplay'));
            add_menu_page('BudgetController', 'Budget Control', 'companyadmin', 'Budget', array($this, 'ProjectCode'), 'dashicons-portfolio');
                //add_submenu_page('Budget', 'Project', 'Project Code', 'companyadmin', 'Project', 'BudgetController');
                add_submenu_page('Budget', 'Center', 'Cost Center', 'companyadmin', 'Center', array($this, 'CostCenter'));

            add_menu_page('ReportsGraphs', 'ReportsGraphs', 'companyadmin', 'Graphs', array($this, 'ReportsGraphs'), 'dashicons-chart-bar');
                add_submenu_page('Graphs', 'EmployeeWise', 'Employee Wise', 'companyadmin', 'Employeewise', array($this, 'EmployeeGraphs'), 'ReportsGraphs');
                add_submenu_page('Graphs', 'Tracker', 'Travel Spend Tracker related to Air / Car / Hotels / Bus', 'companyadmin', 'Tracker', array($this, 'TravelGraphs'));
          
//   
        }
    }

    /**
     * Handles HR calendar script
     *
     * @return void
     */
    function hr_calendar_script() {
        wp_enqueue_script('erp-momentjs');
        wp_enqueue_script('erp-fullcalendar');
        wp_enqueue_style('erp-fullcalendar');
    }

    /**
     * Handles thecompany calling tablefunctions page
     *
     * @return void
     */
    public function dashboard_page() {
        include WPERP_CORPTNE_VIEWS . '/dashboard.php';
    }

    public function Designations() {
        include WPERP_COMPANY_VIEWS . '/company/Designations.php';
    }

    public function Departments() {
        include WPERP_COMPANY_VIEWS . '/company/Department.php';
    }

    public function Grades() {
        include WPERP_COMPANY_VIEWS . '/company/Grades.php';
    }

    public function ExpenseGrades() {
        include WPERP_COMPANY_VIEWS . '/company/ExpenseGrades.php';
    }

    public function TravelDesk() {
        include WPERP_COMPANY_VIEWS . '/company/traveldesk.php';
    }

    public function TravelDesk_Invoice() {
        include WPERP_COMPANY_VIEWS . '/company/TravelDesk-Invoice.php';
    }

    public function TravelDesk_Logs() {
        include WPERP_COMPANY_VIEWS . '/company/TravelDesk_Logs.php';
    }

    public function TravelDesk_Tolerance() {
        include WPERP_COMPANY_VIEWS . '/company/TravelDesk_Tolerance_Limits.php';
    }

    public function DefaultCategory() {
        include WPERP_COMPANY_VIEWS . '/company/expensedeafultcat.php';
    }

    public function Mileage() {
        include WPERP_COMPANY_VIEWS . '/company/Mileage.php';
    }

    public function ExpenseManagment() {
        include WPERP_COMPANY_VIEWS . '/company/ExpenseManagment.php';
    }

    public function ProjectCode() {
        include WPERP_COMPANY_VIEWS . '/company/ProjectCodeCreate.php';
    }

    public function CostCenter() {
        include WPERP_COMPANY_VIEWS . '/company/CostCenter.php';
    }

    public function ReportsGraphs() {
        include WPERP_COMPANY_VIEWS . '/reporting/Reportingraphs.php';
    }

    public function EmployeeGraphs() {
        include WPERP_COMPANY_VIEWS . '/reporting/Employeegraphs.php';
    }

    public function TravelGraphs() {
        include WPERP_COMPANY_VIEWS . '/reporting/TravelGraphs.php';
    }

    public function company_dashboard() {
        include WPERP_COMPANY_VIEWS . '/company/dashboard.php';
    }

    public function PreDisplay() {
        include WPERP_COMPANY_VIEWS . '/pre-travel-display.php';
    }   
    public function PostDisplay() {
        include WPERP_COMPANY_VIEWS . '/post-travel-display.php';
    }
    public function UtilityDisplay() {
        include WPERP_COMPANY_VIEWS . '/utilirty-expense-details.php';
    }
     public function OtherDisplay() {
        include WPERP_COMPANY_VIEWS . '/other-expense-display.php';
    }
     public function MileageDisplay() {
        include WPERP_COMPANY_VIEWS . '/mileage-display.php';
    } 
    public function TdInvoiceDisplay() {
        include WPERP_COMPANY_VIEWS . '/travel-desk-claims.php';
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
     * Handles Requests page
     *
     * @return void
     */
    public function expense_requests() {
        include WPERP_COMPANY_VIEWS . '/expense_requests.php';
    }

    /**
     * Handles Approver Limits page
     *
     * @return void
     */
    public function approver_limits() {
        include WPERP_COMPANY_VIEWS . '/approver_limits.php';
    }

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function employee_page() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'view':
                $employee = new Employee($id);
                if (!$employee->id) {
                    wp_die(__('Employee not found!', 'erp'));
                }

                $template = WPERP_HRM_VIEWS . '/employee/single.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/employee.php';
                break;
        }

        $template = apply_filters('erp_hr_employee_templates', $template, $action, $id);

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function companyview_page() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'view';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'view':
                $companyview = new Companyview($id);
                if (!$id) {
                    wp_die(__('Company not found!', 'erp'));
                }
                $template = WPERP_CORPTNE_VIEWS . '/company/companyview.php';
                break;

            default:
                $template = WPERP_CORPTNE_VIEWS . '/companyview.php';
                break;
        }

        $template = apply_filters('erp_hr_company_templates', $template, $action, $id);

        if (file_exists($template)) {
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
        $action = isset($_GET['action']) ? $_GET['action'] : 'view';
        $id = isset($_GET['id']) ? intval($_GET['id']) : intval(get_current_user_id());

        switch ($action) {
            case 'view':
                $employee = new Employee($id);
                if (!$employee->id) {
                    wp_die(__('Employee not found!', 'erp'));
                }

                $template = WPERP_HRM_VIEWS . '/employee/single.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/employee/single.php';
                break;
        }

        $template = apply_filters('erp_hr_employee_my_profile_templates', $template, $action, $id);

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function department_page() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'view':
                $template = WPERP_HRM_VIEWS . '/departments/single.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/departments.php';
                break;
        }

        $template = apply_filters('erp_hr_department_templates', $template, $action, $id);

        if (file_exists($template)) {
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

        $action = isset($_GET['type']) ? $_GET['type'] : 'main';

        switch ($action) {
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
            case 'years-of-service':
                $template = WPERP_HRM_VIEWS . '/reporting/Reportingraphs.php';
                break;

            default:
                $template = WPERP_HRM_VIEWS . '/reporting.php';
                break;
        }

        $template = apply_filters('erp_hr_reporting_pages', $template, $action);

        if (file_exists($template)) {

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
        $view = isset($_GET['view']) ? $_GET['view'] : 'list';

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

    /**
     * Handles the Employe list Page
     *
     * @return void
     */
    public function employee_list() {
        include WPERP_COMPANY_VIEWS . '/company/employee_list.php';
    }

    /**
     * Handles the Employe Log list Page
     *
     * @return void
     */
    public function employeelogs_list() {
        include WPERP_COMPANY_VIEWS . '/company/employeelogs_list.php';
    }

    /**
     * Handles the Employe Delegates list Page
     *
     * @return void
     */
    public function empdelegates_list() {
        include WPERP_COMPANY_VIEWS . '/company/empdelegates_list.php';
    }

    /**
     * Upload Employees Page
     *
     * @return void
     */
    public function upload_employees() {
        include WPERP_COMPANY_VIEWS . '/upload-employees.php';
    }

    /**
     * Export Employees Page
     *
     * @return void
     */
    public function export_employees() {
        include WPERP_COMPANY_VIEWS . '/export-employees.php';
    }

    /**
     * Finance Approvers Page
     *
     * @return void
     */
    public function finance_approvers() {
        include WPERP_COMPANY_VIEWS . '/finance-approver-listing.php';
    }

    /**
     * Handles the employeeview page
     *
     * @return void
     */
    public function employeeview_page() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'view';
        // $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
        echo $id = isset($_POST['employee_id']);
        switch ($action) {
            case 'view':
                $employeeview = new Employeeview($id);
                /* if ( !$id ) {
                  wp_die( __( 'Employee not found!', 'erp' ) );
                  } */
                $template = WPERP_COMPANY_VIEWS . '/company/employeeview.php';
                break;

            default:
                $template = WPERP_COMPANY_VIEWS . '/employeeview.php';
                break;
        }

        $template = apply_filters('erp_hr_company_templates', $template, $action, $id);

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Workflow Page
     *
     * @return void
     */
    public function company_workflow() {
        include WPERP_COMPANY_VIEWS . '/workflow.php';
    }

}
