<?php
namespace WeDevs\ERP\Traveldesk;
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
class Traveldesk_Claims_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'traveldeskclaim',
            'plural' => 'traveldeskclaims',
        ));
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_Slno($item)
    {
        return '<em>' . $item['COM_Id'] . '</em>';
    }
    
	
	function column_ref_no($item) {
		 $compid = $_SESSION['compid']; 
			 return sprintf( '%4$s <a href="%3$s"><strong>%1$s</strong></a> %2$s',$item['TDC_ReferenceNo'], '', erp_travel_desk_claim_details_view( $item['TDC_Id'],$compid),'');
        }
   
    
    function column_requests($item) {
       global $wpdb;
       $table_name = "travel_desk_claim_requests";
       $tdcId = $item['TDC_Id'];	
       $req = $wpdb->get_results("SELECT TDCR_Id FROM $table_name WHERE TDC_Id=$tdcId");
       return count($req);
    }
    
     function column_quantity($item) {
       global $wpdb, $quantity;
       $table_name = "travel_desk_claim_requests";
       $tdcId = $item['TDC_Id'];	
       $quan = $wpdb->get_results("SELECT TDCR_Quantity FROM $table_name WHERE TDC_Id=$tdcId");
       $quantity = 0;
       foreach($quan as $rowqnt){    
        $quantity = $quantity + $rowqnt->TDCR_Quantity;
       }
       return $quantity;
    }
            
    
    function column_total_amt($item){
       global $wpdb, $tamt;
       $table_name = "travel_desk_claim_requests";
       $tdcId = $item['TDC_Id'];	
       $t_amt = $wpdb->get_results("SELECT TDCR_Amount FROM $table_name WHERE TDC_Id=$tdcId");
       $tamt = 0;
       foreach($t_amt as $rowamt){
          $tamt = $tamt + $rowamt->TDCR_Amount;
          $tamt=$tamt + $item['TDC_ServiceCharges'];
       }
       $servtax_servcharge_amount=$item['TDC_ServiceCharges'] * ($item['TDC_ServiceTax'] / 100) ;
       $tamt=$tamt + $servtax_servcharge_amount;
       return $tamt;
    }
    
    function column_approval_status($item){       
       return tdclaimapprovals($item['TDC_Level']);
    }
    
     function column_claim_status($item){       
       return approvals($item['TDC_Status']);
    }
    
    function column_invoice_date($item){       
       return date('d-M-y',strtotime($item['TDC_Date']));
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
            'ref_no' => __('Reference No.', 'expensecategory_table_list'),
            'requests' => __('Requests', 'expensecategory_table_list'),
            'quantity' => __('Quantity', 'expensecategory_table_list'),
            'total_amt' => __('Total Amount (Rs)', 'expensecategory_table_list'),
            'approval_status' => __('Approval Status', 'expensecategory_table_list'),
            'claim_status' => __('Claim Status', 'expensecategory_table_list'),
            'invoice_date' => __('Invoice Date', 'expensecategory_table_list'),
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
            'Mode Name' => array('MOD_Name', true),
            'Expense Category' => array('EC_Name', false),
        );
        return $sortable_columns;
    }


    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
        $table_name = 'travel_desk_claims'; // do not forget about tables prefix

        $per_page = 15; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();
		$compid = $_SESSION['compid'];
        // will be used in pagination settings
        $total_items = count($wpdb->get_results("SELECT COM_Id='$compid' FROM $table_name"));

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'TDC_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
	//$comId = $_SESSION['compid'];	
	//$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE COM_Id=$comId ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        //	$comId = $_SESSION['compid'];
             //   var_dump($comId);
        $comId = $_SESSION['compid'];
	$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE COM_Id=$comId ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}


