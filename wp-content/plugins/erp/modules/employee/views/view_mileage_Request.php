<?php
global $etEdit;
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
global $totalcost;
$paytotd=0;
$reqid = $_GET['reqid'];
$row=$wpdb->get_row("SELECT * FROM requests req, request_employee re, employees emp WHERE req.REQ_Id='$reqid' AND RT_Id=5 AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND REQ_Active=1 AND re.RE_Status=1");
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
$empdetails=$wpdb->get_row("SELECT * FROM employees emp, company com, department dep, designation des, employee_grades eg WHERE emp.EMP_Id='$empuserid' AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id");
$repmngname = $wpdb->get_row("SELECT EMP_Name FROM employees WHERE EMP_Code='$empdetails->EMP_Reprtnmngrcode' AND COM_Id='$compid'");	
$selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
$selmode=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id IN (1,2,4) AND COM_Id IN (0, '$compid') AND MOD_Status=1");
?>
<style type="text/css">
#my_centered_buttons { text-align: center; width:100%; margin-top:60px; }
</style>
<div class="postbox">
    <div class="inside">
        <div class="wrap pre-travel-request erp" id="wp-erp">
            <h2><?php _e( 'Mileage Expense Request', 'employee' ); ?></h2>
            <code class="description">View Request</code>
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
                <td>Reporting Manager Name</td>
                <td>:</td>
                <td><?php if($repmngname)echo $repmngname->EMP_Name;?></td>
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
            <?php _e(requestDetails(5));?>
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
                <h4 >/ Mileage Rates /</h4>
               <p style="border-bottom:thin dashed #999999;">&nbsp;</p>
               <?php
               $selamnt=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' AND MOD_Id='31' AND MIL_Status=1 AND MIL_Active=1");
               ?>
               <input type="hidden" id="hiddenTwowheeler" name="hiddenTwowheeler" value="<?php echo $selamnt->MIL_Amount?>" />
                <dl> <b>Two Wheeler:</b> <?php if($selamnt) echo  $selamnt->MIL_Amount; else echo 'N/A'; ?> / Km, 

                <?php   
                $selamnt=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' AND MOD_Id='32' AND MIL_Status=1 AND MIL_Active=1");
                ?>
              <input type="hidden" id="hiddenFourwheeler" name="hiddenFourwheeler" value="<?php if($selamnt) echo $selamnt->MIL_Amount?>" />
                
                <b>Four Wheeler:</b> <?php if($selamnt) echo $selamnt->MIL_Amount; else echo 'N/A'; ?></dl> / Km
                <form name="post-travel-req-form" action="#" method="post" enctype="multipart/form-data">
            <table class="wp-list-table widefat striped admins" border="0" id="table1">
                  <thead class="cf">
                    <tr>
                      <th width="10%">Date</th>
                      <th width="15%">Expense Description</th>
                      <th width="20%" colspan="2">Expense Category</th>
                      <th width="15%">City / Location</th>
                       <th width="10%" style="text-align:right;">Distance (in km)</th>
                       <th width="10%" style="text-align:right;">Cost / km</th>
                      <th width="10%" style="text-align:right;">Total Cost</th>
                      <th width="10%">Upload<br />
                        bills / tickets</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                        
                        $selsql=$wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id=$row->REQ_Id AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Id ASC");
                        foreach($selsql as $rowsql){
                        ?>
                    <tr>
                      <input type="hidden" id="et" value="5">
                      <input type="hidden" value="<?php echo $reqid; ?>" name="req_id" id="req_id"/>
                      <input type="hidden" name="reqcode" id="reqcode" value="<?php echo $row->REQ_Code?>" />
                      <td align="center" data-title="Date"><?php echo date('d/M/Y',strtotime($rowsql->RD_Dateoftravel));?></td>
                      <td data-title="Description"><div style="height:40px; overflow:auto;"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                      <td data-title="Category"><?php echo $rowsql->EC_Name; ?></td>
                      <td data-title="Category"><?php echo $rowsql->MOD_Name; ?></td>
                      <td data-title="City/Location"><?php 
						
							echo '<b>From:</b> '.$rowsql->RD_Cityfrom.'<br />';
							echo '<b>To:</b> '.$rowsql->RD_Cityto;
						?></td>
                        
                         <td align="right" style="padding-right:2px;" data-title="Distance (in km)"><b><?php echo $rowsql->RD_Distance; ?> Km</b></td>
                         <td align="right" style="padding-right:2px;"><b><?php echo $rowsql->RD_Rate; ?> / Km</b></td>
                        <td align="right" data-title="Total Cost"><?php echo IND_money_format($rowsql->RD_Cost).".00"; ?></td>
                        
                      <td data-title="Upload bills / tickets"><?php 	
                                                
						$selfiles=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowsql->RD_Id'");
						
						if(count($selfiles)){
						
							$j=1;						
							foreach($selfiles as $rowfiles)
							{
								$temp=explode(".",$rowfiles->RF_Name);
								$ext=end($temp);
								
								$fileurl="/erp/modules/company/upload/".$compid."/bills_tickets/".$rowfiles->RF_Name;
								
							?>
                        <?php echo $j.") "; ?><a href="<?php echo WPERP_COMPANY_DOWNLOADS ?><?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a><br />
                        <?php 
							
							$j++;
							}
						
						} else {
						
							echo approvals(5);
						
						}
						
						 ?>
                      </td>
                    </tr>
                    <?php  
					
                    $totalcost+=$rowsql->RD_Cost;


                    } ?>
                  </tbody>
                </table>
                <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                  <tr>
                    <td align="right" width="85%">Claim Amount</td>
                    <td align="center" width="5%">:</td>
                    <td align="right"><?php echo IND_money_format($totalcost-$paytotd).".00"; ?></td>
                  </tr>
                </table>
            </div>
            <!-- Edit Buttons -->
            <?php _e(Actions(5));?>
            </form>
        </div>
    </div>
    
</div>
