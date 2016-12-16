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
class Travel_Agent_Company_Invoicecreate_Table extends \WP_List_Table {
/**
* [REQUIRED] You must declare constructor and give some basic params
*/
function __construct() {
global $row;
global $supid;
global $status, $page;

parent::__construct(array(
'singular' => 'companyinvoicecreate',
'plural' => 'companyinvoicecreates',
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
	}?>
	<div class="alignleft actions">
        <a href="#" id="rise_invoice" class="button button-primary">Rise Invoice</a> 
        </div>
		<?php
	$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
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
			<label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
			<select name="selFilter" id="selFilter" class="erp-select2">
			<option value="">All</option>
			<option value="1" <?php if ($type == 1) echo 'selected="selected"'; ?> >Pending Booking Requests</option>
			<option value="2" <?php if ($type == 2) echo 'selected="selected"'; ?>>Pending Cancellation Requests</option>
			<option value="3" <?php if ($type == 3) echo 'selected="selected"'; ?>>All Booking Requests</option>
			<option value="4" <?php if ($type == 4) echo 'selected="selected"'; ?>>All Cancellation Requests</option>
			</select>

			<?php
			submit_button(__('Search'), 'button', 'filter_company', false);
			echo '</div>'; 
			?>
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
$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
$cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
$void = $badge = $icon = $onclick = $selclmreqid = null ; 	
switch($item['REQ_Active']){		
case 1:	
$reqcode = $item['REQ_Code'];								
break;
case 9:
$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
break;
}
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

//$getvals = rawSelectQuery($selsql, $filename, $show = false);
$getvals = $selsql;

$reqtype = $item['REQ_Type'];

$alertBadge = 0;

switch ($item['REQ_Type']){
case 2:
$href='travel-agent-request-details.php';
$type='<span style="font-size:10px;">[E]</span>';
$title="Employee Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 					
break;
case 4:
$href='travel-agent-group-request-details.php';
$type='<span style="font-size:10px;">[G]</span>';
$title="Group Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
break;
}

$disabled = 0;

$baidsarry = explode(",", $getvals[0]->baids);

if( in_array(1, $baidsarry) ) {

$badge = '<span class="status-1">'.$getvals[0]->rdCnt.'</span>'; 

$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';

$disabled = 1;
}
else { 
$badge = '<span class="status-2">'.$getvals[0]->rdCnt.'</span>'; 

$selclmreqid = $wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmp' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='". $item['REQ_Id'] ."'");
if(!empty($selclmreqid[0]->TDC_Status)){
switch($selclmreqid[0]->TDC_Status){

case 1:

$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';

$icon=1;

$disabled = 1;

break;


case 2:

$icon=2;

$disabled = 1;

break;
}
}
}
$check = $disabled ? 'disabled="disabled"': null; $void .' '.$onclick;
//$check = $disabled ? 'disabled="disabled"': null;
return '<input type="checkbox" name="reqid[]" value="'. $item['REQ_Id'] .'" '. $check .'/>';                        
}

function column_Request_Code($item) {
$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
$cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
$void = $badge = $icon = $onclick = $selclmreqid = null ; 	
switch($item['REQ_Active']){		
case 1:	
$reqcode = $item['REQ_Code'];								
break;
case 9:
$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
break;
}
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

//$getvals = rawSelectQuery($selsql, $filename, $show = false);
$getvals = $selsql;

$reqtype = $item['REQ_Type'];

$alertBadge = 0;

switch ($item['REQ_Type']){
case 2:
$href='travel-agent-request-details.php';
$type='<span style="font-size:10px;">[E]</span>';
$title="Employee Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 					
break;
case 4:
$href='travel-agent-group-request-details.php';
$type='<span style="font-size:10px;">[G]</span>';
$title="Group Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
break;
}

$disabled = 0;

$baidsarry = explode(",", $getvals[0]->baids);

if( in_array(1, $baidsarry) ) {

$badge = '<span class="status-1">'.$getvals[0]->rdCnt.'</span>'; 

$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';

$disabled = 1;
}
else { 
$badge = '<span class="status-2">'.$getvals[0]->rdCnt.'</span>'; 

$selclmreqid = $wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmp' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='". $item['REQ_Id'] ."'");
if(!empty($selclmreqid[0]->TDC_Status)){
switch($selclmreqid[0]->TDC_Status){

case 1:

$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';

$icon=1;

$disabled = 1;

break;


case 2:

$icon=2;

$disabled = 1;

break;
}
}
}

if($getvals[0]->rdids){
global $wpdb;
$rdids = $getvals[0]->rdids;
$rddetails = $wpdb->get_results("SELECT * FROM  request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");

$rdids = "";
foreach ($rddetails as $rowsql) {
$RDDescription = stripslashes($rowsql->RD_Description); '<br />'; 

$date = date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); '<br />';
if($rowsql->RD_Status == 9){
$date = removedByClient();
} 
}
}

if($icon==1){ 
$icon =  '<i class="fa fa-thumbs-o-up"></i>'; 
$title = "Invoice created";
}else if($icon==2){ 
$icon = '<i class="fa fa-thumbs-up"></i>'; 
$title = "claimed"; 
}

return '<span  width="15%" title="'. $title .'"><a href="'. $href .'&reqid='. $item['REQ_Id'] .'" target="_blank">'. $reqcode . '</a>'. $type . $icon .'</span>' . '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"  style="font-size:11px;"><th style="width:160px!important">Date & Expense Desc</th><tr><td>'. $date .'<div style="height:40px; overflow-y:auto;">'. $RDDescription .'</div></td></tr></table>';

// return $reqcode . $type ;
}

function column_Employee_No($item) {
$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
$cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
$void = $badge = $icon = $onclick = $selclmreqid = null ; 	
switch($item['REQ_Active']){		
case 1:	
$reqcode = $item['REQ_Code'];								
break;
case 9:
$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
break;
}
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

//$getvals = rawSelectQuery($selsql, $filename, $show = false);
$getvals = $selsql;

$reqtype = $item['REQ_Type'];

$alertBadge = 0;

switch ($item['REQ_Type']){
case 2:
$href='travel-agent-request-details.php';
$type='<span style="font-size:10px;">[E]</span>';
$title="Employee Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 					
break;
case 4:
$href='travel-agent-group-request-details.php';
$type='<span style="font-size:10px;">[G]</span>';
$title="Group Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
break;
}

$disabled = 0;

$baidsarry = explode(",", $getvals[0]->baids);

if( in_array(1, $baidsarry) ) {

$badge = '<span class="status-1">'.$getvals[0]->rdCnt.'</span>'; 

$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';

$disabled = 1;
}
else { 
$badge = '<span class="status-2">'.$getvals[0]->rdCnt.'</span>'; 

$selclmreqid = $wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmp' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='". $item['REQ_Id'] ."'");
if(!empty($selclmreqid[0]->TDC_Status)){
switch($selclmreqid[0]->TDC_Status){

case 1:

$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';

$icon=1;

$disabled = 1;

break;


case 2:

$icon=2;

$disabled = 1;

break;
}
}
}
if($getvals[0]->rdids){
global $wpdb;
$rdids = $getvals[0]->rdids;
$rddetails = $wpdb->get_results("SELECT * FROM  request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");

$rdids = "";
foreach ($rddetails as $rowsql) {
$expcategory = stripslashes($rowsql->EC_Name); '<br />'; 
$MOD_Name = stripslashes($rowsql->MOD_Name); '<br />'; 
}
}

return $getvals[0]->empCnt .'<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse" class="table table-bordered table-hover" style="font-size:11px;"><th width="10%">Expense Category</th><tr><td width="5%">'. $expcategory  .'&nbsp;&nbsp' . $MOD_Name  .'</td></tr></table>';
}


function column_nbsp($item) {
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

$getvals = $selsql;
if($getvals[0]->rdids){
global $wpdb;
$rdids = $getvals[0]->rdids;
$rddetails = $wpdb->get_results("SELECT * FROM  request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");

$rdids = "";
foreach ($rddetails as $rowsql) {
//CANCELLATION STATUS //
		
				$selrdcs = $wpdb->get_results("SELECT * FROM booking_status WHERE  RD_Id='". $rowsql->RD_Id ."' AND BS_Status=3 AND BS_Active=1");
				if(!empty($selrdcs->RD_Id)){
				if ($selrdcs->RD_Id) {

					$cancellation =  ($selrdcs->BA_Id == 1) ? bookingStatus($selrdcs->BA_Id) . "<br>" : '';

					$cancellation.= '<b title="cancellation request date">Request Date: </b>' . date('d-M-y (h:i a)', strtotime($selrdcs->BS_Date)) . "<br>";

					$cancellation.= '----------------------------------<br>';

					$query = "BA_Id IN (4,5)";
					$cancellationstatus = $cancellation;
				}
				}
			if(!empty($selrdcs->BA_Id)){
			$cancellationstatus.= bookingStatus($selrdcs->BA_Id);
			}else{
			$cancellationstatus= bookingStatus(0);	
			}
			if(!empty($selrdcs->BA_Id)){
			switch ($selrdcs->BA_Id) {

				case 4: case 6:
					
					$doc = NULL;
				
					$seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='". $selrdcs->BS_Id ."'");

					$f = 1;

					foreach ($seldocs as $docs) {

						$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

						$f++;
					}
					
					$cancellation = '<br><b>Cancellation Amnt</b>: ' . IND_money_format($selrdcs->BS_CancellationAmnt) . '.00<br>';
					$cancellation.= $doc;
					$cancellation.= '<b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
					$cancellationstatus.= $cancellation;
					break;

				case 5: case 7:
					$cancellation = '<br><b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs[0]->BA_ActionDate));
					$cancellationstatus.= $cancellation;
					break;
			}
			}
				
}
}

					

return '<a data-id="'.$item['REQ_Id'].'" class="companyinvoicearrow" data-toggle="collapse" href="#collapse"><i class="collapse-caret fa fa-angle-down"></i> </a>'. '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><tr><td>' . $cancellationstatus .'</td></tr></table>';

}

function column_Quantity($item) {
$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
$cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
$void = $badge = $icon = $onclick = $selclmreqid = null ; 	
switch($item['REQ_Active']){		
case 1:	
$reqcode = $item['REQ_Code'];								
break;
case 9:
$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
break;
}
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

//$getvals = rawSelectQuery($selsql, $filename, $show = false);
$getvals = $selsql;

$reqtype = $item['REQ_Type'];

$alertBadge = 0;

switch ($item['REQ_Type']){
case 2:
$href='travel-agent-request-details.php';
$type='<span style="font-size:10px;">[E]</span>';
$title="Employee Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 					
break;
case 4:
$href='travel-agent-group-request-details.php';
$type='<span style="font-size:10px;">[G]</span>';
$title="Group Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
break;
}

$disabled = 0;

$baidsarry = explode(",", $getvals[0]->baids);

if( in_array(1, $baidsarry) ) {

$badge = '<span class="status-1" style="padding:5px 8px !important;border-radius: 15px;line-height:1">'.$getvals[0]->rdCnt.'</span>'; 

$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';

$disabled = 1;
}
else { 
$badge = '<span class="status-2" style="padding:5px 8px !important;border-radius: 15px;line-height:1">'.$getvals[0]->rdCnt.'</span>'; 

$selclmreqid = $wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmp' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='". $item['REQ_Id'] ."'");
if(!empty($selclmreqid[0]->TDC_Status)){
switch($selclmreqid[0]->TDC_Status){

case 1:

$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';

$icon=1;

$disabled = 1;

break;


case 2:

$icon=2;

$disabled = 1;

break;
}
}
}

if($getvals[0]->rdids){
global $wpdb;
$rdids = $getvals[0]->rdids;
$rddetails = $wpdb->get_results("SELECT * FROM  request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");

$rdids = "";
foreach ($rddetails as $rowsql) {
if($rowsql->EC_Id==1) {
			
			$Place = '<b>From:</b> '.$rowsql->RD_Cityfrom.'<br />
					<b>To:</b> '.$rowsql->RD_Cityto;						
				
				} else {
				
					$Place = '<b>Loc:</b> '.$rowsql->RD_Cityfrom;
					
					if ($rowsd=$wpdb->get_results("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql->SD_Id'")) {
					
						$Place = '<br>Stay :'.$rowsd[0]->SD_Name;
							
					}
				
				}
}
}


return $badge .'<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse" style="font-size:11px;"><th width="10%">Place</th><tr><td width="10%">'. $Place .'</td></tr></table>';
}
function column_Quote_Amount($item) {
$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
$cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0;
$void = $badge = $icon = $onclick = $selclmreqid = null ; 	
switch($item['REQ_Active']){		
case 1:	
$reqcode = $item['REQ_Code'];								
break;
case 9:
$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
break;
}
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

//$getvals = rawSelectQuery($selsql, $filename, $show = false);
$getvals = $selsql;

$reqtype = $item['REQ_Type'];

$alertBadge = 0;

switch ($item['REQ_Type']){
case 2:
$href='travel-agent-request-details.php';
$type='<span style="font-size:10px;">[E]</span>';
$title="Employee Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 					
break;
case 4:
$href='travel-agent-group-request-details.php';
$type='<span style="font-size:10px;">[G]</span>';
$title="Group Request";
$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
break;
}

$disabled = 0;

$baidsarry = explode(",", $getvals[0]->baids);

if( in_array(1, $baidsarry) ) {

$badge = '<span class="status-1">'.$getvals[0]->rdCnt.'</span>'; 

$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';

$disabled = 1;
}
else { 
$badge = '<span class="status-2">'.$getvals[0]->rdCnt.'</span>'; 

$selclmreqid = $wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmp' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='". $item['REQ_Id'] ."'");
if(!empty($selclmreqid[0]->TDC_Status)){
switch($selclmreqid[0]->TDC_Status){

case 1:

$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';

$icon=1;

$disabled = 1;

break;


case 2:

$icon=2;

$disabled = 1;

break;
}
}
}

if($getvals[0]->rdids){
global $wpdb;
$rdids = $getvals[0]->rdids;
$rddetails = $wpdb->get_results("SELECT * FROM  request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");

$rdids = "";
foreach ($rddetails as $rowsql) {
// BOOKING STATUS STATUS //
		   
	$selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='".$rowsql->RD_Id."' AND BS_Status=1 AND BS_Active=1");
				
		if ($selrdbs[0]->RD_Id) {

			$booking= ($selrdbs[0]->BA_Id == 1) ? bookingStatus($selrdbs[0]->BA_Id) . "<br>" : '';

			$booking.= '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BS_Date)) . "<br>";

			$booking.= '----------------------------------<br>';
			
			$query = "BA_Id IN (2,3)";
			$bookingstatus = $booking;
			
		}
			$bookingstatus.= bookingStatus($selrdbs[0]->BA_Id);
				
			
			//echo 'baid='.$selrdbs['BA_Id'];

			$imdir = "../company/upload/$cmp/bills_tickets/";
			switch ($selrdbs[0]->BA_Id) {

				case 2:
					$doc = NULL;
				
					$seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='". $selrdbs[0]->BS_Id ."'");

					$f = 1;

					foreach ($seldocs as $docs) {

						$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

						$f++;
					}
					$booking = '<br>';
					$booking.='<b>Booked Amnt:</b> ' . IND_money_format($selrdbs[0]->BS_TicketAmnt) . '.00</span><br>';
					$booking.=$doc;
					$booking.= '<b>Booked Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
					$bookingstatus.= $booking;
					break;

				case 3:
					$booking = '<br>';
					$booking.= '<strong>Failed Date</strong>: ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
					$bookingstatus.= $booking;
					break;
			}
}
}

return $totalcosts .'<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><th>Booking Status</th><tr><td>'. $bookingstatus .'</td></tr></table>';
}

function column_Date($item) {
$type = ( isset($_REQUEST['selFilter']) ) ? $_REQUEST['selFilter'] : 0;
$cmp = ( isset($_REQUEST['filter_cmp']) ) ? $_REQUEST['filter_cmp'] : 0; 	
global $wpdb;
$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id, CHAR(8))) AS rdids, COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
((SUM(rd.RD_Cost)		*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdcost,((SUM(rd.RD_TotalCost)	*	COUNT(DISTINCT rd.RD_Id)) / COUNT(*)) as rdGrpcost,
GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id, CHAR(8))) AS baids,  bs.BA_Id AS baid FROM requests req LEFT JOIN  request_details rd ON req.REQ_Id = rd.REQ_Id
LEFT JOIN  request_employee re ON req.REQ_Id = re.REQ_Id LEFT JOIN booking_status bs ON rd.RD_Id = bs.RD_Id WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
AND BS_Active = 1 GROUP BY req.REQ_Id");

