<?php ?>
<div class="wrap erp-company-costcenter" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e('Cost Center', 'company'); ?>
        <a href="#" id="erp-new-costcenter" class="add-new-h2" data-single="1"><?php _e(' Add Cost Center', 'erp'); ?></a></h2>
    <h4> <?php _e('ADD / UPDATE / CLOSE Cost Center'); ?></h4>

    <?php
    global $wpdb;
    $table = new WeDevs\ERP\Company\CostCenter_List_Table();
    $table->prepare_items();
    
//    $message = '';
//        if ('delete' === $table->current_action()) {
//            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
//        }
        ?>
        <div class="list-table-wrap erp-company-costcenter-wrap">
        <div class="list-table-inner erp-company-costcenter-wrap-inner">
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>


</div>
