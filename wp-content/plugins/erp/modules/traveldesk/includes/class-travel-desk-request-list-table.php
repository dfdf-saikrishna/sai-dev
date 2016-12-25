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
class Travel_Desk_Request_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'traveldeskrequest',
            'plural' => 'traveldeskrequests',
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
	global $wpdb;
	if ($which != 'top') {
	return;
	}?>
		<?php
	$txtReqid = ( isset($_REQUEST['txtReqid']) ) ? $_REQUEST['txtReqid'] : '';
	$reqtype = ( isset($_REQUEST['reqtype']) ) ? $_REQUEST['reqtype'] : 0;
	$selReqstatus	= ( isset($_REQUEST['selReqstatus']) ) ? $_REQUEST['selReqstatus'] : '';
?>
			<div class="alignleft actions">
			 <form action="" method="post" name="form1" id="form1">
                <input type="text" class="form-control" name="txtReqid" placeholder="REQUEST CODE" value="<?php echo $txtReqid; ?>" />
                <select class="form-control" name="reqtype" id="reqtype">
                  <option value="">All</option>
                  <?php 
				  $selsql=$wpdb->get_results("SELECT * FROM td_request_type");
				  
				  foreach($selsql as $rowsql){
					  print_r($rowsql);
				  ?>
                  <option value="<?php echo $rowsql->TRT_Id; ?>" <?php if($reqtype==$rowsql->TRT_Id) echo 'selected="selected"';?> ><?php echo $rowsql->TRT_Name; ?></option>
                  <?php } ?>
                </select>
                <select class="form-control" name="selReqstatus" id="selReqstatus">
                  <option value="">All</option>
                  <option value="2" <?php if($selReqstatus==2) echo 'selected="selected"';?> >Approved</option>
                  <option value="1" <?php if($selReqstatus==1) echo 'selected="selected"';?>>Pending</option>
                  <option value="3" <?php if($selReqstatus==3) echo 'selected="selected"';?>>Rejected</option>
                </select>
              
                <input type="submit" class="btn btn-theme" value="Submit" />
              </div>
            </form>
			<!--<form name="tdclaimform" id="tdclaimform" method="get" action="travel-agent-invoice.php">
			<div class="form-group">

			<button type="submit" name="gotoInvoicepageButton" id="gotoInvoicepageButton" class="add-new-h2">Raise Invoice</button>
			<input type="text" name="reqids" id="reqids" />

			</div>
			</form>-->

<?php
}  


/**
* [REQUIRED] this is how checkbox column renders
*
* @param $item - row (key, value array)
* @return HTML
*/
function column_cb($item)
{
	global $wpdb;
	$compid = $_SESSION['compid'];
	$selsql = $wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 ORDER BY bs.BS_Id DESC LIMIT 0, 10");

	foreach ($selsql as $rowsql) {
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id=$item[REQ_Id] AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {		
				if(isset($values->BS_Status)){
				if($values->BS_Status != 3)
					$totalcosts+=$values->RD_Cost;									

					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id==1)
					$void += 1;
					
				}
				}
				//echo 'totalcost='.$totalcosts."<br>";
				$rdids="";
				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				$compid = $_SESSION['compid'];
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id=$item[REQ_Id]");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					if(!empty($selclmreqid)){		
					if($selclmreqid[0]->TDC_Status==2)
					$icon=2;
					}
					
					//echo 'tdc status='.$selclmreqid[TDC_Status]."<br>";
				} 
				

                         
						 
						switch ($item['REQ_Type']){
						
							case 1:
							$href='travel-desk-booking-details.php';
							$type='<span style="font-size:10px;">[E]</span>';
							$title="Employee Request";
							break;
							
							case 2:
							$href='travel-desk-individual-without-approval-details.php';
							$type='<span style="font-size:10px;">[W/A]</span>';
							$title="Without Approval";
							break;
							
							case 3:
							$href='travel-desk-individual-with-approval-details.php';
							$type='<span style="font-size:10px;">[AR]</span>';
							$title="Approval Required";
							break;
						
							case 4:
							$href='travel-desk-group-request-details.php';
							$type='<span style="font-size:10px;">[G]</span>';
							$title="Group Request Without Approval";
							break;
						}
	}
	//$check = if($void) echo $void; else echo "";  
	/* $check = if($onclick){ 
		echo $onclick;
	} */
return '<input type="checkbox" name="reqid[]" value="'. $item['REQ_Id'] .'" />';                        
}

