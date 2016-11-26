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
class Empdelegates_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct( array(
            'singular' => 'delegate',
            'plural'   => 'delegates',
            'ajax'     => false
        ) );
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_last_login($item){
		global $wpdb;
        $table_name = "employee_logs";
		$empId = $item['EMP_Id'];
		$log = $wpdb->get_results("SELECT * FROM $table_name WHERE EMP_Id=$empId ORDER BY EL_Id DESC");
	if(count($log)!='0'){
        return date('d/M/Y', strtotime($log[0]->EL_In)) . date('h:i a', strtotime($log[0]->EL_In));
	}else{
		return "---";
	}
    }
	
    
    function column_To($item){
        global $wpdb;
        $table_name = "employees";
		$toempId = $item['DLG_ToEmpid'];			 
        $toid = $wpdb->get_results("SELECT EMP_Code,EMP_Name FROM $table_name WHERE EMP_Id='".$toempId."'");		
		return $toid['0']->EMP_Code ."<br> ". $toid['0']->EMP_Name;
    }
	

	 function column_Comments($item)
    {
        return stripslashes($item['DLG_Comments']);
    }
	
	function column_Term($item)
    {
		return "( ". date('d-M, y',strtotime($item['DLG_FromDate']))." ) to ( ". date('d-M, y',strtotime($item['DLG_ToDate']))." )";
    }
	
	function column_AddedDate($item)
    {
		return date('d-M, y',strtotime($item['DLG_AddedDate']));
    }
	
	function column_Status($item)
    {
			return ($item['DLG_Status']==1) ? '<span class="green">active</span>' : '<span class="red">over</span>';
	
    }
	function column_Updated($item)
    {
			return ($item['DLG_Active']==1)? '<span class="gray">No</span>' : '<span class="gray">Yes</span>';
	
    }
	function column_ForcefullyRemoved($item)
    {
			return ($item['DLG_ForcefullyRemovedDate']) ? date('d-M, y',strtotime($item['DLG_ForcefullyRemovedDate'])) : '<span class="label label-info">n/a</span>';
    }
	function column_From($item)
    {
		global $wpdb;
		 $table_name = "employees";
		 $fromempId = $item['DLG_FromEmpid'];
		$fromid = $wpdb->get_results("SELECT EMP_Code,EMP_Name FROM $table_name WHERE EMP_Id='".$fromempId."'");
					  
		return $fromid['0']->EMP_Code ."<br> ". $fromid['0']->EMP_Name;
    }

    function column_slno($item)
    {
        return $item['DLG_Id'];
    }

	
	function column_emailcontact($item){

        return $item['EMP_Email'] .'<br>'. $item['EMP_Phonenumber'] ;
    }
	
	function column_depdes($item){
			return $item['DEP_Name'] .'<br>'. $item['DES_Name'] ;
    }
	
	
	 function column_repm($item){
		//print_r($employeelist);
        global $wpdb;
		$found=0;			  
		if($selrepmng=$wpdb->get_results("SELECT * FROM employees WHERE EMP_Code='".$item['EMP_Reprtnmngrcode']."'"));
		{
			if(count($selrepmng)!=0){
			$repMngid		=	$selrepmng[0]->EMP_Id;
			$repMngName		=	$selrepmng[0]->EMP_Name;
			$repMngCode		=	$selrepmng[0]->EMP_Code;
			}else{
			$repMngid		=	'___';
			$repMngName		=	'___';
			$repMngCode		=	'___';	
			}
			$found=1;
		}
			return sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_employeeview($repMngid).'"><strong>' . $repMngName . '</strong></br>' . $repMngCode .'</a>',''
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
            'slno' => __('SL.NO.', 'empdelegates_table_list'),
            'From' => __('From', 'empdelegates_table_list'),
            'To' => __('To', 'empdelegates_table_list'),
            'Comments' => __('Comments', 'empdelegates_table_list'),
            'Term' => __('Term', 'empdelegates_table_list'),
            'Activities' => __('Activities', 'empdelegates_table_list'),
            'AddedDate' => __('AddedDate', 'empdelegates_table_list'),
			'Status' => __('Status', 'empdelegates_table_list'),
			'Updated' => __('Updated', 'empdelegates_table_list'),
			'ForcefullyRemoved' => __('Forcefully Removed', 'empdelegates_table_list'),
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
			'name'         =>array('Employee Name Employee code', true),
			'grade'		   => array( 'Grade', true),
            'emailcontact' => array( 'Email-Id Contact No.', true),
            'repm'   	   => array('Reporting Manager', true),
            'depdes'       => array( 'Department Designation', true),
            'Tot_login'        => array('Func. Rep. Manager', true),
            'last_login'     => array('Requests', true),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
   /*  function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    } */

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action()
    {
 
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
		global $wpdb;
        $table_name = 'employeelogs'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();
		
		$companyid = $_SESSION['compid'];
		//$companyid ='56';
        // will be used in pagination settings
	$total1_items = $wpdb->get_results("SELECT * FROM delegate WHERE COM_Id='$companyid' ORDER BY DLG_Id DESC");
	$total_items = count($total1_items);		
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'DLG_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		if(!empty($_POST["s"])) {
            $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'EMP_Email',
			'EMP_Name'
			);
			$i =0;
			foreach( $searchcol as $col) {
				if($i==0) {
					$sqlterm = 'AND';
				} else {
					$sqlterm = 'OR';
				}
				if(!empty($_REQUEST["s"])) {$query .=  ' '.$sqlterm.' '.$col.' LIKE "'.$search.'"';}
				$i++;
			}
			$this->items = $wpdb->get_results($wpdb->prepare("".$query."ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
			$comId = $_SESSION['compid'];
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM delegate WHERE COM_Id=$comId ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
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