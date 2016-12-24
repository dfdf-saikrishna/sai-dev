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
class Traveldeskdashboard_List_Table extends \WP_List_Table
{
   /**
* [REQUIRED] You must declare constructor and give some basic params
*/
function __construct() {
global $row;
global $supid;
global $status, $page;

parent::__construct(array(
'singular' => 'tdinvoicecreate',
'plural' => 'tdinvoicecreates',
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
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
						
	//$check = if($void) echo $void; if($onclick) echo $onclick; 
	/* $check = if($onclick){ 
		echo $onclick;
	} */
return '<input type="checkbox" name="reqid[]" value="'. $item['REQ_Id'] .'"/>';                        
}

function column_Request_Code($item) {
global $wpdb;
	$compid = $_SESSION['compid'];
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
							$href='/wp-admin/admin.php?page=View-Request&reqid='.$item['REQ_Id'];
							$type='<span style="font-size:10px;">[W/A]</span>';
							$title="Without Approval";
							break;
							
							case 3:
							$href='/wp-admin/admin.php?page=View-Appr-Request&reqid='.$item['REQ_Id'];
							$type='<span style="font-size:10px;">[AR]</span>';
							$title="Approval Required";
							break;
						
							case 4:
							$href='travel-desk-group-request-details.php';
							$type='<span style="font-size:10px;">[G]</span>';
							$title="Group Request Without Approval";
							break;
						}
	
			$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
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
return '<span  width="15%" title="'. $title .'"><a href="'. $href .'">'. $item['REQ_Code'] . $icon .'</span></a>'.$reqdate;
  
// return $reqcode . $type ;
}

function column_Request_Type($item) {
global $wpdb;
	$compid = $_SESSION['compid'];
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
						$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {	
						$EC_Name  = $rowsql->EC_Name; 
                        $MOD_Name =   $rowsql->MOD_Name;
						}
						}else{
						$EC_Name ="";
						$MOD_Name ="";
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
Category</th><tr><td>'. $EC_Name .'&nbsp;&nbsp;' . $MOD_Name .'</td></tr></table>';
else
$EC_Name ='';
	 
return  $type . $EC_Name;

}


function column_nbsp($item) {
global $wpdb;
	$compid = $_SESSION['compid'];
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
						$j=1;
						$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='". $item['REQ_Id'] ."' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
						if(!empty($rddetails)){
						foreach ($rddetails as $rowsql) {
				if ($selrdcs = $wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='". $rowsql->RD_Id ."' AND BS_Status=3 AND BS_Active=1")) {
										?>
                            <form method="post" id="cancellationForm<?php echo $j; ?>" name="cancellationForm<?php echo $j; ?>" onsubmit="return submitCancellationForm(<?php echo $j; ?>);">
                              <input type="hidden" name="rdid1<?php echo $j; ?>" id="rdid1<?php echo $j; ?>" value="<?php echo $rowsql['RD_Id'] ?>" />
                              <input type="hidden" name="type1<?php echo $j; ?>" id="type1" value="2" />
                              <div id="cancelStatusContainer<?php echo $j; ?>">
                                <?php
						if ($selrdcs->RD_Id) {

							$cancellationstatus.= ($selrdcs->BA_Id == 1) ? bookingStatus($selrdcs->BA_Id) . "<br>" : '';

							$cancellationstatus.= '<b title="cancellation request date">Request Date: </b>' . date('d-M-y (h:i a)', strtotime($selrdcs['BS_Date'])) . "<br>";

							$cancellationstatus.= '----------------------------------<br>';

							$query = "BA_Id IN (4,5,6,7)";
						}
						
						//echo 'Baid='.$selrdcs['BA_Id']; 			


						if ($selrdcs->BA_Id == 4 || $selrdcs->BA_Id == 5 || $selrdcs->BA_Id == 6 || $selrdcs->BA_Id == 7) {

							$cancellationstatus.= bookingStatus($selrdcs->BA_Id);

							$doc = NULL;

							if ($selrdcs->BA_Id == 4 || $selrdcs->BA_Id == 6) {

								$seldocs = $wpdb->get_results("Select * FROM booking_documents WHERE BS_Id='$selrdcs[BS_Id]'", $filename, 0);

								$f = 1;

								foreach ($seldocs as $docs) {

									$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

									$f++;
								}
							}


							switch ($selrdcs->BA_Id) {

								case 4: case 6:
									$cancellationstatus.='<br><b>Cancellation Amnt</b>: ' . IND_money_format($selrdcs->BS_CancellationAmnt) . '.00<br>';
									$cancellationstatus.= $doc;
									$cancellationstatus.= '<b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
									break;

								case 5: case 7:
									$cancellationstatus.= '<br><b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
									break;
							}
																					
																					
																					
                      } else if ($selrdcs->BA_Id == 1) {
                                                                                    ?>
                                <div class="col-sm-12" id="imgareaid2<?php echo $j; ?>"></div>
                                <div class="col-sm-8">
                                  <div class="form-group">
                                    <div>
                                      <select name="selCancActions<?php echo $j; ?>" id="selCancActions<?php echo $j; ?>" class="form-control" onChange="showHideCanc(<?php echo $j; ?>, this.value)">
                                        <option value="">Select</option>
                                        <?php
                                                                                                    $ba = select_all("booking_actions", "*", "$query", $filename, 0);

                                                                                                    foreach ($ba as $barows) {
                                                                                                        ?>
                                        <option value="<?php echo $barows->BA_Id; ?>"><?php echo $barows->BA_Name; ?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-8" id="cancAmntDiv<?php echo $j; ?>" style="display:none;">
                                  <div class="form-group">
                                    <div>
                                      <input type="text" class="form-control"  name="txtCanAmount<?php echo $j; ?>" onKeyUp="return checkCost(this.id)"  id="txtCanAmount<?php echo $j; ?>" />
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-8" id="ticketCancDiv<?php echo $j; ?>" style="display:none;">
                                  <div class="form-group">
                                    <div>
                                      <input type="file" name="fileCanAttach<?php echo $j; ?>[]" id="fileCanAttach<?php echo $j; ?>[]" multiple="true" onchange="return Validate(this.id);">
                                      <!-- //fileinput-->
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div>
                                      <button name="buttonUpdateStatusCanc" id="buttonUpdateStatusCanc<?php echo $j; ?>" style="display:none; width:75px; height:20px; padding-bottom:20px;" type="submit" class="btn btn-link">Update</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div>
                                      <button name="buttonCancelCanc" id="buttonCancelCanc<?php echo $j; ?>" style="display:none; width:75px; height:20px; padding-bottom:20px;" onClick="cancelCancstat(<?php echo $j; ?>)" type="button" class="btn btn-link">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                                <?Php } ?>
                              </div>
                            </form>
                            <?php
									} else {
										$cancellationstatus = bookingStatus(NULL);
									}
                                                                   
                                  $j++;
						
						}
						}else{
						$cancellationstatus = "";
						}
							
	

$cancelstatus = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><tr><th>Cancel Status</th><td>' . $cancellationstatus .'</td></tr></table>';

	 
	
return '<a data-id="'.$item['REQ_Id'].'" class="traveldeskrequestarrow" data-toggle="collapse" href="#collapse"><i class="collapse-caret fa fa-angle-down"></i> </a>'. $cancelstatus; 
}

function column_Quantity($item) {
global $wpdb;
	$compid = $_SESSION['compid'];
$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
						 if ($rowsql->EC_Id == 1) {
							 $From = $rowsql->RD_Cityfrom;
							 $To= $rowsql->RD_Cityto;
							 $Loc = 'FROM:'. $From . '</br>To:' . $To;
                            } else { 
                            $Loc = $rowsql->RD_Cityfrom;
					if ($rowsd = $wpdb->get_results("SELECT SD_Name FROM stay_duration WHERE SD_Id='".$rowsql->SD_Id ."'")) {
                             
							 $Loc = '<br>Stay :' . $rowsd[0]->SD_Name;
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
$bookingStatus="";
$cancellationstatus="";
	$compid = $_SESSION['compid'];
	$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
						
			$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='". $item['REQ_Id'] ."' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");

						$rdids = "";

$j = 1;
						
						foreach ($rddetails as $rowsql) {			
			$selrdbs = $wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='". $rowsql->RD_Id ."' AND BS_Status=1 AND BS_Active=1");
			if ($selrdbs->RD_Id) {
                                                                        ?>
                            <form method="post" id="bookingForm<?php echo $j; ?>" name="bookingForm<?php echo $j; ?>" onsubmit="return submitBookingForm(<?php echo $j; ?>);">
                              <input type="hidden" name="rdid<?php echo $j; ?>" id="rdid<?php echo $j; ?>" value="<?php echo $item['RD_Id'] ?>" />
                              <input type="hidden" name="type<?php echo $j; ?>" id="type" value="1" />
                              <div id="bookingStatusContainer<?php echo $j; ?>">
                                <?php
				if ($selrdbs->RD_Id) {

					$bookingStatus .= ($selrdbs->BA_Id == 1) ? bookingStatus($selrdbs->BA_Id) . "<br>" : '';

					$bookingStatus .= '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs->BS_Date)) . "<br>";

					$bookingStatus .= '----------------------------------<br>';

					$query = "BA_Id IN (2,3)";
				}

				if ($selrdbs->BA_Id == 2 || $selrdbs->BA_Id == 3) {
					$bookingStatus .= bookingStatus($selrdbs->BA_Id);

					//echo 'baid='.$selrdbs['BA_Id'];

					$imdir = "../company/upload/$compid/bills_tickets/";


					$doc = NULL;

					if ($selrdbs->BA_Id == 2) {

						$seldocs = $wpdb->get_results("Select * FROM booking_documents WHERE BS_Id='". $selrdbs->BS_Id ."'");

						$f = 1;

						foreach ($seldocs as $docs) {

							$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

							$f++;
						}
					}



					switch ($selrdbs->BA_Id) {

						case 2:
							$bookingStatus .= '<br>';
							 $bookingStatus .= '<b>Booked Amnt:</b> ' . IND_money_format($selrdbs->BS_TicketAmnt) . '.00</span><br>';
							$bookingStatus .= $doc;
							$bookingStatus .= '<b>Booked Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate));
							break;

						case 3:
							$bookingStatus .= '<br>';
							$bookingStatus .= '<strong>Failed Date</strong>: ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate));
							break;
					}
				} else if ($selrdbs->BA_Id == 1) {
                                                                                    ?>
                                <div class="col-sm-8" id="imgareaid<?php echo $j; ?>"></div>
                                <div class="col-sm-8" >
                                  <div class="form-group">
                                    <div>
                                    <?php $bookingStatus .=  '<select name="selBookingActions'.$j.'" id="selBookingActions'.$j.'" class="form-control" onchange="showHideBooking('.$j.', this.value)" >
                                        <option value="">Select</option>'; ?>
                                        <?php
											$ba = $wpdb->get_results("Select * FROM booking_actions WHERE $query");

											foreach ($ba as $barows) { ?>
                                      <?php $bookingStatus .=  '<option value="'. $barows->BA_Id .'">'. $barows->BA_Name .'</option>'; ?>
                                        <?php } ?>
                                      <?php $bookingStatus .=  '</select>'; ?>
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-8" style="display:none;" id="amntDiv<?php echo $j; ?>">
                                  <div class="form-group">
                                    <div>
                                      <input type="text" class="form-control"  name="txtAmount<?php echo $j; ?>" onkeyup="return checkCost(this.id)"  id="txtAmount<?php echo $j; ?>" />
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-8" id="ticketUploaddiv<?php echo $j; ?>" style="display:none;">
                                  <div class="form-group">
                                    <div>
                                      <input type="file" multiple="true" name="fileattach<?php echo $j; ?>[]" id="fileattach<?php echo $j; ?>[]" onchange="return Validate(this.id);">
                                      <!-- //fileinput-->
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div>
                                      <button name="buttonUpdateStatus" id="buttonUpdateStatus<?php echo $j; ?>" value="<?php echo $j; ?>" style="display:none; width:75px; height:20px; padding-bottom:20px;" type="submit" class="btn btn-link">Update</button>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div>
                                      <button name="buttonCancel" id="buttonCancel<?php echo $j; ?>" value="<?php echo $j; ?>" style="display:none; width:75px; height:20px; padding-bottom:20px;" onclick="cancelBookingstat(this.value)" type="button" class="btn btn-link">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              <?php  } ?>
                              </div>
                            </form>
                            <?php
								} else {

									$bookingStatus .= bookingStatus(NULL);
								}
								 $j++; 
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
//if(!empty($bookingstatus))
$bookingstatuss = '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"><th>Booking Status</th><tr><td>'. $bookingStatus .'</td></tr></table>';
//else
//$bookingstatuss ='';					
								
return $totalcosts . $bookingstatuss;
}

function column_Date($item) {
	global $wpdb;
	$compid = $_SESSION['compid'];
	$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id),rd.*,bs.* FROM request_details rd,booking_status bs WHERE rd.REQ_Id='".$item['REQ_Id']."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND BS_Active=1 AND RD_Status=1");
				
				$void=0; $icon=0; $onclick=NULL;

				foreach ($getvals as $values) {
					if($values->BS_Status != 3)
					$totalcosts ="";	
					$totalcosts+= $values->RD_Cost;									
					$rdids = "";	
					$rdids.=$values->RD_Id . ",";
														
					if($values->BA_Id == 1)
					$void += 1;
					
				}
				
				//echo 'totalcost='.$totalcosts."<br>";

				$rdids = rtrim($rdids, ",");

				if (!$rdids)
				$rdids = "'" . "'";
				
				if($void){
				
					$void='onclick="alert(\'Selected request is not closed. Please close it and then select for claim.\'); return false;"';
				
				} else {
				
					$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE  tdc.COM_Id='$compid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id='".$item['REQ_Id']."'");
		
					//echo 'count='.count($selclmreqid)."<br>";
					
					if(count($selclmreqid) != "0"){
						$onclick='onclick="alert(\'Selected request is already sent for claims. Please select another request.\'); return false;"';
						$icon=1;
					}
					foreach($selclmreqid as $selclmreqid){				
					if($selclmreqid->TDC_Status==2)
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
	$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='". $item['REQ_Id'] ."' AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");
						$rdids = "";
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
$total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query));
$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query . "ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
} else {
	$compid = $_SESSION['compid'];
$total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query));
	
$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id"
        . " AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 " . $query . "ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

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