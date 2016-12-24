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
            <?php erp_html_form_label(__('Halt', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Halt}}"  required name="company[txtHalt]" id="txtHalt" >
            </span>
        </div>
         <div class="row">
            <?php erp_html_form_label(__('Boarding', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Boarding}}"  required name="company[txtBoarding]" id="txtBoarding" >
            </span>
        </div>
        
        <div class="row">
            <?php erp_html_form_label(__('Others', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Other_Te_Others}}"  required name="company[txtOthers]" id="txtOthers" >
            </span>
        </div>
    </fieldset>
    <input type="hidden" name="action" id="erp-gradelimit-action" value="gradelimits_get">
</div>