<div class="wrap erp-hr-company" id="wp-erp">

    <h2>
        <?php
        _e( 'Delegations', 'erp' );
        ?>
    </h2>
	<?php
                $empdelegates_table = new \WeDevs\ERP\Company\Empdelegates_List_Table();
                $empdelegates_table->prepare_items();
                $message = '';
            if ('delete' === $empdelegates_table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'empdelegates_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
                ?>
 <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $empdelegates_table->search_box('Search Delegate', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $empdelegates_table->display() ?>
            </form>

        </div>
        </div>
</div>
