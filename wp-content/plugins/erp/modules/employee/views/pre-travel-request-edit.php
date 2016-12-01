<?php
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
$reqid = $_GET['reqid'];
            
if(!$row=$wpdb->get_row("SELECT * FROM requests req, request_employee re WHERE RT_Id=1 AND req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND REQ_Active=1 AND re.RE_Status=1"))
{
	header("location:employee-dashboard.php?msg=1"); exit;
}

$claim=0;

 if($row->REQ_Claim){
 	
	$claim=1;
	
	header("location:employee-dashboard.php?msg=1"); exit;
	
	
 } else {
	 
	 $claim=0;
	 
	 $url='action.php?reqid='.$reqid;
	 
 }
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
        <div class="wrap pre-travel-request" id="wp-erp">
            <h2><?php _e( 'Pre Travel Expense Request', 'employee' ); ?></h2>
            <code class="description">ADD Request</code>
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
                <td><?php echo $repmngname->EMP_Name;?></td>
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
            <form id="request_form" name="input" action="#" method="post">
            <table class="wp-list-table widefat striped admins" border="0" id="table-pre-travel">
                  <thead class="cf">
                    <tr>
                      <th class="column-primary">Date</th>
                      <th class="column-primary">Expense Description</th>
                      <th class="column-primary" colspan="2">Expense Category</th>
                      <th class="column-primary" >Place</th>
                      <th class="column-primary">Estimated Cost</th>
                      <th class="column-primary">Get Quote</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 

                        $rows=1;

                        $selrequest=$wpdb->get_results("SELECT * FROM request_details WHERE REQ_Id='$row->REQ_Id' AND RD_Status=1 ORDER BY RD_Dateoftravel ASC");

                        $rdidarry=array();


                        foreach($selrequest as $rowrequest)
                        {

                                $disabled=0;

                                if(count($selrequest)==1){

                                        $disabled=1;

                                } else {

                                        if(($rowrequest->MOD_Id == 1) || ($rowrequest->MOD_Id == 2) || ($rowrequest->MOD_Id == 5)){

                                                
                                                if($selrdbs=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$rowrequest->RD_Id' AND BS_Status=1 AND BS_Active=1")){

                                                        if( ($selrdbs->BA_Id != 1) /*&& ($selrdbs['BA_Id'] != 3)*/){

                                                                $disabled=1;
                                                        }

                                                } else {

                                                        $disabled=0;

                                                }

                                        } else {

                                                $disabled=0;

                                        }


                                }


                        ?>
                    <tr>
                      <td data-title="Date" class=""><input name="txtDate[]" id="txtDate1" <?php echo $disabled ? 'class="form-control" readonly="readonly"' : 'class="pretraveldate form-control"'; ?> class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00") echo ""; else echo date('d/m/Y',strtotime($rowrequest->RD_Dateoftravel)); ?>"/>
                      <input name="txtStartDate[]" id="txtStartDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                      <input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" <?php echo $disabled ? 'readonly="readonly"':'';?> id="txtaExpdesc1" class="" autocomplete="off"><?php echo stripslashes($rowrequest->RD_Description); ?></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Category"><input type="hidden" <?php if($disabled){?> name="selExpcat[]" id="selExpcat<?php echo $rows; ?>" value="<?php echo $rowrequest->EC_Id?>" <?php } ?>/>
                          <select <?php if($disabled){?> disabled="disabled" <?php } else ?> name="selExpcat[]" id="selExpcat1" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selexpcat as $rowexpcat)
				  {
				  ?>
                          <option value="<?php echo $rowexpcat->EC_Id?>" <?php if($rowexpcat->EC_Id==$rowrequest->EC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->EC_Name; ?></option>
                          <?php } ?>
                         
                        </select></td>
                      <td data-title="Category"><input type="hidden" <?php if($disabled){ ?> name="selModeofTransp[]" id="selModeofTransp<?php echo $rows; ?>" value="<?php echo $rowrequest->MOD_Id; ?>" <?php } ?> />
                        <span id="modeoftr<?php echo $rows; ?>1acontent">
                        <select <?php if($disabled){ ?> disabled="disabled" <?php } else ?> name="selModeofTransp[]"  id="selModeofTransp1" class="">
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
                        <input  name="from[]" id="from<?php echo $rows; ?>" type="text" placeholder="From" value="<?php echo $rowrequest->RD_Cityfrom?>" <?php echo ($disabled) ? 'readonly="readonly"': ''; ?>>
                        <input  name="to[]" id="to<?php echo $rows; ?>" <?php if($rowrequest->EC_Id==2 || $rowrequest->EC_Id==4){ echo 'value="n/a" style="display:none;"'; } else { echo 'value="'.$rowrequest->RD_Cityto.'"'; } ?> <?php echo ($disabled) ? 'readonly="readonly"': ''; ?> type="text" placeholder="To" class="">
                        </span></td>
                        <td data-title="Estimated Cost"><span id="cost1container">
                        <input type="text" class="" name="txtCost[]" id="txtCost" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" value="<?php echo $rowrequest->RD_Cost;?>" <?php echo ($disabled) ? 'readonly="readonly"' : ''; ?> autocomplete="off"/>
                        </br><span class="red" id="show-exceed"></span>
                        <input type="hidden" value="1" name="ectype" id="ectype"/>
                        <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                        </span></td>
                      <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>
                    </tr>
                    <?php 
                    $rows++; 

                    array_push($rdidarry, $rowrequest->RD_Id);

                    } ?>
                  </tbody>
                </table>
                <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-row-pretravel" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
                <span id="totaltable"> </span>
                </form>
            </div>
            <div id="my_centered_buttons">
            <button type="button" name="submit" id="submit-pre-travel-request" class="button button-primary">Submit</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" name="reset" id="reset" class="button">Reset</button>
            </div>
        </div>
        
        <!-- Grade Limits -->
        <?php _e(gradeLimits());?>
        
    </div>
    
</div>
