<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
    <fieldset class="no-border">
          <input type="text" value="{{data.user_id}}" name="company[user_id]" id="user_id">
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
        <input type="hidden" value="{{data.TD_Id}}" name="company[tdid]" id="tdid">
         <div> <ol class="form-fields two-col">
                <li>
                    <label for="txtUsername">User Name<span class="required">*</span></label><input  placeholder="minlength = 4" required value="{{data.TD_Username}}" name="company[txtUsername]" id="txtUsername" type="text">
                </li> </ol></div>
         <ol class="form-fields two-col">
            <li>
            <label for="email"> Email-Id <span class="required">*</span></label>
            <input value="{{data.TD_Email}}"  placeholder="Enter Email Id" required name="company[txtEmail]" type="email" id="txtEmail" >
            </li>
        </ol>
    </fieldset>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="hidden" name="action" id="traveldesk_create" value="traveldesk_create">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>