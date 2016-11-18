<?php
namespace WeDevs\ERP\Company;
/**
 * PART 2. Defining Custom Table List
 * ============================================================================
 *
 * In this part you are going to define custom table list class,
 * that will display your database records in nice looking table
 *
 * http://codex.wordpress.org/Class_Reference/WP_List_Table
 * http://wordpress.org/extend/plugins/custom-list-table-example/
 */

//if (!class_exists('WP_List_Table')) {
    //require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
//}

/**
 * Custom_Table_Example_List_Table class that will display our custom table
 * records in nice table
 */
class Finance_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'company',
            'plural' => 'companies',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name)
    {
//        switch ( $column_name ) {
//        case 'Contact':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Tot_Admins':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Tot_Employees':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Tot_Request':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Created_Date':
//            return $item['COM_Spcontactno'];
//            break;
//        }
        //return $item['COM_Name'];
    }
    
    /*function column_your_image_column_name($item)
    {
        return sprintf(
            '<img src="%s" />',
            $item['your_image_column_name']
        );
    }*/

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
//    function column_num($item)
//    {
//        //return '<em>' . $item['user_nicename'] . '</em>';
//        for($i=1;$i<n;$i++){
//            echo $i;
//            
//        }
//    }
//    
    function column_code($item){
        $code = $item['EMP_Name'] . ',</br>' . $item['EMP_Code']; 
        return $code;
    }
    
    function column_grades($item){
//        global $wpdb;
//        $table_name = "admin";
//        $comId = $item['COM_Id'];
//        $admin_count = $wpdb->get_var("SELECT COUNT(ADM_Id) FROM $table_name WHERE COM_Id=$comId");
//        if($admin_count == 0){
//            return "nil";
//        }
//        else{
//            return '(' . $admin_count . ')';
//        }
        $grade = $item['EG_Name']; 
        return $grade;
    }
    
    function column_email($item){
//        global $wpdb;
//        $table_name = "employees";
//        $comId = $item['COM_Id'];
//        $emp_count = $wpdb->get_var("SELECT COUNT(EMP_Id) FROM $table_name WHERE COM_Id=$comId");
//        return $emp_count;
         $email = $item['EMP_Email'] . ',</br>' . $item['EMP_Phonenumber']; 
        return $email;
    }
    
    function column_rpmgr($item){
        global $wpdb;
        $table_name = "employees";
        $comId = $item['COM_Id'];
         $rmrcode = $item['EMP_Reprtnmngrcode'];
        $rpmgr = $wpdb->get_var("SELECT EMP_Code='$rmrcode' AND COM_Id='$comId'");
        $display = $rpmgr['EMP_Name'] . ',</br>' . $rpmgr['EMP_Code']; 
        return $display;
     
     }
      function column_frmgr($item){
        global $wpdb;
        $table_name = "employees";
        $comId = $item['COM_Id'];
        $frmgrcode = $item['EMP_Funcrepmngrcode'];
        $frmgr = $wpdb->get_var("SELECT EMP_Code='$frmgrcode' AND COM_Id='$comId'");
        $display = $frmgr['EMP_Name'] . ',</br>' . $frmgr['EMP_Code']; 
        return $display;
     
     }
   function column_dep($item){
       
        $dep = $item['DEP_Name'] . ',</br>' . $item['DES_Name']; 
        return $dep;
     
     }
      function column_request($item){
        global $wpdb;
        //$table_name = "employees";
        $comId = $item['COM_Id'];
        $empId = $item['EMP_Id'];
        $total = $wpdb->get_var("SELECT requests req, request_employee re", "DISTINCT (req.REQ_Id)", "req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empId' AND COM_Id='$compId' AND REQ_Active !=9 AND RE_Status=1");
        $approved = $wpdb->get_var("SELECT requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empId' AND req.REQ_Id=re.REQ_Id AND COM_Id='$compId' AND REQ_Status=2 AND REQ_Active != 9 AND RE_Status=1");
        $pending = $wpdb->get_var("SELECT requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empId' AND req.REQ_Id=re.REQ_Id AND COM_Id='$compId' AND REQ_Status=1 AND REQ_Active != 9 AND RE_Status=1");
        $reject = $wpdb->get_var("SELECT requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empId' AND req.REQ_Id=re.REQ_Id AND COM_Id='$compId' AND REQ_Status=3 AND REQ_Active != 9 AND RE_Status=1");
        $display =  $total . '/' .$approved . '/' . $pending. '/' .$reject;
        return $display;
     }
     
    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_name($item)
    {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=financemenu" data-id=%s>%s</a>', $item['EMP_Id'], __('Edit', 'finance_table_list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['EMP_Id'], __('Delete', 'custom_table_example')),
        );
