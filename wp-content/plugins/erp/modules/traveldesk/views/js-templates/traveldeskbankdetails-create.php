<div class="erp-employee-form">   
    <fieldset class="no-border">
	<input type="hidden" name="traveldeskbankdetails[TDBA_Id]" value="{{ data.TDBA_Id }}">
        <ol class="form-fields two-col">
			<li>
				<label for="txtFullname">Account Holder's Full Name <span class="required">*</span></label>
				<input required value="{{ data.TDBA_Fullname }}" name="traveldeskbankdetails[txtFullname]" id="txtFullname" type="text">
			</li>
			<li>
				<label for="txtAccnumber">Account Number<span class="required">*</span></label>
				<input required value="{{ data.TDBA_AccountNumber }}" name="traveldeskbankdetails[txtAccnumber]" id="txtAccnumber"  type="text">
			</li>
			<li>
				<label for="txtBankName">Bank Name<span class="required">*</span></label>
				<input required value="{{ data.TDBA_BankName}}"    name="traveldeskbankdetails[txtBankName]" id="txtBankName"  type="text">
			</li>                       
			<li>
				<label for="txtBranchName">Branch Name</label>
				<input value="{{ data.TDBA_BranchName }}" name="traveldeskbankdetails[txtBranchName]" id="txtBranchName"  type="text">
			</li>
			<li>
				<label for="txtIfsc">Bank IFSC Code</label>
				<input value="{{ data.TDBA_BankIfscCode }}" name="traveldeskbankdetails[txtIfsc]" id="txtIfsc"  type="text">
			</li>
			<li> 
				<label for="txtAccountType">Account Type</label>
				<input value="{{ data.TDBA_AccountType }}" name="traveldeskbankdetails[txtAccountType]" id="txtAccountType"  type="text">
			</li>
		</ol>
    </fieldset>  
        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <input type="hidden" name="action" id="traveldeskbankdetails_create" value="traveldeskbankdetails_create">
</div>