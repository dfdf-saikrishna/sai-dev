<div class="erp-employee-form">

    
    <fieldset class="no-border">
        <ol class="form-fields">
            <li>
                <label for="full-name">Upload Company Logo</label>
                <div class="photo-container">
                    <input name="company[photo_id]" id="emp-photo-id" value="0" type="hidden">
                    
                        <a href="#" id="erp-set-emp-photo" class="button button-small">Select File</a>
                    
                </div>
            </li>
        </ol>
        <ol class="form-fields two-col">
                            <li>
                    <label for="txtCompname">CompanJHVy Name <span class="required">*</span></label><input required value="{{data.COM_Name}}" name="company[txtCompname]" id="txtCompname" type="text"></li>
                        <li>
                <label for="txtEmpCodePrefx">Employee Username Prefix <span class="required">*</span></label><input required value="{{data.COM_Prefix}}" name="company[txtEmpCodePrefx]" id="erp-hr-user-email"  type="text"></li>

        </ol>
        <ol class="form-fields two-col">
                            <li>
                    <label for="txtCompmob">Mobile <span class="required">*</span></label><input required value="{{data.COM_Mobile}}" pattern="[789][0-9]{9}" name="company[txtCompmob]" id="personal[employee_id]" type="text"></li>
                        <li>
                    <label for="txtCompemail">Email <span class="required">*</span></label><input required value="{{data.COM_Email}}"    name="company[txtCompemail]" id="erp-hr-user-email"  type="text"></li>
                        
                        <li><label for="txtComplandline">Landline</label><input value="{{data.COM_Landline}}" name="company[txtComplandline]" id="erp-hr-user-email"  type="text"></li>

        </ol>
    </fieldset>
            <fieldset>
            <legend>Location Details <span class="required">*</span></legend>

            <ol class="form-fields two-col">

                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]"><span class="required">*</span>Address</label>
                    <textarea name="company[txtaCompaddr]" required value="{{data.COM_Address}}"></textarea>
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Location</label>
                    <input value="{{data.COM_Location}}" name="company[txtCompoloc]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]"><span class="required">*</span>City</label>
                    <input value="{{data.COM_City}}" name="company[txtCompcity]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">State</label>
                    <input value="{{data.COM_State}}" name="company[txtCompstate]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
    <fieldset>
            <legend>Contact Person 1 <span class="required">*</span></legend>

            <ol class="form-fields two-col">

            
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]"><span class="required">*</span>Username</label>
                    <input value="{{data.COM_Cp1username}}" required name="company[txtCompcntp1name]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]"><span class="required">*</span>Email</label>
                    <input value="{{data.COM_Cp1email}}" required name="company[txtCompcntp1email]"  id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]"><span class="required">*</span>Mobile</label>
                    <input value="{{data.COM_Cp1mobile}}" required name="company[txtCompcntp1mob]" id="personal[employee_id]" pattern="[789][0-9]{9}" type="text">
                </li>

                
            </ol>
        </fieldset>
    <fieldset>
            <legend>Contact Person 2 <span class="required">*</span></legend>

            <ol class="form-fields two-col">

            
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Username</label>
                    <input value="{{data.COM_Cp2username}}" name="company[txtCompcntp2name]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Email</label>
                    <input value="{{data.COM_Cp2email}}" name="company[txtCompcntp2email]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Mobile</label>
                    <input value="{{data.COM_Cp2mobile}}" name="company[txtCompcntp2mob]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
        <fieldset>
            <legend>Settings</legend>

            <ol class="form-fields two-col">
<!--                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Color-Theme</label>
                    <select name="company[selCT]" id="personal[nationality]" class="erp-hrm-select2" tabindex="-1" aria-hidden="true">
                    <option value="">- Select -</option>
                    <option value="">Blue-White</option>
                    <option value="">Blue-Orange</option>
                    </select>
                </li>-->
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Get Quote Option<span class="required">*</span></label>
                    <span class="checkbox"><label for="user_notification"><input type="checkbox" value="{{data.COM_Flight}}" name="company[cbFlight]" id="user_notification">Flight</label></span>
                    <span class="checkbox"><label for="user_notification"><input type="checkbox" value="{{data.COM_Bus}}" name="company[cbBus]" id="user_notification">Bus</label></span>
                    <span class="checkbox"><label for="user_notification"><input type="checkbox" value="{{data.COM_Hotel}}" name="company[cbHotel]" id="user_notification">Hotel</label></span>
                </li>
            </ol>
        </fieldset>
        <fieldset>
            <legend>Marketing/Sales Person's Comment</legend>

            <ol class="form-fields two-col">
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Marketing/Sales person's name</label>
                    <input value="{{data.COM_Spname}}" name="company[txtSalespersname]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Email-Id</label>
                    <input value="{{data.COM_Spemail}}" name="company[txtSalesperemail]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Contact Number</label>
                    <input value="{{data.COM_Spcontactno}}" name="company[txtSalespercontno]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Description about this deal</label>
                    <textarea name="company[txtadescdeal]" value="{{data.COM_Descdeal}}"></textarea>
                </li>
                <li>
            </ol>
        </fieldset>
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="erp-employee-action" value="erp-hr-employee-new">
</div>