function column_Request_Code($item) {
	$compid = $_SESSION['compid'];
	$type=NULL;
					
					switch ($item['REQ_Type']) 
					{
						case 2:
						$href="/wp-admin/admin.php?page=View-Request&reqid=". $item['REQ_Id'];
						$edithref="/wp-admin/admin.php?page=Edit-Request";
						$type='<span style="font-size:10px;">[W/A]</span>';
						$title="Without Approval";
						break;
						
						case 3:
						$href='/wp-admin/admin.php?page=View-Appr-Request&reqid='.$item['REQ_Id'];
						$edithref="/wp-admin/admin.php?page=Edit-Appr-Request";
						$type='<span style="font-size:10px;">[AR]</span>';
						$title="Approval Required";
						break;
						
						case 4:
						$href='/wp-admin/admin.php?page=Group-Request-Details&reqid='.$item['REQ_Id'];
						$edithref='/wp-admin/admin.php?page=Edit-Group-Request';
						$type='<span style="font-size:10px;">[G]</span>';
						$title="Group Request Without Approval";
						break;
					}               
return '<a style="padding-left:25px;" href="'.$href.'">'. $item['REQ_Code'] .'</a>'. $type;

// return $reqcode . $type ;
}

function column_Total_Cost($item) {
global $wpdb;
$totalcost=$wpdb->get_row("SELECT RD_Cost FROM request_details WHERE REQ_Id='".$item['REQ_Id']."'");
if(!empty($totalcost)){
 $cost = $totalcost->RD_Cost;
}else{
	$cost = "";
}
return  IND_money_format($cost).".00";


}


function column_Reporting_Manager_Approval($item) {
global $wpdb;
	if($item['REQ_Type']==2 || $item['REQ_Type']==4){
					
						$approvals=approvals(5);
					
					} else {
					
						// reporting manager status
						
						if($item['POL_Id'] !=4){
						
							if($repmngrStatus=$wpdb->get_results("SELECT REQ_Status FROM request_status WHERE REQ_Id='".$item['REQ_Id']."' AND RS_Status=1 AND RS_EmpType=1"))
							{
								$approvals=approvals($repmngrStatus[0]->REQ_Status);
							}
							else
							{
								$approvals=approvals(1);
							}
						
						} else {
						
							$approvals=approvals(5);
						
						}
						
					
					}

                    $appr = $approvals;$approvals=NULL;
return $appr; 
}

function column_Finance_Approval($item) {
global $wpdb;
	if($item['REQ_Type']==2 || $item['REQ_Type']==4){
					
						$approvals=approvals(5);
					
					} else {
					
						// finance status
						
						if($item['POL_Id'] !=3){
						
						
							if($repmngrStatus=$wpdb->get_results("SELECT REQ_Status FROM request_status", "", "REQ_Id='". $item['REQ_Id'] ."' AND RS_Status=1 AND RS_EmpType=2"))
							{
								$approvals=approvals($repmngrStatus[0]->REQ_Status);
							}
							else
							{
								$approvals=approvals(1);
							}
						
						} else {
						
							$approvals=approvals(5);
						}
					
					
					}
					
                    $apprf = $approvals; $approvals=NULL;
return $apprf; 
}

	function column_Action($item) {	

		$type=NULL;
					
					switch ($item['REQ_Type']) 
					{
						case 2:
						$href="/wp-admin/admin.php?page=View-Request";
						$edithref='/wp-admin/admin.php?page=Edit-Request';
						$type='<span style="font-size:10px;">[W/A]</span>';
						$title="Without Approval";
						break;
						
						case 3:
						$href="travel-desk-individual-with-approval-details.php";
						$edithref='travel-desk-individual-with-approval-edit.php';
						$type='<span style="font-size:10px;">[AR]</span>';
						$title="Approval Required";
						break;
						
						case 4:
						$href="travel-desk-group-request-details.php";
						$edithref='travel-desk-group-request-edit.php';
						$type='<span style="font-size:10px;">[G]</span>';
						$title="Group Request Without Approval";
						break;
					}  
	if($item['REQ_Claim']){
						
							$act =  approvals(5);
							
						} else {
						
							if(!$item['REQ_PreToPostStatus']){
							
								$act = '<span class="tooltip-area"> <a href="'.$edithref.'&reqid='.$item['REQ_Id'].'" class="button button-default" title="Edit"><i class="fa fa-pencil"></i></a> </span>';
							
							} else {
							
								$act = approvals(5);
								
							}
						
						}


	return $act;
	}

function column_Request_Date($item) {			
return date('d-M-y',strtotime($item['REQ_Date']));
}

