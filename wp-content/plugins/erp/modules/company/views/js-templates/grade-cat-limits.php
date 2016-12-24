<?php
global $wpdb;
$compid = $_SESSION['compid'];
?>
<div class="erp-employee-form">
    <fieldset class="no-border">
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
        <input type="hidden" value="{{data.EG_Id}}" name="company[egId]" id="egId">
        <input type="hidden" value="{{data.GL_Id}}" name="company[glId]" id="glId">
        <div class="row">
            <?php erp_html_form_label(__('Flight', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Flight}}"  required name="company[txtflight]" id="txtflight" >
            </span>
        </div>
        <div class="row">
            <?php erp_html_form_label(__('Bus', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Bus}}"  required name="company[txtBus]" id="txtBus" >
            </span>
        </div>
        <div class="row">
            <?php erp_html_form_label(__('Car', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Car}}"  required name="company[txtCar]" id="txtCar" >
            </span>
        </div>
        <div class="row">
            <?php erp_html_form_label(__('Others (Travel)', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Others_Travels}}"  required name="company[txtOthers1]" id="txtOthers1" >
            </span>
        </div>
    </fieldset>
    <?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );   ?>
    <input type="hidden" name="action" id="erp-gradelimit-action" value="gradelimits_get">
 <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>