<div class="erp-invoice-management">
    <fieldset class="no-border">
	 <div class="postbox leads-actions">
      <div class="inside">
        <ol class="form-fields two-col">
         <li class="erp-hr-js-department" data-selected={{data.COM_Id}}>
            <?php $companylist = get_invoicecompany_list(); 
                  $count = count($companylist);
                  ?>
           <label for="comname">Select Company</label>
           <select id="Companyinvoice" name="invoice[company]" value="{{data.COM_Id}}" class="" tabindex="-1" aria-hidden="true">
           <option value="0">-SELECT COMPANY-</option>
               <?php for($i=0; $i<$count; $i++){?>
               <option value="<?php echo $companylist[$i]->COM_Id; ?>"><?php echo $companylist[$i]->COM_Name; ?></option>

               <?php } ?>
           </select>
          </li>
	</ol>
     </div></div>   
    </fieldset>
        <div class="wrap erp-hr-companyinvoice" id="invoiceview" style="display:none">
		
		</div>
</div>