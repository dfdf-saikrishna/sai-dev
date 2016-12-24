<?php
global $wpdb;
global $showProCode;
global $totalcost;
require_once WPERP_TRAVELDESK_PATH . '/includes/functions-group-requests.php';
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$allemps=$wpdb->get_results("SELECT EMP_Id, EMP_Code, EMP_Name FROM employees WHERE COM_Id='$compid' AND EMP_Status=1 ORDER BY EMP_Name ASC");
?>
<style type="text/css">
#my_centered_buttons { text-align: center; width:100%; margin-top:60px; }
</style>
<form name="post-travel-req-form" action="#" method="post" enctype="multipart/form-data">
<div class="postbox">
    <div class="inside">
        <h2>Group Request</h2>
        <code>Edit Group Booking Request</code>
        <div style="text-align: center;">
        <label class="control-label">Employees :</label>
        <?php
            $selsql=$wpdb->get_results("SELECT EMP_Id FROM request_employee WHERE REQ_Id='$reqid' AND RE_Status=1");
			  
            $temp_array=array();


            $c=0;
            foreach($selsql as $values){

                  $temp_array[]=$values->EMP_Id;

                  $c++;

            }
            $empCount = count($selsql);
        ?>
        <select class="erp-select2" style="width:50%;" multiple="multiple" name="selEmployees[]" id="selEmployees" parsley-required="true">
        <?php foreach($allemps as $value){ ?>
          <option value="<?php echo $value->EMP_Id;?>" <?php echo (in_array($value->EMP_Id,$temp_array)) ? 'selected="selected"' : ''; ?>><?php echo $value->EMP_Code." - ".$value->EMP_Name; ?></option>
          <?php } ?>
        </select>
        </div>
    </div>
