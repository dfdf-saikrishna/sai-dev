<?php ?>
<div class="wrap erp-company-traveldesk" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e('Travel Desk', 'company'); ?>
        <a href="#" id="erp-new-traveldesk" class="add-new-h2" data-single="1"><?php _e('Add Travel Desk', 'erp'); ?></a></h2>
    <h4> <?php _e('ADD / UPDATE / CLOSE Travel Desk Login Details'); ?></h4>

    <?php
    global $wpdb;

    $table = new WeDevs\ERP\Company\TravelDesk_List_Table();
    $table->prepare_items();
        ?>
        <div class="list-table-wrap erp-company-traveldesk-wrap">
        <div class="list-table-inner erp-company-traveldesk-wrap-inner">
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>


</div>
