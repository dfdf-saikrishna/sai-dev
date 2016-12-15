<div class="wrap erp-hr-travelagentuser" id="wp-erp">

    <h2>
        <?php
        _e( 'Travel Agents User', 'erp' );

        if ( current_user_can( 'travelagent' ) ) {
            ?>
                <a href="#" id="erp-travelagentuser-new" class="add-new-h2"><?php _e( 'Add New', 'erp' ); ?></a>
            <?php
        }
        ?>
    </h2>
	<?php
        $tauser_table = new \WeDevs\ERP\Travelagent\Travel_Agent_User_List_Table();
        $tauser_table->prepare_items();
        $message = '';
            if ('delete' === $tauser_table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'employee_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
                ?>

     <div class="list-table-wrap erp-hr-travelagentuser-wrap">
        <div class="list-table-inner erp-hr-travelagentuser-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $tauser_table->search_box('Search User', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $tauser_table->display() ?>
            </form>

        </div>
        </div>

</div>

