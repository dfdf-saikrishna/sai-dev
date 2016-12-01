<?php
/*
Plugin Name: Corptne
Description: A Plugin For Corptne
Author: Sai Krishna 
Version: 0.1
*/
define( 'CORPTNE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'admin_init','css_and_js');
add_action('wp_login', 'custom_login');
add_action('admin_menu', 'corptne');
add_action( 'admin_menu', 'custom_menu_page_removing' );
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
add_action('login_head', 'my_loginlogo');
add_filter('login_headertitle', 'my_loginURLtext');
add_action('admin_head','favicon');
add_action( 'login_head', 'hide_login_nav' );
add_action('admin_head', 'hid_wordpress_thankyou');
/**
 * change wp-admin favicon
 */
function favicon(){
echo '<link rel="shortcut icon" href="',plugins_url(),'/corptne/assets/images/favicon.ico" />',"\n";
}
/**
 * remove Back to site link in wp-login
 */
function hide_login_nav()
{
    ?><style>#backtoblog{display:none}</style><?php
}
/**
 * remove annoying footer thankyou from wordpress
 */
function hid_wordpress_thankyou() {
  echo '<style type="text/css">#wpfooter {display:none;}</style>';
}
/**
 * custom wp-admin logo
 */
function my_loginlogo() {
  echo '<style type="text/css">
    h1 a {
      background-image: url(' . plugins_url() . '/corptne/assets/images/logo_small.png) !important;
      background-size: 200px !important;
      width: 100% !important;
    }
  </style>';
}
/**
 * custom wp-admin logo hover text
 */
function my_loginURLtext() {
    return 'Corptne';
}
/**
 * remove un-necessary menus
 */
function custom_menu_page_removing($user) {
    if ( current_user_can( 'employee' ) || current_user_can( 'travelagentclient' ) || current_user_can( 'traveldesk' ) || current_user_can( 'superadmin' ) || current_user_can( 'companyadmin' ) || current_user_can( 'travelagent' ) || current_user_can( 'masteradmin' ) || current_user_can( 'travelagentuser' )) {
            remove_menu_page( 'index.php' );
    }
}
/**
 * Redirect to specific Dashboard page on login
 */
function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		}
                else if ( in_array( 'finance', $user->roles ) ) {
			return "/wp-admin/admin.php?page=finance-dashboard";
		}
                else if ( in_array( 'employee', $user->roles ) ) {
			return "/wp-admin/admin.php?page=employee";
		}
                else if ( in_array( 'travelagentclient', $user->roles ) ) {
			return "/wp-admin/admin.php?page=travelagentclient-dashboard";
		}
                else if ( in_array( 'traveldesk', $user->roles ) ) {
			return "/wp-admin/admin.php?page=traveldesk-dashboard";
		}
                else if ( in_array( 'superadmin', $user->roles ) ) {
			return "/wp-admin/admin.php?page=superadmin-dashboard";
		}
                else if ( in_array( 'companyadmin', $user->roles ) ) {
			return "/wp-admin/admin.php?page=company-dashboard";
		}
                else if ( in_array( 'travelagent', $user->roles ) ) {
			return "/wp-admin/admin.php?page=travelagent-dashboard";
		}
                else if ( in_array( 'masteradmin', $user->roles ) ) {
			return "/wp-admin/admin.php?page=master-dashboard";
		}
                else if ( in_array( 'travelagentuser', $user->roles ) ) {
			return "/wp-admin/admin.php?page=travelagent-user-dashboard";
		}
	} else {
		return $redirect_to;
	}
}

/**
 * Load custom css for wp-admin
 */
function css_and_js() {
	//wp_register_style( 'bootstrap', plugins_url( 'corptne/assets/css/bootstrap/bootstrap.min.css' ));
        wp_register_style( 'corptne', plugins_url( 'corptne/assets/css/admin.css' ));
	//wp_enqueue_style('bootstrap');
        wp_enqueue_style('corptne');
}
/**
 * Function for All plugin menus
 */
