 <h2><?php _e('Travel Desk Logs', 'company'); ?>
<div class="wrap erp-company-mileage" id="wp-erp">
    <?php
    global $wpdb;

    $table = new WeDevs\ERP\Company\TravelDeskLogs_List_Table();
    $table->prepare_items();
        ?>
        <div class="list-table-wrap erp-company-mileage-wrap">
        <div class="list-table-inner erp-company-mileage-wrap-inner">
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>
</div>
