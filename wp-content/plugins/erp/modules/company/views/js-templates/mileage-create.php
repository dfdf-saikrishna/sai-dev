<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
    <fieldset class="no-border">
        
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
        <div class="row">
            <?php
                $getmileage = get_mileage_type();
               // print_r($getfinance);
                $count = count($getmileage);
                ?>
        <?php erp_html_form_label( __( 'Mileage Type', 'erp' ), 'Mileage-type' ); ?>
        <span class="field">
            <select name="company[selectmileage]" required id="selectmileage"  aria-hidden="true" id="selectmileage">
                 <option value="0">-SELECT -</option>
                <?php for ($i = 0; $i < $count; $i++) { ?>
                        <option value="<?php echo $getmileage[$i]->MOD_Id; ?>"><?php echo $getmileage[$i]->MOD_Name ?></option>
                <?php } ?>
            </select>
        </span>
    </div>
          <div class="row">
       <?php erp_html_form_label( __( 'Units', 'erp' ), 'mileage-title', true ); ?>
                 <span class="field">
                <select id="units" name="company[units]" required="true" id="units" value="{{data.MIL_Units}}"  aria-hidden="true">
                    <option required>km</option></span>
                </select>
          </div>
         <div class="row">
        <?php erp_html_form_label( __( 'Amount', 'erp' ), 'mileage-title', true ); ?>
        <span class="field">
            <input value="{{data.MIL_Amount}}"  placeholder="digits only" required name="company[txtMilAmount]" type="number" id="txtMilAmount" >
        </span>
        </div>
<!--         <ol class="form-fields two-col">
            <li>
            <label for="Amount"> Amount <span class="required">*</span></label>
            <input value="{{data.MIL_Amount}}"  placeholder="digits only" required name="company[txtMilAmount]" type="number" id="txtMilAmount" >
            </li>
        </ol>-->
    </fieldset>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="hidden" name="action" id="erp-mileage-action" value="mileage_create">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>