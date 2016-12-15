<div class="wrap erp-travelagentclient">
	<h2>
        <?php
        _e( 'All Requests', 'erp' );
        ?>
    </h2>
		<?php
			global $wpdb;
			
            $table = new WeDevs\ERP\Travelagent\Travel_Agent_Request_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
       <div class="list-table-wrap erp-travelagentclient-wrap">
        <div class="list-table-inner erp-travelagentclient-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('Search', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>
</div>
