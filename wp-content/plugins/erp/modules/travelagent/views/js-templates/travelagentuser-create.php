<div class="erp-employee-form">   
    <fieldset class="no-border">
	<input type="hidden" name="travelagentuser[user_id]" value="{{ data.user_id }}">
        <ol class="form-fields">
			<li>
				<label for="txtUsername">User Name <span class="required">*</span></label>
				<input required value="{{ data.SUP_Username }}" name="travelagentuser[txtUsername]" id="txtUsername" type="text">
			</li>
			<li>
				<label for="txtAgencyName">Branch Name <span class="required">*</span></label>
				<input required value="{{ data.SUP_AgencyName }}" name="travelagentuser[txtAgencyName]" id="txtAgencyName"  type="text">
			</li>
			<li>
				<label for="txtAgencyCode">Branch Code <span class="required">*</span></label>
				<input required value="{{ data.SUP_AgencyCode }}"  name="travelagentuser[txtAgencyCode]" id="txtAgencyCode" type="text">
			</li>
			<li>
				<label for="txtAgentName">Employee Name  <span class="required">*</span></label>
				<input required value="{{ data.SUP_Name}}"    name="travelagentuser[txtAgentName]" id="txtAgentName"  type="text">
			</li>                       
			<li>
				<label for="txtEmail">Employee Email-Id </label>
				<input required  value="{{ data.SUP_Email }}" name="travelagentuser[txtEmail]" id="txtEmail"  type="email">
			</li>
			<li>
				<label for="txtPhn">Employee Phone No </label>
				<input required  value="{{ data.SUP_Contact }}" name="travelagentuser[txtPhn]" id="txtPhn"  type="number">
			</li>
		</ol>
    </fieldset>  
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="travelagentuser_create" value="travelagentuser_create">
</div>