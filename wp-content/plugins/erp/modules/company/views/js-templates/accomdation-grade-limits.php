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
            <?php erp_html_form_label(__('Hotel', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Hotel}}"  required name="company[txtHotel]" id="txtHotel" >
            </span>
        </div>
        <div class="row">
            <?php erp_html_form_label(__('Self', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Self}}"  required name="company[txtSelf]" id="txtSelf" >
            </span>
        </div>
    </fieldset>
    <input type="hidden" name="action" id="erp-gradelimit-action" value="gradelimits_get">
</div>