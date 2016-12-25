<?php

namespace WeDevs\ERP\Company;

use WeDevs\ERP\Framework\Traits\Hooker;

/**
 * The HRM Class
 *
 * This is loaded in `init` action hook
 */
class Company {

    use Hooker;

    private $plugin;

    /**
     * Kick-in the class
     *
     * @param \WeDevs_ERP $plugin
     */
    public function __construct(\WeDevs_ERP $plugin) {

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

        do_action('erp_hrm_loaded');
    }

    /**
     * Define the plugin constants
     *
     * @return void
     */
    private function define_constants() {
        define('WPERP_COMPANY_FILE', __FILE__);
        define('WPERP_COMPANY_PATH', dirname(__FILE__));
        define('WPERP_COMPANY_VIEWS', dirname(__FILE__) . '/views');
        define('WPERP_COMPANY_JS_TMPL', WPERP_COMPANY_VIEWS . '/js-templates');
        define('WPERP_COMPANY_ASSETS', plugins_url('/assets', __FILE__));
        define('WPERP_COMPANY_DOWNLOADS', plugins_url());
        define('COMPANY_UPLOADS', WPERP_COMPANY_PATH . '\upload');
    }

    /**
     * Include the required files
     *
     * @return void
     */
    private function includes() {
        require_once WPERP_COMPANY_PATH . '/includes/actions-filters.php';
        require_once WPERP_COMPANY_PATH . '/includes/PHPExcel.php';
        require_once WPERP_COMPANY_PATH . '/includes/PHPExcel/Writer/Excel2007.php';
        require_once WPERP_COMPANY_PATH . '/includes/functions-import-export.php';
        require_once WPERP_COMPANY_PATH . '/includes/layout-functions.php';
        require_once WPERP_COMPANY_PATH . '/includes/functions-employee.php';
        require_once WPERP_COMPANY_PATH . '/includes/function_expenses.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-mileage.php';
        require_once WPERP_COMPANY_PATH . '/includes/functions-traveldesk.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-grades.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-designation.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-departments.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-projectcode.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-costcenter.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-gradelimits.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-reportsgraphs.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-gradelimitscat.php';
        require_once WPERP_COMPANY_PATH . '/includes/function-subcategory.php';
        
//        require_once WPERP_COMPANY_PATH . '/includes/layout-functions.php';
//        require_once WPERP_COMPANY_PATH . '/includes/functions-employee.php';
//        require_once WPERP_COMPANY_PATH . '/includes/functions-leave.php';
//        require_once WPERP_COMPANY_PATH . '/includes/functions-capabilities.php';
//        require_once WPERP_COMPANY_PATH . '/includes/functions-dashboard-widgets.php';
//        require_once WPERP_COMPANY_PATH . '/includes/functions-reporting.php';
//        require_once WPERP_COMPANY_PATH . '/includes/actions-filters.php';
    }

    /**
     * Initialize WordPress action hooks
     *
     * @return void
     */
    private function init_actions() {
        $this->action('admin_enqueue_scripts', 'admin_scripts');
        $this->action('admin_footer', 'admin_js_templates');
    }

    /**
     * Initialize WordPress filter hooks
     *
     * @return void
     */
    private function init_filters() {
        add_filter('erp_settings_pages', array($this, 'add_settings_page'));
    }

