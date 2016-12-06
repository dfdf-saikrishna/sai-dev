<?php
global $wpdb;
$compid = $_SESSION['compid'];
?>
<div class="erp-employee-form">
    <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
<!--    <input type="hidden" value="{{data.ADM_Id}}" name="company[adminid]" id="adminid">-->
    <input type="hidden" value="{{data.PC_Id}}" name="company[pcId]" id="pcId">
    <div class="row">
    <?php erp_html_form_label(__('Project Code', 'erp'), 'projectcode-title', true); ?>
        <span class="field">
            <input value="{{data.PC_Code}}"  required name="company[txtProjectCode]" id="txtProjectCode" >
        </span>
    </div>
    <div class="row">
    <?php erp_html_form_label(__('Project Name', 'erp'), 'projectcode-title', true); ?>
        <span class="field">
            <input value="{{data.PC_Name}}"  required name="company[txtProjectName]" id="txtProjectName" >
        </span>
    </div>
    <div class="row">
    <?php erp_html_form_label(__('Project Location', 'erp'), 'projectcode-title', true); ?>
        <span class="field">
            <input value="{{data.PC_Location}}"  required name="company[txtProjectLoc]" id="txtProjectLoc" >
        </span>
    </div>
     <div class="row">
        <?php erp_html_form_label( __( 'Project Description', 'erp' ), 'projectcode-desc' ); ?>
        <span class="field">
            <textarea name="company[txtProjectDesc]" id="txtProjectDesc" rows="2" cols="20" placeholder="<?php _e( 'Optional', 'erp' ); ?>">{{data.PC_Description}}</textarea>
        </span>
    </div>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );   ?>
    <input type="hidden" name="action" id="erp-projectcode-action" value="projectcode_create">
 <!--<input type="hidden" name="action" id="erp_company_projectcode_create" value="erp_company_projectcode_create">-->
</div>