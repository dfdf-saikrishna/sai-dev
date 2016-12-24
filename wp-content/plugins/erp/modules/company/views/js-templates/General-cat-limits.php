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
            <?php erp_html_form_label(__('Local Conveyance', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Local_Conveyance}}"  required name="company[txtLocal]" id="txtLocal" >
            </span>
        </div>
        <div class="row">
            <?php erp_html_form_label(__('Client Meeting', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_ClientMeeting}}"  required name="company[txtClient]" id="txtClient" >
            </span>
        </div>
        
        <div class="row">
            <?php erp_html_form_label(__('Others', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Others_Other_te}}"  required name="company[txtOthers]" id="txtOthers" >
            </span>
        </div>
        <div class="row">
            <?php erp_html_form_label(__('Marketing', 'erp'), 'grades-title', true); ?>
            <span class="field">
                <input value="{{data.GL_Marketing}}"  required name="company[txtMarketing]" id="txtMarketing" >
            </span>
        </div>
      
    </fieldset>
    <input type="hidden" name="action" id="erp-gradelimit-action" value="gradelimits_get">
</div>