function corptne(){
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

//    add_menu_page('Settings', 'Settings', 'employee', 'Settings', 'setting','dashicons-admin-generic');
//    add_submenu_page('Settings', 'Change Password', 'Change Password', 'employee','Change Password'.'/Change Password', 'setting');
//    add_submenu_page('Settings', 'Always Left menu', 'Always Left menu', 'employee','Always Left menu'.'/Always Left menu', 'setting');
//    add_submenu_page('Settings', 'Show & Hide Left menu', 'Show & Hide Left menu', 'employee','Show & Hide Left menu'.'/Show & Hide Left menu', 'setting');
    add_menu_page('Download Company Expense Policy', 'Download Company Expense Policy', 'employee', 'Download Company Expense Policy', 'setting','dashicons-arrow-down-alt');
    }

     /* *********************************
     * 
     * Company Admin
     * 
     *  **********************************/
    else if ( current_user_can( 'companyadmin' ) ) {
    add_menu_page('Company Dashboard', 'Company Dashboard', 'companyadmin','company-dashboard', 'companyDashboard','dashicons-dashboard');
    
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
   
    add_menu_page('Finance Approvers', 'Finance Approvers', 'companyadmin', 'finance', 'finance','dashicons-money');
    add_submenu_page('finance', 'action', 'View/Edit/Delete employee', 'companyadmin', 'finaceEmp', 'finance');
    add_submenu_page('finance', 'Limits', 'Define Approval Limits(set/Edit Limits)', 'companyadmin', 'Limits', 'finance');
    
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
    /** Master Admin **/
    else if ( current_user_can( 'masteradmin' ) ) {
    add_menu_page('Master Dashboard', 'Master Dashboard', 'masteradmin', 'master-dashboard', 'masterDashboard','dashicons-admin-users');
		  
    add_menu_page('Companies', 'Companies', 'masteradmin', 'Companies', 'Companies','dashicons-admin-users');

    add_submenu_page('Companies', 'Create Request', 'Create Request', 'masteradmin','Create Request'.'/ Create Request', 'Create Request');
    add_submenu_page('Companies', 'View / Edit Request', 'View / Edit Request', 'masteradmin','View / Edit Request'.'/ View / Edit Request', 'View / Edit Request');
    add_submenu_page('Companies', 'Company Admins', 'Company Admins', 'masteradmin','Company Admins'.'/ Company Admins', 'Company Admins');

    add_menu_page('Workflow', 'Workflow', 'masteradmin', 'Workflow', ' Workflow','dashicons-tickets');
          
         add_submenu_page('Workflow', 'Add / Edit / Delete Request', 'Add / Edit / Delete Request', 'masteradmin','Add / Edit / Delete Request'.'Add / Edit / Delete Request', 'Add / Edit / Delete Request');

    add_menu_page('Reports & Charts', 'Reports & Charts', 'masteradmin', ' Reports & Charts', 'Reports & Charts','dashicons-migrate');
          add_submenu_page('Reports & Charts', 'Chart 1', 'Chart 1', 'masteradmin','Chart 1'.'/ Chart 1', 'Chart 1');
          add_submenu_page('Reports & Charts', 'Chart 2', 'Chart 2', 'masteradmin','Chart 2'.'/ Chart 2', 'Chart 2');
          add_submenu_page('Reports & Charts', 'Chart 3', 'Chart 3', 'masteradmin','Chart 3'.'/ Chart 3', 'Chart 3');
          add_submenu_page('Reports & Charts', 'Chart 4', 'Chart 4', 'masteradmin','Chart 4'.'/ Chart 4', 'Chart 4');
		  
    add_menu_page('Expense Category', 'Expense Category', 'masteradmin', 'Expense Category', 'Expense Category','dashicons-media-spreadsheet');
          add_submenu_page('Expense Category', 'Default Expense Request', 'Default Expense Request', 'masteradmin','Default Expense Request'.'/ Default Expense Request', 'Default Expense Request');
          add_submenu_page('Expense Category', 'Company Expense Request', 'Company Expense Request', 'masteradmin','Company Expense Request'.'/ Company Expense Request', 'Company Expense Request');

    add_menu_page('Help Docs', 'Help Docs', 'masteradmin', 'Help Docs', 'Help Docs','dashicons-admin-generic');
        add_submenu_page('Help Docs', 'Create Request', 'Create Request', 'masteradmin','Create Request'.'/ Create Request', 'Create Request');
        add_submenu_page('Help Docs', 'View / Edit Request', 'View / Edit Request', 'masteradmin','View / Edit Request'.'/ View / Edit Request', 'View / Edit Request');


    add_menu_page('Settings', 'Settings', 'masteradmin', 'Settings', 'settings','dashicons-admin-generic');
          add_submenu_page('Settings', 'Change Password Request', 'Change Password Request', 'masteradmin','Change Password Request'.'/ Change Password Request', 'Change Password Request');
          add_submenu_page('Settings', 'Hide User Panel Request', 'Hide User Panel Request', 'masteradmin','Hide User Panel Request'.'/ Hide User Panel Request', 'Hide User Panel Request');
          add_submenu_page('Settings', 'Show & Hide Request', 'Show & Hide Request', 'masteradmin', 'Show & Hide Request','Show & Hide Request'.'/ Show & Hide Request', 'Show & Hide Request');
          add_submenu_page('Settings', 'Top Menu Request', 'Top Menu Request', 'masteradmin','Top Menu Request'.'/ Top Menu Request', 'Top Menu Request');
		  add_submenu_page('Settings', 'Footer Show Request', 'Footer Show Request', 'masteradmin','Footer Show Request'.'/ Footer Show Request', 'Footer Show Request');
          add_submenu_page('Settings', 'Footer With Menu Request', 'Footer With Menu Request', 'masteradmin','Footer With Menu Request'.'/ Footer With Menu Request', 'Footer With Menu Request');
    }      
    /*admin traveldesk*/
    else if ( current_user_can( 'traveldesk' ) ) {
    add_menu_page('Dashboard', 'Travel Desk Dashboard', 'traveldesk', 'traveldesk-dashboard', 'traveldeskDashboard','dashicons-admin-users');
		  
    add_menu_page('Request Without Approval', 'Request Without Approval', 'traveldesk', 'Request Without Approval', 'Request Without Approval','dashicons-admin-users');
		  
        add_submenu_page('Request Without Approval', 'Create Request', 'Create Request', 'traveldesk','Create Request'.'/ Create Request', 'Create Request');
        add_submenu_page('Request Without Approval', 'View / Edit Request', 'View / Edit Request', 'traveldesk','View / Edit Request'.'/ View / Edit Request', 'View / Edit Request');
 


    add_menu_page('Request With Approval', 'Request With Approval', 'traveldesk', 'Request With Approval', ' Request With Approval','dashicons-tickets');
        add_submenu_page('Request With Approval', 'Create Request', 'Create Request', 'traveldesk','Create Request'.'/ Create Request', 'Create Request');
        add_submenu_page('Request With Approval', 'View / Edit Request', 'View / Edit Request', 'traveldesk','View / Edit Request'.'/ View / Edit Request', 'View / Edit Request');

    add_menu_page('Group Request', 'Group Request', 'traveldesk', ' Group Request', 'Group Request','dashicons-migrate');
        add_submenu_page('Group Request', 'Create Request', 'Create Request', 'traveldesk','Create Request'.'/ Create Request', 'Create Request');
        add_submenu_page('Group Request', 'View / Edit Request', 'View / Edit Request', 'traveldesk','View / Edit Request'.'/ View / Edit Request', 'View / Edit Request');


    add_menu_page('claims', 'claims', 'traveldesk', 'claims', 'claims','dashicons-media-spreadsheet');
        add_submenu_page('claims', 'View Invoices', 'View Invoices', 'traveldesk','View Invoices'.'/ View Invoices', 'View Invoices');
        add_submenu_page('claims', 'Bank Details', 'Bank Details', 'traveldesk','Bank Details'.'/ Bank Details', 'Bank Details');
        //add_menu_page('Download Company Expense Policy', 'Download Company Expense Policy', 'traveldesk', 'Download Company Expense Policy', 'setting');
    }
    /* *********************************
     * 
     * Travel Agent Employee/User
     * 
     *  **********************************/
    else if ( current_user_can( 'travelagentuser' ) ) {
    add_menu_page('User Dashboard', 'User DashBoard', 'travelagentuser', 'travelagent-user-dashboard', 'UserDashboard');
    add_menu_page('Clients', 'Clients', 'travelagentuser','clients', 'Clients','dashicons-groups');
     add_submenu_page('view', 'viewClients', 'View Clients', 'travelagentuser', 'viewClients', 'clients');
    }
   
    /* *********************************
     * 
     * Travel Agent Admin
     * 
     *  **********************************/
    else if ( current_user_can( 'travelagent' ) ) {
    add_menu_page('agent Dashboard', 'Travelagent DashBoard', 'travelagent', 'travelagent-dashboard', 'travelagentDashboard','dashicons-dashboard');
    
    add_menu_page('User', 'User Management', 'travelagent','UserM', 'UserManagement','dashicons-admin-users');
        add_submenu_page('UserM', 'Add', 'Add User', 'travelagent', 'Add', 'UserManagement');
        add_submenu_page('UserM', 'UserActions', 'View /Edit/Delete user', 'travelagent', 'UserActions', 'UserManagement');
        
   add_menu_page('Client', 'Client Management', 'travelagent','client', 'ClientManagement','dashicons-admin-users');
        add_submenu_page('Client', 'Add', 'Add Client', 'travelagent', 'ClientM', 'ClientManagement');
        add_submenu_page('ClientM', 'ClientMActions', 'View /Edit Client', 'travelagent', 'ClientActions', 'ClientManagement');
        add_submenu_page('ClientM', 'ClientAlloc', 'Client Allocations', 'travelagent', 'ClientAllocations', 'ClientManagement');
        
    add_menu_page('InvoiceM', 'Invoice Management', 'travelagent','InvoiceM', 'InvoiceManagement','dashicons-id-alt');
        add_submenu_page('InvoiceM', 'Create', 'Create Invoice', 'travelagent', 'AddInvoice', 'InvoiceManagement');
        add_submenu_page('InvoiceM', 'ViewInv', 'View Invoice ', 'travelagent', 'ViewInvoice', 'InvoiceManagement');
        
    add_menu_page('BankM', 'Bank Management', 'travelagent','BankM', 'BankrManagement','dashicons-money');
        add_submenu_page('BankM', 'Bank', 'Add Bank Details', 'travelagent', 'BankAdd', 'BankrManagement');
        add_submenu_page('BankM', 'BankActions', 'View /Edit Bank Details', 'travelagent', 'BankActions', 'BankrManagement');
    add_menu_page('Settings', 'Settings', 'travelagent', 'Settings', 'setting','dashicons-admin-generic');
        add_submenu_page('Settings', 'Change Password', 'Change Password', 'travelagent','Change Password'.'/Change Password', 'setting');
        add_submenu_page('Settings', 'Always Left menu', 'Always Left menu', 'travelagent','Always Left menu'.'/Always Left menu', 'setting');
        add_submenu_page('Settings', 'Show & Hide Left menu', 'Show & Hide Left menu', 'travelagent','Show & Hide Left menu'.'/Show & Hide Left menu', 'setting');
    //add_menu_page('super admin Dashboard', 'Super Admin Dashboard', 'travelagent', 'super', 'superadmin');
    }
      
    /* *********************************
     * Super Admin Dashboard
     *  **********************************/
     if ( current_user_can( 'superadmin' ) ) {
    add_menu_page('SuperAdmin Dashboard', 'SuperAdmin Dashboard', 'superadmin', 'superadmin-dashboard', 'superadminDashboard','dashicons-welcome-view-site' );
	
	add_menu_page( 'Master Admin Menu', 'Master Admin', 'superadmin', 'masteradminmenu', 'masteradminmenu_init','dashicons-building' );
	add_submenu_page( 'masteradminmenu', 'Add Master Admin', 'Add Master Admin', 'superadmin', 'masteradminadd', 'masteradminadd');
	add_submenu_page( 'masteradminmenu', 'View / Edit / Delete Master Admin', 'View / Edit / Delete Master Admin', 'superadmin', 'ViewEditDeleteMasterAdmin', 'ViewEditDeleteMasterAdmin');
	
	add_menu_page( 'Companies Menu', 'Companies', 'superadmin', 'companiesmenu', 'companies_init','dashicons-building' );
	add_submenu_page( 'companiesmenu', 'Create Company', 'Create Company', 'superadmin', 'mastercompaniesnew', 'mastercompaniesnew');
	add_submenu_page( 'companiesmenu', 'View / Edit Company', 'View / Edit Company', 'superadmin', 'mastercompanieslisting', 'mastercompanieslisting');
	add_submenu_page( 'companiesmenu', 'Company Admins', 'Company Admins', 'superadmin', 'mastercompaniesadmin', 'mastercompaniesadmin');
	
	add_menu_page( 'Travelagents Menu', 'Travel Agents', 'superadmin', 'travelagentsmenu', 'travelagentsmenu_init' );
	add_submenu_page( 'travelagentsmenu', 'Add Travel Agents', 'Add Travel Agents', 'superadmin', 'superadmintravelagentsadd', 'superadmintravelagentsadd');
	add_submenu_page( 'travelagentsmenu', 'View / Edit / Delete Travel Agents ', 'View / Edit / Delete Travel Agents ', 'superadmin', 'superadmintravelagentsview', 'superadmintravelagentsview');
	add_submenu_page( 'travelagentsmenu', 'Travel Desk Logs', 'Travel Desk Logs', 'superadmin', 'superadmintravelagentslogs', 'superadmintravelagentslogs');
	
	add_menu_page( 'workflow Menu', 'Workflow', 'superadmin', 'workflowsmenu', 'workflowsmenu_init','dashicons-products' );
	add_submenu_page( 'workflowsmenu', 'Add / Edit / Delete Workflow', 'Add / Edit / Delete Workflow', 'superadmin', 'mastercompaniesworkflow', 'mastercompaniesworkflow');
	
	add_menu_page( 'reportscharts Menu', 'Reports & Charts', 'superadmin', 'reportschartsmenu', 'reportschartsmenu_init','dashicons-chart-bar');
	add_submenu_page( 'reportschartsmenu', 'Chart 1', 'Chart 1', 'superadmin', '', '');
	add_submenu_page( 'reportschartsmenu', 'Chart 2', 'Chart 2', 'superadmin', '', '');
	add_submenu_page( 'reportschartsmenu', 'Chart 3', 'Chart 3', 'superadmin', '', '');
	add_submenu_page( 'reportschartsmenu', 'Chart 4', 'Chart 4', 'superadmin', '', '');
	
	add_menu_page( 'Expense Category Menu', 'Expense Category', 'superadmin', 'expensecategorymenu', 'expensecategorymenu_init' );
	add_submenu_page( 'expensecategorymenu', 'Default Expense Category', 'Default Expense Category', 'superadmin', 'masterexpensecategory', 'masterexpensecategory');
	add_submenu_page( 'expensecategorymenu', 'Company Expense Category', 'Company Expense Category', 'superadmin', 'mastercompanyexpcat', 'mastercompanyexpcat'); 
	
	add_menu_page( 'Help Docs Menu', 'Help Docs', 'superadmin', 'helpdocsmenu', 'helpdocsmenu_init' );
	add_submenu_page( 'helpdocsmenu', 'Create Topic', 'Create Topic', 'superadmin', '', '');
	add_submenu_page( 'helpdocsmenu', 'View /Edit Topic', 'View /Edit Topic', 'superadmin', '', ''); 
	
	add_menu_page( 'Settings Menu', 'Settings', 'superadmin', 'settingsmenu', 'settingsmenu_init','dashicons-editor-ul');
	add_submenu_page( 'settingsmenu', 'Change Password', 'Change Password', 'superadmin', 'masterchangepassword', 'masterchangepassword');
	add_submenu_page( 'settingsmenu', 'Hide User Panel', 'Hide User Panel', 'superadmin', '', ''); 
	add_submenu_page( 'settingsmenu', 'Show & Hide', 'Show & Hide', 'superadmin', '', '');  
	add_submenu_page( 'settingsmenu', 'Top Menu', 'Top Menu', 'superadmin', '', ''); 
	add_submenu_page( 'settingsmenu', 'Footer Show', 'Footer Show', 'superadmin', '', ''); 
	add_submenu_page( 'settingsmenu', 'Footer with menu', 'Footer with menu', 'superadmin', '', ''); 
      }
		
    /* *********************************
     * Travel Agent Client
    * **********************************/
    if ( current_user_can( 'travelagentclient' ) ) {
    add_menu_page('DashboardTA', 'Travel Agent Dashboard', 'travelagentclient', 'travelagent-dashboard', 'ncorptnetraveldesk_init','dashicons-welcome-view-site' );
    
	/* *********************************
     * Booking Request Menu
     *  **********************************/
	add_menu_page( 'Booking Request Menu', 'Booking Request', 'travelagentclient', 'bookingrequestmenu', 'bookingrequestmenu_init','dashicons-welcome-write-blog' );
	add_submenu_page( 'bookingrequestmenu', 'Create Request', 'Create Request', 'travelagentclient', 'traveldeskrequestcreate', 'traveldeskrequestcreate');
	add_submenu_page( 'bookingrequestmenu', 'View / Edit Request', 'View / Edit Request', 'travelagentclient', 'traveldeskrequestlisting', 'traveldeskrequestlisting');
	
	/* *********************************
     * Group Request Menu
     *  **********************************/
	add_menu_page( 'Group Request Menu', 'Group Request', 'travelagentclient', 'grouprequestmenu', 'grouprequestmenu_init','dashicons-welcome-write-blog' );
	add_submenu_page( 'grouprequestmenu', 'Create Request', 'Create Request', 'travelagentclient', 'traveldeskgrouprequestadd', 'traveldeskgrouprequestadd');
	add_submenu_page( 'grouprequestmenu', 'View / Edit Request', 'View / Edit Request', 'travelagentclient', 'traveldeskgrouprequestlisting', 'traveldeskgrouprequestlisting');
	
	/* *********************************
     * Invoice Menu
     *  **********************************/
	add_menu_page( 'Invoice Menu', 'Invoice', 'travelagentclient', 'invoicemenu', 'invoicemenu_init','dashicons-welcome-write-blog');
	add_submenu_page( 'invoicemenu', 'View Invoices', 'View Invoices', 'travelagentclient', 'traveldeskclaims', 'traveldeskclaims');
	add_submenu_page( 'invoicemenu', 'Bank Details', 'Bank Details', 'travelagentclient', 'traveldeskbankdetails', 'traveldeskbankdetails');
	/* *********************************
     * Settings Menu
     *  **********************************/
	add_menu_page( 'Settings Menu', 'Settings', 'travelagentclient', 'nonsettingsmenu', 'nonsettingsmenu_init' );
	add_submenu_page( 'nonsettingsmenu', 'Change Password', 'Change Password', 'travelagentclient', 'traveldeskchangepassword', 'traveldeskchangepassword');
	add_submenu_page( 'nonsettingsmenu', 'Always Left menu', 'Always Left menu', 'travelagentclient', '', '');
	add_submenu_page( 'nonsettingsmenu', 'Show & Hide Left menu', 'Show & Hide Left menu', 'travelagentclient', '', '');
        
    }
    if ( current_user_can( 'employee' ) ) {
             
    add_menu_page('Employee Dashboard', 'Employee Dashboard', 'employee', 'employee', 'employeeDashboard','dashicons-admin-users');
     
    /* Finance Menu */
    if ( current_user_can( 'finance' ) ) {
    add_menu_page('financedashboard', 'Finance Dashboard', 'finance', 'finance-dashboard', 'financeDashboard','dashicons-admin-users');
    add_submenu_page('finanaceD','pre', 'PreTravel Expense Request', 'finance', 'PreT', 'PreTravelRequest','dashicons-money');
    add_submenu_page('finanaceD','PostTravel', 'Post Travel Expense Request', 'finance', 'PostTravel', 'PostTravelRequest','dashicons-money');
    add_submenu_page('finanaceD','General', 'General Expense Request', 'finance', 'General', 'GeneralExpenseRequest','dashicons-money');
    add_submenu_page('finanaceD','MileageExpense', 'Mileage Expense Request', 'finance', 'MileageExpense', 'MileageExpenseRequest','dashicons-money');
    add_submenu_page('finanaceD','UtilityExpense', 'Utility Expense Request', 'finance', 'UtilityExpense', 'UtilityExpenseRequest','dashicons-money');
    add_submenu_page('finanaceD','claims', 'TravelDesk Claims', 'finance', 'TDClaims', 'TravelDeskClaims','dashicons-location');
    add_menu_page('FinanceExpense', 'Expense', 'finance', 'FinanceExpense', 'FinanceExpense','dashicons-money');
            add_submenu_page('FinanceExpense', 'create', 'Create Expense', 'finance', 'create', 'FinanceExpense');
            add_submenu_page('FinanceExpense', 'view', 'View Expense', 'finance', 'view', 'FinanceExpense');
            add_submenu_page('FinanceExpense', 'General', 'View General Expense', 'finance', 'General', 'FinanceExpense');
            add_submenu_page('FinanceExpense', 'utility', 'View Utility Expense', 'finance', 'Utility', 'FinanceExpense');
    }
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

//    add_menu_page('Settings', 'Settings', 'employee', 'Settings', 'setting','dashicons-admin-generic');
//    add_submenu_page('Settings', 'Change Password', 'Change Password', 'employee','Change Password'.'/Change Password', 'setting');
//    add_submenu_page('Settings', 'Always Left menu', 'Always Left menu', 'employee','Always Left menu'.'/Always Left menu', 'setting');
//    add_submenu_page('Settings', 'Show & Hide Left menu', 'Show & Hide Left menu', 'employee','Show & Hide Left menu'.'/Show & Hide Left menu', 'setting');
    add_menu_page('Download Company Expense Policy', 'Download Company Expense Policy', 'employee', 'Download Company Expense Policy', 'setting','dashicons-arrow-down-alt');
        
       
       
    }    
}

