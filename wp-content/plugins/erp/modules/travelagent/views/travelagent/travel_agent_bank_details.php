<div class="wrap erp-travelagentbankdetails" id="wp-erp">
	<h2>
        <?php
        _e( 'Bank Accounts', 'erp' );

        if ( current_user_can( 'travelagent' ) ) {
            ?>
                <a href="#" id="erp-travelagentbankdetails-new" class="add-new-h2"><?php _e( 'Add New', 'erp' ); ?></a>
            <?php
        }
        ?>
    </h2>
	    <div class="erp-single-container">
		<?php
			global $wpdb;
			
            $table = new WeDevs\ERP\Travelagent\Travel_Agent_Bankdetails_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-travelagentbankdetails-wrap">
        <div class="list-table-inner erp-travelagentbankdetails-wrap-inner">
			 <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('search', 'search_id'); ?>
			</form>
			
            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>	
    </div>
    
</div>
