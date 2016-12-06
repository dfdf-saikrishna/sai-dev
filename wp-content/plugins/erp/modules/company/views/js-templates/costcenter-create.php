<?php
global $wpdb;
$compid = $_SESSION['compid'];
?>
<!-- Messages -->
<div style="display:none" id="failure" class="notice notice-error is-dismissible">
    <p id="p-failure"></p>
</div>

<div style="display:none" id="notice" class="notice notice-warning is-dismissible">
    <p id="p-notice"></p>
</div>

<div style="display:none" id="success" class="notice notice-success is-dismissible">
    <p id="p-success"></p>
</div>

<div style="display:none" id="info" class="notice notice-info is-dismissible">
    <p id="p-info"></p>
</div>
<div class="erp-employee-form">
    <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
<!--    <input type="hidden" value="{{data.ADM_Id}}" name="company[adminid]" id="adminid">-->
    <input type="text" value="{{data.CC_Id}}" name="company[ccId]" id="ccId">
    <div class="row">
        <?php erp_html_form_label(__('CostCenter Code', 'erp'), 'costcenter-title', true); ?>
        <span class="field">
            <input value="{{data.CC_Code}}"  required name="company[txtCostCenterCode]" id="txtCostCenterCode" >
        </span>
    </div>
    <div class="row">
        <?php erp_html_form_label(__('CostCenter Name', 'erp'), 'costcenter-title', true); ?>
        <span class="field">
            <input value="{{data.CC_Name}}"  required name="company[txtCostCenterName]" id="txtCostCenterName" >
        </span>
    </div>
    <div class="row">
        <?php erp_html_form_label(__('CostCenter Location', 'erp'), 'costcenter-title', true); ?>
        <span class="field">
            <input value="{{data.CC_Location}}"  required name="company[txtCostCenterLoc]" id="txtCostCenterLoc" >
        </span>
    </div>
    <div class="row">
        <?php erp_html_form_label(__('CC Description', 'erp'), 'costcenter-desc'); ?>
        <span class="field">
            <textarea name="company[txtCostCenterDesc]" id="txtCostCenterDesc" rows="2" cols="20" placeholder="<?php _e('Optional', 'erp'); ?>">{{data.CC_Description}}</textarea>
        </span>
    </div>

    <?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );   ?>
    <input type="hidden" name="action" id="erp-costcenter-action" value="costcenter_create">
 <!--<input type="hidden" name="action" id="erp_company_costcenter_create" value="erp_company_costcenter_create">-->
</div>