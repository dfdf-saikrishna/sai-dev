
<h2><?php _e('Manager Listing - Account', 'company'); ?></h2>
        <?php
        global $wpdb;
        $table = new WeDevs\ERP\Company\Manager_Department_List_Table();
        $table->prepare_items();
        $message = '';
        if ('delete' === $table->current_action()) {
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'dep_manager_table'), count($_REQUEST['id'])) . '</p></div>';
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
