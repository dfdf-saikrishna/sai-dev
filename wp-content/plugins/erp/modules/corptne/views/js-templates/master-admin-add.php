<div class="erp-employee-form">
    <fieldset class="no-border">
	     <ol class="form-fields two-col">
		 <input type="hidden" name="masteradmin[user_id]" value="{{data.user_id}}" >
              <li>
                <label for="txtUsername">Username </label><input required name="masteradmin[txtUsername]" value="{{data.SUP_Username}}" id="txtUsername" type="text"></li>
              <li>
                <label for="txtName">Master Admin Name </label><input required name="masteradmin[txtName]" value="{{data.SUP_Name}}" id="txtName" type="text"></li>
              
			  <li>
              <label for="txtEmail">Email </label><input required  name="masteradmin[txtEmail]" id="txtEmail" value="{{data.SUP_Email}}" type="email"></li>
        </ol>
        <ol class="form-fields two-col">
            <li><label for="txtMob">Mobile </label><input required  name="masteradmin[txtMob]" id="txtMob" value="{{data.SUP_Contact}}"  type="number"></li>         
            <!--<li><label for="selAccess">Access Level</label><input  required name="masteradmin[selAccess]" value="{{data.SUP_Access}}"  id="selAccess"  type="text"></li>-->
	    <li><label for="selAccess">Access Level</label>
	    <select name="masteradmin[selAccess]" id="selAccess">
                <option value="1" >Yes</option>
                <option value="9" >NO</option>
            </select>
			</li>
	   </ol>
	  
        </fieldset>
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="masteradmin_create" value="masteradmin_create">
</div>
		