<div class="erp-employee-form">
    <div>
             <input type="hidden" value="{{data.user_id}}" name="company[user_id]" id="user_id">
        <div>  <ol class="form-fields two-col">
                <li>
                    <label for="Username">User Name <span class="required">*</span></label>
                    <input required value="{{data.SUP_Username}}" name="company[txtUsername]" id="txtUsername" type="text"></div></li>
            </ol>
            <div> <ol class="form-fields two-col">
                <li>
                    <label for="AgencyName">Agency Name </label><input required value="{{data.SUP_AgencyName}}" name="company[txtAgencyName]" id="txtAgencyName" type="text">
                </li> </ol></div>
            <div><ol class="form-fields two-col">
                    <li>
                <label for="Address">Agent Address</label>
                    <textarea name="company[txtaAddress]" required value="{{data.SUP_Address}}"> {{data.SUP_Address}}</textarea></li></ol>
            </div>
            <div><ol class="form-fields two-col"><li>
                <label for="AgentName">Agent Name<span class="required">*</span></label>
                <input required value="{{data.SUP_Name}}" name="company[txtAgentName]" id="txtUsername" type="text"></li></ol>
            </div>
            <div><ol class="form-fields two-col"><li>
                <label for="Email">Agent Email-Id<span class="required">*</span></label>
                <input required value="{{data.SUP_Email}}" name="company[txtEmail]" id="txtEmail" type="text"></li></ol>
            </div>
            <div><ol class="form-fields two-col"><li>
                <label for="Phn">Agent Phone No.<span class="required">*</span></label>
                <input required value="{{data.SUP_Contact}}" pattern="[789][0-9]{9}" name="company[txtPhn]" id="txtPhn" type="text"></div></li></ol>
                <input type="hidden" name="action" id="erp-travelagent-action" value="erp-hr-travelagent-new">
        </div>