//        if($item['COM_Logo']){
//            $image = '<img src=' . $item['COM_Logo'] . ' alt="" class="avatar avatar-32 photo" height="auto" width="32">';  
//        }
//        else{
            $image = '<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32">';
        //}
        /* return sprintf('%s %s %s',
            $image,
            '<a href="#"><strong>' . $item['COM_Name'] . '</strong></a>',
            $this->row_actions($actions)
        ); */
		return sprintf('%s %s %s',
            $image,
            '<a href="'.erp_company_url_single_financeview( $item['EMP_Id']).'"><strong>' . $item['EMP_Name'] . '</strong></a>',
            $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['EMP_Id']
        );
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
           // 'num' => __('Sl.No', 'finance_table_list'),
            'code' => __('Employee Name & Employee Code', 'finance_table_list'),
            'grades' => __('Grade', 'finance_table_list'),
            'email' => __('Email & Contact NO.', 'finance_table_list'),
            'rpmgr' => __('Reporting Manager', 'finance_table_list'),
            'dep' => __('Department & Designation', 'finance_table_list'),
            'frmgr' => __('Func. Rep.Manager', 'finance_table_list'),
            'request' => __('Request', 'finance_table_list'),
        );
        return $columns;
    }

    /**
     * [OPTIONAL] This method return columns that may be used to sort table
     * all strings in array - is column names
     * notice that true on name column means that its default sort
     *
     * @return array
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            //'Company Name' => array('company_name', true),
            //'Company Logo' => array('company_logo', false),
            //'num' => array('Sl.No', true),
            'code' => array('Employee Name & Employee Code', true),
            'grades' => array('Grade', true),
            'email' => array('Email & Contact NO.', true),
            'rpmgr' => array('Reporting Manager', true),
            'dep' => array('Department & Designation', true),
            'frmgr' => array('Func. Rep.Manager', true),
            'request' => array('Request', true),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action()
    {
        global $wpdb;
        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
        $table_name = "employees";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE COM_Id IN($ids)");
            }
        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
       $table_name = 'employees'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
      $total_items = $wpdb->get_var("SELECT COUNT(EMP_Id) FROM $table_name");
     // print_r($total_items);die;

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'EMP_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
        
        $comId = $wpdb->get_var("SELECT COM_Id FROM $table_name");
       //print_r($comId);die;
       $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg  WHERE emp.COM_Id='$comId' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 AND emp.EMP_Access=1 AND emp.EMP_AccountsApprover=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
	//print_r($test);die;
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}

/**
 * Simple function that validates data and retrieve bool on success
 * and error message(s) on error
 *
 * @param $item
 * @return bool|string
 */

/**
 * Do not forget about translating your plugin, use __('english string', 'your_uniq_plugin_name') to retrieve translated string
 * and _e('english string', 'your_uniq_plugin_name') to echo it
 * in this example plugin your_uniq_plugin_name == custom_table_example
 *
 * to create translation file, use poedit FileNew catalog...
 * Fill name of project, add "." to path (ENSURE that it was added - must be in list)
 * and on last tab add "__" and "_e"
 *
 * Name your file like this: [my_plugin]-[ru_RU].po
 *
 * http://codex.wordpress.org/Writing_a_Plugin#Internationalizing_Your_Plugin
 * http://codex.wordpress.org/I18n_for_WordPress_Developers
 */
function custom_table_example_languages()
{
    load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
}

add_action('init', 'custom_table_example_languages');