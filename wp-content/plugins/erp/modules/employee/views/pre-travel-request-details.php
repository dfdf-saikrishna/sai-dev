<?php
require_once WPERP_EMPLOYEE_PATH . '/includes/functions-pre-travel-req.php';
global $wpdb;
$compid = $_SESSION['compid'];
$empuserid = $_SESSION['empuserid'];
$empdetails=$wpdb->get_row("SELECT * FROM employees emp, company com, department dep, designation des, employee_grades eg WHERE emp.EMP_Id='$empuserid' AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id");
$repmngname = $wpdb->get_row("SELECT EMP_Name FROM employees WHERE EMP_Code='$empdetails->EMP_Reprtnmngrcode' AND COM_Id='$compid'");	
$selexpcat=$wpdb->get_results("SELECT * FROM expense_category WHERE EC_Id IN (1,2,4)");
$selmode=$wpdb->get_results("SELECT * FROM mode WHERE EC_Id IN (1,2,4) AND COM_Id IN (0, '$compid') AND MOD_Status=1");
?>
<style type="text/css">
#my_centered_buttons { text-align: center; width:100%; margin-top:60px; }
</style>
<div class="postbox">
    <div class="inside">
        <div class="wrap pre-travel-request" id="wp-erp">
            <h2><?php _e( 'Pre Travel Requests Details', 'employee' ); ?></h2>
            <code class="description">Request Details Display</code>
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
            <div style="margin-top:60px;">
            <table class="wp-list-table widefat striped admins">
              <tr>
                <td width="20%">Employee Code</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->EMP_Code?> (<?php echo $empdetails->EG_Name?>)</td>
                <td width="20%">Company Name</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo stripslashes($empdetails->COM_Name); ?></td>
              </tr>
              <tr>
                <td width="20%">Employee Name</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->EMP_Name; ?></td>
                <td width="20%">Reporting Manager Code</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->EMP_Reprtnmngrcode; ?></td>
              </tr>
              <tr>
                <td>Employee Designation </td>
                <td>:</td>
                <td><?php echo $empdetails->DES_Name; ?></td>
                <td>Reporting Manager Name</td>
                <td>:</td>
                <td><?php echo $repmngname->EMP_Name;?></td>
              </tr>
              <tr>
                <td width="20%">Employee Department</td>
                <td width="5%">:</td>
                <td width="25%"><?php echo $empdetails->DEP_Name; ?></td>

              </tr>
            </table>
            </div>
            <div style="margin-top:60px;">
            <!-- Request Details -->
            <?php _e(requestDetails(1));?>
            </div>
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
            <div style="margin-top:60px;">
            <form id="request_form" name="input" action="#" method="post">
            <table class="wp-list-table widefat striped admins" border="0" id="table1">
                  <thead class="cf">
                    <tr>
                      <th class="column-primary">Date</th>
                      <th class="column-primary">Expense Description</th>
                      <th class="column-primary" colspan="2">Expense Category</th>
                      <th class="column-primary" >Place</th>
                      <th class="column-primary">Estimated Cost</th>
                      <th class="column-primary">Select</th>
                      <th class="column-primary">Booking Status</th>
                      <th class="column-primary">Cancellation Status</th>
                      <th class="column-primary">Get Quote</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td data-title="Date" class=""><input name="txtDate[]" id="txtDate1" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"/>
                      <input name="txtStartDate[]" id="txtStartDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                      <input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc1" class="" autocomplete="off"></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Category"><select name="selExpcat[]" id="selExpcat1" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selexpcat as $rowexpcat)
				  {
				  ?>
                          <option value="<?php echo $rowexpcat->EC_Id?>" ><?php echo $rowexpcat->EC_Name; ?></option>
                          <?php } ?>
                         
                        </select></td>
                      <td data-title="Category"><span id="modeoftr1acontent">
                        <select name="selModeofTransp[]"  id="selModeofTransp1" class="">
                          <option value="">Select</option>
                          <?php
                          foreach($selmode as $rowsql)
					  {
					  ?>
                          <option value="<?php echo $rowsql->MOD_Id; ?>"><?php echo $rowsql->MOD_Name; ?></option>
                          <?php } ?>
                        </select>
                        </span></td>
                      <td data-title="Place"><span id="city1container">
                        <input  name="from[]" id="from1" type="text" placeholder="From" class="">
                        <input  name="to[]" id="to1" type="text" placeholder="To" class="">
                        </span></td>
                        <td data-title="Estimated Cost"><span id="cost1container">
                        <input type="text" class="" name="txtCost[]" id="txtCost" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/>
                        </br><span class="red" id="show-exceed"></span>
                        <input type="hidden" value="1" name="ectype" id="ectype"/>
                        <input type="hidden" value="0" name="expenseLimit" id="expenseLimit"/>
                        </span></td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                      <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>
                    </tr>
                  </tbody>
                </table>
                <span id="totaltable"> </span>
                </form>
            </div>
            <div id="my_centered_buttons">
            <button type="button" name="submit" id="submit-pre-travel-request" class="button button-primary">Submit</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" name="reset" id="reset" class="button">Reset</button>
            </div>
        </div>
        
        <!-- Notes -->
    <div class="note-tab-wrap erp-grid-container">
    <h3><?php _e( 'Send Notes', 'erp' ) ?></h3>

    <form action="" class="note-form row" method="post">
        <?php erp_html_form_input( array(
            'name'        => 'note',
            'required'    => true,
            'placeholder' => __( 'Add a note...', 'erp' ),
            'type'        => 'textarea',
            'custom_attr' => array( 'rows' => 3, 'cols' => 30 )
        ) ); ?>

        <input type="hidden" name="user_id" value="">
        <input type="hidden" name="action" id="erp-employee-action" value="erp-hr-employee-new-note">

        <?php wp_nonce_field( 'wp-erp-hr-employee-nonce' ); ?>
        <?php submit_button( __( 'Send Note', 'erp' ), 'primary' ); ?>
        <span class="erp-loader erp-note-loader"></span>
    </form>

    <?php
    //$no_of_notes = 10;
    //$total_notes = $employee->count_notes();
    //$notes = $employee->get_notes( $no_of_notes );

    //if ( $notes ) {
        ?>
        <ul class="erp-list notes-list">
            <?php //foreach( $notes as $note ) { ?>
            <li>
                <div class="avatar-wrap">
                    <?php // get_avatar( $note->user->user_email, 64 ); ?>
                </div>

                <div class="note-wrap">
                    <div class="by">
                        <a href="#" class="author"><?php //echo $note->user->display_name; ?></a>
                        <span class="date"><?php //echo erp_format_date( $note->created_at, __( 'M j, Y \a\t g:i a', 'erp' ) ); ?></span>
                    </div>

                    <div class="note-body">
                        <?php //echo wpautop( $note->comment ); ?>
                    </div>
                    <?php //if( current_user_can( 'manage_options' ) OR (wp_get_current_user()->ID == $note->comment_by ) ) { ?>
                        <div class="row-action">
                        <!--<span class="delete"><a href="#" class="delete_note" data-note_id=""><?php //_e( 'Delete', 'erp' ); ?></a></span>-->
                        </div>
                    <?php //} ?>
                </div>
            </li>
            <?php //} ?>
        </ul>



    <?php //} ?>
     <?php  //$display_class =  ( $no_of_notes < $total_notes ) ? 'show':'hide' ; ?>
    <div class="wperp-load-more-btn <?php //echo $display_class?>">
        <input type="submit" value="Load More">
    </div>

</div>
    </div>
    
</div>
