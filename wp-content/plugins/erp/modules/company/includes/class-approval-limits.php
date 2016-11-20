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
class Approval_Limits extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $compid;
        global $status, $page;

        parent::__construct(array(
            'singular' => 'admin',
            'plural' => 'admins',
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
    function column_age($item)
    {
        return '<em>' . $item['user_nicename'] . '</em>';
    }
    
    function column_Username($item){
        $username =  $item['ADM_Username']; 
        return $username;
    }
    
    function column_Email($item){
$email =  $item['ADM_Email']; 
        return $email;
    }
    
    function column_Contact($item){
        $contact =  $item['ADM_Cont']; 
        return $contact;
    }
    
    function column_Created_Date($item){

        return date('d/M/Y', strtotime($item['ADM_Regdate'])) . date('h:i a', strtotime($item['ADM_Regdate']));
    }
    
    // function column_Tot_Requests($item){
        // global $wpdb;
        // $table_name = "requests";
        // $comId = $item['COM_Id'];
        // $req_count = $wpdb->get_var("SELECT COUNT(REQ_Id) FROM $table_name WHERE COM_Id=$comId");
        // return $req_count;
    // }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_employee($item)
    {
        return "<a href='admin-employees-display.php?empid=$item[EMP_Id]'>$item[EMP_Code]</a><br />$item[EMP_Name]";
    }
    
    function column_limit_amount($item)
    {
        return $this->IND_money_format($item['APL_LimitAmount']).'.00';
    }
    
    function column_status($item)
    {
        if($item['APL_Status']==1)
            return "<span class='status-2'>Open</span>";
        else if($item['APL_Status']==2)
            return "<span class='status-4'>Closed</span>";
    }
    
    function column_added_date($item)
    {
        return date('d-m-y h:i a', strtotime($item['APL_AddedDate']));
    }
    
    function column_closed_date($item){
        if($item['APL_ClosedDate'])
            return date('d-m-y h:i a', strtotime($item['APL_ClosedDate']));
        else
            return "<span class='status-3'>&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>";
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
            $item['COM_Id']
        );
    }
    
    function IND_money_format($money){
        $len = strlen($money);
        $m = '';
        $money = strrev($money);
        for($i=0;$i<$len;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
                $m .=',';
            }
            $m .=$money[$i];
        }
        return strrev($m);
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
            'employee' => __('Employee', 'approval_limits_table_list'),
            'limit_amount' => __('Limit Amount (Rs)', 'approval_limits_table_list'),
            'status' => __('Status', 'approval_limits_table_list'),
            'added_date' => __('Added Date', 'approval_limits_table_list'),
            'closed_date' => __('Closed Date', 'approval_limits_table_list'),
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
            'Company Name' => array('company_name', true),
            'Company Logo' => array('company_logo', false),
            'Contact' => array('contact', false),
            'Tot. Admins' => array('admins', false),
            'Tot. Employees' => array('employees', false),
            'Tot. Requests' => array('requests', false),
            'Created Date' => array('date', false),
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
        $table_name = "admin";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE ADM_Id IN($ids)");
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
        $compid = $_SESSION['compid'];
        global $wpdb;
        $table_name = 'admin'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'COM_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		if(!empty($_POST["s"])) {
            $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'EMP_Code'
			);
			$i =0;
			foreach( $searchcol as $col) {
				if($i==0) {
					$sqlterm = 'WHERE';
				} else {
					$sqlterm = 'OR';
				}
				if(!empty($_REQUEST["s"])) {$query .=  ' '.$sqlterm.' '.$col.' LIKE "'.$search.'"';}
				$i++;
			}
            // will be used in pagination settings
            $total_items = count($wpdb->get_results("SELECT * FROM approval_limit al, employees emp".$query." AND al.APL_Active=1 AND al.EMP_Id = emp.EMP_Id AND emp.COM_Id='$compid' AND EMP_Status=1 AND EMP_AccountsApprover=1 AND EMP_Access=1"));
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM approval_limit al, employees emp".$query." AND al.APL_Active=1 AND al.EMP_Id = emp.EMP_Id AND emp.COM_Id='$compid' AND EMP_Status=1 AND EMP_AccountsApprover=1 AND EMP_Access=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
            // will be used in pagination settings
            $total_items = count($wpdb->get_results("SELECT * FROM approval_limit al, employees emp WHERE al.APL_Active=1 AND al.EMP_Id = emp.EMP_Id AND emp.COM_Id='$compid' AND EMP_Status=1 AND EMP_AccountsApprover=1 AND EMP_Access=1"));
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM approval_limit al, employees emp WHERE al.APL_Active=1 AND al.EMP_Id = emp.EMP_Id AND emp.COM_Id='$compid' AND EMP_Status=1 AND EMP_AccountsApprover=1 AND EMP_Access=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
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
function custom_table_example_validate_person($item)
{
    $messages = array();

    if (empty($item['name'])) $messages[] = __('Name is required', 'custom_table_example');
    if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'custom_table_example');
    if (!ctype_digit($item['age'])) $messages[] = __('Age in wrong format', 'custom_table_example');
    //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
    //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
    //...

    if (empty($messages)) return true;
    return implode('<br />', $messages);
}

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