<?php
global $wpdb;
global $showProCode;
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
global $totalcost;
$row = $wpdb->get_row("SELECT * FROM requests WHERE REQ_Id='$reqid' AND COM_Id='$compid' AND ((REQ_Active=1 AND REQ_Type=4) OR (REQ_Active=2 AND REQ_Type=4))");
?>
<div class="postbox">
    <div class="inside">
        <!-- Messages -->
        <div style="display:none" id="failure" class="notice notice-error is-dismissible">
        <p id="p-failure"></p>
        </div>
        <div style="display:none" id="success" class="notice notice-success is-dismissible">
            <p id="p-success"></p>
        </div>
        <h2>Employees Group Travel Expense Request Details</h2>
        <code>Request Details Display</code>
        </br></br></br>

        <?php
            require WPERP_TRAVELDESK_VIEWS."/employee-request-details.php";
        ?>
        </br></br></br>
        
               <div class="inside">
               <div class="cols">
                   <label><b>EMPLOYEES :</b></label>
        <?php  
                     $selsql=$wpdb->get_results("SELECT EMP_Code, EMP_Name FROM request_employee re, employees emp WHERE re.REQ_Id=$row->REQ_Id AND re.EMP_Id = emp.EMP_Id AND re.RE_Status=1");

                     $emps	=	NULL;

                     foreach($selsql as $rowsql){

                             $emps	.=	$rowsql->EMP_Code.'--'.$rowsql->EMP_Name.", ";

                     }

                     $emps	=	rtrim($emps, ", ");



                     echo $emps;


                     echo '</div><br><br><br><br>';

        ?>
        <table class="wp-list-table widefat striped admins" id="table1" style="font-size:11px;">
                <thead>
                  <tr>
                    <th width="10%">Date</th>
                    <th width="20%">Expense<br />
                      Description</th>
                    <th width="10%" colspan="2">Expense <br />
                      Category</th>
                    <th width="8%">Place</th>
                    <th width="7%">Total Cost</th>
                    <th width="20%">Booking Status</th>
                    <th  width="20%">Cancellation <br />
                      Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
						  
				$selsql=$wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id=$row->REQ_Id AND rd.RD_Type=2 AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Dateoftravel ASC");		
				
				
				$j=1;
				
				foreach($selsql as $rowsql){
				  ?>
                  <tr>
                    <td align="center"><?php echo date('d-M-Y',strtotime($rowsql->RD_Dateoftravel));?></td>
                    <td><div style="height:40px; overflow-y:auto;"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                    <td width="5%"><?php echo $rowsql->EC_Name; ?></td>
                    <td width="5%"><?php echo $rowsql->MOD_Name; ?></td>
                    <td><?php 
					
						if($rowsql->EC_Id==1) {
							
							echo '<b>From:</b> '.$rowsql->RD_Cityfrom.'<br />
							<b>To:</b> '.$rowsql->RD_Cityto;						
						
						} else {
						
							echo '<b>Loc:</b> '.$rowsql->RD_Cityfrom;
							
							if ($rowsd=$wpdb->get_row("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql->SD_Id'")) {
							
								echo '<br>Stay :'.$rowsd->SD_Name;
									
							}
						
						}
						
						?></td>
                    <td align="right"><?php echo IND_money_format($rowsql->RD_Cost).".00"; ?></td>
                    <!----- BOOKING STATUS STATUS ------>
                    <td><?php               
					 $selrdbs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=1 AND BS_Active=1");
					 
					 
					 if($selrdbs->RD_Id){
					?>
                      <form method="post" id="bookingForm<?php echo $j; ?>" name="bookingForm<?php echo $j; ?>" onsubmit="return submitBookingForm(<?php echo $j; ?>);">
                        <input type="hidden" name="rdid<?php echo $j; ?>" id="rdid<?php echo $j; ?>" value="<?php echo $rowsql->RD_Id ?>" />
                        <input type="hidden" name="type<?php echo $j; ?>" id="type" value="1" />
                        <div id="bookingStatusContainer<?php echo $j; ?>">
                          <?php 
					
							if($selrdbs->BA_Id == 2/* || $selrdbs[BA_Id] == 3  || $selrdbs[BA_Id] ==4 || $selrdbs[BA_Id] ==5*/){
							
								echo bookingStatus($selrdbs->BA_Id);
																
								$imdir="../company/upload/$compid/bills_tickets/";
								
								$seldocs=$wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$selrdbs->BS_Id'");
								
								$doc=NULL;
								
								$f=1;
									
								foreach($seldocs as $docs){
								
									$doc.='<b>Uploaded File no. '.$f.': </b> <a href="download-file.php?file='.$imdir.$docs->BD_Filename.'" class="btn btn-link">download</a><br>';
									
									$f++;
								}
								
								switch ($selrdbs->BA_Id){
								
									case 2:
									echo '<br>';
									echo '<b>Booked Amnt:</b> '.IND_money_format($selrdbs->BS_TicketAmnt).'.00</span><br>';
									echo $doc;
									echo '<b>Booked Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdbs->BA_ActionDate));
									break;
									
									case 3:
									echo '<br>';
									echo '<strong>Failed Date</strong>: '.date('d-M-y (h:i a)',strtotime($selrdbs->BA_ActionDate));
									break;

								}
								
							
							}
					   ?>
                        </div>
                      </form>
                      <?php 
					  
					  } else {
					  
					  	echo bookingStatus(NULL);
					  
					  }
					  
					  ?>
                    </td>
                    <!----- CANCELLATION STATUS ------>
                    <!----- CANCELLATION STATUS ------>
                                <td><?php 
					
					$enableCanc=0;
					
					if($row->REQ_Status==2 &&  ($selrdbs->BA_Id==2)){	

						if($selptc=$wpdb->get_row("SELECT PTC_Id, PTC_Status FROM pre_travel_claim WHERE REQ_Id='$row->REQ_Id'")){
							
							$enableCanc=1;
							
						}
										
						if($selrdbs->RD_Id && !$enableCanc){
						?>
                      <form method="post" id="cancellationForm<?php echo $j; ?>" name="cancellationForm<?php echo $j; ?>" onsubmit="return submitCancellationForm(<?php echo $j; ?>);" enctype="multipart/form-data">
                        <input type="hidden" name="rdid1<?php echo $j; ?>" id="rdid1<?php echo $j; ?>" value="<?php echo $rowsql->RD_Id ?>" />
                        <input type="hidden" name="type1<?php echo $j; ?>" id="type1" value="2" />
                        <div id="cancelStatusContainer<?php echo $j; ?>">
                          <?php 						
											
							if($selrdcs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=3 AND BS_Active=1")){
							
								echo bookingStatus($selrdcs->BA_Id);
								
								
								$doc=NULL;
				
								if($selrdcs->BA_Id==6){                                                                    
									$seldocs=$wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$selrdcs->BS_Id'");
																		
									$f=1;
										
									foreach($seldocs as $docs){
									
										$doc.='<b>Uploaded File no. '.$f.': </b> <a href="'.$imdir.$docs->BD_Filename.'" class="btn btn-link">download</a><br>';
										
										$f++;
									}
								
								}
								
								
								switch ($selrdcs->BA_Id){
								
									case 6:
									echo '<br><b>Cancellation Amnt</b>: '.IND_money_format($selrdcs->BS_CancellationAmnt).'.00<br>';
									echo $doc;
									echo '<b>Cancellation Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdcs->BA_ActionDate));
									break;
									
									case 7:
									echo '<br><b>Cancellation Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdcs->BA_ActionDate));
									break;
	
								}
								
								
							
							} else {
							
								
								 
							
								if(!$row->REQ_Claim) {	   
							
						  ?>
                          <div class="col-sm-12" id="imgareaid2<?php echo $j; ?>"></div>
                          <div class="col-sm-8">
                            <div class="form-group">
                              <div>
                                <select name="selCancActions<?php echo $j; ?>" id="selCancActions<?php echo $j; ?>" class="form-control" onChange="showHideCanc(<?php echo $j; ?>,this.value)">
                                  <option value="-1">Select</option>
                                  <?php                             
								  $ba=$wpdb->get_results("SELECT * FROM booking_actions WHERE BA_Id IN (6,7)");
								  
								  foreach($ba as $barows){
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
                          <input type="hidden" value="<?php echo $j; ?>" name="iteration">
                                <button name="buttonUpdateStatusCanc" id="buttonUpdateStatusCanc<?php echo $j; ?>" style="display:none;" type="submit" value="<?php echo $j; ?>" class="button-primary">Update</button>
                                
                                <button name="buttonCancelCanc" id="buttonCancelCanc<?php echo $j; ?>" style="display:none;" onClick="cancelCancstat(<?php echo $j; ?>)" type="button" class="button erp-button-danger">Cancel</button>
                              
                          <?Php		
						  
						  } else {
						  
						  	echo bookingStatus(NULL);		
						  
						  }	
						  
						  		  
					  } 
					   ?>
                        
                      </form>
                      <?php 
						  } else {
						  	
							echo bookingStatus(NULL);
									  
						  }
					  
					  } else {
					  
					  	echo approvals(5);
						
					  }
					  ?>
                    </td>
                  </tr>
                  <?php 					
					
					//$totalcost+=$rowsql[RD_Cost];
                                        
					if($selrdcs){
						
						$totalcost+=$selrdcs->BS_CancellationAmnt;
					
					} else {
						
						$totalcost+=$selrdbs->BS_TicketAmnt;
					
					}
					
					//echo 'Cancellation='.$selrdcs[BS_CancellationAmnt]."<br>";
							
					//echo 'Booking='.$selrdbs[BS_TicketAmnt]."<br>";
					
					
					$j++;
					
					} ?>
                </tbody>
              </table>
              <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                <tr>
                  <td align="right" width="85%">Claim Amnt (Rs)</td>
                  <td align="center" width="5%">:</td>
                  <td align="right" width="10%"><?php echo IND_money_format($totalcost).".00"; ?></td>
                </tr>
              </table>
              <?PHP 
			
			$claimrow=$wpdb->get_row("SELECT REQ_Id, REQ_Active, REQ_PreToPostStatus, REQ_PreToPostDate FROM requests WHERE REQ_Id='$reqid' AND REQ_Active != 9 AND REQ_Type=4");

			if($claimrow->REQ_Active==2 && $claimrow->REQ_PreToPostStatus==NULL)
			{
			?>
            <form name="claimform" action="action.php" method="post">
                </br>
              <div style="float:right">
                <button type="submit" class="button-primary" name="groupReqClaimButton" id="groupReqClaimButton" value="<?php echo $reqid; ?>">Submit for Claim</button>
              </div>
            </form>
            <?php } else if($claimrow->REQ_Active==1 && $claimrow->REQ_PreToPostStatus==1){ ?>
            <div style="float:right;"> <a class="button-secondary" href="javascript:void(0);" title="<?php echo 'Claim Submitted Date: '.date('d-M-y',strtotime($claimrow->REQ_PreToPostDate)); ?>">Claim Submitted</a> </div>
            <?php } ?>
    </div>
</div>
<script>
    function showHideCanc(flid, bookingActionval)
    {
	var cancAmntDiv		=	'cancAmntDiv'+flid;	
	var txtCancAmnt		=	'txtCanAmount'+flid;
	var ticketCancDiv	=	'ticketCancDiv'+flid;
	var fileCanAttach	=	'fileCanAttach'+flid+'[]';
	var bookingbutton	=	'buttonUpdateStatusCanc'+flid;
	var cancelButton	=	'buttonCancelCanc'+flid;	
	
	//alert(bookingActionval);
	
	switch(bookingActionval){
		
		case '4': case '6':
		document.getElementById(cancAmntDiv).style.display='inline';
		document.getElementById(txtCancAmnt).value=null;
		document.getElementById(txtCancAmnt).placeholder="Cancellation Amount";
		document.getElementById(ticketCancDiv).style.display='inline';
		document.getElementById(fileCanAttach).value=null;
		break;
				
		case '5': case '7':
		document.getElementById(txtCancAmnt).placeholder ="";
		document.getElementById(txtCancAmnt).value=null;
		document.getElementById(cancAmntDiv).style.display='none';
		document.getElementById(fileCanAttach).value=null;		
		document.getElementById(ticketCancDiv).style.display='none';
		break;
		
		
		default:
		document.getElementById(cancAmntDiv).style.display='none';
		document.getElementById(txtCancAmnt).value=null;
		document.getElementById(ticketCancDiv).style.display='none';
		document.getElementById(fileCanAttach).value=null;
		document.getElementById(bookingbutton).style.display='none';
		document.getElementById(cancelButton).style.display='none';
		
		
	}
	
	if(bookingActionval){
	
		document.getElementById(bookingbutton).style.display='inline';
		document.getElementById(cancelButton).style.display='inline';
	
	}
    }
    /*
	
    ---------- CANCELLATION REQUEST ---------------

    */
	
	
function cancelCancstat(buttonId)
{	
	var selCancActions	=	'selCancActions'+buttonId;
	var cancAmntDiv		=	'cancAmntDiv'+buttonId;
	var canAmnt			=	'txtCanAmount'+buttonId;
	var bookingbutton	=	'buttonUpdateStatusCanc'+buttonId;
	var cancelButton	=	'buttonCancelCanc'+buttonId;
	var ticketcandiv	=	'ticketCancDiv'+buttonId;
	var fileCanAttach	=	'fileCanAttach'+buttonId+'[]'
	
	//document.getElementById(selCancActions).value=null;
	document.getElementById(cancAmntDiv).style.display='none';
	document.getElementById(canAmnt).value=null;
	document.getElementById(fileCanAttach).value=null;
	document.getElementById(ticketcandiv).style.display='none';
	document.getElementById(bookingbutton).style.display='none';
	document.getElementById(cancelButton).style.display='none';
	
}
</script>
