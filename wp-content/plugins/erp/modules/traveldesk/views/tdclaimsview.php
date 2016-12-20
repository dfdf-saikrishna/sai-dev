<?php 
global $wpdb;
$tdcid=$_GET['tdcid'];
$compid=$_GET['cmpid'];
?>
<div class="wrap erp erp-hr-employees erp-employee-single">

   <!-- <h2 class="erp-hide-print"><?php _e( 'Invoice Details ', 'erp' );?> </h2>-->
    <div class="erp-single-container erp-hr-employees-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-employees-wrap-inner">
            <div id="erp-area-left-inner">
                <script type="text/javascript">
                    window.wpErpCurrentClaimsview = <?php echo json_encode( $claimsview->to_array() ); ?>
                </script>
<div class="erp-profile-top">
<div class="postbox leads-actions">
<div class="inside">           
<div id="main">
  <!-- //breadcrumb-->
  <div id="content">
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading sm" data-color="theme-inverse">
            <h2>Claims Details</h2>
			<code>Claims Details</code>
          </header>
          <div class="panel-body">
            <div class="invoice">
              <div class="row">
                <div class="col-sm-6">
                  <h3>Reference NO. #<?php echo $claimsview->TDC_ReferenceNo; ?></h3>
                  <span><?php echo date('d F Y', strtotime($claimsview->TDC_Date))?></span> </div>
				  
				  <div >

                <div class="erp-area-right erp-hide-print" style="margin:-108px 0px 0px 125px" >
                  <div class="col-sm-12">
                    <h4>Payment Details :</h4>
                  </div>
                  <div class="col-sm-8"> <strong>Service Tax:</strong> </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="text" class="form-control" parsley-type="number" parsley-required="true" name="txtServiceTax" id="txtServiceTax" readonly="readonly" value="<?php echo $claimsview->TDC_ServiceTax;?>">
                      <span class="input-group-addon" style="width:0% !important">&nbsp;%&nbsp;</span> </div>
                  </div>
                  <div class="clearfix"></div>
                  <br />
                  <div class="col-sm-8"> <strong>Service Charges:</strong> </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="text" class="form-control" parsley-type="digits" parsley-required="true" name="txtServiceChrgs" id="txtServiceChrgs" readonly="readonly" value="<?php echo $claimsview->TDC_ServiceCharges / $claimsview->TDC_Quantity; ?>">
                      <span class="input-group-addon" style="width:0% !important">.00</span> </div>
                  </div>
                  <div class="clearfix"></div>
                  <br />
                  <div class="col-sm-8"> <strong>Account No:</strong> </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <?php 
					  global $wpdb;
					  $bank_details=$wpdb->get_results("SELECT TDBA_AccountNumber FROM travel_desk_bank_account WHERE TDBA_Id='".$claimsview->TDBA_Id."'");
					 ?>
                      <input type="text" class="form-control"  name="txtAccNo" id="txtAccNo" readonly="readonly" parsley-required="true" value="<?php echo $bank_details[0]->TDBA_AccountNumber; ?>">
                    </div>
                  </div>
                </div>
              <div class="clearfix"> </div>
              <hr>
              <br>
              <br>
              <!--  /////////////////////////////////////////-->
              <div class="panel-group">
                <div class="table-responsive">
                  <table class="wp-list-table widefat striped admins">
                    <thead>
                      <tr height="35">
                        <th width="10%" style="text-align:left;">Sl.no. </th>
                        <th width="25%" style="text-align:left; padding-left:5px;">Request Code</th>
                        <th width="10%" style="text-align:left;">Quantity</th>
                        <th width="35%" >Date</th>
                        <th width="20%" style="text-align:left;">Amount (Rs)</th>
                        <th width="5%" style="text-align:left; padding-left:5px;">&nbsp;</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <?php
			  global $wpdb;
			  
			  $selsql=$wpdb->get_results("SELECT * FROM travel_desk_claim_requests tdcr, requests req WHERE TDC_Id='".$tdcid ."' and tdcr.REQ_Id = req.REQ_Id");
				
				$totqty=0; $totalamnt=0;
			  
				$i=1; $j = 1;
				foreach ($selsql as $rowsql) {
				
					?>
                <div class="panel panel-shadow">
                  <header class="panel-heading" style="padding:0 10px">
                    <div class="table-responsive">
						<table class="wp-list-table widefat striped admins" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'">
                        <tr>
                          <td  width="10%"><?php echo $i; ?>. </td>
                          <?php		
				global $wpdb;				
				$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id) FROM request_details rd, booking_status bs WHERE rd.REQ_Id='". $rowsql->REQ_Id ."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3)  AND BS_Active=1 ");
					
					
					foreach ($getvals as $values) {
							
                        $rdids="";
						$totalcosts="";
						$rdids.= $values->RD_Id . ",";
						
						$countAll=count($wpdb->get_results("SELECT BS_Id FROM booking_status WHERE RD_Id='". $values->RD_Id ."' AND BS_Active=1"));
														
						if($countAll==2){
							if($rowcn=$wpdb->get_results("SELECT BA_Id, BS_CancellationAmnt FROM  booking_status WHERE RD_Id='". $values->RD_Id ."' and BS_Status=3 AND BS_Active=1")){

								if($rowcn[0]->BA_Id==4 || $rowcn[0]->BA_Id==6){
									
									$totalcosts	+=	$rowcn[0]->BS_CancellationAmnt;
								
								}
							
							} else {
							
								$rowbk=$wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='". $values->RD_Id ."' and BS_Status=1 AND BS_Active=1");
								
								$totalcosts	+=	$rowbk[0]->BS_TicketAmnt;
							
							}
							
							
						} else {
						
							$rowbk=$wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='". $values->RD_Id ."' and BS_Status=1 AND BS_Active=1");
						
							$totalcosts	+=	$rowbk[0]->BS_TicketAmnt;
						
						}
						
						
						
					}
					
					//echo 'totalcost='.$totalcosts."<br>";

					$rdids = rtrim($rdids, ",");

					if (!$rdids)
					$rdids = "'" . "'";

				   //echo 'Reqids='.$rdids;
				   
				   $totqty += count($getvals);
				   
				   
				   $totalamnt	+=	$totalcosts;
					
						   
            ?>
                          <td  width="25%"><?php echo $rowsql->REQ_Code; ?></td>
                          <td width="10%" style="text-align:center;"><?php echo count($getvals);  ?></td>
                          <td width="35%" style="text-align:center; padding-left:30px;"><?php  echo date('d-M-Y', strtotime($rowsql->REQ_Date)) ?></td>
                          <td width="20%" style="text-align:center;"><?php echo IND_money_format($totalcosts). ".00"; $totalcosts = NULL ; ?></td>
                          <td><a data-toggle="collapse" href="#collapse"><i class="collapse-caret fa fa-angle-down"></i> </a> </td>
                        </tr>
                      </table>
                    </div>
                  </header>
                  <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse" >
                    <div class="panel-body">
                      <div class="table-responsive">
					  <table class="hide-table<?php echo $rowsql->REQ_Id; ?> init-invoice wp-list-table widefat fixed striped collapse"  style="font-size:11px;">
                         <thead>
                            <tr>
                              <th width="10%">Date</th>
                              <th width="20%">Expense<br />
                                Description</th>
                              <th width="10%" colspan="2">Expense <br />
                                Category</th>
                              <th width="10%">Place</th>
                              <th width="10%">Estimated <br />
                                Cost</th>
                              <th width="20%">Booking Status</th>
                              <th  width="20%">Cancellation <br />
                                Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
							
							$imdir = "../company/upload/$compid/bills_tickets/";
							
							$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='".$rowsql->REQ_Id ."' AND rd.RD_Id IN($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id ORDER BY RD_Id ASC");
							$rdids = "";



							foreach ($rddetails as $rowsql) {
							
								?>
                            <tr>
                              <td align="center"><?php echo date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); ?>
                                <?php 
			
								if($rowsql->RD_Status == 9){
								
									echo removedByClient();
								}
							
							?>
                              </td>
                              <td ><div style="height:40px; overflow-y:auto;"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                              <td width="5%"><?php echo $rowsql->EC_Name; ?></td>
                              <td width="5%"><?php echo $rowsql->MOD_Name; ?></td>
                              <td><?php 
							
							
							if($rowsql->EC_Id==1) {
										
										echo '<b>From:</b> '.$rowsql->RD_Cityfrom .'<br />
										<b>To:</b> '.$rowsql->RD_Cityto;						
									
									} else {
									
										echo '<b>Loc:</b> '.$rowsql->RD_Cityfrom;
										
										if ($rowsd=$wpdb->get_results("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql->SD_Id'")) {
										
											echo '<br>Stay :'.$rowsd[0]->SD_Name;
												
										}
									
									}
									
									?></td>
                              <td align="center"><?php 
							  
							  $rdcost = null;
							  $reqtype = null;
							 // echo $reqtype;
							  	
								switch($reqtype){
								
									case 2:
										echo  IND_money_format($rowsql->RD_Cost);
									break;
									
									case 4:
										echo 'Unit Cost - '.IND_money_format($rowsql->RD_Cost) . '<br>'; 
										echo 'Total Cost - '.IND_money_format($rowsql->RD_TotalCost);
										
									break;
									
									
								
								}
							  
							  ?>
                              </td>
                              <!----- BOOKING STATUS STATUS ------>
                              <td><?php
									
									$selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='". $rowsql->RD_Id ."' AND BS_Status=1 AND BS_Active=1");
							if ($selrdbs[0]->RD_Id) {
									
									switch($selrdbs[0]->BA_Id){
									
									
										case 1: {
										
									
											echo ($selrdbs[0]->BA_Id == 1) ? bookingStatus($selrdbs[0]->BA_Id) . "<br>" : '';
		
											echo '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BS_Date)) . "<br>";
				
											echo '----------------------------------<br>';
				
											$query = "BA_Id IN (2,3)";
										
										
										break;
										
										}
										
										
										
										case 2: case 3: {
										
											
											echo bookingStatus($selrdbs[0]->BA_Id);
				
				
											switch ($selrdbs[0]->BA_Id) {
				
												case 2:{
													
													$doc = NULL;  // getting documents uploaded.
													
													$seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='". $selrdbs[0]->BS_Id ."'");
				
													$f = 1;
					
													foreach ($seldocs as $docs) {
					
														$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';
					
														$f++;
													}
												
													echo '<br>';
													echo '<b>Booked Amnt:</b> ' . IND_money_format($selrdbs[0]->BS_TicketAmnt) . '.00</span><br>';
													echo $doc;
													echo '<b>Booked Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
													
													break;
													}
													
				
												case 3:{
													echo '<br>';
													echo '<strong>Failed Date</strong>: ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
													break;
													}
											}
										
										break;
										}
										
									
									}
                                                                        
								  
						 
								} else {

									echo bookingStatus(NULL);
								}
								?>
                              </td>
                              <!----- CANCELLATION STATUS ------>
                              <td><?php
							
							if ($selrdcs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='". $rowsql->RD_Id ."' AND BS_Status=3 AND BS_Active=1")) {
									
									
							if ($selrdcs[0]->RD_Id) {
							
							
							
								switch($selrdcs[0]->BA_Id){
								
									case 1: {
										echo bookingStatus(NULL);
									break;
									}
									
									
									case 4: case 5:{
									
										echo bookingStatus($selrdcs[0]->BA_Id);

		
										switch ($selrdcs[0]->BA_Id) {
		
											case 4: {
											
												$doc = NULL;
											
												$seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='".$selrdcs[0]->BS_Id."'");
		
												$f = 1;
			
												foreach ($seldocs as $docs) {
			
													$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';
			
													$f++;
												}
											
												echo '<br><b>Cancellation Amnt</b>: ' . IND_money_format($selrdcs[0]->BS_CancellationAmnt) . '.00<br>';
												echo $doc;
												echo '<b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs[0]->BA_ActionDate));
												break;
												}
		
											case 5:{
												echo '<br><b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs[0]->BA_ActionDate));
												break;
												}
										}
										
									break;
									}
								
								}

								
							}

 
									 
								} else {
									echo bookingStatus(NULL);
								}
								
								
								
								?>
                              </td>
                            </tr>
                            <?php
							$j++;
						}
						?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- //panel-body -->
                  </div>
                  <!-- //panel-collapse -->
                </div>
                <?php
                                    $i++;
                                }
 
                                ?>
                <!-- //panel -->
              </div>
              <!-- ////////////////////////////////////////-->
              <br>
              <br>
              <div class="row">
                <div class="col-sm-6">
                  <!--<div class="align-lg-left"> 795 Park Ave, Suite 120 <br>
                    San Francisco, CA 94107 <br>
                    P: (234) 145-1810 <br>
                    Full Name <br>
                    first.last@email.com </div>-->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Invoice No.</label>
                      <div>
                        <input type="text" name="txtInvoiceNo" id="txtInvoiceNo" class="form-control" disabled="disabled" value="<?php echo $claimsview->TDC_InvoiceNo; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Invoice Doc.</label>
                      <div> <a href="download-file.php?file=../company/upload/<?php echo $compid; ?>/bills_tickets/<?php echo $claimsview->TDC_Filename; ?>">download</a> </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Remarks</label>
                      <div>
                        <textarea data-height="auto" name="txtaRemarks" id="txtaRemarks" class="form-control" disabled="disabled"><?php echo stripslashes($claimsview->TDC_Remarks) ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <p>&nbsp;</p>
                </div>
				<div class="erp-area-right erp-hide-print">
                <div class="col-sm-6">
                  <div class="align-lg-right" style="margin:-200px 0px 0px 125px;">
                    <ul>
                      <li> Total Quantity: <strong><?php echo $totqty; ?></strong> </li>
                      <?php 
					  	$servTax=$claimsview->TDC_ServiceCharges * ($claimsview->TDC_ServiceTax/100);
						
					  ?>
                      <li id="servicetaxlistid">Service Tax: <strong id="servicetaxid"><?php echo $servTax ?></strong></li>
                      <li id="serviceamntlistid">Service Charges: <strong id="servicechargesid"><?php echo $claimsview->TDC_ServiceCharges; ?></strong></li>
                      <li> Total amount: <strong><?php echo IND_money_format($totalamnt + $servTax + $claimsview->TDC_ServiceCharges). '.00'; ?> </strong> </li>
                      <!--  <li> Discount: ----- </li>
                        <li> Grand Total: <strong>$3,485</strong> </li>-->
                    </ul>
                    <br>
                    <!-- <a href="javascript:window.print();" class="btn btn-theme hidden-print"><i class="fa fa-print"></i> </a>-->
                    <!--<a href="#" class="btn btn-theme-inverse hidden-print"> SAVE </a>-->
                  </div>
                  <div class="clearfix"></div>
                </div></div>
				
				
              </div>
              <div class="clearfix"></div>
			  <form class="form-horizontal" method="post" id="form2" name="form2" action="action.php" data-collabel="3" data-alignlabel="left" parsley-validate enctype="multipart/form-data">
                <input type="hidden" value="<?php echo basename($_SERVER['PHP_SELF']); ?>" name="filename" id="filename" >
                <input type="hidden" value="<?php echo $tdcid; ?>" name="tdcid" id="tdcid" />
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6">
                    <h4>Notes</h4>
                    <hr>
                    <dd id="sumitnotes">
                      <?php 
				  $selq=$wpdb->get_results("SELECT * FROM travel_desk_claims_notes WHERE TDC_Id=$tdcid");
				  
				  if(count($selq)>0){
				  print_r($selq);
					foreach ($selq as $results):
						switch ($results['TDCN_Type']):
							
							case 1:
							echo '<dl><b>Finance: </b>'.stripslashes($results['TDCN_Text']).'<br><span style="font-size:9px;">'.date('d/m/y h:i a', strtotime($results[TDCN_Date])).'</span></dl>'; 
							break;
							
							case 2:
							echo '<dl><b>Travel Desk: </b>'.stripslashes($results['TDCN_Text']).'<br><span style="font-size:9px;">'.date('d/m/y h:i a', strtotime($results[TDCN_Date])).'</span></dl>'; 
							break;
						
						endswitch;
					
					 endforeach; ?>
                      <?php } ?>
                    </dd>
                    <span style="display:none;" id="hiddenimg"><img src="../images/loading.gif" /> Loading...</span> </div>
                  <div class="clearfix"></div>
                  <?php 
				  if($claimsview->TDC_Status==1){
				  ?>
                  <div class="col-sm-12">
                    <div class="col-sm-6"> </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Notes</label>
                        <div>
                          <textarea class="form-control" data-height="auto" name="txtaNotes" id="txtaNotes"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div>
                          <button type="submit" name="subclaimnotes" id="subclaimnotes" class="btn btn-palevioletred">Submit Notes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                <div class="clearfix"></div>
                <p>&nbsp;</p>
                <?php 
			
			  //if($rows[TDC_Status]==1){
			  	
				echo '<div class="col-sm-12 text-right"><label class=control-label>Claim Status </label>: ';
				
				switch ($claimsview->TDC_Level):
					
					case 1:
					echo approvals(1);
					break;
					
					case 2:
					echo approvals(2);
					break;
					
					case 3:
					echo approvals(4);
					break;
				
				endswitch;
			  	
				echo '</div>';
			  
			 // } 
			  
			  ?>
              </form>
              <p>&nbsp;</p>
			  <?php 
				if($claimsview->TDC_Level==1 || $claimsview->TDC_Level==3){
				?>
              <div class="col-sm-12 text-right">
                <div class="form-group">
                  <div> <a  class="btn btn-primary" href="travel-desk-claim-edit.php?tdcid=<?php echo $tdcid; ?>">&nbsp;&nbsp;&nbsp;&nbsp; Edit / Update Claim &nbsp;&nbsp;&nbsp;&nbsp;</a> </div>
                </div>
              </div>
              <?PHp
				}
				?>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <?php 
			  
			if($claimsview->TDC_Level==2){
			
				if($claimsview->TDC_Status==1){
				
					echo '<div class="col-sm-12 text-right"><span class="label label-warning">Payment not updated.</span></div><div class="clearfix"></div>
					<p>&nbsp;</p> <p>&nbsp;</p>';
				
				} else if($claimsview->TDC_Status==2){
				
				
					$selrow=$wpdb->get_results("SELECT * FROM travel_desk_claim_payments WHERE TDC_Id='$tdcid' AND TDCP_Status=1");
					echo '<div class="col-lg-6" align="center"> <a href="javascript:void(0);" class="btn btn-success">Request Claimed on '.date("d/m/y",strtotime($selrow[0]->TDCP_AddedDate)).'</a> </div> ';
				
					
				  
				  ?>
              <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                    <h3>Payment Details</h3>
                  </header>
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="control-label">Payment mode</label>
                      <div>
                        <select class="form-control" name="selPaymentMode" id="selPaymentMode" parsley-required="true" disabled="disabled">
                          <option value="">Select</option>
                          <?php 
							  $selsql=$wpdb->get_results("SELECT * FROM payment_modes");
							  foreach($selsql as $rowsql){
							  ?>
                          <option value="<?php echo $rowsql->PM_Id; ?>" <?php echo ($selrow[0]->PM_Id==$rowsql->PM_Id) ? 'selected="selected"' : ''; ?> ><?php echo $rowsql->PM_Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div id="chequeid" <?php echo ($selrow[0]->PM_Id==1) ? 'style="display:block;"' : 'style="display:none;"'; ?>  >
                      <div class="form-group">
                        <label class="control-label">Cheque Number</label>
                        <div>
                          <input type="text" class="form-control" name="txtChequeNumber" id="txtChequeNumber"  <?php echo ($selrow[0]->TDCP_ChequeNumber) ? 'value="'.$selrow[0]->TDCP_ChequeNumber.'"' : ''; ?> disabled="disabled" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Cheque Date</label>
                        <div>
                          <!--<div class="row">
								<div class="input-group date form_datetime col-lg-12" data-picker-position="bottom-left"  data-date-format="dd MM yyyy - HH:ii p" >-->
                          <input type="text" <?php /*?>name="txtDate[]"<?php */?> name="txtCqDate" id="txtCqDate" class="form-control"  <?php echo ($selrow[0]->TDCP_ChequeDate) ? 'value="'.$selrow[0]->TDCP_ChequeDate.'"' : ''; ?> disabled="disabled" >
                          <!-- <span class="input-group-btn">
								  <button class="btn btn-default" type="button"><i class="fa fa-times"></i></button>
								  <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
								  </span></div>-->
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Issuing Bank</label>
                        <div>
                          <input type="text" class="form-control" name="txtBankBranch" id="txtBankBranch"  <?php  echo ($selrow[0]->TDCP_ChequeIssuingbb) ? 'value="'.$selrow[0]->TDCP_ChequeIssuingbb .'"' : ''; ?> disabled="disabled"/>
                        </div>
                      </div>
                    </div>
                    <div id="cashid" <?php echo ($selrow[0]->PM_Id==2) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                      <div class="form-group">
                        <label class="control-label">Payment Details</label>
                        <div>
                          <textarea class="form-control" data-height="auto" name="txtaCshComments" id="txtaCshComments" disabled="disabled"><?php  echo ($selrow[0]->TDCP_CashPaymentDetails) ? stripslashes($selrow[0]->TDCP_CashPaymentDetails) : ''; ?>
	</textarea>
                        </div>
                      </div>
                    </div>
                    <div id="banktransferid" <?php echo ($selrow[0]->PM_Id==3) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                      <div class="form-group">
                        <label class="control-label">Transaction Id</label>
                        <div>
                          <input type="text" class="form-control" name="txtTransId" id="txtTransId"  disabled="disabled" <?php  echo ($selrow[0]->TDCP_BTTransactionId) ? 'value="'.$selrow[0]->TDCP_BTTransactionId .'"' : ''; ?>/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Bank Details</label>
                        <div>
                          <input type="text" class="form-control" name="txtBankdetails" id="txtBankdetails" disabled="disabled" <?php  echo ($selrow['TDCP_BTBankDetails']) ? 'value="'.$selrow[0]->TDCP_BTBankDetails .'"' : ''; ?>/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Transaction Date</label>
                        <div>
                          <div class="row">
                            <div class="input-group date form_datetime col-lg-12" data-picker-position="bottom-left"  data-date-format="dd MM yyyy - HH:ii p" >
                              <input type="text" <?php /*?>name="txtDate[]"<?php */?> name="txtBBDate" id="txtBBDate" class="form-control" disabled="disabled" <?php  echo ($selrow[0]->TDCP_BTTransferDate) ? 'value="'.$selrow[0]->TDCP_BTTransferDate .'"' : ''; ?>>
                              <span class="input-group-btn">
                              <button class="btn btn-default" type="button"><i class="fa fa-times"></i></button>
                              <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                              </span> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="othersid" <?php echo ($selrow[0]->PM_Id==4) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                      <div class="form-group">
                        <label class="control-label">Payment Details</label>
                        <div>
                          <textarea class="form-control" data-height="auto" name="txtaOtherComments" disabled="disabled"><?php  echo ($selrow[0]->TDCP_OthersPaymentDetails) ? stripslashes($selrow[0]->TDCP_OthersPaymentDetails) : ''; ?>
	</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
			<?php  }  }?>
            </div>
          </div>
          <!--</form>-->
        </section>
      </div>
    </div>
    <!-- //content > row > col-lg-8 -->
    <!-- //content > row > col-lg-4 -->
    <!-- //content > row-->
  </div>
  <!-- //content-->
</div>
</div>
</div>
</div>

        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
</div><!-- #erp-area-left-inner -->
			
			