//$getvals = rawSelectQuery($selsql, $filename, $show = false);
$getvals = $selsql;
$reqtype =	$item['REQ_Type'];
if($getvals[0]->rdids){
global $wpdb;
$rdids = $getvals[0]->rdids;
$rddetails = $wpdb->get_results("SELECT * FROM  request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");

$rdids = "";
foreach ($rddetails as $rowsql) {
//$reqtype = $rowsql[0]->REQ_Type;
$rdcost = null;
				
			  //echo $reqtype;
				
				switch($reqtype){
				
					case 2:
						$RD_Cost = IND_money_format($rowsql->RD_Cost);
					break;
					
					case 4:
						$RD_Cost = 'Unit Cost - '.IND_money_format($rowsql->RD_Cost) . '<br>'; 
						$RD_Cost = 'Total Cost - '.IND_money_format($rowsql->RD_TotalCost);
						
					break;
					
					
				
				}
}
}



return date('d-M-Y', strtotime($item['REQ_Date'])).'<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><th>Estimated Cost</th><tr><td>'. $RD_Cost .'</td></tr></table>';
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
//'SlNo' => __('Sl.No.', 'companyinvoicecreate_table_list'),
'cb' =>   __('', 'companyinvoicecreate_table_list'),
'Request_Code' => __('Request Code', 'companyinvoicecreate_table_list'),
'Employee_No' => __('Employee No.s', 'companyinvoicecreate_table_list'),
'Quantity' => __('Quantity', 'companyinvoicecreate_table_list'),
'Date' => __('Date', 'companyinvoicecreate_table_list'),
'Quote_Amount' => __('Quote_Amount', 'companyinvoicecreate_table_list'),
'nbsp' => __('&nbsp;', 'companyinvoicecreate_table_list'),
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
'&nbsp;' => __('&nbsp;', true),
'Request_Code' => __('Request Code', true),
'Employee_No' => __('Employee No.s', true),
'Quantity' => __('Quantity',true),
'Date' => __('Date', true),
'Quote_Amount' => __('Quote Amount (Rs)', true),
'&nbsp' => __('&nbsp;', true),
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

