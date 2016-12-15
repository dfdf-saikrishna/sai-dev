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
class Travel_Agent_Company_Invoice_Table extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
		global $supid;
        global $status, $page;

        parent::__construct(array(
            'singular' => 'companyinvoice',
            'plural' => 'companyinvoices',
        ));
    }

    /**
     * Render extra filtering option in
     * top of the table
     *
     * @since 0.1
     *
     * @param  string $which
     *
     * @return void
     */
    function extra_tablenav($which) {
		$supid = $_SESSION['supid'];
        global $wpdb;
        if ($which != 'top') {
            return;
        }
        $cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
        ?>
        <div class="alignleft actions">
            <label class="screen-reader-text" for="new_role"><?php _e('Filter by company', 'erp') ?></label>
            <select name="filter_cmp" id="filter_cmp" class="erp-select2">
                <option value="">- All -</option>
                <?php				   
                $selsql = $wpdb->get_results("SELECT com.COM_Id,com.COM_Name FROM company com WHERE com.SUP_Id = $supid AND com.COM_Status = 0 ORDER BY 2");
                foreach ($selsql as $rowcom) {
                    ?>
                    <option value="<?php echo $rowcom->COM_Id; ?>" <?php if ($cmp == $rowcom->COM_Id) echo 'selected="selected"'; ?> ><?php echo $rowcom->COM_Name; ?></option>
                    <?php } ?>
                </select>
			
                <?php
                submit_button(__('Search'), 'button', 'filter_company', false);
                echo '</div>';
        }

        function column_SlNo($item) {
            return $item['TDC_Id'];
        }
		
		function column_Reference_No($item) {
		 $cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
			 return sprintf( '%4$s <a href="%3$s"><strong>%1$s</strong></a> %2$s',$item['TDC_ReferenceNo'], '', erp_invoicedetails_url_single_view( $item['TDC_Id'],$cmp),'');
        }
		
		function column_Requests($item) {
            return $item['cntReqs'];
        }
		function column_Paid_Amount($item) {
			
			if($item['TDC_PaidAmount']){
			return IND_money_format($item['TDC_PaidAmount']).'.00';
			}
			else { 
			return '--';
			}
        }
		
		function column_Arrears($item) {
			if($item['TDC_Arrears']){ 
			return IND_money_format($item['TDC_Arrears']).'.00';
			}				
			else { 
			return '--';
			}
        }
		
		function column_Invoice_Status($item) {
			return  approvals($item['TDC_Status']); 
        }
		function column_Invoice_Date($item) {
			return date('d-M-y',strtotime($item['TDC_Date'])); 
        }
		
		function column_Quantity($item) {
			return ceil($item['totalQty']);
        }
        function column_Total_Amount($item) {
			//return ceil($item['totalQty']);
            global $wpdb;
			$amnt=0; $reqs=0; $servtax_servcharge_amount=0;
            $servtax_servcharge_amount = $item['TDC_ServiceCharges'] * ($item['TDC_ServiceTax'] / 100) ; 
					  
			$amnt = $item['totalAmnt'] + $servtax_servcharge_amount;
				
			$amnt += $item['TDC_ServiceCharges'];

            return $this->IND_money_format($amnt).".00";
        }

        function column_request_date($item) {
            return date('d-M-y', strtotime($item['REQ_Date']));
        }


  //INDIAN MONEY FORMAT

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
        function get_columns() {
            $columns = array(
                'SlNo' => __('Sl.No.', 'companyinvoice_table_list'),
                'Reference_No' => __('Reference No.', 'companyinvoice_table_list'),
                'Requests' => __('Requests', 'companyinvoice_table_list'),
                'Quantity' => __('Quantity', 'companyinvoice_table_list'),
                'Total_Amount' => __('Total Amount (Rs)', 'companyinvoice_table_list'),
                'Paid_Amount' => __('Paid Amount(Rs)', 'companyinvoice_table_list'),
				'Arrears' => __('Arrears(Rs)', 'companyinvoice_table_list'),
				'Invoice_Status' => __('Invoice Status', 'companyinvoice_table_list'),
				'Invoice_Date' => __('Invoice Date', 'companyinvoice_table_list'),
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
        function get_sortable_columns() {
            $sortable_columns = array(
                'SlNo' => __('Sl.No.', true),
                'Reference_No' => __('Reference No.', true),
                'Requests' => __('Requests', true),
                'Quantity' => __('Quantity', true),
                'Total_Amount' => __('Total Amount (Rs)',true),
                'Paid_Amount' => __('Paid Amount(Rs)', true),
				'Arrears' => __('Arrears(Rs)', true),
				'Invoice_Status' => __('Invoice Status', true),
				'Invoice_Date' => __('Invoice Date', true),
            );
            return $sortable_columns;
        }
        /**
         * [REQUIRED] This is the most important method
         *
         * It will get rows from database and prepare them to be showed in table
         */
        function prepare_items() {
            global $wpdb;
			 global $cmp;
            global $query;
            //$table_name = 'requests'; // do not forget about tables prefix
	
			
            $per_page = 5; // constant, how much records will be shown per page

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            // here we configure table headers, defined in our methods
            $this->_column_headers = array($columns, $hidden, $sortable);

            // [OPTIONAL] process bulk action if any
            $this->process_bulk_action();
            
            // filter company		
            if (isset($_REQUEST['filter_cmp']) && $_REQUEST['filter_cmp']) {
                $cmp = $_REQUEST['filter_cmp'];
                //$query.="WHERE COM_Id='$cmp'";
            }
		
            // will be used in pagination settings
            //$total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");
            // prepare query params, as usual current page, order by and order direction
            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'TDC_Id';
            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

            // [REQUIRED] define $items array
            // notice that last argument is ARRAY_A, so we will retrieve array
            if (!empty($_POST["s"])) {
                $query = "";
				//$q = "";
                $search = trim($_POST["s"]);
                $searchcol = array(
                    'TDC_ReferenceNo'
                );
                $i = 0;
                foreach ($searchcol as $col) {
                    if ($i == 0) {
                        $sqlterm = 'WHERE';
                    } else {
                        $sqlterm = 'OR';
                    }
                    if (!empty($_REQUEST["s"])) {
                        $query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
                    }
                    $i++;
                }
                $total_items = count($wpdb->get_var("SELECT tdc.TDC_Id, TDC_ReferenceNo, TDC_PaidAmount,TDC_Arrears,TDC_Status,TDC_Date,TDC_ServiceCharges, TDC_ServiceTax,COUNT(DISTINCT tdcr.TDCR_Id) AS cntReqs,SUM(tdcr.TDCR_Quantity) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalQty,
				SUM(tdcr.TDCR_Amount) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalAmnt FROM travel_desk_claims tdc INNER JOIN travel_desk_claim_requests tdcr USING(TDC_Id) WHERE COM_Id='$cmp'" . $query. "GROUP BY tdcr.TDC_Id"));
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT tdc.TDC_Id, TDC_ReferenceNo, TDC_PaidAmount,TDC_Arrears,TDC_Status,TDC_Date,TDC_ServiceCharges, TDC_ServiceTax,COUNT(DISTINCT tdcr.TDCR_Id) AS cntReqs,SUM(tdcr.TDCR_Quantity) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalQty,
				SUM(tdcr.TDCR_Amount) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalAmnt FROM travel_desk_claims tdc INNER JOIN travel_desk_claim_requests tdcr USING(TDC_Id) WHERE COM_Id='$cmp'" . $query . "GROUP BY tdcr.TDC_Id  ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            } else {
                $total_items = count($wpdb->get_results("SELECT tdc.TDC_Id, TDC_ReferenceNo, TDC_PaidAmount,TDC_Arrears,TDC_Status,TDC_Date,TDC_ServiceCharges, TDC_ServiceTax,COUNT(DISTINCT tdcr.TDCR_Id) AS cntReqs,SUM(tdcr.TDCR_Quantity) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalQty,
				SUM(tdcr.TDCR_Amount) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalAmnt FROM travel_desk_claims tdc INNER JOIN travel_desk_claim_requests tdcr USING(TDC_Id) WHERE COM_Id='$cmp'" . $query." GROUP BY tdcr.TDC_Id"));
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT tdc.TDC_Id, TDC_ReferenceNo, TDC_PaidAmount,TDC_Arrears,TDC_Status,TDC_Date,TDC_ServiceCharges, TDC_ServiceTax,COUNT(DISTINCT tdcr.TDCR_Id) AS cntReqs,SUM(tdcr.TDCR_Quantity) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalQty,
				SUM(tdcr.TDCR_Amount) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalAmnt FROM travel_desk_claims tdc INNER JOIN travel_desk_claim_requests tdcr USING(TDC_Id) WHERE COM_Id='$cmp' " . $query . " GROUP BY tdcr.TDC_Id ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
			
				
			}
            // [REQUIRED] configure pagination
            $this->set_pagination_args(array(
                'total_items' => $total_items, // total items defined above
                'per_page' => $per_page, // per page constant defined at top of method
                'total_pages' => ceil($total_items / $per_page) // calculate pages count
            ));
        }

    }

//}

    /**
     * Simple function that validates data and retrieve bool on success
     * and error message(s) on error
     *
     * @param $item
     * @return bool|string
     */
    function custom_table_example_validate_person($item) {
        $messages = array();

        if (empty($item['name']))
            $messages[] = __('Name is required', 'custom_table_example');
        if (!empty($item['email']) && !is_email($item['email']))
            $messages[] = __('E-Mail is in wrong format', 'custom_table_example');
        if (!ctype_digit($item['age']))
            $messages[] = __('Age in wrong format', 'custom_table_example');
        //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
        //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
        //...

        if (empty($messages))
            return true;
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
    function custom_table_example_languages() {
        load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
    }

    add_action('init', 'custom_table_example_languages');
    



  
    

