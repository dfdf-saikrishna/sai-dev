<?php
global $showProCode;
global $etEdit;
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
global $totalcost;
$paytotd=0;
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$row=$wpdb->get_row("SELECT * FROM requests req, request_employee re, employees emp WHERE req.REQ_Id='$reqid' AND req.COM_Id=$compid AND req.COM_Id=emp.COM_Id AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND req.REQ_Active=1 AND re.RE_Status=1");
$empuserid = $_SESSION['empuserid'];
$selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
$selmode=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id IN (1,2,4) AND COM_Id IN (0, '$compid') AND MOD_Status=1");
$row=$wpdb->get_row("SELECT * FROM requests req, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND REQ_Active=1 AND re.RE_Status=1");
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
            <?php
                require WPERP_EMPLOYEE_VIEWS."/employee-details.php";
            ?>
            <div style="margin-top:60px;">
            <!-- Request Details -->
            <?php _e(requestDetails(3));?>
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
            <table class="wp-list-table widefat striped admins" border="0" id="table-others-travel">
                  <thead class="cf">
                    <tr>
                       <th>Date</th>
                      <th>Expense Description</th>
                      <th>Expense Category</th>
                      <th>Total Cost</th>
                      <th>Upload
                        bills / tickets</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
				
				$selrequest=$wpdb->get_results("SELECT * FROM request_details WHERE REQ_Id='$row->REQ_Id' AND RD_Status=1 ORDER BY RD_Id ASC");
				
				$cntRows	= count($selrequest);
				
				$rows=1;			
				
				foreach($selrequest as $rowrequest)
				{
				?>
                    <tr>
                      <input type="hidden" value="3" name="ectype"/>
                      <input type="hidden" value="0" name="expenseLimit">
                      <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" id="reqid" />
                      <input type="hidden" value="n/a" name="selStayDur[]" id="selStayDur<?php echo $rows; ?>" style="display:none;">
                      <td data-title="Date" class="scrollmsg"><input name="txtDate[]" id="txtDate1" class="startdate form-control" placeholder="dd/mm/yyyy" autocomplete="off" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00") echo ""; else echo date('d-m-Y',strtotime($rowrequest->RD_Dateoftravel)); ?>"  />
                        <input name="txtStartDate[]" id="txtStartDate1" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" />
                        <input name="txtEndDate[]" id="txtEndDate1" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" />
                        <input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class="form-control" style="display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc1" class="form-control"><?php echo stripslashes($rowrequest->RD_Description) ?></textarea>
                        <select name="selExpcat[]" id="selExpcat1" class="form-control" style="display:none;">
                          <option value="3">select</option>
                        </select></td>
                      <td data-title="Category"><span id="modeoftr1acontent">
                        <select name="selModeofTransp[]" id="selModeofTransp1" class="form-control">
                          <option value="">Select</option>
                          <?php 
					  
					  $selsql=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id=3 AND COM_Id IN (0, '$compid') AND MOD_Status=1");
					  
					  foreach($selsql as $rowsql){
					  ?>
                          <option value="<?php echo $rowsql->MOD_Id; ?>" <?php if($rowsql->MOD_Id==$rowrequest->MOD_Id) echo 'selected="selected"'; ?>><?php echo $rowsql->MOD_Name; ?></option>
                          <?php } ?>
                        </select>
                        </span></td>
                      <td data-title="Total Cost"><input name="from[]" id="city1" type="text" placeholder="From" class="form-control" value="n/a" style="display:none;">
                        <input name="to[]" id="city2" type="text" placeholder="To" class="form-control" value="n/a" style="display:none;">
                        <input type="text" class="form-control" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/>
                        <input type="text" class="form-control" name="txtCost[]" id="txtCost1" onkeyup="valCost(this.value);" autocomplete="off" value="<?php echo $rowrequest->RD_Cost;?>"/></td>
                      <td align="left" data-title="Upload Bills / Tickets"><?php 
					
					$seluplfiles=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowrequest->RD_Id' AND RF_Status=1");
					
					$j=1;
					
					foreach($seluplfiles as $rowuplfiles){
					
						$temp=explode(".",$rowuplfiles->RF_Name);
						$ext=end($temp);
						
						$fileurl="company/upload/".$compid."/bills_tickets/".$rowuplfiles->RF_Name;
					
					?>
                        <span id="reqfilesid<?php echo $j.$rows; ?>"><?php echo $j.") "; ?> <a href="download-file.php?file=<?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a> &nbsp; <a onclick="return delFile(<?php echo $rowuplfiles->RF_Id; ?>,'reqfilesid<?php echo $j.$rows; ?>')" onmouseover="this.style.cursor='pointer'"><i class="fa fa-times" title="delete"></i></a></span><br />
                        <?php $j++; } ?>
                        <input type='file' name='file<?php echo $rows; ?>[]' id="file<?php echo $rows; ?>[]" multiple="true" onchange="Validate(this.id);"></td>
                      <td data-title="Actions"><span class="tooltip-area">
                        <button type="submit" value="<?php echo $rowrequest->RD_Id; ?>" class="btn btn-small btn-default" name="deleteRowbutton" onclick="return checkDeletRow();" <?php if($cntRows==1) echo 'disabled="disabled"'; ?> ><i class="fa fa-trash-o"></i></button>
                        </span>
                        <input type="hidden" value="<?php echo $rowrequest->RD_Id; ?>" name="rdids[]"/></td>
                    </tr>
                    <?php 
					  $totalcost+=$rowrequest->RD_Cost;
					  ?>
                    <?php $rows++; } ?>
                  </tbody>
                  <input type="hidden" id="hidrowno" name="hidrowno" value="<?php echo $rows-1;?>" />
                </table>
                <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                  <tr>
                    <td align="right" width="85%">Claim Amount</td>
                    <td align="center" width="5%">:</td>
                    <td align="right"><?php echo IND_money_format($totalcost).".00"; ?></td>
                  </tr>
                </table>
                <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-row-others-edit" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
            </div>
            <div id="my_centered_buttons">
            <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
            <input type="submit" name="update-pre-travel-request" id="update-pre-travel-request" value="Update" class="button button-primary">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" name="reset" id="reset" class="button">Reset</button>
            </div>
            </form>
        </div>
    </div>
    
</div>
