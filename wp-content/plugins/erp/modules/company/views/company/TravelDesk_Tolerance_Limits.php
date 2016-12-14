    <?php
    global $wpdb;
    $compid = $_SESSION['compid'];
    $row = $wpdb->get_results("SELECT * FROM tolerance_limits WHERE COM_Id='$compid' AND TL_Status=1 AND TL_Active=1");
    ?>
    <h2><?php _e('Travel Desk Tolerance Limits', 'company'); ?></h2>
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
    <div class="wrap erp-company-traveldesklimits" id="wp-erp">
        <div class="col-sm-3">
            <div class="form-group" style="margin:-31px 22px 0px 430px">
                <label class="control-label">Limit Percentage</label>
                <input type="hidden" id="tlId" >
                <div>
                    <input type="text" name="txtLimitPercentage" id="txtLimitPercentage" value="<?php echo $row[0]->TL_Percentage ? $row[0]->TL_Percentage : NULL; ?>" parsley-type="digits" parsley-required="true" placeholder="digits only" />
                    <button type="submit" class="button button-primary" id="submitToleranceLimits" ><?php echo $row[0]->TL_Id ? 'Update' : 'Submit'; ?></button>
                  
                </div>
            </div>
        </div>
        <?php
        global $wpdb;
        $table = new WeDevs\ERP\Company\TravelDesk_Tolerance_List_Table();
        $table->prepare_items();
        $message = '';
        if ('delete' === $table->current_action()) {
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'tolerance_limits_table'), count($_REQUEST['id'])) . '</p></div>';
        }
        ?>
        <div class="list-table-wrap erp-company-traveldesklimits-wrap">
            <div class="list-table-inner erp-company-traveldesklimits-wrap-inner">
                <form method="GET">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                    <?php $table->display() ?>
                </form>

            </div>
        </div>
          <input type="hidden" name="action" id="erp-tolerance-action" value="tolerance_limit_amount">
    </div>
