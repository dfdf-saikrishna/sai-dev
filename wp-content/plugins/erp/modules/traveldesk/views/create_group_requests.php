<?php
global $wpdb;
global $showProCode;
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
            <option value="">Select</option>
       <?php foreach($allemps as $value){ ?>
          <option value="<?php echo $value->EMP_Id;?>"><?php echo $value->EMP_Code." - ".$value->EMP_Name; ?></option>
          <?php } ?>
        </select>
        </div>
    </div>
</div>
<div class="postbox">
    <div class="inside">
        <table class="wp-list-table widefat striped admins">
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    <?PHP 
                    
	  $selexpcat=$wpdb->get_results("SELECT * FROM project_code WHERE COM_Id='$compid' AND PC_Active=1");
	  
	  if(count($selexpcat)){
		
                    if($showProCode){
							
					?>
                    <td width="20%" style="color:#C66300;">Project Code</td>
                    <td width="5%">:</td>
                    <td width="25%"><?php 
	  if($row->PC_Id){
                    
		  if($rowpcname=$wpdb->get_row("SELECT PC_Code, PC_Name FROM project_code WHERE COM_Id='$compid' AND PC_Id=$row->PC_Id AND PC_Active=1")){
		  
			 echo $rowpcname->PC_Code.' -- '.$rowpcname->PC_Name;
		  
		  
		  } 
	  }  else {
	  
	  	echo 'None';
	  
	  }
	  ?></td>
                    <?php
				
				
			
			
		
		} else {
		
		?>
                    <td width="20%" style="color:#C66300;">Project Code</td>
                    <td width="5%">:</td>
                    <td width="25%"><select name="selProjectCode" id="selProjectCode" class="erp-select2">
                        <option value="">None</option>
                        <?php 
				  
				  foreach($selexpcat as $rowexpcat)
				  {
				  ?>
                        <option value="<?php echo $rowexpcat->PC_Id?>" <?php if($rowexpcat->PC_Id==$rowexpcat->PC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->PC_Code." -- ".$rowexpcat->PC_Name; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <?php	
		
		}
		
	  
	  ?>
                    <?php }  else { ?>
                    <td colspan="3">&nbsp;</td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    <?PHP 
	  
	  $selexpcat=$wpdb->get_results("SELECT * FROM cost_center WHERE COM_Id='$compid' AND CC_Active=1");
	  
	  if(count($selexpcat)){
		
		if($showProCode){
							
					?>
                    <td width="20%" style="color:#C66300;">Cost Center</td>
                    <td width="5%">:</td>
                    <td width="25%"><?php 
	  if($row[CC_Id]){
                      
		  if($rowpcname=$wpdb->get_row("SELECT CC_Code, CC_Name FROM cost_center WHERE COM_Id='$compid' AND CC_Id=$row->CC_Id AND CC_Active=1")){
		  
			 echo $rowpcname->CC_Code.' -- '.$rowpcname->CC_Name;
		  
		  
		  } 
	  }  else {
	  
	  	echo 'None';
	  
	  }
	  ?></td>
                    <?php
		
		} else {
		
		?>
                    <td width="20%" style="color:#C66300;">Cost Center</td>
                    <td width="5%">:</td>
                    <td width="25%"><select name="selCostCenter" id="selCostCenter" class="">
                        <option value="">None</option>
                        <?php 
				  
				  foreach($selexpcat as $rowexpcat)
				  {
				  ?>
                        <option value="<?php echo $rowexpcat->CC_Id?>" <?php if($rowexpcat->CC_Id==$rowexpcat->CC_Id) echo 'selected="selected"'; ?>><?php echo $rowexpcat->CC_Code." -- ".$rowexpcat->CC_Name; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <?php	
		
		}
		
	  
	  ?>
                    <?php }  else { ?>
                    <td colspan="3">&nbsp;</td>
                    <?php } ?>
                  </tr>
                </table>
        <div style="margin-top:60px;">
        <table class="wp-list-table widefat striped admins" id="table1" style="font-size:11px;">
        <thead>
          <tr>
            <th width="13%">Date</th>
            <th >Expense Description</th>
            <th colspan="2">Expense Category</th>
            <th >Place</th>
            <th>Unit Cost</th>
            <th>Total Cost</th>
            <th>Bills / Tickets</th>
          </tr>
        </thead>
        <tbody align="center">
          <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
          <input type="hidden" value="3" name="addnewrequest" id="addnewrequest"/>
          <input type="hidden" value="1" name="ectype"/>
          <tr>
            <td><input name="txtDate[]"  id="txtDate1" class="startdate erp-leave-date-field"placeholder="dd/mm/yyyy" autocomplete="off"/></td>
            <td><textarea name="txtaExpdesc[]" id="txtaExpdesc1" data-height="auto" class="" autocomplete="off"></textarea></td>
            <td ><select name="selExpcat[]" id="selExpcat1" class="" onchange="javascript:getMotPreTravel(this.value,1)">
                <option value="">Select</option>
                <?php 
                        
                        $selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2)");

                        foreach($selexpcat as $rowexpcat)
                        {
                        ?>
                <option value="<?php echo $rowexpcat->EC_Id?>" ><?php echo $rowexpcat->EC_Name; ?></option>
                <?php } ?>
              </select></td>
            <td ><span id="modeoftr1acontent">
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
              <input  name="from[]" id="from1" type="text" placeholder="From" class="" autocomplete="off">
              <input  name="to[]" id="to1" type="text" placeholder="To" class="" autocomplete="off" >
              </span></td>
            <td><input type="text" class="" name="txtTotalCost[]" id="txtTotalCost1" onkeyup="valGroupRequestCost(this.value);"  autocomplete="off"/>
            </td>
            <td><input type="text" class="" name="txtCost[]" id="txtCost1" autocomplete="off"/></td>
            <td><input type='file' name='file1[]' id="file1[]" multiple="true" onchange="Validate(this.id);"></td>
          </tr>
        </tbody>
      </table>
      <div id="my_centered_buttons">
        <span class="erp-loader" style="margin-left:67px;margin-top: 4px;display:none"></span>
        <input type="submit" name="submit-traveldesk-request_withoutappr" id="submit-post-travel-request" class="button button-primary">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" name="reset" id="reset" class="button">Reset</button>
      </div>
      </div>
    </div>
</div>
</form>
