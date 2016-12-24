<?php
global $etEdit;
$showProCode = 1;
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
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
            <?php if(isset($_REQUEST['msg'])) {
            $msg = $_REQUEST['msg'];
            // booking 
            $a		=	$_GET['a'];
            $c		=	$_GET['c'];
            $b		=	$_GET['b'];
            $d		=	$_GET['d'];


            // self booking
            $s		=	$_GET['s'];

            // cancellation
            $p		=	$_GET['p'];
            $h		=	$_GET['h'];
            $f		=	$_GET['f'];

            switch($msg)
            {
                    case 1:
                    $msg= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success">You have successfully Approved this Pre Travel Expense Request</p>
                           </div>';
                    break;

                    case 4:
                    $msg= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success">You have successfully added a note. </p>
                           </div>';
                        
                    break;

                    case 6:
                    
                    $msg= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success">You have successfully Rejected this Pre Travel Expense Request </p>
                           </div>';
                    break;


                    // booking request 
                    case 7:

                    $msg=NULL;
                    if($a){
                            $a=convert_number($a);
                            $msg='<div style="display:block" id="notice" class="notice notice-warning is-dismissible">
                                <p id="p-notice"><?php echo $b; ?> '.$a.' record was already send to travel desk for booking.</p>
                            </div>';
                            	
                    } 

                    if($b){	
                            $b=convert_number($b);
                            $msg.= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success">'.$b.' records successfully send to travel desk for booking. </p>
                            </div>';
                            
                    }

                    break;


                    /*
                     SELF BOOKING
                    */

                    case 8:

                    $msg="";
                    if($a){
                            $a=convert_number($a);
                            $msg='<div style="display:block" id="notice" class="notice notice-warning is-dismissible">
                                <p id="p-notice"><?php echo $b; ?> '.$a.' records was already set as self booking. </p>
                            </div>';
                            
                    } 

                    if($s){
                            $s=convert_number($s);		
                            $msg.= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success"> '.$s.' records were successfully set as self booking. </p>
                            </div>';
                            
                    }
                    break;


                    case 9:

                    $msg="";

                    if($h){
                            $h=convert_number($h);
                            $msg='<div style="display:block" id="notice" class="notice notice-warning is-dismissible">
                                <p id="p-notice"><?php echo $b; ?> '.$h.' records not yet booked. Cancellation not possible.</p>
                            </div>';
                            
                    }

                    if($p){
                            $p=convert_number($p);
                            $msg.='<div style="display:block" id="notice" class="notice notice-warning is-dismissible">
                                <p id="p-notice"><?php echo $b; ?> '.$p.' records are under processing by the travel desk.</p>
                            </div>';
                            
                    }
                    if($f){
                            $f=convert_number($f);
                            $msg.='<div style="display:block" id="notice" class="notice notice-warning is-dismissible">
                                <p id="p-notice"><?php echo $b; ?> '.$f.' records were failed to book by the travel desk. It cannot be cancelled.</p>
                            </div>';
                    }
                    if($b){
                            $b=convert_number($b);		
                            $msg.= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success"> '.$b.' records were successfully sent for cancellation. </p>
                            </div>';
                           
                    }
                    if($c){
                            $c=convert_number($c);
                            $msg.= '<div style="display:block" id="success" class="notice notice-success is-dismissible">
                            <p id="p-success"> '.$j.' records were already cancelled. Please go through the request details carefully </p>
                            </div>';
                            
                    }	
                    break;


                    case 11:
                    $msg='<div style="display:block" id="notice" class="notice notice-warning is-dismissible">
                            <p id="p-notice"><?php echo $b; ?>Finance Approval pending.</p>
                          </div>';
                    break;
            }
            echo $msg;
            }
?>
            <div style="display:none" id="failure" class="notice notice-error is-dismissible">
            <p id="p-failure"></p>
            </div>
            
            <div style="display:none" id="notice" class="notice notice-warning is-dismissible">
                <p id="p-notice"><?php echo $a; ?> Record was Already Sent to Travel Desk For Booking</p>
            </div>
            
            <div style="display:none" id="notice" class="notice notice-warning is-dismissible">
                <p id="p-notice"><?php echo $b; ?> Records was Already Sent to Travel Desk For Booking</p>
            </div>
            
            <div style="display:none" id="success" class="notice notice-success is-dismissible">
                <p id="p-success"></p>
            </div>

            <div style="display:none" id="info" class="notice notice-info is-dismissible">
                <p id="p-info"></p>
            </div>
            
            <?php
                require WPERP_EMPLOYEE_VIEWS."/employee-details.php";
            ?>
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
            <form id="pre-travel-details" name="input" action="#" method="post">
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
                      <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" id="reqid"/>
                      <input type="hidden" name="reqcode" id="reqcode" value="<?php echo $row->REQ_Code?>" />
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
                <div style="float:right;">
                  <button type="submit" name="bookTickets" id="bookTickets" class="button button-primary" value="1">Book Tickets</button>
                  <button type="submit" name="buttonSelfbooking" id="buttonSelfbooking" class="button button-primary" value="2">Self Booking</button>
                  <button type="submit" class="button erp-button-danger" name="cancelTickets" id="cancelTickets" value="3">Cancel Tickets</button>
                </div>
              <br />
              <br />
              <?php                     } 
			  	} else { 
								
				if($row->REQ_Status==2/* && $curDate >= $rowsql['RD_Dateoftravel']*/){
					
					 ?>
              <br />
              <br />
              <div style="float:right;">  
                  <button type="submit" name="bookTickets" id="bookTickets" class="button button-primary" value="1">Book Tickets</button>
                  <button type="submit" name="buttonSelfbooking" id="buttonSelfbooking" class="button button-primary" value="2">Self Booking</button>
                  <button type="submit" class="button erp-button-danger" name="cancelTickets" id="cancelTickets" value="3">Cancel Tickets</button>
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
    <?php _e(Actions(1));?>
    
</div>
</div>