function dashboard(){
	require_once "views/custom-dashboard.php";
}
/*
 * Employee Menu Functions 
 * 
 */
function employeeDashboard(){
    require_once "modules/employee/views/employee-dashboard.php";
}
function employement_details(){
	echo "<h1>Profile details</h1>";
	//require_once "Modules/employee/views/custom-dashboard.php";
}
function travel_expense(){
	echo "<h1>Travel Expense</h1>";
	//require_once "Modules/employee/views/custom-dashboard.php";
}

function general_expense(){
	echo "<h1>General Expense</h1>";
	//require_once "Modules/employee/views/custom-dashboard.php";
}

function reports(){
	echo "<h1>Reports</h1>";
	//require_once "Modules/employee/views/custom-dashboard.php";
}

function delegate(){
	echo "<h1>Create delegate</h1>";
	//require_once "views/custom-dashboard.php";
}

function setting(){
	echo "<h1>Edit information</h1>";
	//require_once "Modules/employee/views/custom-dashboard.php";
}

/*
 * Company Admin Menu Functions
 * 
 */
function companyDashboard(){
    require_once "modules/company/views/company-dashboard.php";
}

function employee() {
    require_once "modules/company/views/Employeemanagement.php";
}

function finance() {
    require_once "modules/company/views/financeapprover.php";
}

