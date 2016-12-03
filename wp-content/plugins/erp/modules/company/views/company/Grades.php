<?php ?>
<div class="wrap erp-company-grades" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e('Grades', 'company'); ?>
        <a href="#" id="erp-new-grades" class="add-new-h2" data-single="1"><?php _e('Add Grades', 'erp'); ?></a></h2>
    <h4> <?php _e('ADD / UPDATE / CLOSE Grades'); ?></h4>

    <?php
    global $wpdb;

    $table = new WeDevs\ERP\Company\Grades_List_Table();
    $table->prepare_items();
        ?>
        <div class="list-table-wrap erp-company-grades-wrap">
        <div class="list-table-inner erp-company-grades-wrap-inner">
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>


</div>
