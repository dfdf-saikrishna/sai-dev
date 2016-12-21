<?php
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
$empdetails=$wpdb->get_row("SELECT * FROM employees emp, company com, department dep, designation des, employee_grades eg WHERE emp.EMP_Id='$empuserid' AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id");
$repmngname = $wpdb->get_row("SELECT EMP_Name FROM employees WHERE EMP_Code='$empdetails->EMP_Reprtnmngrcode' AND COM_Id='$compid'");
$selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
$selmode=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id IN (1,2,4) AND COM_Id IN (0, '$compid') AND MOD_Status=1");
$reqid  =   $_GET['reqid'];
$selsql=$wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id='$reqid' AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Dateoftravel ASC");
$row=$wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");
?>
<style type="text/css">
#my_centered_buttons { text-align: center; width:100%;}
</style>
<div class="postbox">
    <div class="inside">
        <div class="wrap pre-travel-request" id="wp-erp">
            <h2><?php _e( 'Pre Travel Requests Details', 'employee' ); ?></h2>
            <code class="description">Request Details Display</code>
            <!-- Messages -->
            <div style="display:none" id="failure" class="notice notice-error is-dismissible">
            <p id="p-failure"></p>
            </div>

            <div style="display:none" id="notice" class="notice notice-warning is-dismissible">
                <p id="p-notice"></p>
            </div>

            <div style="display:none" id="success" class="notice notice-success is-dismissible">
                <p id="p-success"></p>
            </div>

            <div style="display:none" id="info" class="notice notice-info is-dismissible">
                <p id="p-info"></p>
            </div>
            <div style="margin-top:60px;">
            <table class="wp-list-table widefat striped admins">
              <tr>
                <td width="20%">Employee Code</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->EMP_Code?> (<?php echo $empdetails->EG_Name?>)</td>
                <td width="20%">Company Name</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo stripslashes($empdetails->COM_Name); ?></td>
              </tr>
              <tr>
                <td width="20%">Employee Name</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->EMP_Name; ?></td>
                <td width="20%">Reporting Manager Code</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->EMP_Reprtnmngrcode; ?></td>
              </tr>
              <tr>
                <td>Employee Designation </td>
                <td>:</td>
                <td><?php echo $empdetails->DES_Name; ?></td>
                
                <?php if($repmngname){?>
                <td>Reporting Manager Name</td>
                <td>:</td>
                <td><?php echo $repmngname->EMP_Name;?></td>
                <? } ?>
                
              </tr>
              <tr>
                <td width="20%">Employee Department</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->DEP_Name; ?></td>

              </tr>
            </table>
            </div>
            <div style="margin-top:60px;">
            <!-- Request Details -->
            <?php _e(requestDetails(1));?>
            </div>
            <!-- Messages -->
            <div style="display:none" id="failure" class="notice notice-error is-dismissible">
            <p id="p-failure"></p>
            </div>

            <div style="display:none" id="notice" class="notice notice-warning is-dismissible">
                <p id="p-notice"></p>
            </div>

            <div style="display:none" id="success" class="notice notice-success is-dismissible">
                <p id="p-success"></p>
            </div>

            <div style="display:none" id="info" class="notice notice-info is-dismissible">
                <p id="p-info"></p>
            </div>
            <div style="margin-top:60px;">
            <form id="request_form" name="input" action="#" method="post">
            <table class="wp-list-table widefat striped admins" border="0" id="table1">
                  <thead class="cf">
                    <tr>
                      <th class="column-primary">Date</th>
                      <th class="column-primary">Expense Description</th>
                      <th class="column-primary" colspan="2">Expense Category</th>
                      <th class="column-primary" >Place</th>
                      <th class="column-primary">Estimated Cost</th>
                      <th class="column-primary">Select</th>
                      <th class="column-primary">Booking Status</th>
                      <th class="column-primary">Cancellation Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($selsql as $rowsql){
                    ?>
                    <tr>
                      <input type="hidden" id="et" value="1">
                      <td data-title="Date" style="width: 9%;"><?php echo date('d-M-Y',strtotime($rowsql->RD_Dateoftravel));?></td>
                      <td data-title="Description"><?php echo stripslashes($rowsql->RD_Description); ?></td>
                      <td data-title="Category"><?php echo $rowsql->EC_Name; ?></td>
                      <td data-title="Category"><?php echo $rowsql->MOD_Name; ?></td>
                      <td data-title="Place"><?php 
                      if($rowsql->EC_Id==1) {

                            echo '<b>From:</b> '.$rowsql->RD_Cityfrom.'<br />';
                            echo '<b>To:</b> '.$rowsql->RD_Cityto;

                      } else {

                            echo '<b>Loc:</b> '.$rowsql->RD_Cityfrom; 

                                
                            if ($rowsd=$wpdb->get_row("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql->SD_Id'"))
                            echo '<br>Stay :'.$rowsd->SD_Name;	

                      }

                      ?></td>
                      <td data-title="Estimated Cost"><?php  echo $rowsql->RD_Cost ? IND_money_format($rowsql->RD_Cost).".00" :  approvals(5);  ?></td>
                      <td><?php 
					  
					 // echo 'Approver='.$approver."<br>";
					  $approver = isApprover();
					  if($approver){
					  
					  	if($empuserid==$row->EMP_Id){
						
							if($row->REQ_Status==2){
						
								// find out for which and all booking is possible
								
								if( in_array($rowsql->MOD_Id, array(1,2,5)) )	{
								?>
                        <input type="checkbox" <?php if($row->REQ_Status==2) echo 'value="'.$rowsql->RD_Id.'" name="rdid[]" id="rdid[]"';  else echo 'disabled="disabled"'; ?>  />
                        <?Php
								
                                            } else {

                                                    echo '<input type="checkbox" disabled="disabled" />';

                                            }


                                    } else {

                                            echo '<input type="checkbox" disabled="disabled" />';

                                    }

                            } else {

                                    echo '<input type="checkbox" disabled="disabled" />';


                            }


                      } elseif(!$approver) {


                            //echo 'Req status='.$row['REQ_Status']."<Br>"; 


                            if($row->REQ_Status==2){


                                    // find out for which and all booking is possible

                                    if( in_array($rowsql->MOD_Id, array(1,2,5)) )	{


                                            /* if this mode is able to book, show checkbox else show n/a status */

                                            echo '<input type="checkbox" value="'.$rowsql->RD_Id.'" name="rdid[]" id="rdid[]" />';


                                    } else {

                                            echo '<input type="checkbox" disabled="disabled" />';

                                    }

                            } else {

                                    echo '<input type="checkbox" disabled="disabled" />';
                            }

                      } 


                      ?></td>
                      <td><?PHP 
					  
                        // if($row['REQ_Status']==2){

                                $imdir="company/upload/$compid/bills_tickets/";

                                 if( in_array($rowsql->MOD_Id, array(1,2,5)) )	{


                                       // check for self booking
      
                                       if($selrdbs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=2 AND BS_Active=1")){

                                               echo bookingStatus(8);
                                               echo '<br><b>Date: </b>'.date('d-M-y (h:i a)',strtotime($selrdbs->BS_Date));

                                       } else {
                                                
                                               $selrdbs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=1 AND BS_Active=1");
                                               if($selrdbs){

                                                       echo '<b>Request date: </b>'.date('d-M-y (h:i a)',strtotime($selrdbs->BS_Date))."<br>";

                                                       echo '----------------------------------<br>';

                                                       echo bookingStatus($selrdbs->BA_Id);

                                                       
                                                       $seldocs=$wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$selrdbs->BS_Id'");

                                                       $doc=NULL;

                                                       $f=1;

                                                       foreach($seldocs as $docs){

                                                               $doc.='<b>Uploaded File no. '.$f.': </b> <a href="download-file.php?file='.$imdir.$docs->BD_Filename.'" class="btn btn-link">download</a><br>';

                                                               $f++;
                                                       }



                                                       switch ($selrdbs->BA_Id)
                                                       {										
                                                               case 2:
                                                               echo '<br><b>Booked Amnt:</b> '.IND_money_format($selrdbs->BS_TicketAmnt).'.00</span><br>';
                                                               echo $doc;
                                                               echo '<b>Booked Date:</b> '.date('d-M-y (h:i a)',strtotime($selrdbs->BA_ActionDate));
                                                               break;

                                                               case 3:
                                                               echo '<br><b>Failed Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdbs->BA_ActionDate));
                                                               break;

                                                       }

                                               } else {

                                                       echo bookingStatus(NULL);

                                               }

                                       } 

                               } else {

                                       echo bookingStatus(NULL);

                               }

                       //}

                         ?></td>
                      <td><?PHP 
                //if($row['REQ_Status']==2){

                        if( in_array($rowsql->MOD_Id, array(1,2,5)) )	{


                              // check for self booking
                                
                              if($selrdbs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=2 AND BS_Active=1")){

                                      echo bookingStatus(NULL);


                              } else {
                                      
                                      $selrdbs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=3 AND BS_Active=1");

                                      if($selrdbs){


                                              echo '<b title="Cancellation Request Date">Request date: </b>'.date('d-M-y (h:i a)',strtotime($selrdbs->BS_Date))."<br>";

                                              echo '----------------------------------<br>';

                                              //echo ($selrdbs['BA_Id']==1) ? bookingStatus($selrdbs['BA_Id'])."<br>" : '';

                                              if($selrdbs->BA_Id==1){

                                                      echo bookingStatus($selrdbs->BA_Id)."<br>";

                                              } else {


                                                      echo bookingStatus($selrdbs->BA_Id);
                                                      
                                                      $seldocs=$wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$selrdbs->BS_Id'");

                                                      $doc=NULL;

                                                      $f=1;

                                                      foreach($seldocs as $docs){

                                                              $doc.='<b>Uploaded File no. '.$f.': </b> <a href="download-file.php?file='.$imdir.$docs->BD_Filename.'" class="btn btn-link">download</a><br>';

                                                              $f++;
                                                      }

                                                      switch ($selrdbs->BA_Id)
                                                      {

                                                              case 4: case 6:
                                                                      echo '<br><b>Cancellation Amnt:</b> '.IND_money_format($selrdbs->BS_CancellationAmnt).'.00<br>';
                                                                      echo $doc;
                                                                      echo '<b>Cancellation Date:</b> '.date('d-M-y (h:i a)',strtotime($selrdbs->BA_ActionDate))."<br>";								
                                                              break;

                                                              case 5: case 7:
                                                                      echo '<br><b>Cancellation Date:</b> '.date('d-M-y (h:i a)',strtotime($selrdbs->BA_ActionDate))."<br>";	
                                                              break;

                                                      }

                                              }


                                      } else {

                                              echo bookingStatus(NULL);

                                      }

                              } 

                      } else {

                              echo bookingStatus(NULL);

                      }

              //}

                        ?></td>
                      </tr>
                    <?php
                    $totalcost = "";
                    if(!$rowsql->RD_Duplicate)
                    $totalcost+=$rowsql->RD_Cost;

                    $rdidarry=array();
                    array_push($rdidarry, $rowsql->RD_Id);
                    
                   } ?>
                  </tbody>
                </table>
                <?php 
			 
                $shows=0;
                                        
                if($selptc = $wpdb->get_row("SELECT REQ_Id FROM pre_travel_claim WHERE REQ_Id='$reqid'")){

                       $shows=1;

                }
                //echo 'Current Date='.$row['REQ_Status'];
                    
                if($seltd=count($wpdb->get_results("SELECT TD_Id FROM travel_desk WHERE COM_Id='$compid'"))){

                        if(!$shows){

                                if($approver/* && $curDate >= $rowsql['RD_Dateoftravel']*/){

                                        if($row->EMP_Id==$empuserid){


                ?>
                <span><table class="wp-list-table widefat striped admins" style="font-weight:bold;"><tr ><td align="right" width="85%">Total Estimated Cost</td><td align="center" width="5%">:</td><td align="right" width="10%"><?php echo IND_money_format($totalcost).".00"; ?></td></tr></table></span>
                <div class="col-sm-12 align-sm-right">
                <div style="float:right;">
                  <a href="#" class="status-all">Book Tickets</a> | 
                  <a href="#" class="status-all">Self Booking</a> |
                  <a href="#" class="status-all">Cancel Tickets</a> 
                </div>
              </div>
              <br />
              <br />
              <?php 			} 
			  				} 
							 
                                    } 
						
                }
					
		?>
                </form>
            </div>
        
        
        <!-- Notes -->
        <?php _e(chat_box(2,''));?>  
    </div>
<!--    <div id="my_centered_buttons">
    <button type="button" name="submit" id="submit-pre-travel-request" class="button button-primary">Submit</button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" name="reset" id="reset" class="button">Reset</button>
    </div>-->
    <!-- Edit Buttons -->
    <?php _e(FinanceActions(1));?>
    
</div>
</div>