<?php 
$tdcid		=	$_GET['tdcid'];
$compid = $_SESSION['compid'];
global $wpdb;
$rows=$wpdb->get_row("SELECT * FROM travel_desk_claims WHERE TDC_Id='$tdcid' AND COM_Id='$compid'");
?>
<div class="wrap erp erp-hr-employees erp-employee-single">
 <div class="erp-single-container erp-hr-employees-wrap" id="erp-single-container-wrap">
        <div class="erp-area-left full-width erp-hr-employees-wrap-inner">
            <div id="erp-area-left-inner">
                <div style="display:none" id="success" class="notice notice-success is-dismissible">
        <p id="p-success"></p>
    </div>
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
            <label class="color">Claim<strong> Details </strong></label>
          </header>
          <form class="form-horizontal" method="post" id="buttoneditclaim" name="buttoneditclaim" action="#" data-collabel="3" data-alignlabel="left" parsley-validate enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $tdcid; ?>" name="tdcid" />
          <div class="panel-body">
            <div class="invoice">
              <div class="row">
                <div class="col-sm-6">
                  <h3>Reference NO. #<?php echo $rows->TDC_ReferenceNo; ?></h3>
                  <span><?php echo date('d F Y', strtotime($rows->TDC_Date)); ?></span> </div>
                <div class="erp-area-right erp-hide-print" style="margin:-108px 0px 0px 0px">
                  <div class="col-sm-12">
                    <h4>Payment Details :</h4>
                  </div>
                  <div class="col-sm-8"> <strong>Service Tax:</strong> </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="text" class="form-control" parsley-type="number" parsley-required="true" name="txtServiceTax" id="txtServiceTax"  value="<?php echo $rows->TDC_ServiceTax; ?>">
                      <span class="input-group-addon">&nbsp;%&nbsp;</span> </div>
                  </div>
                  <div class="clearfix"></div>
                  <br />
                  <div class="col-sm-8"> <strong>Service Charges:</strong> </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="text" class="form-control" parsley-type="digits" parsley-required="true" name="txtServiceChrgs" id="txtServiceChrgs"  value="<?php echo $rows->TDC_ServiceCharges / $rows->TDC_Quantity; ?>">
                      <span class="input-group-addon">.00</span> </div>
                  </div>
                  <div class="clearfix"></div>
                  <br />
                  <div class="col-sm-8"> <strong>Account No:</strong> </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                        <?php 
					$tduserid = $_SESSION['tdid'];
					  $bank_details=$wpdb->get_row("SELECT TDBA_Id, TDBA_AccountNumber FROM travel_desk_bank_account WHERE TD_Id='$tduserid' AND TDBA_Status=1");
					  ?>
                        <input type="text" class="form-control"   readonly="readonly" parsley-required="true" value="<?php echo $bank_details->TDBA_AccountNumber; ?>">
                        <input type="hidden" name="txtAccNo" id="txtAccNo" value="<?php echo $bank_details->TDBA_Id; ?>" />
                      </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"> </div>
              <div class="erp-area-right erp-hide-print" style="margin:-71px -86px 0px 0px" >
                <div class="form-group">
                  <div><br />
                    <button type="button" class="btn label label-success" name="buttonCalculate" id="buttonCalculate">calculate</button>
                  </div>
                </div>
              </div>
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
			  
			  
			  $selsql=$wpdb->get_results("SELECT * FROM travel_desk_claim_requests tdcr, requests req WHERE TDC_Id='". $tdcid ."' and tdcr.REQ_Id = req.REQ_Id");
				
				$totqty=0; $totalamnt=0;
			  
				$i=1; $j = 1;

				foreach ($selsql as $rowsql) {
					?>
                <div class="panel panel-shadow">
                  <header class="panel-heading" style="padding:0 10px">
                    <div class="table-responsive">
                      <table class="table table-hover" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'">
                        <tr>
                          <td  width="10%"><?php echo $i; ?>. </td>
                          <?php	
				$getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id) FROM request_details rd, booking_status bs WHERE rd.REQ_Id='". $rowsql->REQ_Id ."' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3)  AND BS_Active=1 AND RD_Status=1");
					foreach ($getvals as $values) {
						$rdids ="";
						$rdids.=$values->RD_Id . ",";
	
						$countAll=count($wpdb->get_results("SELECT BS_Id FROM booking_status WHERE RD_Id='". $values->RD_Id ."' AND BS_Active=1"));
														
						if($countAll==2){
						
							if($rowcn=$wpdb->get_row("SELECT BA_Id, BS_CancellationAmnt FROM booking_status WHERE RD_Id='". $values-->RD_Id ."' and BS_Status=3 AND BS_Active=1")){
							
								if($rowcn->BA_Id==4 || $rowcn->BA_Id==6){
									$totalcosts ="";
									$totalcosts	+=	$rowcn->BS_CancellationAmnt;
								
								}
							
							} else {
							
								$rowbk=$wpdb->get_row("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='". $values['RD_Id'] ."' and BS_Status=1 AND BS_Active=1");
								$totalcosts ="";
								$totalcosts	+=	$rowbk->BS_TicketAmnt;
							
							}
							
							
						} else {
						
							$rowbk=$wpdb->get_row("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='". $values->RD_Id ."' and BS_Status=1 AND BS_Active=1");
							$totalcosts ="";
							$totalcosts	+=	$rowbk->BS_TicketAmnt;
						
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
                          <td><a data-toggle="collapse" href="#collapse<?php echo $i; ?>"><i class="collapse-caret fa fa-angle-down"></i> </a> </td>
                        </tr>
                      </table>
                    </div>
                  </header>
                  <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
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
							$rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='". $rowsql->REQ_Id ."' AND rd.RD_Id IN($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");

							$rdids = "";

							foreach ($rddetails as $rowsql) {
								?>
                            <tr>
                              <td align="center"><?php echo date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); ?></td>
                              <td><div style="height:40px; overflow-y:auto;"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                              <td width="5%"><?php echo $rowsql->EC_Name; ?></td>
                              <td width="5%"><?php echo $rowsql->MOD_Name; ?></td>
                              <td><?php 
					
						if($rowsql->EC_Id==1) {
							
							echo '<b>From:</b> '.$rowsql->RD_Cityfrom.'<br />
							<b>To:</b> '.$rowsql->RD_Cityto;						
						
						} else {
						
							echo '<b>Loc:</b> '.$rowsql->RD_Cityfrom;
							
							if ($rowsd=$wpdb->get_row("SELECT SD_Name FROM stay_duration WHERE SD_Id='". $rowsql->SD_Id ."'")) {
							
								echo '<br>Stay :'. $rowsd->SD_Name;
									
							}
						
						}
						
						?></td>
                              <td align="right"><?php echo IND_money_format($rowsql->RD_Cost) . ".00"; ?></td>
                              <!----- BOOKING STATUS STATUS ------>
                              <td><?php
								$selrdbs = $wpdb->get_row("SELECT * From booking_status WHERE RD_Id='". $rowsql->RD_Id ."' AND BS_Status=1 AND BS_Active=1");

						if ($selrdbs->RD_Id) {

							echo ($selrdbs->BA_Id == 1) ? bookingStatus($selrdbs->BA_Id) . "<br>" : '';

							echo '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs->BS_Date)) . "<br>";

							echo '----------------------------------<br>';

							$query = "BA_Id IN (2,3)";
						}

					   

							echo bookingStatus($selrdbs->BA_Id);

							//echo 'baid='.$selrdbs['BA_Id'];

							$imdir = "../company/upload/$compid/bills_tickets/";


							$doc = NULL;

							if ($selrdbs->BA_Id == 2) {

								$seldocs = select_all("booking_documents", "*", "BS_Id='$selrdbs[BS_Id]'", $filename, 0);

								$f = 1;

								foreach ($seldocs as $docs) {

									$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs['BD_Filename'] . '" class="btn btn-link">download</a><br>';

									$f++;
								}
							}



							switch ($selrdbs->BA_Id) {

								case 2:
									echo '<br>';
									echo '<b>Booked Amnt:</b> ' . IND_money_format($selrdbs->BS_TicketAmnt) . '.00</span><br>';
									echo $doc;
									echo '<b>Booked Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate));
									break;

								case 3:
									echo '<br>';
									echo '<strong>Failed Date</strong>: ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate));
									break;
							}
											
											?>
                              </td>
                              <!----- CANCELLATION STATUS ------>
                              <td><?php
								$selrdcs = $wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='". $rowsql->RD_Id ."' AND BS_Status=3 AND BS_Active=1");
if(!empty($selrdcs)){
						if ($selrdcs->RD_Id) {

							echo ($selrdcs->BA_Id == 1) ? bookingStatus($selrdcs->BA_Id) . "<br>" : '';

							echo '<b title="cancellation request date">Request Date: </b>' . date('d-M-y (h:i a)', strtotime($selrdcs->BS_Date)) . "<br>";

							echo '----------------------------------<br>';

							$query = "BA_Id IN (4,5)";
						}

							echo bookingStatus($selrdcs->BA_Id);

							$doc = NULL;

							if ($selrdcs->BA_Id == 4) {

								$seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='". $selrdcs->BS_Id ."'");

								$f = 1;

								foreach ($seldocs as $docs) {

									$doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

									$f++;
								}
							}


							switch ($selrdcs->BA_Id) {

								case 4:
									echo '<br><b>Cancellation Amnt</b>: ' . IND_money_format($selrdcs->BS_CancellationAmnt) . '.00<br>';
									echo $doc;
									echo '<b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
									break;

								case 5:
									echo '<br><b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
									break;
							}
											
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

                                //mysqli_free_result($ressql); 
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
                        <input type="text" name="txtInvoiceNo" id="txtInvoiceNo" class="form-control"  value="<?php echo $rows->TDC_InvoiceNo; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Invoice Doc.</label>
                      <div id="fileDiv">
                        <?php if($rows->TDC_Filename){?>
                        <a style="font-size:12px;" href="download-file.php?file=../company/upload/<?php echo $compid; ?>/bills_tickets/<?php echo $rows->TDC_Filename; ?>">download current</a> <br />
                        <a style="font-size:12px;" href="javascript:upload1();">upload new</a>
                        <?php } ?>
                        <input type="hidden" name="oldimg" value="<?php echo $rows->TDC_Filename?>"  />
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Remarks</label>
                      <div>
                        <textarea data-height="auto" name="txtaRemarks" id="txtaRemarks" class="form-control" ><?php echo stripslashes($rows->TDC_Remarks) ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <p>&nbsp;</p>
                </div>
                <input type="hidden" name="hiddenTickets" id="hiddenTickets" value="<?php echo $totqty; ?>"  />
                <div class="col-sm-6">
                  <div class="erp-area-right erp-hide-print" style="margin:-225px 0px 0px 0px">
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
                    <!-- <a href="javascript:window.print();" class="btn btn-theme hidden-print"><i class="fa fa-print"></i> </a>-->
                    <!--<a href="#" class="btn btn-theme-inverse hidden-print"> SAVE </a>-->
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-sm-12">
                <div class="col-sm-4"> </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <div>
                      <button type="submit" class="button button-success" name="buttoneditclaim" id="buttoneditclaim">Submit</button>
                    <input type="hidden" name="action" id="traveldeskclaims_update" value="traveldeskclaims_update">
					</div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group" style="margin:-28px 0px 0px 70px">
                    <div>
					<?php $compid = $_SESSION['compid']; ?>
                      <a  class="button button-danger"  onclick="javascript:if(confirm('Sure to cancel ?')){ location.href='/wp-admin/admin.php?page=ViewClaims&action=view&tdcid=<?php echo $tdcid; ?>&cmpid=<?php echo $compid; ?>' } else { return false; }" >Cancel</a>
                    </div>
                  </div>
                </div>
              </div>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            </div>
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
</div>

        </div><!-- .leads-left -->
    </div><!-- .erp-leads-wrap -->
</div>
</div><!-- #erp-area-left-inner -->
<!-- //nav left menu-->
<!--
		/////////////////////////////////////////////////////////////////
		//////////     RIGHT NAV MENU     //////////
		/////////////////////////////////////////////////////////////
		-->
<!-- //nav right menu-->
<script>
	var type=4;
</script>