function column_Claim_Status($item) {
	global $wpdb;
	$type=NULL;
					
					switch ($item['REQ_Type']) 
					{
						case 2:
						$href="travel-desk-individual-without-approval-details.php";
						$edithref="travel-desk-individual-without-approval-edit.php";
						$type='<span style="font-size:10px;">[W/A]</span>';
						$title="Without Approval";
						break;
						
						case 3:
						$href="travel-desk-individual-with-approval-details.php";
						$edithref="travel-desk-individual-with-approval-edit.php";
						$type='<span style="font-size:10px;">[AR]</span>';
						$title="Approval Required";
						break;
						
						case 4:
						$href="travel-desk-group-request-details.php";
						$edithref="travel-desk-group-request-edit.php";
						$type='<span style="font-size:10px;">[G]</span>';
						$title="Group Request Without Approval";
						break;
					}
	$compid = $_SESSION['compid'];
					if($item['REQ_Claim']){
						$appr= '<span class="label label-primary" title="Claimed on: '.date("d/M/y", strtotime($item["REQ_ClaimDate"])).'">Claimed</span>';
						
					} else {
						//echo $rowsql['REQ_PreToPostStatus']."<br>";
						if($item['REQ_Type']==4){	
							if($item['REQ_PreToPostStatus'])
							 $appr=approvals($item['REQ_PreToPostStatus']);
							else
							 $appr=approvals(1);	
						} else {
							if($item['REQ_PreToPostStatus']){
								if($selptc=$wpdb->get_results("SELECT * FROM pre_travel_claim WHERE REQ_Id='". $item['REQ_Id'] ."'")){
									switch ($selptc[0]->PTC_Status){
										case 1:
										 $appr=approvals($selptc[0]->PTC_Status);
										break;
										
										case 2:
										 $appr=approvals($selptc[0]->PTC_Status);
										break;
										
										case 3:
										 $appr=approvals($selptc[0]->PTC_Status);
										break;
									}
								}
							} else {
								if($item['REQ_Status']==2)
								 $appr=approvals(1);
								else
								 $appr=approvals(5);
							}
						
						}
					}
return $appr;
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
'Request_Code' => __('Request Code', 'traveldeskrequest_table_list'),
'Total_Cost' => __('Total Cost', 'traveldeskrequest_table_list'),
'Reporting_Manager_Approval' => __('Reporting Manager Approval', 'traveldeskrequest_table_list'),
'Finance_Approval' => __('Finance Approval', 'traveldeskrequest_table_list'),
'Request_Date' => __('Request Date', 'traveldeskrequest_table_list'),
'Claim_Status' => __('Claim Status', 'traveldeskrequest_table_list'),
'Action' => __('Action', 'traveldeskrequest_table_list'),
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
'Request_Code' => __('Request Code', true),
'Total_Cost' => __('Total Cost', true),
'Reporting_Manager_Approval' => __('Reporting Manager Approval',true),
'Finance_Approval' => __('Finance Approval', true),
'Request_Date' => __('Request Date', true),
'Claim_Status' => __('Claim Status', true),
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
global $q;
global $cmp;
global $query;

$per_page = 14; // constant, how much records will be shown per page

$columns = $this->get_columns();
$hidden = array();
$sortable = $this->get_sortable_columns();

// here we configure table headers, defined in our methods
$this->_column_headers = array($columns, $hidden, $sortable);

// [OPTIONAL] process bulk action if any
$this->process_bulk_action();
$txtReqid = ( isset($_REQUEST['txtReqid']) ) ? $_REQUEST['txtReqid'] : '';
	$reqtype = ( isset($_REQUEST['reqtype']) ) ? $_REQUEST['reqtype'] : 0;
	$selReqstatus	= ( isset($_REQUEST['selReqstatus']) ) ? $_REQUEST['selReqstatus'] : '';
				if($reqtype)
				$q =" AND REQ_Type=$reqtype";
				else
				$q.=" AND REQ_Type IN (2,3,4)";				
				if($txtReqid)
				$q.=" AND REQ_Code='$txtReqid'";			
				if($selReqstatus)
				$q.=" AND REQ_Status=$selReqstatus";

// will be used in pagination settings
//$total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");
// prepare query params, as usual current page, order by and order direction
$paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
$orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'REQ_Id';
$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

// [REQUIRED] define $items array
// notice that last argument is ARRAY_A, so we will retrieve array
if (!empty($_POST["s"])) {
$query = "";
//$q = "";
$search = trim($_POST["s"]);
$searchcol = array(
	'REQ_Code',
	'REQ_Date'
);
$i = 0;
foreach ($searchcol as $col) {
	if ($i == 0) {
		$sqlterm = 'AND';
	} else {
		$sqlterm = 'OR';
	}
	if (!empty($_REQUEST["s"])) {
		$query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
	}
	$i++;
}
$compid = $_SESSION['compid'];
$total_items = count($wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Active !=9 $q " . $query));
$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Active !=9 $q " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
} else {
	$compid = $_SESSION['compid'];
$total_items = count($wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Active !=9 $q " . $query));
	
$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Active !=9 $q " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

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
?>
<style>
.init-invoice{
display:none;
}
</style>