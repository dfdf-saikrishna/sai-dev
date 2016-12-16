<?php
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
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
            <h2><?php _e( 'Utility Expense Request', 'employee' ); ?></h2>
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
                <form name="post-travel-req-form" action="#" method="post" enctype="multipart/form-data">
            <table class="wp-list-table widefat striped admins" border="0" id="table1">
                  <thead class="cf">
                    <tr>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Expense Description</th>
                      <th>Expense Category</th>
                      <th>Bill Number</th>
                      <th>Bill Amount (Rs)</th>
                      <th>Upload Bills/Tickets</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="text-align:center;" data-title="Start Date" class="scrollmsg"><input name="txtStartDate[]" id="txtStartDate1" class="startdate erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"/>
                        <input name="txtDate[]" id="txtDate1" class="" placeholder="dd/mm/yyyy" style="display:none;" value="n/a"/></td>
                      <td style="text-align:center;" data-title="End Date" class="scrollmsg"><input name="txtEndDate[]" id="txtEndDate1" class="startdate erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"/></td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc1" class="" autocomplete="off"></textarea>
                        <select name="selExpcat[]" id="selExpcat1" class="" style="display:none;">
                          <option value="6">select</option>
                        </select></td>
                      <td data-title="Category"><span id="modeoftr1acontent">
                        <select name="selModeofTransp[]" id="selModeofTransp1" class="" style="width:110px;" onchange="return setFromTo(this.value, 1);">
                          <option value="">Select</option>
                          <?php 
					  
					  $selsql=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id=6 AND COM_Id IN (0, '$compid') AND MOD_Status=1");
					  
					  foreach($selsql as $rowsql)
					  {
					  ?>
                          <option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option>
                          <?php } ?>
                        </select>
                        </span></td>
                      <td data-title="Bill Number"><input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class=""/></td>
                      <td data-title="Bill Amount (Rs)"><span id="city1container">
                        <input type="text" class="" name="txtCost[]" id="txtCost1" onkeyup="valCost(this.value);" autocomplete="off"/>
                        <input  name="from[]" id="from1" type="text" style="display:none;" value="n/a" placeholder="From" class=""  autocomplete="off">
                        <input  name="to[]" id="to1" type="text" placeholder="To" class="" value="n/a" style="display:none;"  autocomplete="off">
                        <select name="selStayDur[]" class="" style="display:none;">
                          <option value="n/a">Select</option>
                        </select>
                        <input type="text" class="" name="txtdist[]"  id="txtdist1" style="display:none;width:110px;" value="n/a" autocomplete="off" />
                        </span> </td>
                      <td data-title="Upload bills"><input type='file' name='file1[]' id="file1[]" multiple="true" onchange="Validate(this.id);"></td>
                    </tr>
                  </tbody>
                </table>
                <span id="totaltable"> </span>
            </div>
            <div id="my_centered_buttons">
                <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
            <input type="submit" name="submit-post-travel-request" id="submit-post-travel-request" class="button button-primary">
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
                   <?php _e(gradeLimits(''));?>
                </div>
            </div><!-- .postbox -->
        </div>
    </div>
    
</div>
