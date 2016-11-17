<div class="erp-employee-form">
    <fieldset class="no-border">
        <input type="hidden" value="{{data.user_id}}" name="admin[user_id]">
        <ol class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
            <?php $getcompany = get_company_list(); 
                  //print_r($getcompany);
                  $count = count($getcompany);
                  ?>
           <label for="comname">Select Company</label>
           <select id="selectCompany" name="admin[compnyadminname]" value="{{data.COM_Id}}" class="" tabindex="-1" aria-hidden="true">
           <option value="0">-SELECT COMPANY-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $getcompany[$i]->COM_Id; ?>"><?php echo $getcompany[$i]->COM_Name; ?></option>

               <?php } ?>
           </select>
          </li>
	</ol>
        
		 <ol class="form-fields two-col">
                            <li>
                    <label for="adminname">Admin Name </label><input value="{{data.ADM_Name}}"  name="admin[comadminname]" id="personal[employee_id]" type="text"></li>
                        
        </ol>
		 <ol class="form-fields two-col">
                            <li>
                    <label for="adminname">Admin Email </label><input value="{{data.ADM_Email}}" name="admin[comadminemail]" id="personal[employee_id]" type="text"></li>
                        
        </ol>
		 <ol class="form-fields two-col">
                            <li>
                    <label for="adminname">Admin Contact </label><input value="{{data.ADM_Cont}}" name="admin[comadmincontact]" id="personal[employee_id]" type="text"></li>
                        
        </ol>
		 <ol class="form-fields two-col">
                            <li>
                    <label for="adminname">Admin UserName </label><input value="{{data.ADM_Username}}" name="admin[comadminusername]" id="personal[employee_id]" type="text"></li>
                        
        </ol>
		

		
	
    </fieldset>
        <?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="companyadmin_create" value="companyadmin_create">
</div>