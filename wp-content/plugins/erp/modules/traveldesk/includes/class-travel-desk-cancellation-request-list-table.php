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
class Travel_Desk_Cancellation_Request_List_Table extends \WP_List_Table
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
	<div class="alignleft actions">
        <a href="#" id="traveldeskrise_invoice" class="button button-primary">Rise Invoice</a> 
        </div>
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
			$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {	
						$date = date('d-M-Y', strtotime($rowsql->RD_Dateoftravel));
						$RD_Description = stripslashes($rowsql->RD_Description);
						}
						}else{
							$date = "";
							$RD_Description="";
						}						
	}
	 if($icon==1){
		 $title = 'sent for claims'; 
		 $icon = '<i class="fa fa-thumbs-o-up"></i>';
	 }else if($icon==2){
		 $title = 'claimed'; 
		 $icon ='<i class="fa fa-thumbs-up"></i>';
	 }else{
		$title = ''; 
		 $icon =''; 
	 } 
if(!empty($date))
$reqdate = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"  style="font-size:11px;"><th style="width:160px!important">Date & Expense Desc</th><tr><td>'. $date .'</td></tr></table>';
else
$reqdate ='';
return '<span  width="15%" title="'. $title .'">'. $item['REQ_Code'] . $icon .'</span>'.$reqdate;

// return $reqcode . $type ;
}

function column_Request_Type($item) {
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
						$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {	
						$EC_Name  = $rowsql['EC_Name']; 
                        $MOD_Name =   $rowsql['MOD_Name'];
						}
						}else{
						$EC_Name ="";
						$MOD_Name ="";
						}
							
	}
	 if($icon==1){
		 $title = 'sent for claims'; 
		 $icon = '<i class="fa fa-thumbs-o-up"></i>';
	 }else if($icon==2){
		 $title = 'claimed'; 
		 $icon ='<i class="fa fa-thumbs-up"></i>';
	 }else{
		$title = ''; 
		 $icon =''; 
	 } 
if(!empty($EC_Name) || !empty($MOD_Name))
$EC_Name = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"  style="font-size:11px;"><th style="width:160px!important">Expense 
Category</th><tr><td>'. $EC_Name . $MOD_Name .'</td></tr></table>';
else
$EC_Name ='';
	 
return  $type . $EC_Name;

}


function column_nbsp($item) {
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
						
						$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {

						$cancellationstatus = "";
						}
						}else{
						$cancellationstatus = "";
						}
							
	}

if(!empty($cancellationstatus))
$cancellationstatus = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><tr><th>Cancel Status</th><td>' . $cancellationstatus .'</td></tr></table>';
else
$cancellationstatus ='';
	 
	
return '<a data-id="'.$item['REQ_Id'].'" class="traveldeskrequestarrow" data-toggle="collapse" href="#collapse"><i class="collapse-caret fa fa-angle-down"></i> </a>'. $cancellationstatus; 
}

function column_Quantity($item) {
global $wpdb;
	$compid = $_SESSION['compid'];
	$selsql = $wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 ORDER BY bs.BS_Id DESC LIMIT 0, 10");

	foreach ($selsql as $rowsql) {
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id=$item[REQ_Id] AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
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
				 
	
	$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {	
						 if ($rowsql->EC_Id == 1) {
							 $From = $rowsql->RD_Cityfrom;
							 $To= $rowsql->RD_Cityto;
							 $Loc = $From . $To;
                            } else { 
                            $Loc = $rowsql->RD_Cityfrom;
					if ($rowsd = $wpdb->get_results("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql[SD_Id]'")) {
                             $Loc = '<br>Stay :' . $rowsd->SD_Name;
					}
						}
						}
						}else{
							 $Loc = "";
						}
	if(!empty($Loc))
$Loc = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><th>Placce</th><tr><td>'. $Loc .'</td></tr></table>';
else
$Loc ='';					
			
//return count($getvals).$Loc;
return  '<span class="status-2" style="padding:5px 8px !important;border-radius: 15px;line-height:1">'. count($getvals) .'</span>'.$Loc; 
}

function column_Quote_Amount($item) {
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
					
				}else{
					$totalcosts ="";
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
						
						$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {

						$bookingstatus = "";
						}
						}else{
						$bookingstatus = "";
						}
							
	}
	 if($icon==1){
		 $title = 'sent for claims'; 
		 $icon = '<i class="fa fa-thumbs-o-up"></i>';
	 }else if($icon==2){
		 $title = 'claimed'; 
		 $icon ='<i class="fa fa-thumbs-up"></i>';
	 }else{
		$title = ''; 
		 $icon =''; 
	 }
if(!empty($bookingstatus))
$bookingstatus = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><th>Booking Status</th><tr><td>'. $bookingstatus .'</td></tr></table>';
else
$bookingstatus ='';					
								
return $totalcosts . $bookingstatus;
}

function column_Date($item) {
	global $wpdb;
	$compid = $_SESSION['compid'];
	$selsql = $wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 ORDER BY bs.BS_Id DESC LIMIT 0, 10");

	foreach ($selsql as $rowsql) {
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id=$item[REQ_Id] AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
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
				 
	
	$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$item[REQ_Id]' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {	
						$RD_Cost = IND_money_format($rowsql->RD_Cost) . ".00";
						}
						}else{
							 $RD_Cost = "";
						}
	
if(!empty($RD_Cost))
$RD_Cost = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><th>Estimated Cost</th><tr><td>'. $RD_Cost .'</td></tr></table>';
else
$RD_Cost ='';	
	

return date('d-M-Y', strtotime($item['REQ_Date'])).$RD_Cost;
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
'Request_Type' => __('Request Type', 'companyinvoicecreate_table_list'),
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
'Request_Type' => __('Request Type', true),
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
$orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'bs.BS_Id';
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
$compid = $_SESSION['compid'];
$total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' $q AND " . "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1" . $query));
$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' $q AND "
        . "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
} else {
	$compid = $_SESSION['compid'];
$total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' $q AND "
        . "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query));
	
$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' $q AND "
        . "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

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