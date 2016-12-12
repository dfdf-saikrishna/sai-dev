 <h2 class="erp-hide-print"><?php _e( 'ADD Bank Details', 'erp' );?> </h2>
 <label class="color">Bank Details   :<strong>ADD / EDIT / DELETE</strong> </label></br></br>
<div class="wrap erp-emp-travel" id="wp-erp">
        <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">
         <ul class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
            <?php $getbankdetails = get_traveldesk_bank_details(); 
                //  print_r($getbankdetails);
                  $count = count($getbankdetails);
                  ?>
              <div class="form-group">
                <label class="control-label">Upload / Change Passbook Image</label>
                <div>
                     <div class="erp-avatar">
                       <img src="<?php echo $getbankdetails[0]->TDBA_ImageFrontView; ?>" width="100px" />
		    </div>
                    <div> <span class="btn btn-default btn-file"> <span class="fileinput-new"><?php echo $getbankdetails[0]->TDBA_ImageFrontView ? 'Change image' : 'Select image'; ?></span><span class="fileinput-exists"></span>
                      <input type="file" name="fileComplogo" id="fileComplogo" onchange="">
                      </span> <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
                 
                  <span class=""> <a>Only jpg, jpeg, png, gif images allowed, upto 2mb size</a> <i class="fa fa-info"></i></span>
                  <input type="hidden" name="oldfile" id="oldfile" value="<?php echo $getbankdetails[0]->TDBA_ImageFrontView ;?>" />
                </div>
              </div></br>
             
           <label for="comname">Full Name</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_Fullname; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           
            <label for="comname">Account Number</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_AccountNumber; ?>" class="" tabindex="-1" aria-hidden="true"></input>
         </li>
             </ul>
        </div>
           
            <div class="list-table-inner erp-hr-employees-wrap-inner">
             <ul class="form-fields two-col">
           <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
            <label for="comname">Bank Details</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_BankName; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           
            <label for="comname">Branch Name</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_BranchName; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           </li>
           </ul>
        </div>
           
            <div class="list-table-inner erp-hr-employees-wrap-inner">
             <ul class="form-fields two-col">
            <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
            <label for="comname">Bank IFSC Code</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_BankIfscCode; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           
            <label for="comname">Country</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_Country; ?>" class="" tabindex="-1" aria-hidden="true"></input>
            </li>
            </ul>
        </div>
           
             <div class="list-table-inner erp-hr-employees-wrap-inner">
             <ul class="form-fields two-col">
              <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
              <label for="comname">State</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_State; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           
              <label for="comname">Issued At</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_IssuedAt; ?>" class="" tabindex="-1" aria-hidden="true"></input>
            </li>
            </ul>
        </div>
           
             <div class="list-table-inner erp-hr-employees-wrap-inner">
             <ul class="form-fields two-col">
             <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
              <label for="comname">Account Type</label>
           <input id="selectCompany" name="bankdetails[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_AccountType; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           
              <label for="comname">Issued Date</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_DateofIssue; ?>" class="" tabindex="-1" aria-hidden="true"></input>
            </ul>
        </div>
            
            <div class="list-table-inner erp-hr-employees-wrap-inner">
             <ul class="form-fields two-col">
             <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
              <label for="comname">Nominee Name</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_NomineeName; ?>" class="" tabindex="-1" aria-hidden="true"></input>
           
              <label for="comname">Nominee Relation to me</label>
           <input id="selectCompany" name="admin[compnyadminname]" value="<?php echo $getbankdetails[0]->TDBA_NomineeRelation; ?>" class="" tabindex="-1" aria-hidden="true"></input>
        </li>
	</ul>
        </div>
        </div>
    
        <div>
        <button type="hidden" name="submitBank" id="bank_details_create" value="bank_details_create" class="">Update</button>
        </div>
</div>