// filter company		
if (isset($_REQUEST['filter_cmp']) && $_REQUEST['filter_cmp']) {
$cmp = $_REQUEST['filter_cmp'];
$query.="AND COM_Id='$cmp'";
}
if (isset($_REQUEST['selFilter']) && $_REQUEST['selFilter']) {
$type = $_REQUEST['selFilter'];
switch ($type) {
case 1:
	$q = 'AND bs.BS_Status=1 AND bs.BA_Id=1';
	break;

case 2:
	$q = 'AND bs.BS_Status=3 AND bs.BA_Id=1';
	break;

case 3:
	$q = 'AND bs.BS_Status=1';
	break;

case 4:
	$q = 'AND bs.BS_Status=3';
	break;
}

}

// will be used in pagination settings
//$total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");
// prepare query params, as usual current page, order by and order direction
$paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
$orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'req.REQ_Id';
$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

// [REQUIRED] define $items array
// notice that last argument is ARRAY_A, so we will retrieve array
if (!empty($_POST["s"])) {
$query = "";
//$q = "";
$search = trim($_POST["s"]);
$searchcol = array(
	'REQ_Code'
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
$total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmp' $q AND "
. "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1" . $query));
$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmp' $q AND "
. "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1 " . $query . "ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
} else {
$total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmp' $q AND "
. "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1 " . $query));
	
$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmp' $q AND "
. "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1 " . $query . "ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

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





