<div class="wrap erp-hr-company" id="wp-erp">

    <h2>
        <?php
        _e( 'Employee', 'erp' );

        if ( current_user_can( 'companyadmin' ) ) {
            ?>
                <a href="#" id="erp-companyemployee-new" class="add-new-h2"><?php _e( 'Add New', 'erp' ); ?></a>
            <?php
        }
        ?>
    </h2>
    <!-- Messages -->
    <div style="display:none" id="failure" class="notice notice-error is-dismissible">
        <p id="p-failure"></p>
    </div>
    <div style="display:none" id="success" class="notice notice-success is-dismissible">
        <p id="p-success"></p>
    </div>
	<?php
        $employee_table = new \WeDevs\ERP\Company\Employee_List_Table();
        $employee_table->prepare_items();
        $message = '';
            if ('delete' === $employee_table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'employee_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
                ?>

     <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $employee_table->search_box('Search Employee', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $employee_table->display() ?>
            </form>

        </div>
        </div>

</div>

