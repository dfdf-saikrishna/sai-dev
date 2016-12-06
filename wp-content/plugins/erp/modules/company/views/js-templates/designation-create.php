<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
    <fieldset class="no-border">
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
        <input type="hidden" value="{{data.ADM_Id}}" name="company[adminid]" id="adminid">
         <input type="hidden" value="{{data.DES_Id}}" name="company[desId]" id="desId">
         <div class="row">
        <?php erp_html_form_label( __( 'Designations', 'erp' ), 'designation-title', true ); ?>
        <span class="field">
            <input value="{{data.DES_Name}}"  required name="company[txtDes]" id="txtDes" >
        </span>
         </div>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="hidden" name="action" id="erp-designation-action" value="designation_create">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>