function expense() {
    require_once "modules/company/views/Expense.php";
}

function workflow() {
    require_once "modules/company/views/workflow.php";
}

function TravelDesk() {
    require_once "modules/company/views/TravelDesk.php";
}
function Requests() {
    require_once "modules/company/views/Requests.php";
}
function BudgetController() {
    require_once "modules/company/views/BudgetController.php";
}
function Settings() {
    require_once "modules/company/views/Settings.php";
}

/*
 * Travel Agent User
 * 
 */

function UserDashboard() {
    //require_once "modules/Travelagent/views/UserDashboard.php";
    echo "<h1>Travel Agent User Dashboard</h1>";
}

function Clients() {
    require_once "modules/Travelagent/Clientcompany/views/Clients.php";
}

/*
 * Travel Agent admin
 * 
 */
function travelagentDashboard() {
    require_once "modules/Travelagent/views/travel-agent-dashboard.php";
}
function UserManagement() {
    require_once "modules/Travelagent/admin/views/UserManagement.php";
}
function ClientManagement() {
    require_once "modules/Travelagent/admin/views/ClientManagement.php";
}
function InvoiceManagement() {
    require_once "modules/Travelagent/admin/views/InvoiceManagement.php";
}
function BankrManagement() {
    require_once "modules/Travelagent/admin/views/BankrManagement.php";
}

