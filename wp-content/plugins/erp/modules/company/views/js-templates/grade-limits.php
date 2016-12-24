<?php  
  global $wpdb;
$compid = $_SESSION['compid'];?>
<div class="erp-employee-form">
    <fieldset class="no-border">
        <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
         <input type="hidden" value="{{data.EG_Id}}" name="company[egId]" id="egId">
          <input type="hidden" value="{{data.GL_Id}}" name="company[glId]" id="glId">
        <div class="row">
        <?php erp_html_form_label( __( 'Flight', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Flight}}"  required name="company[txtflight]" id="txtflight" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Bus', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Bus}}"  required name="company[txtBus]" id="txtBus" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Car', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
                <input value="{{data.GL_Car}}"  required name="company[txtCar]" id="txtCar" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Others (Travel)', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Others_Travels}}"  required name="company[txtOthers1]" id="txtOthers1" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Hotel', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Hotel}}"  required name="company[txtHotel]" id="txtHotel" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Self', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Self}}"  required name="company[txtSelf]" id="txtSelf" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Halt', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Halt}}"  required name="company[txtHalt]" id="txtHalt" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Boarding', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Boarding}}"  required name="company[txtBoarding]" id="txtBoarding" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Others', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Other_Te_Others}}"  required name="company[txtOthers]" id="txtOthers" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Local Conveyance', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Local_Conveyance}}"  required name="company[txtLocal]" id="txtLocal" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Mobile', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Mobile}}"  required name="company[txtMobile]" id="txtMobile" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Client Meeting', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_ClientMeeting}}"  required name="company[txtClient]" id="txtClient" >
        </span>
        </div>
          <div class="row">
        <?php erp_html_form_label( __( 'Others Expenses', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Others_Other_te}}"  required name="company[txtOthers]" id="txtOthers" >
        </span>
        </div>
          <div class="row">
        <?php erp_html_form_label( __( 'Data Card', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_DataCard}}"  required name="company[txtData]" id="txtData" >
        </span>
        </div>
          <div class="row">
        <?php erp_html_form_label( __( 'Marketing', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Marketing}}"  required name="company[txtMarketing]" id="txtMarketing" >
        </span>
        </div>
         <div class="row">
        <?php erp_html_form_label( __( 'Two wheeler', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Twowheeler}}"  required name="company[txtTwo]" id="txtTwo" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Four wheeler', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Fourwheeler}}"  required name="company[txtFour]" id="txtFour" >
        </span>
        </div>
           <div class="row">
        <?php erp_html_form_label( __( 'Internet', 'erp' ), 'grades-title', true ); ?>
        <span class="field">
            <input value="{{data.GL_Internet}}"  required name="company[txtInternet]" id="txtInternet" >
        </span>
        </div>
    </fieldset>
<?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );  ?>
       <input type="text" name="action" id="erp-gradelimit-action" value="gradelimits_get">
    <!--<input type="hidden" name="action" id="erp_company_mileage_create" value="erp_company_mileage_create">-->
</div>