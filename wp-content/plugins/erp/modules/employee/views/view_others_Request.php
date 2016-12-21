<?php
global $etEdit;
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
global $totalcost;
$paytotd=0;
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$row=$wpdb->get_row("SELECT * FROM requests req, request_employee re, employees emp WHERE req.REQ_Id='$reqid' AND req.COM_Id=$compid AND req.COM_Id=emp.COM_Id AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND req.REQ_Active=1 AND re.RE_Status=1");
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
            <h2><?php _e( 'Others Expense Request', 'employee' ); ?></h2>
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
               <p style="border-bottom:thin dashed #999999;">&nbsp;</p>
            <form name="post-travel-req-form" action="#" method="post" enctype="multipart/form-data">
            <table class="wp-list-table widefat striped admins" border="0" id="table1">
                  <thead class="cf">
                    <tr>
                       <th>Date</th>
                      <th>Expense Description</th>
                      <th>Expense Category</th>
                      <th>Upload
                        bills / tickets</th>
                      <th>Total Cost</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                        
                        $selsql=$wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id=$row->REQ_Id AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Id ASC");
                        foreach($selsql as $rowsql){
                        ?>
                    <tr>
                      <td data-title="Date"><?php echo date('d-M-Y',strtotime($rowsql->RD_Dateoftravel));?></td>
                      <td data-title="Description"><p style="height:20px; overflow:auto;"><?php echo stripslashes($rowsql->RD_Description); ?></p></td>
                      <td data-title="Category"><?php echo $rowsql->MOD_Name; ?></td>
                      <td data-title="Upload Bills / Tickets"><?php 
						
						$j=1;
                                                
						$selsql=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id=$rowsql->RD_Id");
						
						foreach($selsql as $rowfiles)
						{
							$temp=explode(".",$rowfiles->RF_Name);
							$ext=end($temp);
							
							$fileurl="/erp/modules/company/upload/".$compid."/bills_tickets/".$rowfiles->RF_Name;
						?>
                        <?php echo $j.") "; ?><a href="<?php echo WPERP_COMPANY_DOWNLOADS ?><?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a><br />
                        <?php $j++; } ?>
                      </td>
                      <td data-title="Total Cost"><?php echo IND_money_format($rowsql->RD_Cost).".00"; ?></td>
                    </tr>
                    <?php  
					
                    $totalcost+=$rowsql->RD_Cost;


                    } ?>
                  </tbody>
                </table>
                <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                  <tr>
                    <td>Claim Amount</td>
                    <td>:</td>
                    <td><?php echo IND_money_format($totalcost).".00"; ?></td>
                  </tr>
                </table>
            </div>
            <!-- Edit Buttons -->
            <?php _e(Actions(3));?>
            </form>
        </div>
    </div>
    
</div>