/*
 * Super Admin Functions
 * 
 */

function superadminDashboard(){
	require_once "modules/superadmin/views/super-admin-dashboard.php";
}
function companies_init(){
	require_once "modules/admin/views/master-companies-listing.php";
}
function mastercompaniesnew(){
	require_once "modules/admin/views/master-companies-new.php";
}
function mastercompanieslisting(){
				require_once "modules/admin/views/master-companies-listing.php";
}
function mastercompaniesadmin(){
				require_once "modules/admin/views/master-companies-admin.php";
}
function travelagentsmenu_init(){
	require_once "modules/admin/views/superadmin-travel-agents-view.php";
}
function superadmintravelagentsadd(){
				require_once "modules/admin/views/superadmin-travel-agents-add.php";
}
function superadmintravelagentsview(){
				require_once "modules/admin/views/superadmin-travel-agents-view.php";
}
function superadmintravelagentslogs(){
				require_once "modules/admin/views/superadmin-travel-agents-logs.php";
}
function expensecategorymenu_init(){
	require_once "modules/admin/views/master-expense-category.php";
}
function masterexpensecategory(){
				require_once "modules/admin/views/master-expense-category.php";
}
function mastercompanyexpcat(){
				require_once "modules/admin/views/master-company-exp-cat.php";
}
function helpdocsmenu_init(){
	echo "<h1>Help Docs</h1>";
}
function masteradminmenu_init(){
	require_once "modules/admin/views/super-admin-master-listing.php";
}
function masteradminadd(){
				require_once "modules/admin/views/super-admin-master-admin-add.php";
}
function ViewEditDeleteMasterAdmin(){
				require_once "modules/admin/views/super-admin-master-listing.php";
}
function reportschartsmenu_init(){
	echo "<h1>Reports & Charts</h1>";
	
}
function settingsmenu_init(){
	echo "<h1>Settings</h1>";
}
function masterchangepassword(){
	require_once "modules/admin/views/master-change-password.php";
}
function workflowsmenu_init(){
	require_once "modules/admin/views/master-companies-workflow.php";
}
function mastercompaniesworkflow(){
	require_once "modules/admin/views/master-companies-workflow.php";
}
/*
 * Finance Menu Functions
 * 
 */
