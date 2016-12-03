
<?php ?>
<div class="wrap erp-company-departments" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e('Departments', 'company'); ?>
        <a href="#" id="erp-new-departments" class="add-new-h2" data-single="1"><?php _e('Add Departments', 'erp'); ?></a></h2>
    <h4> <?php _e('ADD / UPDATE / CLOSE Departments'); ?></h4>

    <?php
    global $wpdb;

    $table = new WeDevs\ERP\Company\Departments_List_Table();
    $table->prepare_items();
        ?>
        <div class="list-table-wrap erp-company-departments-wrap">
        <div class="list-table-inner erp-company-departments-wrap-inner">
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>


</div>
