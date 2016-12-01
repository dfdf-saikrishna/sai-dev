<?php ?>
<div class="wrap erp-company-mileage" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e('Travel Desk Claims', 'company'); ?>
<!--        <a href="#" id="erp-new-mileage" class="add-new-h2" data-single="1"><?php _e('Add Mileage', 'erp'); ?></a></h2>-->
    <h4> <?php _e('All Claim Invoices'); ?></h4>

    <?php
    global $wpdb;

    $table = new WeDevs\ERP\Company\TravelDeskInvoice_List_Table();
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
