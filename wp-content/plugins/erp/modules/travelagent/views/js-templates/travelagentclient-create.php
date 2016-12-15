<div class="erp-employee-form">
    <fieldset class="no-border">
	<input type="hidden" name="traveldesk[user_id]" value="{{data.user_id}}">
	<input type="hidden" name="travelagentclient[user_id]" value="{{data.user_id}}">
	<input type="hidden" name="travelagentclient[COM_Id]" value="{{data.COM_Id}}">
	 <ol class="form-fields">
            <li>
                <label for="full-name">Upload Client Photo</label>
                <div class="photo-container">
                    <input name="travelagentclient[photo_id]" id="emp-photo-id" value="{{data.COM_PhotoId}}" type="hidden">
                   
                        <# if ( data.COM_Logo ) { #>
                        <img src="{{ data.COM_Logo }}" alt="" />
                        <a href="#" class="erp-remove-photo">&times;</a>
                        <# } else { #>
                            <a href="#" id="client-photo" class="button button-small">Select File</a>
                        <# } #>
                    
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
                    <textarea name="travelagentclient[txtaCompaddr]" required >{{data.COM_Address}}</textarea>
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
            <legend>Service Pricing</legend>
			     <ol class="form-fields ">
				 <?php $markupdown = get_markupdown_list(); 
                  $count = count($markupdown);
                  ?>
					<?php ?>	
                <li class="erp-hr-js-department" data-selected="{{ data.MC_Id}}">
                        <li>
                            <span>Modes</span>
                            <span>Tariff/fare Type</span>
                            <span>Mark Up/Down</span>
                            <span>Mark Tariff/fare</span>
                        </li>
						
						<li>
					<span>Flight</span>
					<span><select name="selFlightTerms" id="selFlightTerms" class="form-control input-sm">
					<option value="">Select</option>
					<?php for($i=0; $i<$count; $i++){ ?>
					<option value="<?php echo $markupdown[$i]->MC_Id; ?>"><?php echo $markupdown[$i]->MC_Name; ?></option>
					<?php } ?>
					</select></span>
					<span><input type="radio" name="company_markups_markdowns[radioFlightMarkStatus]" class="radioFlightMarkStatus" value="1"  checked="checked"/>
					Mark Up
					<input type="radio" name="company_markups_markdowns[radioFlightMarkStatus]" class="radioFlightMarkStatus" value="2"  />
					Mark Down 
					<input type="text" name="company_markups_markdowns[txtFlightMarkFare]" id="txtFlightMarkFare" class="form-control"  maxlength="4" /></span>
				</li>
				<li>
				<span>Bus</span>
				<span><select name="company_markups_markdowns[selBusTerms]" id="selBusTerms" class="form-control input-sm" >
				<option value="">Select</option>
				<?php for($i=0; $i<$count; $i++){ ?>
				<option value="<?php echo $markupdown[$i]->MC_Id; ?>"><?php echo $markupdown[$i]->MC_Name; ?></option>
				<?php } ?>
				</select></span>
				<span><input type="radio" name="company_markups_markdowns[radioBusMarkStatus]" class="radioBusMarkStatus" value="1"  checked="checked"/>
				Mark Up
				<input type="radio" name="company_markups_markdowns[radioBusMarkStatus]" class="radioBusMarkStatus" value="2"  />
				Mark Down 
				<input type="text" name="company_markups_markdowns[txtBusMarkFare]" id="txtBusMarkFare" class="form-control"  maxlength="4"  /></span>
				</li>
				<li>
				<span>Hotel</span>
				<span><select name="selHotelTerms" id="selHotelTerms" class="form-control input-sm">
				<option value="">Select</option>
				<?php for($i=0; $i<$count; $i++){ ?>
				<option value="<?php echo $markupdown[$i]->MC_Id; ?>"><?php echo $markupdown[$i]->MC_Name; ?></option>
				<?php } ?>
				</select></span>
				<span><input type="radio" name="company_markups_markdowns[radioHotelMarkStatus]" class="radioHotelMarkStatus" value="1"  checked="checked"/>
				Mark Up
				<input type="radio" name="company_markups_markdowns[radioHotelMarkStatus]" class="radioHotelMarkStatus" value="2"  />
				Mark Down 
				<input type="text" name="company_markups_markdowns[txtHotelMarkFare]" id="txtHotelMarkFare" class="form-control"  maxlength="4"  /></span>
				</li>
                </li>
            </ol>
        </fieldset>
		<fieldset>
		<ol class="form-fields ">
				 <?php $bankaccount = get_bankaccount_list(); 
                  $count = count($bankaccount);
                  ?>
						
                <li class="erp-hr-js-department" data-selected="0">
					<span>Bank Account</span>
					<span><select name="travelagentclient[selBankAccount]" id="travelagentclient[selBankAccount]" class="form-control input-sm">
					<option value="">Select</option>
					<?php for($i=0; $i<$count; $i++){ ?>
					<option value="<?php echo $bankaccount[$i]->TDBA_Id; ?>"><?php echo $bankaccount[$i]->TDBA_BankName .'-'. $bankaccount[$i]->TDBA_BranchName .'-'. $bankaccount[$i]->TDBA_AccountNumber ; ?></option>
					<?php } ?>
					</select></span>
				</li>
            </ol>
		</fieldset>
        <fieldset>
            <legend>Marketing/Sales Person's Comment</legend>

            <ol class="form-fields two-col">
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Marketing/Sales person's name</label>
                    <input required value="{{data.COM_Spname}}" name="travelagentclient[txtSalespersname]" id="personal[employee_id]" type="text">
                </li>
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="">Email-Id</label>
                    <input required value="{{data.COM_Spemail}}" name="travelagentclient[txtSalesperemail]" id="personal[employee_id]" type="text">
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
		<fieldset>
		<legend>Allocate Clients To Employees</legend>
		<ol class="form-fields ">
				 <?php $allocation = get_allocation_list(); 
                  $count = count($allocation);
                  ?>
						
                <li class="erp-hr-js-department" data-selected={{data.SUP_Id}}>
					<span>Employees (Multi Selectable)</span>
					<span><select required name="travelagentclient[selTrvAgntUser]" multiple="multiple id="selTrvAgntUser" class="form-control input-sm">
					<option value="">Select</option>
					<?php for($i=0; $i<$count; $i++){ ?>
					<option value="<?php echo $allocation[$i]->SUP_Id; ?>"><?php echo $allocation[$i]->SUP_Name .'-'. $allocation[$i]->SUP_Username ; ?></option>
					<?php } ?>
					</select></span>
				</li>
            </ol>
		</fieldset>
		<fieldset>
		<legend>Create Client/Account Travel Desk Login</legend>
		<ol class="form-fields ">	
                <li class="erp-hr-js-department" data-selected="0">
                    <label for="traveldesk[txtComTrvDeskUsername]">Username</label>
                    <input required value="{{data.COM_Spname}}" name="traveldesk[txtComTrvDeskUsername]" id="traveldesk[txtComTrvDeskUsername]" type="text">
                </li>
            </ol>
		</fieldset>
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="travelagentclient_create" value="travelagentclient_create">
</div>