</div>
<div class="postbox">
    <div class="inside">
        <?php
            $row=0;
            require WPERP_TRAVELDESK_VIEWS."/employee-details.php"; 
        ?>
        <div style="margin-top:60px;">
        <form id="group_request" name="traveldesk_request" action="#" method="post" enctype="multipart/form-data">
        <table class="wp-list-table widefat striped admins" id="group_request">
        <thead>
          <tr>
            <th>Date</th>
            <th >Expense Description</th>
            <th colspan="2">Expense Category</th>
            <th >Place</th>
            <th>Unit Cost</th>
            <th>Total Cost</th>
            <th>Bills / Tickets</th>
            <th>Action</th>
          </tr>
        </thead>
            <?php
            
            $rows=1;
            $row = $wpdb->get_row("SELECT * FROM requests WHERE REQ_Id='$reqid' AND COM_Id='$compid' AND REQ_Active != 9");
            $selrequest=$wpdb->get_results("SELECT * FROM request_details WHERE REQ_Id='$row->REQ_Id' AND RD_Status=1 ORDER BY RD_Id ASC");

            $cntRds	=	count($selrequest);

            //echo $cntRds;

            foreach($selrequest as $rowrequest)
            {

            ?>
          <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
          <input type="hidden" value="1" name="ectype"/>
          <input type="hidden" value="<?php echo $reqid; ?>" name="reqid" id="reqid"/>
          <input type="hidden" name="updateRequest" id="updateRequest" value="5">
          <tr>
            <td><input name="txtDate[]"  id="txtDate1" style="width:101px;" class="erp-leave-date-field"placeholder="dd/mm/yyyy" value="<?php if($rowrequest->RD_Dateoftravel=="0000-00-00") echo ""; else echo date('d-m-Y',strtotime($rowrequest->RD_Dateoftravel)); ?>" autocomplete="off"/></td>
            <td><textarea name="txtaExpdesc[]" rows="2" cols="12" id="txtaExpdesc1" data-height="auto" class="" autocomplete="off"><?php echo stripslashes($rowrequest->RD_Description); ?></textarea></td>
            <td><select name="selExpcat[]" id="selExpcat1" class="" style="width:110px;" onchange="javascript:getMotPreTravel(this.value,1)">
                <option value="">Select</option>
                <?php 
                        
                        $selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2)");

                        foreach($selexpcat as $rowexpcat)
                        {
                        ?>
                <option value="<?php echo $rowexpcat->EC_Id?>" <?php if($rowexpcat->EC_Id==$rowrequest->EC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->EC_Name; ?></option>
                <?php } ?>
              </select></td>
            <td><span id="modeoftr1acontent">
              <select name="selModeofTransp[]" id="selModeofTransp1" class="" onchange="setFromTo(this.value, 1);">
                <option value="">Select</option>
                <?php					  
                                $selsql=$wpdb->get_results("SELECT * FROM mode WHERE MOD_Id IN (1,2,5)");

                                foreach($selsql as $rowsql)
                                {
                                ?>
                <option value="<?php echo $rowsql->MOD_Id; ?>" <?php if($rowsql->MOD_Id==$rowrequest->MOD_Id) echo 'selected="selected"'; ?>><?php echo $rowsql->MOD_Name; ?></option>
                <?php } ?>
              </select>
              </span></td>
            <td><span id="city1container">
              <input  name="from[]" id="from1" type="text" style="width:130px;" <?php echo ($rowrequest->EC_Id==2) ? 'placeholder="Location"' : 'placeholder="From"' ; ?> class="" value="<?php echo $rowrequest->RD_Cityfrom?>" autocomplete="off">
              <input  name="to[]" id="to1" type="text" style="width:130px;" placeholder="To" class="" <?php if($rowrequest->EC_Id==2 || $rowrequest->EC_Id==4){ echo 'value="n/a" style="display:none;"'; } else { echo 'value="'.$rowrequest->RD_Cityto.'"'; } ?> autocomplete="off" >
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
            <select name="selStayDur[]" id="selStayDur<?php echo $rows; ?>" class="form-control" style="width:101px;">
              <option value="">Select</option>
              <?php 
             $selsql=$wpdb->get_results("SELECT * FROM stay_duration");

                foreach($selsql as $rowsql){
                  ?>
              <option value="<?php echo $rowsql->SD_Id;?>" <?php if($rowrequest->SD_Id==$rowsql->SD_Id) echo 'selected="selected"'; ?> ><?php echo $rowsql->SD_Name;?></option>
              <?php } ?>
            </select>
            <?php } ?>
            </span> </td>
            <?php 
            $perempcost=$rowrequest->RD_Cost/($c);

            ?>
            <td><input type="text" class="" name="txtCost[]" id="txtCost<?php echo $rows; ?>" style="width:110px;" onkeyup="valGroupRequestCost(this.value);" value="<?php echo $perempcost; ?>" autocomplete="off"/>
            </td>
            <td><input type="text" class="" name="txtTotalCost[]" value="<?php echo $rowrequest->RD_Cost;?>" id="txtTotalCost<?php echo $rows; ?>" style="width:110px;" autocomplete="off"/></td>
            <td>
            <?php 			
            $seluplfiles=$wpdb->get_results("SELECT BD_Id, BD_Filename FROM booking_status bs, booking_documents bd WHERE bs.RD_Id='$rowrequest->RD_Id' AND bs.BS_Id=bd.BS_Id AND BS_Active=1 AND BD_Status=1");

            $j=1;					
            foreach($seluplfiles as $rowuplfiles){

                    $temp=explode(".",$rowuplfiles->BD_Filename);
                    $ext=end($temp);

                    $fileurl="../company/upload/".$compid."/bills_tickets/".$rowuplfiles->BD_Filename;

            ?>
            <span id="reqfilesid<?php echo $j.$rows; ?>"> <?php echo $j.") "; ?> <a href="download-file.php?file=<?php echo $fileurl; ?>"><?php echo 'file'.$j.".".$ext;  ?></a> &nbsp; <a onclick="return delFile(<?php echo $rowuplfiles->BD_Id; ?>,'reqfilesid<?php echo $j.$rows; ?>')" onmouseover="this.style.cursor='pointer'"><i class="fa fa-times" title="delete"></i></a> </span> <br />
            <?php $j++; } ?>
            <input type='file' name='file<?php echo $rows; ?>[]' id="file<?php echo $rows; ?>[]" multiple="true" style="width:150px;" onchange="Validate(this.id);"></td>
            <td><button type="button" value="<?php echo $rowrequest->RD_Id; ?>" class="button button-default" name="deleteRowbutton" onclick="return checkDeletRow();" id="deleteRowbutton" title="delete row" <?php if($cntRds == 1) echo 'disabled="disabled"'; ?>><i class="fa fa-trash-o"></i></button>
            <input type="hidden" value="<?php echo $rowrequest->RD_Id; ?>" name="rdids[]"/></td>
          </tr>
          <?php 
            $rows++; 
            $totalcost+=$rowrequest->RD_Cost;
            } ?>
      </table>
      <input type="hidden" id="hidrowno" name="hidrowno" value="<?php echo $rows-1; ?>" />
      <span id="totaltable"> 
      <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
        <tr>
          <td align="right" width="85%">Total Cost</td>
          <td align="center" width="5%">:</td>
          <td align="right" width="10%"><?php echo IND_money_format($totalcost).".00"; ?></td>
        </tr>
      </table>
      </span>
      <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-traveldesk-groupreq-edit" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
      <div id="my_centered_buttons">
        <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
        <input type="submit" name="update-traveldesk-request_withoutappr" id="update-traveldesk-request_withoutappr" value="update" class="button button-primary">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="reset" id="reset" class="button">Reset</button>
      </div>
      </form>
      </div>
    </div>
</div>
</form>
