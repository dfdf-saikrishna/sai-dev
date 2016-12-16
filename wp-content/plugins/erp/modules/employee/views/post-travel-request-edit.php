<?php
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
$reqid = $_GET['reqid'];
            
//if(!$row=$wpdb->get_row("SELECT * FROM requests req, request_employee re WHERE RT_Id=1 AND req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND REQ_Active=1 AND re.RE_Status=1"))
//{
//	header("location:employee-dashboard.php?msg=1"); exit;
//}

//$claim=0;
//
// if($row->REQ_Claim){
// 	
//	$claim=1;
//	
//	header("location:employee-dashboard.php?msg=1"); exit;
//	
//	
// } else {
//	 
//	 $claim=0;
//	 
//	 $url='action.php?reqid='.$reqid;
//	 
// }
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
            <h2><?php _e( 'Post Travel Expense Request', 'employee' ); ?></h2>
            <code class="description">Edit Request</code>
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
            <form id="request_edit_form" name="input" action="#" method="post">
            <table class="wp-list-table widefat striped admins" border="0" id="table-pre-travel">
                  <thead class="cf">
                    <tr>
                      <th class="column-primary">Date</th>
                      <th class="column-primary">Expense Description</th>
                      <th class="column-primary" colspan="2">Expense Category</th>
                      <th class="column-primary" >Place</th>
                      <th class="column-primary" >Upload bills / tickets</th>
                      <th class="column-primary">Total Cost</th>
                      <th class="column-primary">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 

                        $rows=1;

                        $selrequest=$wpdb->get_results("SELECT * FROM request_details WHERE REQ_Id='$reqid' AND RD_Status=1 ORDER BY RD_Dateoftravel ASC");
                        $cnt	=	count($selrequest);
                        $rdidarry=array();


                        foreach($selrequest as $rowrequest)
                        {
                        ?>
                    <tr>
                      <td data-title="Date" class=""><input name="txtDate[]" id="txtDate<?php echo $rows; ?>" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00") echo ""; else echo date('d-m-Y',strtotime($rowrequest->RD_Dateoftravel)); ?>"/>
                      <input name="txtStartDate[]" id="txtStartDate<?php echo $rows; ?>" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                      <input type="text" name="textBillNo[]" id="textBillNo<?php echo $rows; ?>" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc<?php echo $rows; ?>" class="" autocomplete="off"><?php echo stripslashes($rowrequest->RD_Description); ?></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Category"><input type="hidden" name="selExpcat[]" id="selExpcat<?php echo $rows; ?>" value="<?php echo $rowrequest->EC_Id?>"/>
                          <select name="selExpcat[]" id="selExpcat<?php echo $rows; ?>" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selexpcat as $rowexpcat)
				  {
				  ?>
                          <option value="<?php echo $rowexpcat->EC_Id?>" <?php if($rowexpcat->EC_Id==$rowrequest->EC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->EC_Name; ?></option>
                          <?php } ?>
                         
                        </select></td>
                      <td data-title="Category"><input type="hidden" name="selModeofTransp[]" id="selModeofTransp<?php echo $rows; ?>" value="<?php echo $rowrequest->MOD_Id; ?>"/>
                        <span id="modeoftr<?php echo $rows; ?>1acontent">
                        <select disabled="disabled" name="selModeofTransp[]"  id="selModeofTransp<?php echo $rows; ?>" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selmode as $rowsql)
					  {
					  ?>
                          <option value="<?php echo $rowsql->MOD_Id; ?>" <?php if($rowsql->MOD_Id==$rowrequest->MOD_Id) echo 'selected="selected"'; ?>><?php echo $rowsql->MOD_Name; ?></option>
                          <?php } ?>
                        </select>
                        </span></td>
                      <td data-title="Place"><span id="city<?php echo $rows; ?>container">
                        <input  name="from[]" id="from<?php echo $rows; ?>" type="text" placeholder="From" value="<?php echo $rowrequest->RD_Cityfrom?>">
                        <input  name="to[]" id="to<?php echo $rows; ?>" <?php if($rowrequest->EC_Id==2 || $rowrequest->EC_Id==4){ echo 'value="n/a" style="display:none;"'; } else { echo 'value="'.$rowrequest->RD_Cityto.'"'; } ?> type="text" placeholder="To" class="">
                        </span></td>
                        <td data-title="Upload bills"><?php
                        
                        $selfiles=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowrequest->RD_Id'");

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
                        <input type='file' name='file<?php echo $rows; ?>[]' id="file<?php echo $rows; ?>[]" multiple="true" onchange="Validate(this.id);" style="width:150px;"></td>
                      </td>
                        <td data-title="Estimated Cost"><span id="cost1container">
                        <input type="text" class="" name="txtCost[]" id="txtCost" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" value="<?php echo $rowrequest->RD_Cost;?>" autocomplete="off"/>
                        </br><span class="red" id="show-exceed"></span>
                        <input type="hidden" value="1" name="ectype" id="ectype"/>
                        <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                        <input type="hidden" value="<?php echo $rowrequest->RD_Id; ?>" name="rdids[]"/>
                        <input type="hidden" name="action" id="send_pre_travel_request_edit" value="send_pre_travel_request_edit">
                        <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" id="reqid"/>
                        </span></td>
                      <td><button type="button" value="<?php echo $rowrequest->RD_Id; ?>" class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row" <?php if($cnt==1) echo 'disabled="disabled"'; ?> ><i class="fa fa-times"></i></button></td>
                    </tr>
                    <?php 
                    $rows++; 

                    array_push($rdidarry, $rowrequest->RD_Id);

                    } ?>
                  </tbody>
                </table>
                <input type="hidden" id="hidrowno" name="hidrowno" value="<?php echo $rows-1; ?>" />
                    <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-row-pretravel" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
                <span id="totaltable"> </span>
                
            </div>
            <div id="my_centered_buttons">
            <input type="submit" name="submit" id="submit-pre-travel-request" class="button button-primary">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" name="reset" id="reset" class="button">Reset</button>
            </div>
            </form>
            <div style="margin-top:60px" id="grade-limit" class="postbox leads-actions closed">
                <div class="handlediv" title="<?php _e( 'Click to toggle', 'erp' ); ?>"><br></div>
                <h3 class="hndle"><span><?php _e( 'Grade Limits', 'erp' ); ?></span></h3>
                <div class="inside">
                   <!-- Grade Limits -->
                   <?php _e(gradeLimits());?>
                </div>
            </div><!-- .postbox -->
        </div>
    </div>
    
</div>