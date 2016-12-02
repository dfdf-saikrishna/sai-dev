
<?php ?>
<div class="wrap erp-company-designations" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e('Designations', 'company'); ?>
        <a href="#" id="erp-new-designations" class="add-new-h2" data-single="1"><?php _e('Add Desination', 'erp'); ?></a></h2>
    <h4> <?php _e('ADD / UPDATE / CLOSE Designations'); ?></h4>

    <?php
    global $wpdb;

    $table = new WeDevs\ERP\Company\Designation_List_Table();
    $table->prepare_items();
        ?>
        <div class="list-table-wrap erp-company-designations-wrap">
        <div class="list-table-inner erp-company-designations-wrap-inner">
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>


</div>
