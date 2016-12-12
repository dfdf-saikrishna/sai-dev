<div class="erp-employee-form">
    <fieldset class="no-border">
         <input type="hidden" value="" name="travel_desk[user_id]">
       
        
		 <ol class="form-fields two-col">
                            <li>
                    <label for="adminname">User Name </label><input value=""  name="travel_desk[travelcomname]" id="travel-desk[travelcomname]" type="text"></li>
                        
        </ol>
		 <ol class="form-fields two-col">
                            <li>
                    <label for="adminname">Email-Id </label><input value="" name="travel_desk[travelcomemail]" id="travel-desk[travelcomemail]" type="text"></li>
                        
        </ol>
		
    </fieldset>
        <?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="travelcompanyadmin_create" value="travelcompanyadmin_create">
</div>