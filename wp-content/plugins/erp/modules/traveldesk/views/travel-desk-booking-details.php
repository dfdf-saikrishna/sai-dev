<?php 
ob_start();
$read	=$_GET['read'];
$reqid	=$_GET['reqid'];
$action	=$_GET['actionButton'];
$et=1;$showProCode=1;

$row=select_query("requests req, request_employee re","*","req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND COM_Id='$compid' AND REQ_Active=1",$filename);

if(!count($row)){
	header("location:travel-desk-dashboard.php?msg=1");exit;
}


$empid=$row['EMP_Id'];
?>
<link rel="stylesheet" type="text/css" href="../css/raw.common.min.css">
<div id="main">
  <ol class="breadcrumb">
    <li><a href="travel-desk-dashboard.php">Dashboard</a></li>
    <li class="active">Pre Travel Request Details</li>
  </ol>
  <!-- //breadcrumb-->
  <div id="content">
    <div class="row">
      <div class="col-lg-8" ></div>
      <!-- //content > row > col-lg-8 -->
      <div class="col-lg-4"></div>
      <!-- //content > row > col-lg-4 -->
    </div>
    <!-- //content > row-->
    <div class="row">
      <div class="col-lg-12" >
        <section class="panel">
          <header class="panel-heading">
            <h3>Pre Travel Expense Request Details</h3>
            <label class="color">Request<em><strong> Details Display</strong></em></label>
          </header>
          <div class="panel-body">
          
          <?php 
		  echo '<br>';
		  $rowtl=select_query("tolerance_limits", "*", "COM_Id='$compid' AND TL_Status=1 AND TL_Active=1", $filename);
		  
		  if($rowtl[TL_Percentage])
		  echo ' <div class="alert alert-warning"><i><b>Note: </b>Tolerance Limit '.$rowtl[TL_Percentage].'%. Please dont exceed the tolerance limit for booking tickets amounts. </i></div>
          		<br />';
		  
		  ?>
            <?php if($msg) echo '<div align="center" id="msgidbox">'.$msg.'</div>' ?>
            <?php 
                require("employee-details.php");
                require("employee-request-details.php");
                echo '<br>';
                ?>
            <div style="height:30px;" align="center"> </div>
            <div class="col-sm-6 align-sm-center" id="resultid"> </div>
            <div class="col-sm-6 align-sm-right"> Font Size:&nbsp; <span class="tooltip-area"> <a name="buttonIncrease" id="buttonIncrease" class="btn btn-default btn-sm" title="Increase"><i class="fa fa-plus-circle"></i></a> <a name="buttonDecrease" id="buttonDecrease"  class="btn btn-default btn-sm" title="Decrease"><i class="fa fa-minus-circle"></i></a> </span> </div>
            <input type="hidden" value="<?php echo $filename; ?>" name="filename" id="filename"  />
            <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" />
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="table1" style="font-size:11px;">
                <thead>
                  <tr>
                    <th width="5%">Date</th>
                    <th width="20%">Expense<br />
                      Description</th>
                    <th width="20%" colspan="2">Expense <br />
                      Category</th>
                    <th width="8%">Place</th>
                    <th width="7%">Estimated <br />
                      Cost</th>
                    <th width="20%">Booking Status</th>
                    <th  width="20%">Cancellation <br />
                      Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
					
					$selsql=select_all("requests req, request_details rd, booking_status bs", "DISTINCT(rd.RD_Id)", "req.COM_Id='$compid' AND req.REQ_Id='$reqid' AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3) AND REQ_Active=1 AND RD_Status=1 AND BS_Active=1", $filename, 0);
					
					foreach($selsql as $value){
						
						$rdids.=$value['RD_Id'].",";
						
					}
					
					$rdids=rtrim($rdids,",");
					
									  
				   $selsql=select_all("request_details rd, expense_category ec, mode mot", "*", "rd.REQ_Id=$row[REQ_Id] AND rd.RD_Id IN ($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Dateoftravel ASC", $filename, 0);
					
					
				$j=1;
				
				$rdidarry=array();
				
				  foreach($selsql as $rowsql){
				  
				  
				  	
				  ?>
                  <tr>
                    <td align="center"><?php echo date('d-M-Y',strtotime($rowsql['RD_Dateoftravel']));?></td>
                    <td><div style="height:40px; overflow-y:auto;"><?php echo stripslashes($rowsql['RD_Description']); ?></div></td>
                    <td><?php echo $rowsql['EC_Name']; ?></td>
                    <td><?php echo $rowsql['MOD_Name']; ?></td>
                    <td style="font-size:11px;"><?php if($rowsql['EC_Id']==1) {?>
                      <b>From:</b> <?php echo $rowsql['RD_Cityfrom']; ?><br />
                      <b>To:</b> <?php echo $rowsql['RD_Cityto']; ?>
                      <?php } else {?>
                      <b>Loc:</b> <?php echo $rowsql['RD_Cityfrom']; ?>
                      <?php 
						if ($rowsd=select_query("stay_duration", "SD_Name", "SD_Id='$rowsql[SD_Id]'", $filename)) {
						echo '<br>Stay :'.$rowsd['SD_Name'];	
						}
						?>
                      <?php }?></td>
                    <td align="right"><?php echo IND_money_format($rowsql['RD_Cost']).".00"; ?></td>
                    <!----- BOOKING STATUS STATUS ------>
                    <td><?php 
					 $selrdbs=select_query("booking_status", "*", "RD_Id='$rowsql[RD_Id]' AND BS_Status=1 AND BS_Active=1", $filename);
					 
					 
					 
					 if($selrdbs['RD_Id']){
					?>
                      <form method="post" id="bookingForm<?php echo $j; ?>" name="bookingForm<?php echo $j; ?>" onsubmit="return submitBookingForm(<?php echo $j; ?>);">
                        <input type="hidden" name="rdid<?php echo $j; ?>" id="rdid<?php echo $j; ?>" value="<?php echo $rowsql['RD_Id'] ?>" />
                        <input type="hidden" name="type<?php echo $j; ?>" id="type" value="1" />
                        <div id="bookingStatusContainer<?php echo $j; ?>">
                          <?php 
						if($selrdbs['RD_Id']){
						
							echo ($selrdbs['BA_Id']==1) ? bookingStatus($selrdbs['BA_Id'])."<br>": '';
						
							echo '<b>Request date: </b>'.date('d-M-y (h:i a)',strtotime($selrdbs['BS_Date']))."<br>";
							
							echo '----------------------------------<br>';
						
							$query="BA_Id IN (2,3)";
							
						} 
					
							if($selrdbs['BA_Id'] == 2 || $selrdbs['BA_Id'] == 3){
							
								echo bookingStatus($selrdbs['BA_Id']);
								
								//echo 'baid='.$selrdbs['BA_Id'];
								
								$imdir="../company/upload/$compid/bills_tickets/";
								
								
								$doc=NULL;
								
								if($selrdbs['BA_Id'] == 2){
								
									$seldocs=select_all("booking_documents", "*", "BS_Id='$selrdbs[BS_Id]'", $filename, 0);
									
									$f=1;
										
									foreach($seldocs as $docs){
									
										$doc.='<b>Uploaded File no. '.$f.': </b> <a href="download-file.php?file='.$imdir.$docs['BD_Filename'].'" class="btn btn-link">download</a><br>';
										
										$f++;
									}
								
								}
								
								
								
								switch ($selrdbs['BA_Id']){
								
									case 2:
									echo '<br>';
									echo '<b>Booked Amnt:</b> '.IND_money_format($selrdbs['BS_TicketAmnt']).'.00</span><br>';
									echo $doc;
									echo '<b>Booked Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdbs['BA_ActionDate']));
									break;
									
									case 3:
									echo '<br>';
									echo '<strong>Failed Date</strong>: '.date('d-M-y (h:i a)',strtotime($selrdbs['BA_ActionDate']));
									break;

								}
								
							
							} else if($selrdbs['BA_Id'] == 1) {
					  	
					  		?>
                          <div class="col-sm-8" id="imgareaid<?php echo $j; ?>"></div>
                          <div class="col-sm-8">
                            <div class="form-group">
                              <div>
                                <select name="selBookingActions<?php echo $j; ?>" id="selBookingActions<?php echo $j; ?>" class="form-control" onchange="showHideBooking(<?php echo $j; ?>,this.value)" >
                                  <option value="">Select</option>
                                  <?php 
								  $ba=select_all("booking_actions", "*", "$query", $filename, 0);
								  
								  foreach($ba as $barows){
								  ?>
                                  <option value="<?php echo $barows['BA_Id']; ?>"><?php echo $barows['BA_Name']; ?></option>
                                  <?php } ?>
                                </select>
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
                          <?Php					  
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
                    <td><?php 
					
					$selrdcs=select_query("booking_status", "*", "RD_Id='$rowsql[RD_Id]' AND BS_Status=3 AND BS_Active=1", $filename);
										
					if($selrdcs['RD_Id']){
					?>
                      <form method="post" id="cancellationForm<?php echo $j; ?>" name="cancellationForm<?php echo $j; ?>" onsubmit="return submitCancellationForm(<?php echo $j; ?>);">
                        <input type="hidden" name="rdid1<?php echo $j; ?>" id="rdid1<?php echo $j; ?>" value="<?php echo $rowsql['RD_Id'] ?>" />
                        <input type="hidden" name="type1<?php echo $j; ?>" id="type1" value="2" />
                        <div id="cancelStatusContainer<?php echo $j; ?>">
                          <?php 						
						if($selrdcs['RD_Id']){
													
							echo ($selrdcs['BA_Id']==1) ? bookingStatus($selrdcs['BA_Id'])."<br>": '';
						
							echo '<b title="cancellation request date">Request Date: </b>'.date('d-M-y (h:i a)',strtotime($selrdcs['BS_Date']))."<br>";
									
							echo '----------------------------------<br>';
						
							$query="BA_Id IN (4,5)";
							
						}
						
										
						if($selrdcs['BA_Id'] == 4 || $selrdcs['BA_Id'] == 5){
						
							echo bookingStatus($selrdcs['BA_Id']);
							
							$doc=NULL;
							
							if($selrdcs['BA_Id'] == 4){							
							
								$seldocs=select_all("booking_documents", "*", "BS_Id='$selrdcs[BS_Id]'", $filename, 0);
								
								$f=1;
									
								foreach($seldocs as $docs){
								
									$doc.='<b>Uploaded File no. '.$f.': </b> <a href="download-file.php?file='.$imdir.$docs['BD_Filename'].'" class="btn btn-link">download</a><br>';
									
									$f++;
								}
							
							}
							
							
							switch ($selrdcs['BA_Id']){
							
								case 4:
								echo '<br><b>Cancellation Amnt</b>: '.IND_money_format($selrdcs['BS_CancellationAmnt']).'.00<br>';
								echo $doc;
								echo '<b>Cancellation Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdcs['BA_ActionDate']));
								break;
								
								case 5:
								echo '<br><b>Cancellation Date</b>: '.date('d-M-y (h:i a)',strtotime($selrdcs['BA_ActionDate']));
								break;

							}
						
						} else if($selrdcs['BA_Id'] == 1) {	  
					  	
					  ?>
                          <div class="col-sm-12" id="imgareaid2<?php echo $j; ?>"></div>
                          <div class="col-sm-8">
                            <div class="form-group">
                              <div>
                                <select name="selCancActions<?php echo $j; ?>" id="selCancActions<?php echo $j; ?>" class="form-control" onChange="showHideCanc(<?php echo $j; ?>,this.value)">
                                  <option value="">Select</option>
                                  <?php 
							  $ba=select_all("booking_actions", "*", "$query", $filename, 0);
							  
							  foreach($ba as $barows){
							  ?>
                                  <option value="<?php echo $barows['BA_Id']; ?>"><?php echo $barows['BA_Name']; ?></option>
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
                          <?Php					  
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
                  </tr>
                  <?php 					
					$totalcost+=$rowsql['RD_Cost'];
					$j++;
					
					array_push($rdidarry, $rowsql['RD_Id']);
					
					} 
					
					?>
                </tbody>
              </table>
            </div>
            <br />
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <td align="right" ></td>
                  <td align="right" >Total Estimated Cost&nbsp;&nbsp;:- &nbsp;<?php echo IND_money_format($totalcost).".00"; ?></td>
                </tr>
              </table>
            </div>
            
            <div class="clearfix"></div>
            <p>&nbsp;</p>
            
            <div id="quoteDivId">
                <?php 
				
				//print_r($rdidarry);
				
			  $a=1;
			  foreach($rdidarry as $rdid){				
			  
			  	//echo 'Rdid='.$rdid;
				
				
				$selrgquote=select_all("request_getquote rg, get_quote_flight gqf", "*", "RD_Id='$rdid' AND rg.GQF_Id=gqf.GQF_Id AND RG_Active=1 ORDER BY GQF_Price ASC", $filename, 0);
				 
				 if(count($selrgquote)){
			
				
				if($rowRdDetails=select_query("request_details rd, mode mo", "RD_Dateoftravel, MOD_Name, RD_Cityfrom, RD_Cityto, rd.MOD_Id, SD_Id", "RD_Id='$rdid' AND rd.MOD_Id=mo.MOD_Id", $filename, 0)){
				
				
				?>
                <div id="field<?php echo $i; ?>" class="col-sm-6">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th><?PHP echo $rowRdDetails['MOD_Name']; ?></th>
                          <?php if($rowRdDetails['MOD_Name']=="Flight" || $rowRdDetails['MOD_Name']=="Bus") { ?>
                          <th><?php echo date('D, d F, Y', strtotime($rowRdDetails['RD_Dateoftravel']));?></th>
                          <th><?php echo $rowRdDetails['RD_Cityfrom'] ?> to <?php echo $rowRdDetails['RD_Cityto'] ?></th>
                          <?php } 
						  
						  if($rowRdDetails['MOD_Name']=="Hotel"){
						  	
							$staydays="+".$rowRdDetails['SD_Id']." day";

							$date = strtotime($staydays, strtotime($rowRdDetails['RD_Dateoftravel']));
							
							$checkoutdate= date("Y-m-d", $date);
							
						  ?>
                          <th>
						  <?php echo  " Check-In: ". date('D, d F Y', strtotime($rowRdDetails['RD_Dateoftravel'])).", <br> Check-Out: ".date('D, d F Y', strtotime($checkoutdate)); ?>
						  </th>
                          <th><?php echo $rowRdDetails['RD_Cityfrom'] ?></th>
                          <?php } ?>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <?php if($rowRdDetails['MOD_Name']=="Flight" || $rowRdDetails['MOD_Name']=="Bus") { ?>
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" style="font-size:10px;">
                      <thead>
                        <tr>
                          <th></th>
                          <th>DEPARTURE</th>
                          <th>ARRIVAL</th>
                          <th><?php if($rowRdDetails['MOD_Id']=='1') echo 'DURATION'; else echo 'Seats'; ?></th>
                          <th style="text-align:right">PRICE (Rs)&nbsp;&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
	  
	 
	  
			foreach($selrgquote as $rowrgquote){
					
				
				if($rowrgquote['MOD_Id']=='2') { 
				
					$flightname='Bus'; 
				
				} else {
				
					$flightname=$rowrgquote["GQF_AirlineName"];
					
					$flightname = preg_replace('~[\r\n]+~', '', $flightname);
				
				}
				
				
				$style=NULL;
				
				if($rowrgquote['RG_Pref']==2)
				$style='style="background-color:#E0F0FF;"';
				
	  
	  ?>
                        <tr >
                          <td <?php echo $style; ?>><span class="logo pull-left text-left <?php echo getFlightLogo($flightname); ?>"></span><br />
                            <?php echo $rowrgquote["GQF_AirlineName"]; ?><br />
                            <?php echo ($rowRdDetails['MOD_Name']=='Flight') ? $rowrgquote["GQF_AirlineCode"] : NULL; ?> - <?php echo $rowrgquote["GQF_FlightNumber"]; ?></td>
                          <td  <?php echo $style; ?>><?php echo date('h:i a', strtotime($rowrgquote["GQF_DepTIme"])); ?><br />
                            <?php echo $rowrgquote["GQF_Origin"]; ?> </td>
                          <td <?php echo $style; ?>><?php echo date('h:i a', strtotime($rowrgquote["GQF_ArrTime"])); ?> <br />
                            <?php echo $rowrgquote["GQF_Destination"]; ?></td>
                          <td <?php echo $style; ?>><?php echo $rowrgquote["GQF_Duration"]; ?> [
                            <?php
			if($rowRdDetails['MOD_Name']=='Flight'){
				
				if($rowrgquote["GQF_Stops"]==0)
				echo "Non Stop";
				else
				echo $rowrgquote["GQF_Stops"]." Stop";
				
			} else if($rowRdDetails['MOD_Name']=='Bus'){
				
				echo $rowrgquote["GQF_Stops"]." Seats";
			
			}
			?>
                            ]</td>
                          <td <?php echo $style; ?> class="text-right"><?php echo IND_money_format($rowrgquote["GQF_Price"]); ?>&nbsp;&nbsp;</td>
                        </tr>
                        <!-- end ngRepeat: flt in (filterdlist=(flights|masterfilter:journeyFilterRequest:filterData.dep))|orderBy:sortFn:order|limitTo:displayed -->
                        <?php
	     }
		 
		 ?>
                      </tbody>
                    </table>
                  </div>
                  <?php } 
				  if($rowRdDetails['MOD_Name']=="Hotel"){
				  ?>
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" style="font-size:10px;">
                      <thead>
                        <tr>
                          <th></th>
                          <th>HOTEL NAME</th>
                          <th>ROOM CATEGORY</th>
                          <th>ROOM TYPE</th>
                          <th style="text-align:right">PRICE (Rs)&nbsp;&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
	  
	 
	  
			foreach($selrgquote as $rowrgquote){
				
				$style=NULL;
				
				if($rowrgquote['RG_Pref']==2)
				$style='style="background-color:#E0F0FF; text-align:center;"';
				
	  
	  ?>
                        <tr >
                          <td data-title="ROOM IMAGE" style="width:10%" <?php echo $style; ?>><?PHP 
		 if($rowrgquote['GQF_DepTIme']){?>
                            <img class="img-responsive img-rounded" width="50" height="50" align="absmiddle" src="<?php echo $rowrgquote['GQF_DepTIme']; ?>" />
                            <?php } else echo '<span>N/A</span>'; ?></td>
                          <td data-title="HOTEL"  <?php echo $style; ?>><?php echo strip_tags($rowrgquote["GQF_AirlineName"]); ?></td>
                          <td data-title="ROOM CATEGORY" <?php echo $style; ?>><?php echo $rowrgquote["GQF_FlightNumber"]; ?></td>
                          <td data-title="ROOM TYPE" <?php echo $style; ?>><?php echo $rowrgquote["GQF_ArrTime"]; ?></td>
                          <td data-title="PRICE" <?php echo $style; ?> align="right" ><?php echo IND_money_format($rowrgquote["GQF_Price"]); ?></td>
                        </tr>
                        <!-- end ngRepeat: flt in (filterdlist=(flights|masterfilter:journeyFilterRequest:filterData.dep))|orderBy:sortFn:order|limitTo:displayed -->
                        <?php
	     }
		 
		 ?>
                      </tbody>
                    </table>
                  </div>
                  <?php } ?>
                </div>
                <?php
				}
				
				}
				
				
				$a++;
				
				 } ?>
              </div>
               
            <div class="clearfix"></div>
            <p style="height:40px;">&nbsp;</p>
            
            <div id="chatContainer">
              <?php
			  $val=1;
			   require("chat.php");?>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- //content-->
</div>
<!-- //main-->
<?php require("travel-desk-left.php");?>
<!--
		/////////////////////////////////////////////////////////////////
		//////////     RIGHT NAV MENU     //////////
		/////////////////////////////////////////////////////////////
		-->
<!-- //nav right menu-->
<?php 

require("travel-desk-footer.php");?>
<script>

var myVar=setInterval(function(){callChatMsg('<?php echo $reqid; ?>')},10*1000); //10 seconds

</script>
<?php 

ob_end_flush();
?>