<?php
namespace WeDevs\ERP\Employee;
$mydetails=myDetails();
$compid = $_SESSION['compid'];
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
class Request_Travel_Expenses extends \WP_List_Table
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

    function column_estimated_cost($item){
        global $wpdb;
        //$totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total FROM request_details WHERE REQ_Id=$item[REQ_Id] AND RD_Status='1'");
        $cls = NULL;

        if ($item['REQ_PreToPostStatus']) {

            if ($item['REQ_Type'] == 4) {

                $totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total  FROM request_details WHERE REQ_Id='$item[REQ_Id]'");
                
                print_r($totalcost);die;
            } else {

                $totalcost = $wpdb->get_row("SELECT SUM(ptac.PTAC_Cost)  AS total  FROM requests req, pre_travel_claim ptc, pre_travel_actual_cost ptac WHERE req.REQ_Id=$item[REQ_Id] AND req.REQ_Id=ptc.REQ_Id AND ptc.PTC_Id=ptac.PTC_Id AND ptac.PTAC_Status=1");
                $selptc = $wpdb->get_results("SELECT * FROM pre_travel_claim WHERE REQ_Id='$item[REQ_Id]'");
                $status1=$selptc['0']->PTC_RepMngrStatus;
                $status=$selptc['0']->PTC_FinanceStatus;
                // emp --> rep mangr --> finance
                if (($status1 == 2) && ($status == 1))
                    $cls = 'class="boldfont"';
            }
        } else {

            switch ($item['POL_Id']) {
                // emp --> rep mangr --> finance
                case 1:
                    if ($sel_apprv_actn =$wpdb->get_row("SELECT REQ_Status FROM  request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_EmpType=1 AND REQ_Status=2 AND RS_Status=1")) {
                        if (!$acc_apprv_actn = $wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_EmpType=2 AND RS_Status=1"))
                            $cls = 'class="boldfont"';
                    }
                    break;

                case 2:// emp --> finance --> rep mangr
                case 4:// emp --> finance 

                    if (!$acc_apprv_actn =$wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_EmpType=2 AND RS_Status=1"))
                        $cls = 'class="boldfont"';

                    break;
            }

            $totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total FROM request_details WHERE REQ_Id=$item[REQ_Id] AND RD_Status=1");
        }

        return IND_money_format($totalcost->total ).".00";
    }
    
    function column_reporting_manager_approval($item){
        global $wpdb;
        global $approvals;
        
        if($item['REQ_Type']==2 || $item['REQ_Type']==4){
            
            $approvals=approvals(5);

        } else {

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

        }
        return $approvals;
    }
    
    function column_finance_approval($item){

        global $wpdb;
        global $approvals;
        
        if($item['REQ_Type']==2 || $item['REQ_Type']==4){
            
            $approvals=approvals(5);

        } else {

            // reporting manager status
            
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

        }
        return $approvals;
    }
    
    function column_status($item){

        global $wpdb;
        global $approvals;
        
        $claimdata='<span class="status-2 title="Claimed on: '.date("d/M/y",strtotime($item['REQ_ClaimDate'])).'">Claimed</span>';
        //echo $claimdata;die;
        if ($item['REQ_Type'] == 4) {

            if ($item['REQ_Claim']) {

                return $claimdata;
            } else {

                if ($item['REQ_PreToPostStatus'])
                    return approvals(1);
                else
                    return approvals(5);
            }
        } else {

            if ($item['REQ_Claim']) {

                return $claimdata;
            } else {

                if ($item['REQ_PreToPostStatus']) {

                    if ($selptc =$wpdb->get_row("SELECT PTC_Status FROM pre_travel_claim WHERE REQ_Id='$item[REQ_Id]'"))
                        return approvals($selptc->PTC_Status);
                }else {

                    if ($item['REQ_Status'] == 2)
                        return approvals(1);
                    else
                        return approvals(5);
                }
            }
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
        $href="";
        if ($item['REQ_Type'] == 4) {
            $href = "#";
        } else {
            if ($item['REQ_Type'] > 1) {
                switch ($item['REQ_Type']) {
                    case 2:
                        $href = "#";
                        break;

                    case 3: case 4:
                        $href = "#";
                        break;
                }
            } else {

                if ($item['REQ_PreToPostStatus']) {

                    $href = "#";
                } else {

                    switch ($item['RT_Id']) {
                        case 1:
                            $href = "#";
                            break;

                        case 2:
                            $href = "#";
                            break;

                        case 3:
                            $href = "#";
                            break;

                        case 5:
                            $href = "#";
                            break;

                        case 6:
                            $href = "#";
                            break;
                    }
                }
            }
        }

        if($item['REQ_Type']==4){
            $cls='class="boldfont"';
                $href="#=".$item['REQ_Id'];

        } else {
                $href="#".$item['REQ_Id'];
        }

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
          return "<a href='<?php echo $href; ?>' >".$item['REQ_Code']."</a>".$type;
    }

    function get_columns()
    {
        $columns = array(
            //'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'request_code' => __('Request Code', 'companiesadmin_table_list'),
            'estimated_cost' => __('Total Cost', 'companiesadmin_table_list'),
            'reporting_manager_approval' => __('Reporting Manager Approval', 'companiesadmin_table_list'),
            'finance_approval' => __('Finance Approval', 'companiesadmin_table_list'),
            'request_date' => __('Request Date', 'companiesadmin_table_list'),
            'status' => __('Claim Status', 'companiesadmin_table_list'),
            
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
            'estimated_cost' => array('Total Cost', true),
            'reporting_manager_approval' => array('Reporting Manager Approval', false),
            'finance_approval' => array('Finance Approval', false),
            'request_date' => array('Request Date', false),
            'status'=>array('Claim Status', false),
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
        $empuserid = $_SESSION['empuserid'];
        global $wpdb;
        
        $compid = $_SESSION['compid'];
        $mydetails=myDetails();
        
       // $table_name = 'requests'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();
         $empid=$mydetails->EMP_Id;
        // will be used in pagination settings
        $total_items = count($wpdb->get_results("SELECT * FROM requests req, request_employee re WHERE req.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id !='$empid' AND req.REQ_Active !=9 AND re.RE_Status=1"));

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
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests req, request_employee re" .$query. " AND req.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id != '$empid' AND req.REQ_Active !=9 AND re.RE_Status=1  ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
                        //print_r($test);die;
                        
                                }
		else{
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM  requests req, request_employee re WHERE req.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id != '$empid' AND req.REQ_Active !=9 AND re.RE_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
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

