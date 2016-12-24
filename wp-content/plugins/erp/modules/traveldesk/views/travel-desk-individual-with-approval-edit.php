<?php
require_once WPERP_TRAVELDESK_PATH . '/includes/functions-traveldesk-req.php';
global $wpdb;
global $empuserid;
global $showProCode;
global $totalcost;
$compid = $_SESSION['compid'];
$reqid	=$_GET['reqid'];
$row = $wpdb->get_row("SELECT * FROM requests req, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Claim IS NULL and req.REQ_Id=re.REQ_Id AND COM_Id='$compid' AND REQ_Active != 9 AND REQ_Type=3 AND RE_Status=1");
$empuserid = $row->EMP_Id;
$empdetails=$wpdb->get_row("SELECT * FROM employees emp, company com, department dep, designation des, employee_grades eg WHERE emp.EMP_Id='$empuserid' AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id");
$repmngname = $wpdb->get_row("SELECT EMP_Name FROM employees WHERE EMP_Code='$empdetails->EMP_Reprtnmngrcode' AND COM_Id='$compid'");
$selsql=$wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id=$row->REQ_Id AND rd.RD_Type=2 AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Dateoftravel ASC");
$selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
$selmode=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id IN (1,2,4) AND COM_Id IN (0, '$compid') AND MOD_Status=1");

?>
<style type="text/css">
#my_centered_buttons { text-align: center; width:100%; margin-top:60px; }
</style>
<div class="wrap erp travel-desk-request">

    <div class="erp-single-container">
            
          <div class="postbox" id="emp_details">
                
              <div class="inside">
                <h2><?php _e( 'Individual Employee Request [ with approval ] Edit', 'traveldesk' ); ?></h2>
                <?php
                $row=0;
                require WPERP_EMPLOYEE_VIEWS."/employee-details.php";
                ?>
       
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
                <form id="traveldesk_request" name="traveldesk_request" action="#" method="post" enctype="multipart/form-data">
                <table class="wp-list-table widefat striped admins" border="0" id="traveldesk_request">
                      <thead class="cf">
                        <tr>
                          <th class="column-primary">Date</th>
                          <th class="column-primary">Expense Description</th>
                          <th class="column-primary" colspan="2">Expense Category</th>
                          <th class="column-primary" >Place</th>
                          <th class="column-primary">Total Cost</th>
                          <th class="column-primary">Get Quote</th>
                          <th  width="5%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php 
                          
                          $rows=1;

                          foreach($selsql as $rowrequest){
                              $disabled=0;
					
                              if(count($rowrequest)==1)
                              $disabled=1;

                          ?>
                        <tr>
                          <td data-title="Date" class=""><input name="txtDate[]" id="txtDate<?php echo $rows; ?>" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00") echo ""; else echo date('d/m/Y',strtotime($rowrequest->RD_Dateoftravel)); ?>" <?php echo $disabled ? 'readonly="readonly"':'';?>/>
                          <input name="txtStartDate[]" id="txtStartDate<?php echo $rows; ?>" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                          <input type="text" name="textBillNo[]" id="textBillNo<?php echo $rows; ?>" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                          </td>
                          <td data-title="Description"><textarea <?php echo $disabled ? 'readonly="readonly"':'';?> name="txtaExpdesc[]" id="txtaExpdesc<?php echo $rows; ?>" class="" autocomplete="off"><?php echo stripslashes($rowrequest->RD_Description) ?></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                          <td data-title="Category"><select name="selExpcat[]" <?php if($disabled){?> disabled="disabled" <?php } else ?> id="selExpcat<?php echo $rows; ?>" class="">
                              <option value="">Select</option>
                              <?php
                              foreach($selexpcat as $rowexpcat)
                                      {
                                      ?>
                              <option value="<?php echo $rowexpcat->EC_Id?>" <?php if($rowexpcat->EC_Id==$rowrequest->EC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->EC_Name; ?></option>
                              <?php } ?>

                            </select></td>
                          <td data-title="Category"><span id="modeoftr1acontent">
                            <select name="selModeofTransp[]" <?php if($disabled){?> disabled="disabled" <?php } else ?> id="selModeofTransp<?php echo $rows; ?>" class="">
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
                            <input  name="from[]" id="from<?php echo $rows; ?>" <?php echo ($disabled) ? 'readonly="readonly"': ''; ?> type="text" placeholder="From" class="" value="<?php echo $rowrequest->RD_Cityfrom?>">
                            <input  name="to[]" id="to<?php echo $rows; ?>" <?php echo ($disabled) ? 'readonly="readonly"': ''; ?> type="text" placeholder="To" class="" value="<?php echo $rowrequest->RD_Cityto; ?>">
                            </span></td>
                            <td data-title="Estimated Cost"><span id="cost1container">
                            <input type="text" class="" name="txtCost[]" <?php echo ($disabled) ? 'readonly="readonly"': ''; ?> id="txtCost" value="<?php echo $rowrequest->RD_Cost;?>" autocomplete="off" onkeyup="valPreCost(this.value,<?php echo $empuserid;?>);" onchange="valPreCost(this.value,<?php echo $empuserid;?>);"/>
                            </br><span class="red" id="show-exceed"></span>
                            <input type="hidden" value="1" name="ectype" id="ectype"/>
                            <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                            <input type="hidden" value="1" name="hiddenDraft" id="hiddenDraft"  />
                            <input type="hidden" value="<?php echo $empuserid; ?>" name="hiddenEmp" id="hiddenEmp" />
                            <input type="hidden" value="1" name="addnewrequest" id="addnewrequest" />
                            <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" />
                            <input type="hidden" value="<?php echo $empuserid ?>" name="selEmployees" id="selEmployees" />
                            <input type="hidden" name="action" id="traveldesk_request_create" value="traveldesk_request_create">
                            </span></td>
                            <td data-title="Get Quote"><button type="button" name="getQuote" <?php echo ($disabled) ? 'disabled="disabled"' : '';?> id="getQuote1" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>
                            <td><button type="button" value="<?php echo $rowrequest->RD_Id; ?>" <?php echo ($disabled) ? 'disabled="disabled"' : '';?> class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row"><i class="fa fa-trash-o"></i></button></td>
                        </tr>
                        <?php 					
                        $totalcost+=$rowrequest->RD_Cost;

                        $rows++; 

                        } ?>
                      </tbody>
                    </table>
                    <span id="totaltable"> </span>
                    <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                        <tr>
                          <td align="right" width="85%">Total Cost</td>
                          <td align="center" width="5%">:</td>
                          <td align="right" width="10%"><?php echo IND_money_format($totalcost).".00"; ?></td>
                        </tr>
                    </table>
                    <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="edit-traveldesk-requestappr" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
                </div>
                <div id="my_centered_buttons">
                <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
                <input type="submit" name="submit" id="submit-traveldesk-request" class="button button-primary">
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
                       <?php _e(gradeLimits($empuserid));?>
                    </div>
                </div><!-- .postbox -->
              
        </div>
        </div>
    </div>
</div>
