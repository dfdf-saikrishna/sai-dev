<?php 
$cmpid = $_SESSION['compid'];
$reqids = $_REQUEST['reqid'];
$comrow	=	companyDetails('COM_LOGO, COM_Name', $cmpid);
?>
<div class="wrap erp-travelagentclaims">
    <div class="erp-single-container erp-travelagentclaims-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-travelagentclaims-wrap-inner">
            <div id="erp-area-left-inner">
                <script type="text/javascript">
                    window.wpErpCurrenttdriseinvoiceview = <?php echo json_encode( $tdriseinvoiceview->to_array() ); ?>
                </script>
                <div class="erp-profile-top">
			

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
            <h2><?php echo $comrow[0]->COM_Name; ?> - Invoices</h2>
            <label class="color">Send for<strong> Invoices </strong></label>
          </header>
          <form class="form-horizontal" method="post" id="tdinvoiceForm" name="invoiceForm" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $reqids; ?>" name="reqids" />
            <input type="hidden" value="<?php echo $cmpid; ?>" name="cmpid" />
            <div class="panel-body">
			  <?php 
			  global $wpdb;
			  $tduserid =$_SESSION['tdid'];
				// select bank details of travel agentl
				$selba = $wpdb->get_results(" SELECT TDBA_Id, TDBA_AccountNumber FROM travel_desk_bank_account WHERE  TD_Id='$tduserid' AND  TDBA_Status=1"); 
				
				$bank_details = $selba;
				
				if(empty($bank_details)){ 
					
					echo '<div class="alert alert-info">
							Sorry. You haven\'t assigned any bank account to this company. Please Assign one and create your invoice.
							</div>';
				
				} else {
			  ?>
              <div class="invoice">
                <!--<div class="row">
                <div class="col-sm-6">
                  <?php 
				  
				if($comrow['COM_LOGO'])
				echo '<img alt="" src="../admin/'.$comrow[0]->COM_LOGO .'> ';
				
				
				?>
                </div>-->
                <div class="col-sm-6 align-lg-right">
                </div>
                <div class="clearfix"> </div>
                <!-- <hr>-->
                <div class="row">
                  <div class="col-sm-3">
                  
                  </div>
                  <div class="col-sm-3">
                    
                  </div>
                  <div class="erp-area-right erp-hide-print" style="margin:0px 0px 0px 841px" >
                    <div class="col-sm-12">
                      <h4>Payment Details :</h4>
                    </div>
                    <div class="col-sm-8"> <strong>Service Tax:</strong> </div>
                    <div class="col-sm-4">
                      <div class="input-group">
                        <input type="text" class="form-control calcInvoiceAmnt" parsley-type="number" <?php /*?> parsley-required="true"<?php */?> name="txtServiceTax" id="txtServiceTax" maxlength="6">
                        <span class="input-group-addon">&nbsp;%&nbsp;</span> </div>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="col-sm-8"> <strong>Service Charges:</strong> </div>
                    <div class="col-sm-4">
                      <div class="input-group">
                        <input type="text" class="form-control calcInvoiceAmnt" parsley-type="digits"<?php /*?> parsley-required="true"<?php */?> name="txtServiceChrgs" id="txtServiceChrgs" maxlength="6">
                        <span class="input-group-addon">.00</span> </div>
                    </div>
                    <div class="clearfix"></div>
					<div class="col-sm-12">
                      <div class="form-group">
                        <button type="button" class="btn label label-success" name="buttonCalculate" id="buttonCalculate">calculate</button>
                      </div>
                    </div>
                    <br />
                    <div class="clearfix"></div>
                    <br />
                     <input type="hidden" name="txtAccNo" id="txtAccNo" value="<?php echo $bank_details[0]->TDBA_Id; ?>" />
                  </div>
                </div>
                <br>
                <br>
                <?PHP
				global $wpdb;
				$selsql = $wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmpid' AND req.REQ_Id IN ($reqids) AND req.REQ_Id=rd.REQ_Id  AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 ORDER BY bs.BS_Id DESC LIMIT 0, 101 
");
				if (!empty($selsql)) {
    ?>
                <div class="panel-group">
                 <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr height="35">
                          <th width="10%" style="text-align:left;">Sl.no. </th>
                          <th width="25%" style="text-align:left; padding-left:5px;">Request Code</th>
                          <th width="10%" style="text-align:left;">Quantity</th>
                          <th width="35%" >Date</th>
                          <th width="20%" style="text-align:left; padding-left:35px;">Amount (Rs)</th>
                          <th width="5%" style="text-align:left; padding-left:5px;">&nbsp;</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <?php
				
				$i=1;
				
				$totqty=0;
				
				$totalamnt=0; $totalcosts=0;

				foreach ($selsql as $rowsql) {
					?>
                  <div class="panel panel-shadow">
                    <header class="panel-heading" style="padding:0 10px">
                      <div class="table-responsive">
                        <table class="wp-list-table widefat striped admins" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'">
                          <tr>
                            <td  width="10%"><?php echo $i; ?>. </td>
                            <td  width="25%"><?php echo $rowsql->REQ_Code; ?></td>
                            <?php
								$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id) FROM request_details rd, booking_status bs WHERE rd.REQ_Id='$rowsql->REQ_Id' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3)  AND BS_Active=1 AND RD_Status=1");
								foreach ($getvals as $values) {
									$rdids="";
									$rdids.=$values->RD_Id . ",";
									
									$countAll=count($wpdb->get_results("SELECT BS_Id FROM booking_status WHERE RD_Id='$values->RD_Id' AND BS_Active=1"));
									
																		
									if($countAll==2){
									
										if($rowcn=$wpdb->get_results("SELECT BA_Id, BS_CancellationAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=3 AND BS_Active=1")){
										
											if($rowcn[0]->BA_Id==4 || $rowcn[0]->BA_Id==6){
												
												$totalcosts	+=	$rowcn[0]->BS_CancellationAmnt;
											
											}
											
										
										} else {
										
											$rowbk=$wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=1 AND BS_Active=1");
											
											$totalcosts	+=	$rowbk[0]->BS_TicketAmnt;
										
										}
										
										
									} else {
									
										$rowbk=$wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=1 AND BS_Active=1");
										
										$totalcosts	+=	$rowbk[0]->BS_TicketAmnt;
									
									}
									
									
									
								}
								
								//echo 'totalcost='.$totalcosts."<br>";

								$rdids = rtrim($rdids, ",");

								if (!$rdids)
								$rdids = "'" . "'";

                              // echo 'Reqids='.$rdids;
							   
							   $totqty += count($getvals);
							   
							   
							   $totalamnt	+=	$totalcosts;
							   
                                                            ?>
                            <td width="10%" style="text-align:center;"><?php echo count($getvals);  ?></td>
                            <td width="35%" style="text-align:center; padding-left:30px;"><?php  echo date('d-M-Y', strtotime($rowsql->REQ_Date)) ?></td>
                            <td width="20%" style="text-align:center;"><?php echo IND_money_format($totalcosts). ".00"; $totalcosts = NULL ; ?></td>
                            <td><a data-toggle="collapse" href="#collapse<?php echo $i; ?>"><i class="collapse-caret fa fa-angle-down"></i> </a> </td>
                          </tr>
                        </table>
                      </div>
                    </header>
                    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="table-responsive">
                          <table class="wp-list-table widefat striped admins" style="font-size:11px;">
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
							$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$rowsql->REQ_Id' AND rd.RD_Id IN($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");

							$rdids = "";

							foreach ($rddetails as $rowdetails) {
								?>
                              <tr>
                                <td align="center"><?php 
								
								echo date('d-M-Y', strtotime($rowdetails->RD_Dateoftravel)); 
								
								?></td>
                                <td><div style="height:40px; overflow-y:auto;"><?php echo stripslashes($rowdetails->RD_Description); ?></div></td>
                                <td width="5%"><?php echo $rowdetails->EC_Name; ?></td>
                                <td width="5%"><?php echo $rowdetails->MOD_Name; ?></td>
                                <td><?php 
					
									if($rowdetails->EC_Id==1) {
										
										echo '<b>From:</b> '.$rowdetails->RD_Cityfrom.'<br />
										<b>To:</b> '.$rowdetails->RD_Cityto;						
									
									} else {
									
										echo '<b>Loc:</b> '.$rowdetails->RD_Cityfrom;
										
										if ($rowsd=$wpdb->get_results("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowdetails->SD_Id'")) {
										
											echo '<br>Stay :'.$rowsd->SD_Name;
												
										}
									
									}
						
						?></td>
                                <td align="right"><?php echo IND_money_format($rowdetails->RD_Cost) . ".00"; ?></td>
								
								
								
                                <!----- BOOKING STATUS STATUS ------>
                                <td><?php
								
								
								$selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rowdetails->RD_Id' AND BS_Status=1 AND BS_Active=1");

						if ($selrdbs[0]->RD_Id) {
						
							echo ($selrdbs[0]->BA_Id == 1) ? bookingStatus($selrdbs[0]->BA_Id) . "<br>" : '';

							echo '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BS_Date)) . "<br>";

							echo '----------------------------------<br>';

							$query = "BA_Id IN (2,3)";
						}

					   

							echo bookingStatus($selrdbs[0]->BA_Id);

							//echo 'baid='.$selrdbs['BA_Id'];

							$imdir = "../company/upload/$cmpid/bills_tickets/";


							



							switch ($selrdbs[0]->BA_Id) {

								case 2:
									$doc = NULL;
								
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

								case 3:
									echo '<br>';
									echo '<strong>Failed Date</strong>: ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
									break;
							}
											
											?>
                                </td>
                                <!----- CANCELLATION STATUS ------>
                                <td><?php
								
								$selrdcs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rowdetails->RD_Id' AND BS_Status=3 AND BS_Active=1");
								if(!empty($selrdcs->RD_Id))	{
								if ($selrdcs->RD_Id) {
		
									echo ($selrdcs->BA_Id == 1) ? bookingStatus($selrdcs->BA_Id) . "<br>" : '';
		
									echo '<b title="cancellation request date">Request Date: </b>' . date('d-M-y (h:i a)', strtotime($selrdcs->BS_Date)) . "<br>";
		
									echo '----------------------------------<br>';
		
									$query = "BA_Id IN (4,5)";
								}
								}
		if(!empty($selrdcs->BA_Id))	{
							echo bookingStatus($selrdcs->BA_Id);

							


							switch ($selrdcs->BA_Id) {

								case 4: case 6:
									
									$doc = NULL;
								
									$seldocs = select_all("booking_documents", "*", "BS_Id='$selrdcs[BS_Id]'", $filename, 0);
	
									$f = 1;
	
									foreach ($seldocs as $docs) {
	
										$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs['BD_Filename'] . '" class="btn btn-link">download</a><br>';
	
										$f++;
									}
									
									echo '<br><b>Cancellation Amnt</b>: ' . IND_money_format($selrdcs['BS_CancellationAmnt']) . '.00<br>';
									echo $doc;
									echo '<b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs['BA_ActionDate']));
									break;

								case 5: case 7:
									echo '<br><b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs['BA_ActionDate']));
									break;
							}
											
		}                                                 
                                                            ?>
                                </td>
                              </tr>
                              <?php
                                                         
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
								
								
								//echo 'count of tickets='.$j;
								
								
								

                                //mysqli_free_result($ressql); 
                                ?>
                  <!-- //panel -->
                  <input type="hidden" name="hiddenTickets" id="hiddenTickets" value="<?php echo $totqty; ?>"  />
                </div>
                <br>
                <br>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- <div class="align-lg-left"> 795 Park Ave, Suite 120 <br>
                      San Francisco, CA 94107 <br>
                      P: (234) 145-1810 <br>
                      Full Name <br>
                      first.last@email.com </div>-->
                  </div>
                  <div class="col-sm-6">
                    <div class="align-lg-right" style="margin:0px 0px 0px 900px">
                      <ul>
                        <li> Total Quantity: <strong><?php echo $totqty; ?></strong> </li>
                        <li style="display:none;" id="servicetaxlistid">Service Tax: <strong id="servicetaxid"></strong></li>
                        <li style="display:none;" id="serviceamntlistid">Service Charges: <strong id="servicechargesid"></strong></li>
                        <li> Total amount: <strong id="totalamountid"><?php echo IND_money_format($totalamnt). '.00'; ?></strong> </li>
						
                        <input type="hidden" name="totalAmount" value="<?php echo $totalamnt; ?>" id="totalAmount" />
                        <!--  <li> Discount: ----- </li>
                        <li> Grand Total: <strong>$3,485</strong> </li>-->
                      </ul>
                      <br>
                      <!--<a href="javascript:window.print();" class="btn btn-theme hidden-print"><i class="fa fa-print"></i> </a>-->
                      <!--<a href="#" class="btn btn-theme-inverse hidden-print"> SAVE </a>-->
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
                <p>&nbsp;</p>
                <div class="row">
                  <div class="col-sm-5">
                    <div class="form-group">
                      <label class="control-label">Invoice No.</label>
                      <div>
                        <input type="text" name="txtInvoiceNo" id="txtInvoiceNo" class="form-control" parsley-required="true" />
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-5">
                    <div class="form-group">
                      <label class="control-label">Invoice Doc.</label>
                      <div>
                        <div class="fileinput fileinput-new" data-provides="fileinput"> <span class="btn btn-default btn-file"> <span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                          <input type="file" name="fileattach" id="fileattach" onchange="picval(this.id)">
                          </span> <span class="fileinput-filename"></span> <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a> </div>
                        <span class="help-block"><a>doc, docx, pdf only</a></span>
                        <!-- //fileinput-->
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-5">
                    <div class="form-group">
                      <label class="control-label">Remarks</label>
                      <div>
                        <textarea data-height="auto" name="txtaRemarks" id="txtaRemarks" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <p>&nbsp;</p>
                  <div class="col-sm-2"></div>
                  <div class="col-sm-4">
                    <div class="form-group">
                   <button type="submit" name="claimsSubmit" id="claimsSubmit" class="button button-primary">Send for Claims</button>
					 <input type="hidden" name="action" id="traveldeskclaims_create" value="traveldeskclaims_create">
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
			  
			  <?php }  ?>
			  
            </div>
			</form>
        </section>
      </div>
    </div>
    <!-- //content > row > col-lg-8 -->
    <!-- //content > row > col-lg-4 -->
    <!-- //content > row-->
  </div>
  <!-- //content-->
</div>
<!-- //main-->
<!--
		/////////////////////////////////////////////////////////////////
		//////////     RIGHT NAV MENU     //////////
		/////////////////////////////////////////////////////////////
		-->
<!-- //nav right menu-->
<!-- //wrapper-->



                    <?php //do_action( 'erp_hr_employee_single_after_info', $companyview ); ?>

                </div><!-- .erp-profile-top -->

               

                <?php //do_action( 'erp_hr_employee_single_bottom', $companyview ); ?>

            </div><!-- #erp-area-left-inner -->
        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>