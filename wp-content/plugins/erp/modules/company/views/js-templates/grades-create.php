<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
    <fieldset class="no-border">
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
         <input type="hidden" value="{{data.EG_Id}}" name="company[egId]" id="egId">
        <div class="row">
        <?php erp_html_form_label( __( 'Grades', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.EG_Name}}"  required name="company[txtGrade]" id="txtGrade" >
        </span>
        </div>
    </fieldset>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="hidden" name="action" id="erp-grades-action" value="grades_create">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>