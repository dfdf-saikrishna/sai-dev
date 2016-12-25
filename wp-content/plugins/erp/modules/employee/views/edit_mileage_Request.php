<?php
global $showProCode;
global $etEdit;
global $totalcost;
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$reqid  =   $_GET['reqid'];
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
            <h2><?php _e( 'Mileage Expense Request', 'employee' ); ?></h2>
            <code class="description">EDIT Request</code>
            <!-- Messages -->
            <?php if(isset($_GET['status'])){?>
            <div style="display:block" id="success" class="notice notice-success is-dismissible">
            <p id="p-success"><?php echo $_GET['msg'] ;?></p>
            </div>
            <?php } ?>
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
            <form name="post-travel-req-form" action="#" method="post" enctype="multipart/form-data">
            <?php
                require WPERP_EMPLOYEE_VIEWS."/employee-details.php";
            ?>
             <div style="margin-top:60px;">
            <!-- Request Details -->
            <?php _e(requestDetails(1));?>
            </div>
            <div style="margin-top:60px;">
                <h4 >/ Mileage Rates /</h4>
               <p style="border-bottom:thin dashed #999999;">&nbsp;</p>
               <?php
               $selamnt=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' AND MOD_Id='31' AND MIL_Status=1 AND MIL_Active=1");
               ?>
               <input type="hidden" id="hiddenTwowheeler" name="hiddenTwowheeler" value="<?php echo $selamnt->MIL_Amount?>" />
                <dl> <b>Two Wheeler:</b> <?php if($selamnt) echo  $selamnt->MIL_Amount; else echo 'N/A'; ?> / Km, 

                <?php   
                $selamnt=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' AND MOD_Id='32' AND MIL_Status=1 AND MIL_Active=1");
                ?>
              <input type="hidden" id="hiddenFourwheeler" name="hiddenFourwheeler" value="<?php if($selamnt) echo $selamnt->MIL_Amount?>" />
                
                <b>Four Wheeler:</b> <?php if($selamnt) echo $selamnt->MIL_Amount; else echo 'N/A'; ?></dl> / Km
                <form name="post-travel-req-form" action="#" method="post" enctype="multipart/form-data">
            <table class="wp-list-table widefat striped admins" border="0" id="table-mileage-travel">
                  <thead class="cf">
                    <tr>
                      <th class="column-primary">Date</th>
                      <th class="column-primary">Expense Description</th>
                      <th class="column-primary">Expenses Category</th>
                      <th class="column-primary" >City/Location</th>
                      <th class="column-primary">Distance (in km)</th>
                      <th class="column-primary">Total Cost</th>
                      <th class="column-primary">Upload Bills/Tickets</th>
                      <th class="column-primary">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
				
				$selrequest=$wpdb->get_results("SELECT * FROM request_details WHERE REQ_Id='$row->REQ_Id' AND RD_Status=1 ORDER BY RD_Dateoftravel ASC");
				
				$cnt	=	count($selrequest);
				
				$rows=1;
				foreach($selrequest as $rowrequest)
				{
				?>
                      <tr>
                      <input type="hidden" value="5" name="ectype"/>
                      <input type="hidden" value="0" name="expenseLimit">
                      <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" id="reqid" />
                      <td data-title="Date" class="scrollmsg"><input name="txtDate[]" style="width:101px;" id="txtDate<?php echo $rows; ?>" class="posttraveldate" placeholder="dd-mm-yyyy" autocomplete="off" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00 00:00:00") echo ""; else echo date('d-m-Y',strtotime($rowrequest->RD_Dateoftravel)); ?>"/><input name="txtStartDate[]" id="txtStartDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" />
                        <input name="txtEndDate[]" id="txtEndDate<?php echo $rows; ?>" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" />
                        <input type="text" name="textBillNo[]" id="textBillNo<?php echo $rows; ?>" autocomplete="off"  class="" style="display:none;" value="n/a"/></td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc<?php echo $rows; ?>" class="" autocomplete="off"><?php echo stripslashes($rowrequest->RD_Description) ?></textarea>
                        <select name="selExpcat[]" id="selExpcat<?php echo $rows; ?>" class="" style="display:none;">
                          <option value="5">select</option>
                        </select></td>
                       <td data-title="Category"><span id="modeoftr<?php echo $rows; ?>acontent">
                        <select name="selModeofTransp[]" id="selModeofTransp<?php echo $rows; ?>" class="form-control" style="width:110px;" onchange="return getAmount(this.value, <?php echo $rows; ?>);">
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
                        <input  name="from[]" id="from<?php echo $rows; ?>" type="text" placeholder="From" class="" value="<?php echo $rowrequest->RD_Cityfrom?>" autocomplete="off">
                        <input  name="to[]" id="to<?php echo $rows; ?>" type="text" placeholder="To" class="" value="<?php echo $rowrequest->RD_Cityto ?>" autocomplete="off">
                        </span><select name="selStayDur[]" class="" style="display:none;">
                          <option value="n/a">Select</option>
                        </select></td>
                      <td data-title="Distance (in km)"><input type="text" class="" name="txtdist[]" style="width:110px;"  id="txtdist<?php echo $rows; ?>" value="<?php echo $rowrequest->RD_Distance ?>" onkeyup="return mileageAmount(this.value, <?php echo $rows; ?>);" autocomplete="off"/></td>
                      <td data-title="Total Cost"> <input type="text" class="" name="txtCost[]" style="width:110px;" id="txtCost<?php echo $rows; ?>" value="<?php echo $rowrequest->RD_Cost;?>" readonly="readonly"  autocomplete="off"/></td>
                      <td align="left" data-title="Upload bills / tickets"><?php 
					
					$seluplfiles=$wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowrequest->RD_Id' AND RF_Status=1");
					
					$j=1;					
					foreach($seluplfiles as $rowuplfiles){
						
						$temp=explode(".",$rowuplfiles->RF_Name);
						$ext=end($temp);
						
						$fileurl="company/upload/".$compid."/bills_tickets/".$rowuplfiles->RF_Name;
						
					?>
                        <span id="reqfilesid<?php echo $j.$rows; ?>"><?php echo $j.") "; ?> <a href="download-file.php?file=<?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a> &nbsp; <a onclick="return delFile(<?php echo $rowuplfiles->RF_Id; ?>,'reqfilesid<?php echo $j.$rows; ?>')" onmouseover="this.style.cursor='pointer'"><i class="fa fa-times" title="delete"></i></a></span><br />
                        <?php $j++; } ?>
                        <input type='file' name='file<?php echo $rows; ?>[]' id="file<?php echo $rows; ?>[]" style="width:150px;" multiple="true" onchange="Validate(this.id);" style="width:150px;"><input type="hidden" value="<?php echo $rowrequest->RD_Id; ?>" name="rdids[]"/></td>
                        <td><button type="button" value="<?php echo $rowrequest->RD_Id; ?>" class="button button-default" name="deleteRowbutton" onclick="return checkDeletRow();" id="deleteRowbutton" title="delete row" <?php if($cnt==1) echo 'disabled="disabled"'; ?> ><i class="fa fa-trash-o"></i></button></td>
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
                <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-row-mileage-edit" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
                <span id="totaltable"> </span>
            </div>
            <div id="my_centered_buttons">
            <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
            <input type="submit" name="update-pre-travel-request" id="update-pre-travel-request" value="Update" class="button button-primary">
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
