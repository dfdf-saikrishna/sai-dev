<?php
global $showProCode;
global $etEdit;
global $totalcost;
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
$reqid = $_GET['reqid'];	
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
            <?php
                $row = 0;
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
                <form id="post_request_edit_form" name="input" action="#" method="post" enctype="multipart/form-data">
            <table class="wp-list-table widefat striped admins" border="0" id="table-post-travel">
                  <thead class="cf">
                    <tr>
                      <th class="column-primary">Date</th>
                      <th class="column-primary">Expense Description</th>
                      <th class="column-primary" colspan="2">Expense Category</th>
                      <th class="column-primary" >Place</th>
                      <th class="column-primary">Total Cost</th>
                      <th class="column-primary" >Upload bills / tickets</th>
                      <th class="column-primary">Action</th>
                    </tr>
                  </thead>
                    <tbody>
                    <?php 
				
				$selrequest=$wpdb->get_results("SELECT * FROM request_details WHERE REQ_Id='$reqid' AND RD_Status=1 ORDER BY RD_Dateoftravel ASC");
				
				$cnt	=	count($selrequest);
				
				$rows=1;
				foreach($selrequest as $rowrequest)
				{
				?>
                    <tr>
                      <td data-title="Date" class="scrollmsg"><input name="txtDate[]" style="width:110px;" id="txtDate<?php echo $rows; ?>" class="posttraveldate" placeholder="dd-mm-yyyy" autocomplete="off" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00 00:00:00") echo ""; else echo date('d-m-Y',strtotime($rowrequest->RD_Dateoftravel)); ?>"  /><input name="txtStartDate[]" id="txtStartDate1" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" />
                      <input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class="form-control" style="display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc1" class="form-control" autocomplete="off"><?php echo stripslashes($rowrequest->RD_Description) ?></textarea><input type="text" class="form-control" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Category"><select name="selExpcat[]" id="selExpcat<?php echo $rows; ?>" style="width:130px;" class="form-control" onchange="javascript:getMotPosttravel(this.value,<?php echo $rows; ?>)">
                          <option value="">Select</option>
                          <?php 
				  
				  $selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
				  
				  foreach($selexpcat as $rowexpcat){
				  
				  ?>
                          <option value="<?php echo $rowexpcat->EC_Id?>" <?php if($rowexpcat->EC_Id==$rowrequest->EC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->EC_Name; ?></option>
                          <?php } ?>
                        </select></td>
                      <td data-title="Category"><span id="modeoftr<?php echo $rows; ?>acontent">
                        <select name="selModeofTransp[]" id="selModeofTransp1" class="form-control" onchange="setFromTo(this.value, <?php echo $rows; ?>);">
                          <option value="">Select</option>
                          <?php             
					  $selsql=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id='$rowrequest->EC_Id' AND COM_Id IN (0, '$compid') AND MOD_Status=1");
					  
					  foreach($selsql as $rowsql){
					  ?>
                          <option value="<?php echo $rowsql->MOD_Id; ?>" <?php if($rowsql->MOD_Id==$rowrequest->MOD_Id) echo 'selected="selected"'; ?>><?php echo $rowsql->MOD_Name; ?></option>
                          <?php } ?>
                        </select>
                        </span></td>
                      <td data-title="City/Location"><span id="city<?php echo $rows; ?>container">
                       
                        <input  name="from[]" id="from<?php echo $rows; ?>" type="text" <?php if($rowrequest->EC_Id==2 || $rowrequest->EC_Id==4){ echo 'placeholder="Location"'; } else { echo 'placeholder="From"'; } ?> <?php if($rowrequest->MOD_Id==1) echo 'class="form-control places"'; else echo 'class="form-control"' ?> value="<?php echo $rowrequest->RD_Cityfrom?>"  autocomplete="off">
                        
                        
                        <input  name="to[]" id="to<?php echo $rows; ?>" type="text" placeholder="To" <?php if($rowrequest->MOD_Id==1) echo 'class="form-control places"'; else echo 'class="form-control"' ?> <?php if($rowrequest->EC_Id==2 || $rowrequest->EC_Id==4){ echo 'value="n/a" style="display:none;"'; } else { echo 'value="'.$rowrequest->RD_Cityto.'"'; } ?>  autocomplete="off">
                        <?php 
                        //echo $rowrequest['EC_Id'];
                        if($rowrequest->EC_Id==1 || $rowrequest->EC_Id==4) {
                          ?>
                        <select name="selStayDur[]" id="selStayDur<?php echo $rows; ?>" class="form-control" style="display:none;">
                          <option value="n/a">Select</option>
                        </select>
                        <?php
                        }else if($rowrequest->EC_Id==2){
                        ?>
                        <select name="selStayDur[]" id="selStayDur<?php echo $rows; ?>" class="form-control">
                          <option value="">Select</option>
                          <?php                     
						   $selsql=$wpdb->get_results("SELECT * FROM stay_duration");
						   
                            foreach($selsql as $rowsql){
                              ?>
                          <option value="<?php echo $rowsql->SD_Id;?>" <?php if($rowrequest->SD_Id==$rowsql->SD_Id) echo 'selected="selected"'; ?> ><?php echo $rowsql->SD_Name;?></option>
                          <?php } ?>
                        </select>
                        <?php } ?>
                        </span><input type="text" class="form-control" name="txtdist[]" id="txtdist<?php echo $rows;?>" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Total Cost"><input type="text" class="form-control" name="txtCost[]" style="width:110px;" id="txtCost<?php echo $rows; ?>" onkeyup="valCost(this.value);" autocomplete="off" value="<?php echo $rowrequest->RD_Cost;?>"/></td>
                      <td align="left" data-title="Upload bills"><?php 
                                                    
					$seluplfiles=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowrequest->RD_Id' AND RF_Status=1");
					
					$j=1;					
					foreach($seluplfiles as $rowuplfiles){
						
						$temp=explode(".",$rowuplfiles->RF_Name);
						$ext=end($temp);
						
						$fileurl="/erp/modules/company/upload/".$compid."/bills_tickets/".$rowuplfiles->RF_Name;
						
					?>
                        <span id="reqfilesid<?php echo $j.$rows; ?>"><?php echo $j.") "; ?> <a href="download-file.php?file=<?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a> &nbsp; <a onclick="return delFile(<?php echo $rowuplfiles->RF_Id; ?>,'reqfilesid<?php echo $j.$rows; ?>')" onmouseover="this.style.cursor='pointer'"><i class="fa fa-times" title="delete"></i></a></span><br />
                        <?php $j++; } ?>
                        <input type='file' name='file<?php echo $rows; ?>[]' id="file<?php echo $rows; ?>[]" style="width:150px;" multiple="true" onchange="Validate(this.id);"></td>
                        <td><span class="tooltip-area">
                       
                        <button type="submit" value="<?php echo $rowrequest->RD_Id; ?>" <?php if($cnt==1) echo 'disabled="disabled"'; ?>  class="button button-default" name="deleteRowbutton" onclick="return checkDeletRow();" ><i class="fa fa-trash-o"></i></button>
                        </span>
                        <input type="hidden" value="<?php echo $rowrequest->RD_Id; ?>" name="rdids[]"/></td>
                        <input type="hidden" value="2" name="ectype" id="ectype"/>
                        <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                        <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" id="reqid" />
                    </tr>
                    <?php
                    $totalcost+=$rowrequest->RD_Cost;
                    ?>
                    <?php $rows++; } ?>
                  </tbody>
                </table>
                <input type="hidden" id="hidrowno" name="hidrowno" value="<?php echo $rows-1; ?>" />                                    
            </div>
            <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                <tr>
                  <td align="right" width="85%">Claim Amount</td>
                  <td align="center" width="5%">:</td>
                  <td align="right"><?php echo IND_money_format($totalcost).".00"; ?></td>
                </tr>
            </table>
            <span id="totaltable"> </span>
            <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-row-posttravel-edit" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
            <div id="my_centered_buttons">
            <input type="submit" value="Update" name="update-pre-travel-request" id="update-pre-travel-request" class="button button-primary">
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
