<?php
global $wpdb;
global $showProCode;
require_once WPERP_TRAVELDESK_PATH . '/includes/functions-group-requests.php';
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
        <code>CREATE Group Booking Request</code>
        <div style="text-align: center;">
        <label class="control-label">Search Employee :</label>
        <select class="erp-select2" style="width:50%;" multiple="multiple" name="selEmployees[]" id="selEmployees" parsley-required="true">
       <?php foreach($allemps as $value){ ?>
          <option value="<?php echo $value->EMP_Id;?>"><?php echo $value->EMP_Code." - ".$value->EMP_Name; ?></option>
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
          </tr>
        </thead>
          <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
          <input type="hidden" value="3" name="addnewrequest" id="addnewrequest"/>
          <input type="hidden" value="1" name="ectype"/>
          <tr>
            <td><input name="txtDate[]"  id="txtDate1" style="width:101px;" class="erp-leave-date-field"placeholder="dd/mm/yyyy" autocomplete="off"/></td>
            <td><textarea name="txtaExpdesc[]" id="txtaExpdesc1" data-height="auto" class="" autocomplete="off"></textarea></td>
            <td><select name="selExpcat[]" id="selExpcat1" class="" style="width:110px;" onchange="javascript:getMotPreTravel(this.value,1)">
                <option value="">Select</option>
                <?php 
                        
                        $selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2)");

                        foreach($selexpcat as $rowexpcat)
                        {
                        ?>
                <option value="<?php echo $rowexpcat->EC_Id?>" ><?php echo $rowexpcat->EC_Name; ?></option>
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
                <option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option>
                <?php } ?>
              </select>
              </span></td>
            <td><span id="city1container">
              <input  name="from[]" id="from1" type="text" style="width:130px;" placeholder="From" class="" autocomplete="off">
              <input  name="to[]" id="to1" type="text" style="width:130px;" placeholder="To" class="" autocomplete="off" >
              </span></td>
            <td><input type="text" class="" name="txtCost[]" id="txtCost1" style="width:110px;" onkeyup="valGroupRequestCost(this.value);"  autocomplete="off"/>
            </td>
            <td><input type="text" class="" name="txtTotalCost[]" onkeypress="return false;" id="txtTotalCost1" onkeyup="valPreCost(this.value);" style="width:110px;" autocomplete="off"/></td>
            <td><input type='file' name='file1[]' id="file1[]" multiple="true" style="width:150px;" onchange="Validate(this.id);"></td>
          </tr>
      </table>
      <span id="totaltable"> </span>
      <div style="float:right;"><a title="Add Rows" class="btn btn-default"><span id="add-traveldesk-groupreq" class="dashicons dashicons-plus-alt"></span></a><span id="removebuttoncontainer"></span></div>
      <div id="my_centered_buttons">
        <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
        <input type="submit" name="submit-traveldesk-request_withoutappr" id="submit-traveldesk-request_withoutappr" class="button button-primary">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="reset" id="reset" class="button">Reset</button>
      </div>
      </form>
      </div>
    </div>
</div>
</form>
