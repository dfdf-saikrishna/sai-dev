<div class="erp-employee-form">

    
    <fieldset class="no-border">
        <ol class="form-fields two-col">
                            <li>
                    <label for="txtCompname">Company Name <span class="required">*</span></label><input value="" name="company[txtCompname]" id="txtCompname" type="text"></li>
                        <li>
                <label for="txtEmpCodePrefx">Employee Username Prefix <span class="required">*</span></label><input value="" name="company[txtEmpCodePrefx]" id="erp-hr-user-email"  type="text"></li>

        </ol>
        <ol class="form-fields two-col">
                            <li>
                    <label for="txtCompmob">Mobile </label><input value="" name="company[txtCompmob]" id="personal[employee_id]" type="text"></li>
                        <li>
                    <label for="txtCompemail">Email <span class="required">*</span></label><input value="" name="company[txtCompemail]" id="erp-hr-user-email"  type="email"></li>
                        
                        <li><label for="txtComplandline">Landline</label><input value="" name="company[txtComplandline]" id="erp-hr-user-email"  type="text"></li>

        </ol>
    </fieldset>
            <fieldset>
            <legend>Location Details <span class="required">*</span></legend>

            <ol class="form-fields two-col">

                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Address</label>
                    <textarea name="company[txtaCompaddr]"></textarea>
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Location</label>
                    <input value="" name="company[txtCompoloc]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">City</label>
                    <input value="" name="company[txtCompcity]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">State</label>
                    <input value="" name="company[txtCompstate]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
    <fieldset>
            <legend>Contact Person 1 <span class="required">*</span></legend>

            <ol class="form-fields two-col">

            
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Username</label>
                    <input value="" name="company[txtCompcntp1name]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Email</label>
                    <input value="" name="company[txtCompcntp1email]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Mobile</label>
                    <input value="" name="company[txtCompcntp1mob]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
    <fieldset>
            <legend>Contact Person 2 <span class="required">*</span></legend>

            <ol class="form-fields two-col">

            
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Username</label>
                    <input value="" name="company[txtCompcntp2name]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Email</label>
                    <input value="" name="company[txtCompcntp2email]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Mobile</label>
                    <input value="" name="company[txtCompcntp2mob]" id="personal[employee_id]" type="text">
                </li>

                
            </ol>
        </fieldset>
        <fieldset>
            <legend>Settings</legend>

            <ol class="form-fields two-col">
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Color-Theme</label>
                    <select name="company[selCT]" id="personal[nationality]" class="erp-hrm-select2" tabindex="-1" aria-hidden="true">
                    <option value="-1">- Select -</option>
                    <option value="-1">Blue-White</option>
                    <option value="-1">Blue-Orange</option>
                    </select>
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Get Quote Option</label>
                    <span class="checkbox"><label for="user_notification"><input type="checkbox" value="on" name="company[cbFlight]" id="user_notification">Flight</label></span>
                    <span class="checkbox"><label for="user_notification"><input type="checkbox" value="on" name="company[cbBus]" id="user_notification">Bus</label></span>
                    <span class="checkbox"><label for="user_notification"><input type="checkbox" value="on" name="company[cbHotel]" id="user_notification">Hotel</label></span>
                </li>
            </ol>
        </fieldset>
        <fieldset>
            <legend>Marketing/Sales Person's Comment</legend>

            <ol class="form-fields two-col">
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Marketing/Sales person's name</label>
                    <input value="" name="company[txtSalespersname]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Email-Id</label>
                    <input value="" name="company[txtSalesperemail]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Contact Number</label>
                    <input value="" name="company[txtSalespercontno]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="work[department]">Description about this deal</label>
                    <textarea name="company[txtadescdeal]"></textarea>
                </li>
                <li>
            </ol>
        </fieldset>
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="companyadmin_create" value="companyadmin_create">
</div>