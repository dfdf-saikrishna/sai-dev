<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
    <fieldset class="no-border">
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
         <input type="hidden" value="{{data.ADM_Id}}" name="company[adminid]" id="adminid">
            <input type="hidden" value="{{data.DEP_Id}}" name="company[depId]" id="depId">
         <ol class="form-fields two-col">
            <li>
            <label for="Departments">  Departments <span class="required">*</span></label>
            <input value="{{data.DEP_Name}}"  required name="company[txtDep]" id="txtDep" >
            </li>
        </ol>
    </fieldset>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="hidden" name="action" id="erp-departments-action" value="departments_create">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>