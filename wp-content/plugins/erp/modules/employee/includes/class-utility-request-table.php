<?php
namespace WeDevs\ERP\Employee;
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
class Utility_Requests_List extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
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

    }
    
   function column_status($item){
        global $wpdb;
        global $approvals;
   $claimdata = '<span class="status-2 title="Claimed on: ' . date("d/M/y", strtotime($item['REQ_ClaimDate'])) . '">Claimed</span>';
        if ($item['REQ_Claim']) {
            return $claimdata;
        } else {

            if ($item['REQ_Status'] == 1 || $item['REQ_Status'] == 3) {

                return approvals(5);
            } else {

                return approvals(1);
            }
        }
        return $approvals;
    }

    function column_estimated_cost($item){
        global $wpdb;
        $totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total FROM request_details WHERE REQ_Id=$item[REQ_Id] AND RD_Status='1'");
        return IND_money_format($totalcost->total).".00";
    }
    
    function column_reporting_manager_approval($item){
        global $wpdb;
        global $approvals;
            // reporting manager status
            if($item['POL_Id'] !=4){
                
                if($repmngrStatus=$wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=1"))
                {
                    $approvals=approvals($repmngrStatus->REQ_Status);
                }
                else
                {
                    $approvals=approvals(1);
                }

            } else {
                $approvals=approvals(5);
            }

        return $approvals;
    }
    
    function column_skiplevel_manager_approval($item){

        global $wpdb;
        global $approvals;

        if($item['REQ_Type']==2 || $item['REQ_Type']==4 || $item['REQ_Type']==3){

            $approvals=approvals(5);

        } else {

            // skiplevel manager status
            //var_dump($item['POL_Id']);
            if($item['POL_Id'] !=3 && $item['POL_Id'] !=4 && $item['POL_Id'] !=2 && $item['POL_Id'] !=1){

                if($repmngrStatus=$wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=5"))
                {
                    $approvals=approvals($repmngrStatus->REQ_Status);
                }
                else
                {
                    $approvals=approvals(1);
                }

            } else {

                $approvals=approvals(5);

            }

        }
        return $approvals;
    }
    
    function column_finance_approval($item){

        global $wpdb;
        global $approvals;
        
            // finance status
            
            if($item['POL_Id'] !=3){
                
                if($repmngrStatus=$wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=2"))
                {
                    $approvals=approvals($repmngrStatus->REQ_Status);
                }
                else
                {
                    $approvals=approvals(1);
                }

            } else {

                $approvals=approvals(5);

            }

        return $approvals;
    }
    
    function column_request_date($item){
        return date('d-M-y',strtotime($item['REQ_Date']));
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_request_code($item)
    {
      $href="/wp-admin/admin.php?page=view-utility&reqid=".$item['REQ_Id'];

        $type=NULL;

        $title=NULL;

        switch ($item['REQ_Type']){
                case 2:
                $type='<span style="font-size:10px;">[W/A]</span>';
                $title="Without Approval";
                break;

                case 3:
                $type='<span style="font-size:10px;">[AR]</span>';
                $title="Approval Required";
                break;

                case 4:
                $type='<span style="font-size:10px;">[G]</span>';
                $title="Group Request Without Approval";
                break;

          }
          return "<a href='$href' >".$item['REQ_Code']."</a>".$type;
    }


    function get_columns()
    {
        $columns = array(
            //'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'request_code' => __('Request Code', 'companiesadmin_table_list'),
            'estimated_cost' => __('Total Cost', 'companiesadmin_table_list'),
            'reporting_manager_approval' => __('Reporting Manager Approval', 'companiesadmin_table_list'),
            'skiplevel_manager_approval' => __('SkipLevel Manager Approval', 'emp_req_table_list'),
            'finance_approval' => __('Finance Approval', 'companiesadmin_table_list'),
            'request_date' => __('Request Date', 'companiesadmin_table_list'),
            'status'=>__('Claim Status', 'companiesadmin_table_list'),
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
            'request_code' => array('Request Code', true),
            'estimated_cost' => array('Total Cost', false),
            'reporting_manager_approval' => array('Reporting Manager Approval', false),
            'skiplevel_manager_approval' => array('SkipLevel Manager Approval', true),
            'finance_approval' => array('Finance Approval', false),
            'request_date' => array('Request Date', false),
            'status'=>array('Status', false),
        );
        return $sortable_columns;
    }

    function prepare_items()
    {
        $empuserid = $_SESSION['empuserid'];
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

        // will be used in pagination settings
        $total_items = count($wpdb->get_results("SELECT * FROM requests req, request_employee re, policy pol WHERE req.COM_Id='$compid' AND req.RT_Id=6 AND re.EMP_Id='$empuserid' AND req.POL_Id=pol.POL_Id AND req.REQ_Id=re.REQ_Id AND req.REQ_Active=1 AND re.RE_Status=1"));

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'req.REQ_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
            if(!empty($_POST["s"])) {
                        $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'REQ_Code'
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
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests req, request_employee re, policy pol WHERE ".$query." req.COM_Id='$compid' AND req.RT_Id=6 AND re.EMP_Id='$empuserid' AND req.POL_Id=pol.POL_Id AND req.REQ_Id=re.REQ_Id AND req.REQ_Active=1 AND re.RE_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests req, request_employee re, policy pol WHERE req.COM_Id='$compid' AND req.RT_Id=6 AND re.EMP_Id='$empuserid' AND req.POL_Id=pol.POL_Id AND req.REQ_Id=re.REQ_Id AND req.REQ_Active=1 AND re.RE_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}