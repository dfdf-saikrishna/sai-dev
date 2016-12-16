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
            <h2><?php _e( 'Post Travel Requests Details', 'employee' ); ?></h2>
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
                      <th class="column-primary" >Upload bills / tickets</th>
                      <th class="column-primary">Total Cost</th>
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
                      <td data-title="Upload bills"><?php
                        
                        $selfiles=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowsql->RD_Id'");

                        if(count($selfiles)){

                                $j=1;						
                                foreach($selfiles as $rowfiles)
                                {
                                        $temp=explode(".",$rowfiles->RF_Name);
                                        $ext=end($temp);

                                        $fileurl="company/upload/".$compid."/bills_tickets/".$rowfiles->RF_Name;

                        ?>
                        <?php echo $j.") "; ?><a href="download-file.php?file=<?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a><br />
                        <?php 
							
                                $j++;
                                }

                        } else {

                                echo approvals(5);

                        }

                         ?>
                      </td>
                      <td data-title="Estimated Cost"><?php  echo $rowsql->RD_Cost ? IND_money_format($rowsql->RD_Cost).".00" :  approvals(5);  ?></td>
                      
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
    <?php _e(Actions(2));?>
    
</div>
</div>