<?php
require_once WPERP_TRAVELDESK_PATH . '/includes/functions-traveldesk-req.php';
global $wpdb;
global $empuserid;
$compid = $_SESSION['compid'];
$allemps=$wpdb->get_results("SELECT EMP_Id, EMP_Code, EMP_Name FROM employees WHERE COM_Id='$compid' AND EMP_Status=1 ORDER BY EMP_Name ASC");
if(isset($_REQUEST['selEmployees'])){
    $empuserid = $_REQUEST['selEmployees'];
    $empdetails=$wpdb->get_row("SELECT * FROM employees emp, company com, department dep, designation des, employee_grades eg WHERE emp.EMP_Id='$empuserid' AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id");
    $repmngname = $wpdb->get_row("SELECT EMP_Name FROM employees WHERE EMP_Code='$empdetails->EMP_Reprtnmngrcode' AND COM_Id='$compid'");
    $selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
    $selmode=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id IN (1,2,4) AND COM_Id IN (0, '$compid') AND MOD_Status=1");
}
?>
<style type="text/css">
#my_centered_buttons { text-align: center; width:100%; margin-top:60px; }
</style>
<div class="wrap erp travel-desk-request">

    <div class="erp-single-container">
            <div class="postbox">
                
                <div class="inside">
                    <h2><?php _e( 'Individual Employee Request [ With Approval ]', 'traveldesk' ); ?></h2>
                    <code>CREATE Request without approvals</code>
                    <hr />
                    <div style="text-align: center">
                        
                      <select id="select_emp_withappr" class="erp-select2">
                          <option value="0">Select Employee</option>
                      <?php foreach($allemps as $value){?>
                      <option value="<?php echo $value->EMP_Id;?>" <?php echo ($empuserid==$value->EMP_Id) ? 'selected="selected"' : ''; ?>><?php echo $value->EMP_Code." - ".$value->EMP_Name; ?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>
            </div>
          <?php if(isset($_REQUEST['selEmployees'])){?>    
          <div class="postbox" id="emp_details">
                
              <div class="inside">
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
                          <?php if($repmngname){?>
                          <td width="20%">Reporting Manager Code</td>
                          <td width="5%">:</td>
                          <td width="25%"><?php echo $empdetails->EMP_Reprtnmngrcode; ?></td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td>Employee Designation </td>
                          <td>:</td>
                          <td><?php echo $empdetails->DES_Name; ?></td>

                          <?php if($repmngname){?>
                          <td>Reporting Manager Name</td>
                          <td>:</td>
                          <td><?php echo $repmngname->EMP_Name;?></td>
                          <?php } ?>

                        </tr>
                        <tr>
                          <td width="20%">Employee Department</td>
                          <td width="5%">:</td>
                          <td width="25%"><?php echo $empdetails->DEP_Name; ?></td>
                        </tr>
                      </table>
       
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
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td data-title="Date" class=""><input name="txtDate[]" id="txtDate1" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"/>
                          <input name="txtStartDate[]" id="txtStartDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                          <input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                          </td>
                          <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc1" class="" autocomplete="off"></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                          <td data-title="Category"><select name="selExpcat[]" id="selExpcat1" class="">
                              <option value="">Select</option>
                              <?php
                              foreach($selexpcat as $rowexpcat)
                                      {
                                      ?>
                              <option value="<?php echo $rowexpcat->EC_Id?>" ><?php echo $rowexpcat->EC_Name; ?></option>
                              <?php } ?>

                            </select></td>
                          <td data-title="Category"><span id="modeoftr1acontent">
                            <select name="selModeofTransp[]"  id="selModeofTransp1" class="">
                              <option value="">Select</option>
                              <?php
                              foreach($selmode as $rowsql)
                                              {
                                              ?>
                              <option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option>
                              <?php } ?>
                            </select>
                            </span></td>
                            <td data-title="Place"><span id="city1container">
                            <input  name="from[]" id="from1" type="text" placeholder="From" class="">
                            <input  name="to[]" id="to1" type="text" placeholder="To" class="">
                            </span></td>
                            <td data-title="Estimated Cost"><span id="cost1container">
                            <input type="text" class="" name="txtCost[]" id="txtCost" autocomplete="off" onkeyup="valPreCost(this.value,<?php echo $empuserid;?>);" onchange="valPreCost(this.value,<?php echo $empuserid;?>);"/>
                            </br><span class="red" id="show-exceed"></span>
                            <input type="hidden" value="1" name="ectype" id="ectype"/>
                            <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                            <input type="hidden" value="1" name="hiddenDraft" id="hiddenDraft"  />
                            <input type="hidden" value="<?php echo $empuserid; ?>" name="hiddenEmp" id="hiddenEmp" />
                            <input type="hidden" value="2" name="addnewrequest" id="addnewrequest" />
                            <input type="hidden" name="action" id="traveldesk_request_create" value="traveldesk_request_create">
                            </span></td>
                            <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>
                        </tr>
                      </tbody>
                    </table>
                    <span id="totaltable"> </span>
                    <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-traveldesk-requestappr" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
                    <span id="totaltable"> </span>
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
              
        </div><?php } ?>
        </div>
    </div>
</div>
