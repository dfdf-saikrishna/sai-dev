<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
   <div class="row">
        <?php erp_html_form_label( __( 'Departments', 'erp' ), 'mileage-title', true ); ?>
        <span class="field">
          <input value="{{data.DEP_Name}}"  required name="company[txtDep]" id="txtDep" >
        </span>
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
         <input type="hidden" value="{{data.ADM_Id}}" name="company[adminid]" id="adminid">
        <input type="hidden" value="{{data.DEP_Id}}" name="company[depId]" id="depId">
        </div>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="hidden" name="action" id="erp-departments-action" value="departments_create">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>