function financeDashboard(){
    require_once "modules/finance/views/finance-dashboard.php";
}
function FinanceExpense() {
    require_once "modules/FinanceExpense.php";
}
function MileageExpenseRequest() {
    require_once "modules/MileageExpenseRequest.php";
}
function UtilityExpenseRequest() {
    require_once "modules/UtilityExpenseRequest.php";
}
function GeneralExpenseRequest() {
    require_once "modules/GeneralExpenseRequest.php";
}
function TravelDeskClaims() {
    require_once "modules/TravelDeskClaims.php";
}
function PostTravelRequest() {
    require_once "modules/PreTravelRequest.php";
}
function PreTravelRequest() {
    require_once "modules/PreTravelRequest.php";
}

/*
 * Travel Desk Dashboard
 * 
 */
function traveldeskDashboard(){
    require_once "modules/traveldesk/views/travel-desk-dashboard.php";
}

/*
 * Master Admin Functions
 * 
 */
function masterDashboard(){
    require_once "modules/master/views/master-dashboard.php";
}

/*
 * Non-corptne Travel Desk Functions
 * 
 */

function ncorptnetraveldesk_init(){
        //require_once "views/custom-dashboard.php";
	require_once "modules/travelagent/views/travel-agent-dashboard.php";
}
function bookingrequestmenu_init(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-request-listing.php";
}
function traveldeskrequestcreate(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-request-create.php";
}
function traveldeskrequestlisting(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-request-listing.php";
}

function grouprequestmenu_init(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-group-request-listing.php";
}
function traveldeskgrouprequestadd(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-group-request-add.php";
}
function traveldeskgrouprequestlisting(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-group-request-listing.php";
}
function invoicemenu_init(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-claims.php";
}
function traveldeskclaim(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-claims.php";
}
function traveldeskbankdetails(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-bank-details.php";
}
function nonsettingsmenu_init(){
	echo "<h1>Settings</h1>";
}
function traveldeskchangepassword(){
	require_once "modules/ncorptne-travel-desk/views/travel-desk-change-password.php";
}

function custom_login() {
    if ( ! empty($_POST['pwd']) &&  ! empty($_POST['log']))
	{
		$password = $_POST['pwd'];
		$login = $_POST['log'];
                //echo $login;die;
	}
}



?>