    /**
     * Init classes
     *
     * @return void
     */
    private function init_classes() {
        new Ajax_Handler();
        new Form_Handler();
        new Announcement();
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
    public function add_settings_page($settings = []) {

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
    public function admin_scripts($hook) {
        // var_dump( $hook );

        $suffix = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '';

        wp_enqueue_media();
        wp_enqueue_script('erp-tiptip');

        if ('hr-management_page_erp-hr-employee' == $hook) {
            wp_enqueue_style('erp-sweetalert');
            wp_enqueue_script('erp-sweetalert');
        }

        wp_enqueue_script('wp-erp-company', WPERP_COMPANY_ASSETS . "/js/companyadmin$suffix.js", array('erp-script'), date('Ymd'), true);

        $localize_script = apply_filters('erp_hr_localize_script', array(
            'nonce' => wp_create_nonce('wp-erp-hr-nonce'),
            'popup' => array(
                'gradelimits_edit' => __('Grade Limits For', 'erp'),
                'mileage_title' => __('Add Mileage Details', 'erp'),
                'mileage_submit' => __('Submit', 'erp'),
                'mileage_edit' => __('Edit Mileage Details', 'erp'),
                'gardes_title' => __('Add Grades Details', 'erp'),
                'gardes_submit' => __('Submit', 'erp'),
                'gardes_edit' => __('Edit Grades Details', 'erp'),
                'designation_title' => __('Add Designation Details', 'erp'),
                'designation_submit' => __('Submit', 'erp'),
                'designation_edit' => __('Edit Designation Details', 'erp'),
                'departments_title' => __('Add Departments Details', 'erp'),
                'departments_submit' => __('Submit', 'erp'),
                'departments_edit' => __('Edit Departments Details', 'erp'),
                'update' => __('Update', 'erp'),
                'traveldesk_title' => __('Add Travel Desk Details', 'erp'),
                'traveldesk_submit' => __('Submit', 'erp'),
                'traveldesk_edit' => __('Edit Travel Desk Details', 'erp'),
                'costcenter_title' => __('Add Projectcode Details', 'erp'),
                'costcenter_submit' => __('Submit', 'erp'),
                'costcenter_edit' => __('Edit Projectcode Details', 'erp'),
                'projectcode_title' => __('Add Projectcode Details', 'erp'),
                'projectcode_submit' => __('Submit', 'erp'),
                'projectcode_edit' => __('Edit Projectcode Details', 'erp'),
                'companyemployee_title' => __('New Employee', 'erp'),
                'companyemployee_update' => __('Update Employee', 'erp'),
                'dept_title' => __('New Department', 'erp'),
                'dept_submit' => __('Create Department', 'erp'),
                'location_title' => __('New Location', 'erp'),
                'location_submit' => __('Create Location', 'erp'),
                'dept_update' => __('Update Department', 'erp'),
                'desig_title' => __('New Designation', 'erp'),
                'desig_submit' => __('Create Designation', 'erp'),
                'desig_update' => __('Update Designation', 'erp'),
                'employee_title' => __('New Employee', 'erp'),
                'company_title' => __('New Company', 'corptne'),
                'employee_create' => __('Create Company', 'erp'),
                'employee_update' => __('Update Company', 'erp'),
                'employment_status' => __('Employment Status', 'erp'),
                'update_status' => __('Update', 'erp'),
                'policy' => __('Leave Policy', 'erp'),
                'policy_create' => __('Create Policy', 'erp'),
                'holiday' => __('Holiday', 'erp'),
                'holiday_create' => __('Create Holiday', 'erp'),
                'holiday_update' => __('Update Holiday', 'erp'),
                'new_leave_req' => __('Leave Request', 'erp'),
                'take_leave' => __('Send Leve Request', 'erp'),
                'terminate' => __('Terminate', 'erp'),
                'leave_reject' => __('Reject Reason', 'erp'),
                'already_terminate' => __('Sorry, this employee is already terminated', 'erp'),
                'already_active' => __('Sorry, this employee is already active', 'erp')
            ),
            'emp_upload_photo' => __('Upload Employee Photo', 'erp'),
            'emp_set_photo' => __('Set Photo', 'erp'),
            'confirm' => __('Are you sure?', 'erp'),
            'delConfirmDept' => __('Are you sure to delete this department?', 'erp'),
            'delConfirmPolicy' => __('Are you sure to delete this policy?', 'erp'),
            'delConfirmHoliday' => __('Are you sure to delete this Holiday?', 'erp'),
            'delConfirmEmployee' => __('Are you sure to delete this employee?', 'erp'),
            'restoreConfirmEmployee' => __('Are you sure to restore this employee?', 'erp'),
            'delConfirmEmployeeNote' => __('Are you sure to delete this employee note?', 'erp'),
            'delConfirmEntitlement' => __('Are you sure to delete this Entitlement? If yes, then all leave request under this entitlement also permanently deleted', 'erp'),
            'make_employee_text' => __('This user already exists, Do you want to make this user as a employee?', 'erp'),
            'employee_exit' => __('This employee already exists', 'erp'),
            'employee_created' => __('Employee successfully created', 'erp'),
            'create_employee_text' => __('Click to create employee', 'erp'),
            'empty_entitlement_text' => sprintf('<span>%s <a href="%s" title="%s">%s</a></span>', __('Please create entitlement first', 'erp'), add_query_arg(['page' => 'erp-leave-assign', 'tab' => 'assignment'], admin_url('admin.php')), __('Create Entitlement', 'erp'), __('Create Entitlement', 'erp')),
        ));

        //Mileage Page
        //string(30) "expense-managment_page_Mileage"

        if ('expense-managment_page_Mileage' == $hook) {
            wp_enqueue_script('post');
            $mileage = new Mileage();
            $localize_script['mileage_empty'] = $mileage->mileage_array();
        }
        if ('expense-managment_page_addcat' == $hook) {
            wp_enqueue_script('post');
            $subcategory = new SubCategory();
            $localize_script['subcategory_empty'] = $subcategory->subcategory_array();
        }
        if ('employee-management_page_Grades' == $hook) {
            wp_enqueue_script('post');
            $grades = new Grades();
            // var_dump($grades);
            $localize_script['grades_empty'] = $grades->grades_array();
        }
        if ('employee-management_page_Des' == $hook) {
            //echo"dbj";
            wp_enqueue_script('post');
            $designation = new Designation();
            $localize_script['designation_empty'] = $designation->designation_array();
        }
        if ('employee-management_page_Dep' == $hook) {
            wp_enqueue_script('post');
            $departments = new Departments();
            $localize_script['departments_empty'] = $departments->departments_array();
        }
        if ('toplevel_page_Travel' == $hook) {
            wp_enqueue_script('post');
            $traveldesk = new TravelDesk();
            $localize_script['traveldesk_empty'] = $traveldesk->to_array();
        }
        if ('toplevel_page_Budget' == $hook) {
            wp_enqueue_script('post');
            $projectcode = new Projectcode();
            $localize_script['projectcode_empty'] = $projectcode->projectcode_array();
        }
        if ('budget-control_page_Center' == $hook) {
            //var_dump('inside');
            wp_enqueue_script('post');
            $costcenter = new CostCenter();
            $localize_script['costcenter_empty'] = $costcenter->costcenter_array();
        }
//        if ('managment_page_gradeslimits' == $hook) {
//            var_dump('inside');
//            wp_enqueue_script('post');
//            $gradelimits = new GradeLimits();
//            $localize_script['gradelimits_empty'] = $gradelimits->gradelimits_array();
//        }
        // if its an employee page
        if ('toplevel_page_menu' == $hook) {
            wp_enqueue_script('post');

            $employeelist = new Employeelist();
            $localize_script['companyemployee_empty'] = $employeelist->to_array();
        }
        wp_localize_script('wp-erp-company', 'wpErpCompany', $localize_script);

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('erp-select2');
        wp_enqueue_style('erp-tiptip');
        wp_enqueue_style('erp-style');

        if ('hr-management_page_erp-hr-reporting' == $hook) {
            wp_enqueue_script('erp-flotchart');
            wp_enqueue_script('erp-flotchart-time');
            wp_enqueue_script('erp-flotchart-pie');
            wp_enqueue_script('erp-flotchart-orerbars');
            wp_enqueue_script('erp-flotchart-axislables');
            wp_enqueue_script('erp-flotchart-valuelabel');
            wp_enqueue_style('erp-flotchart-valuelabel-css');
        }
    }

    /**
     * Print JS templates in footer
     *
     * @return void
     */
    public function admin_js_templates() {
        global $current_screen;

        //var_dump($current_screen->base);
        switch ($current_screen->base) {
            case 'expense-managment_page_addcat':
                //var_dump('inside');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/add-sub-category.php', 'add-sub-category');
                
            case 'expense-managment_page_Mileage':
                //var_dump('inside');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/mileage-create.php', 'mileage-create');
            case 'employee-management_page_Grades':
                //var_dump('inside');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/grades-create.php', 'grades-create');
            case 'employee-management_page_Des':
                //var_dump('inside');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/designation-create.php', 'designation-create');
            case 'employee-management_page_Dep':
                //var_dump('inside');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/department-create.php', 'department-create');

            case 'toplevel_page_Travel':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/traveldesk-create.php', 'traveldesk-create');

            case 'toplevel_page_Budget':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/project-create.php', 'project-create');

            case 'expense-managment_page_gradelimitcat':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/grade-cat-limits.php', 'grade-cat-limits');
            case 'expense-managment_page_gradelimitcat':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/accomdation-grade-limits.php', 'accomdation-grade-limits');
            case 'expense-managment_page_gradelimitcat':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/grade-cat-limits.php', 'grade-cat-limits');
            case 'expense-managment_page_gradelimitcat':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/General-cat-limits.php', 'General-cat-limits');
            case 'expense-managment_page_gradelimitcat':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/grade-cat-limits.php', 'grade-cat-limits');
            case 'expense-managment_page_gradelimitcat':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/other-catl-imits.php', 'other-catl-imits');

            case 'budget-control_page_Center':
                //var_dump('inside');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/costcenter-create.php', 'costcenter-create');

            case 'companies_page_companies-admin':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/companyadmin-create.php', 'companyadmin-create');
                break;
            case 'toplevel_page_menu':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/companyemployee-create.php', 'companyemployee-create');
                break;
            case 'management_page_Profile':
                //erp_get_js_template( WPERP_COMPANY_JS_TMPL . '/companyemployee-view.php', 'companyemployee-view' );
                break;

            case 'toplevel_page_companiesmenu':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-employee.php', 'erp-new-employee');
                break;
            case 'companies_page_mastercompaniesview':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-employee.php', 'erp-new-employee');
                break;

            case 'toplevel_page_superadmin-dashboard':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-employee.php', 'erp-new-employee');
                break;

            case 'toplevel_page_erp-hr':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-leave-request.php', 'erp-new-leave-req');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/leave-days.php', 'erp-leave-days');
                break;

            case 'hr-management_page_erp-hr-depts':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-dept.php', 'erp-new-dept');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/row-dept.php', 'erp-dept-row');
                break;

            case 'hr-management_page_erp-hr-designation':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-designation.php', 'erp-new-desig');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/row-desig.php', 'erp-desig-row');
                break;

            case 'hr-management_page_erp-hr-employee':
            case 'hr-management_page_erp-hr-my-profile':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-employee.php', 'erp-new-employee');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/row-employee.php', 'erp-employee-row');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/employment-status.php', 'erp-employment-status');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/compensation.php', 'erp-employment-compensation');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/job-info.php', 'erp-employment-jobinfo');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/work-experience.php', 'erp-employment-work-experience');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/education-form.php', 'erp-employment-education');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/performance-reviews.php', 'erp-employment-performance-reviews');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/performance-comments.php', 'erp-employment-performance-comments');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/performance-goals.php', 'erp-employment-performance-goals');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/dependents.php', 'erp-employment-dependent');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-dept.php', 'erp-new-dept');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/new-designation.php', 'erp-new-desig');
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/employee-terminate.php', 'erp-employment-terminate');
                break;

            case 'leave_page_erp-leave-policies':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/leave-policy.php', 'erp-leave-policy');
                break;

            case 'leave_page_erp-holiday-assign':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/holiday.php', 'erp-hr-holiday-js-tmp');
                break;

            case 'toplevel_page_erp-leave':
                erp_get_js_template(WPERP_COMPANY_JS_TMPL . '/leave-reject.php', 'erp-hr-leave-reject-js-tmp');
                break;
            default:
                # code...
                break;
        }
    }

}
