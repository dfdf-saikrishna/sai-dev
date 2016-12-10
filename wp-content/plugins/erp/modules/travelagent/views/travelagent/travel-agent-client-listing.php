<div class="wrap erp-travelagentclient">
	<h2>
        <?php
        _e( 'Account Overview', 'erp' );

        if ( current_user_can( 'travelagent' ) ) {
            ?>
                <a href="#" id="erp-travelagentclient-new" class="add-new-h2"><?php _e( 'Add New', 'erp' ); ?></a>
            <?php
        }
        ?>
    </h2>
		<?php
			global $wpdb;
			
            $table = new WeDevs\ERP\Travelagent\Travel_Agent_Client_List_Table();
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
			  <?php $table->search_box('Search Client', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>
</div>
