<?php
global $showProCode;
global $etEdit;
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
            <h2><?php _e( 'Pre Travel Expense Request', 'employee' ); ?></h2>
            <code class="description">ADD Request</code>
            <form id="request_form" name="input" action="#" method="post">
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
            <?php
                $row=0;
                require WPERP_EMPLOYEE_VIEWS."/employee-details.php";
            ?>
            <div style="margin-top:60px;">
            
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
                        ?>
                    <tr>
                      <td data-title="Date" class=""><input name="txtDate[]" id="txtDate<?php echo $rows; ?>" class="pretraveldate" placeholder="dd/mm/yyyy" autocomplete="off"/>
                      <input name="txtStartDate[]" id="txtStartDate<?php echo $rows; ?>" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate<?php echo $rows; ?>" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                      <input type="text" name="textBillNo[]" id="textBillNo<?php echo $rows; ?>" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc<?php echo $rows; ?>" class="" autocomplete="off"></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Category"><select name="selExpcat[]" id="selExpcat<?php echo $rows; ?>" onchange="javascript:getMotPreTravel(this.value,1)" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selexpcat as $rowexpcat)
				  {
				  ?>
                          <option value="<?php echo $rowexpcat->EC_Id?>" ><?php echo $rowexpcat->EC_Name; ?></option>
                          <?php } ?>
                         
                        </select></td>
                      <td data-title="Category"><span id="modeoftr<?php echo $rows; ?>acontent">
                        <select name="selModeofTransp[]"  id="selModeofTransp<?php echo $rows; ?>" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selmode as $rowsql)
					  {
					  ?>
                          <option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option>
                          <?php } ?>
                        </select>
                        </span></td>
                        <td data-title="Place"><span id="city<?php echo $rows; ?>container">
                        <input  name="from[]" id="from<?php echo $rows; ?>" type="text" placeholder="From" class="">
                        <input  name="to[]" id="to<?php echo $rows; ?>" type="text" placeholder="To" class="">
                        </span></td>
                        <td data-title="Estimated Cost"><span id="cost<?php echo $rows; ?>container">
                        <input type="text" class="" name="txtCost[]" id="txtCost<?php echo $rows; ?>" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/>
                        </br><span class="red" id="show-exceed"></span>
                        <input type="hidden" value="1" name="ectype" id="ectype"/>
                        <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                        <input type="hidden" name="action" id="send_pre_travel_request" value="send_pre_travel_request">
                        </span></td>
                      <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>
                    </tr>
                    <?php 
                    $rows++;
                    ?>
                  </tbody>
                </table>
                <span id="totaltable"></span>
                <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-row-pretravel" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
            </div>
            <div id="my_centered_buttons">
                <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
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
                   <?php _e(gradeLimits(''));?>
                </div>
            </div><!-- .postbox -->
        </div>
    </div>
    
</div>
