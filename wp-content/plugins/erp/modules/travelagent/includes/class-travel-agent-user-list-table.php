<?php
namespace WeDevs\ERP\Travelagent;
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
class Travel_Agent_User_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'travelagentuser',
            'plural' => 'travelagentusers',
        ));
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
            $item['SUP_Id']
        );
    }
  
    function column_Name($item){
		
		$actions = array(
            'edit' => sprintf('<a href="?page=UserM" data-id=%s>%s</a>', $item['SUP_Id'], __('Edit', 'companies_table_list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['SUP_Id'], __('Delete', 'custom_table_example')),
        );
		return sprintf('%s %s %s',
            '',
            '<a href="'.erp_company_url_single_companyview( $item['SUP_Id']).'"><strong>' . $item['SUP_Name'] . '&nbsp;(' . $item['SUP_Username'] . ')'.  '</strong></a>',
            $this->row_actions($actions)
        );
        
		//$username = $item['SUP_Username'];
       // return $name .'<br>'. $username;
    }
    
	function column_BranchNameCode($item){
        $AgencyName = $item['SUP_AgencyName']; 
		$AgencyCode = $item['SUP_AgencyCode'];
        return $AgencyName .'<br>'. $AgencyCode;
    }
	
	function column_Total_Client($item){
		$cntCom = $item['cntCom'];
        return $cntCom;
    }
	function column_Email($item){
		$Email = $item['SUP_Email'];
        return $Email;
    }
	function column_Contact($item){
		$Contact = $item['SUP_Contact'];
        return $Contact;
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
            'cb' =>'<input type="checkbox" />', //Render a checkbox instead of text
            'Name' => __('Name', 'travelagentuser_table_list'),
            'BranchNameCode' => __('Branch Name/Code', 'travelagentuser_table_list'),
			'Total_Client' => __('Total Client', 'travelagentuser_table_list'),
			'Email' => __('Email', 'travelagentuser_table_list'),
			'Contact' => __('Contact', 'travelagentuser_table_list'),
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
			'cb' => array('', true),
            'Name' => __('Name',false),
            'BranchNameCode' => __('Branch Name/Code',true),
			'Total_Client' => __('Total Client',false),
			'Email' => __('Email',true),
			'Contact' => __('Contact',true ),
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
        $table_name = "superadmin";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

        if (!empty($ids)) {
		$supid = $_SESSION['supid'];
		$wpdb->query("UPDATE superadmin SET SUP_Status=9 WHERE SUP_Id IN($ids) AND SUP_Status=1 AND SUP_Refid='$supid'");
        $wpdb->query("UPDATE assign_company SET AC_RemovedDate=NOW(),AC_Status=2,AC_Active=9 WHERE SUP_Id IN($ids) AND AC_Status=1");     
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
		$supid = $_SESSION['supid'];
        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items1 = $wpdb->get_results("SELECT SUP_Username,SUP_AgencyName,SUP_AgencyCode,SUP_Name,SUP_Email,SUP_Contact,SUP_Address,SUP_Date,
						sup.SUP_Id,COUNT(DISTINCT ac.COM_Id) AS cntCom,GROUP_CONCAT(DISTINCT com.COM_Name) AS coms FROM superadmin sup
						LEFT JOIN assign_company ac ON sup.SUP_Id = ac.SUP_Id AND SUP_Status = 1 AND SUP_Type = 4 AND ac.AC_Active = 1
						INNER JOIN company com ON ac.COM_Id = com.COM_Id
						WHERE sup.SUP_Refid = '$supid' GROUP BY sup.SUP_Id");
						
		$total_items=count($total_items1);
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'sup.SUP_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		if(!empty($_POST["s"])) {
            $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'SUP_Name',
			'SUP_AgencyName',
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
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT SUP_Username,SUP_AgencyName,SUP_AgencyCode,SUP_Name,SUP_Email,SUP_Contact,SUP_Address,SUP_Date,
						sup.SUP_Id,COUNT(DISTINCT ac.COM_Id) AS cntCom,GROUP_CONCAT(DISTINCT com.COM_Name) AS coms FROM superadmin sup
						LEFT JOIN assign_company ac ON sup.SUP_Id = ac.SUP_Id AND SUP_Status = 1 AND SUP_Type = 4 AND ac.AC_Active = 1
						INNER JOIN company com ON ac.COM_Id = com.COM_Id
						WHERE SUP_Refid = '$supid'
						GROUP BY sup.SUP_Id".$query."ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT SUP_Username,SUP_AgencyName,SUP_AgencyCode,SUP_Name,SUP_Email,SUP_Contact,SUP_Address,SUP_Date,
						sup.SUP_Id,COUNT(DISTINCT ac.COM_Id) AS cntCom,GROUP_CONCAT(DISTINCT com.COM_Name) AS coms FROM superadmin sup
						LEFT JOIN assign_company ac ON sup.SUP_Id = ac.SUP_Id AND SUP_Status = 1 AND SUP_Type = 4 AND ac.AC_Active = 1
						INNER JOIN company com ON ac.COM_Id = com.COM_Id
						WHERE SUP_Refid = '$supid'
						GROUP BY sup.SUP_Id ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}


