<div class="erp-employee-form">
    <fieldset class="no-border">
        <ol class="form-fields">
            <li>
                <label for="full-name">Upload Client Logo</label>
                <div class="photo-container">
                    <input name="travelagentclient[photo_id]" id="emp-photo-id" value="0" type="hidden">
                    
                        <a href="#" id="erp-set-emp-photo" class="button button-small">Select File</a>
                    
                </div>
            </li>
        </ol>
        <ol class="form-fields two-col">
                            <li>
                    <label for="txtCompname">Client Name<span class="required">*</span></label><input required value="{{data.COM_Name}}" name="travelagentclient[txtCompname]" id="txtCompname" type="text"></li>
                        <li>
                <label for="txtEmpCodePrefx">Employee Username Prefix <span class="required">*</span></label><input required value="{{data.COM_Prefix}}" name="travelagentclient[txtEmpCodePrefx]" id="erp-hr-user-email"  type="text"></li>

        </ol>
        <ol class="form-fields two-col">
		<li>
                    <label for="txtCompemail">Email <span class="required">*</span></label><input required value="{{data.COM_Email}}"    name="travelagentclient[txtCompemail]" id="erp-hr-user-email"  type="text"></li>
                        
                            <li>
                    <label for="txtCompmob">Mobile <span class="required">*</span></label><input required value="{{data.COM_Mobile}}" pattern="[789][0-9]{9}" name="travelagentclient[txtCompmob]" id="personal[employee_id]" type="text"></li>
                        
                        <li><label for="txtComplandline">Landline</label><input value="{{data.COM_Landline}}" name="travelagentclient[txtComplandline]" id="erp-hr-user-email"  type="text"></li>
						<li class="erp-hr-js-department" data-selected="0">
                    <label for=""><span class="required">*</span>Address</label>
                    <textarea name="travelagentclient[txtaCompaddr]" required value="{{data.COM_Address}}"></textarea>
                </li>
					
		</ol>
    </fieldset>
            <fieldset>
            <legend>Location Details <span class="required">*</span></legend>

            <ol class="form-fields two-col">

                
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Location</label>
                    <input value="{{data.COM_Location}}" name="travelagentclient[txtCompoloc]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for=""><span class="required">*</span>City</label>
                    <input value="{{data.COM_City}}" name="travelagentclient[txtCompcity]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">State</label>
                    <input value="{{data.COM_State}}" name="travelagentclient[txtCompstate]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
    <fieldset>
            <legend>Contact Person 1 <span class="required">*</span></legend>

            <ol class="form-fields two-col">

            
                <li class="erp-hr-js-department" data-selected="0">
                    <label for=""><span class="required">*</span>Username</label>
                    <input value="{{data.COM_Cp1username}}" required name="travelagentclient[txtCompcntp1name]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for=""><span class="required">*</span>Email</label>
                    <input value="{{data.COM_Cp1email}}" required name="travelagentclient[txtCompcntp1email]"  id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for=""><span class="required">*</span>Mobile</label>
                    <input value="{{data.COM_Cp1mobile}}" required name="travelagentclient[txtCompcntp1mob]" id="personal[employee_id]" pattern="[789][0-9]{9}" type="text">
                </li>

                
            </ol>
        </fieldset>
    <fieldset>
            <legend>Contact Person 2 <span class="required">*</span></legend>

            <ol class="form-fields two-col">

            
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Username</label>
                    <input value="{{data.COM_Cp2username}}" name="travelagentclient[txtCompcntp2name]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Email</label>
                    <input value="{{data.COM_Cp2email}}" name="travelagentclient[txtCompcntp2email]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Mobile</label>
                    <input value="{{data.COM_Cp2mobile}}" name="travelagentclient[txtCompcntp2mob]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
        
		
        <fieldset>
            <legend>Marketing/Sales Person's Comment</legend>

            <ol class="form-fields two-col">
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Marketing/Sales person's name</label>
                    <input value="{{data.COM_Spname}}" name="travelagentclient[txtSalespersname]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Email-Id</label>
                    <input value="{{data.COM_Spemail}}" name="travelagentclient[txtSalesperemail]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Contact Number</label>
                    <input value="{{data.COM_Spcontactno}}" name="travelagentclient[txtSalespercontno]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Description about this deal</label>
                    <textarea name="travelagentclient[txtadescdeal]" value="{{data.COM_Descdeal}}"></textarea>
                </li>
                <li>
            </ol>
        </fieldset>
		
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="travelagentuser_create" value="travelagentuser_create">
</div>