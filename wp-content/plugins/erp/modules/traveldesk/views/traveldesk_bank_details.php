<div class="wrap erp-traveldeskbankdetails" id="wp-erp">
	<h2>
        <?php
        _e( 'Bank Accounts', 'erp' );

        if ( current_user_can( 'traveldesk' ) ) {
			global $wpdb;
			$tduserid = $_SESSION['tdid'];
			$check = count($wpdb->get_results("SELECT * FROM travel_desk_bank_account WHERE TD_Id='$tduserid' AND TDBA_Status=1"));
           if($check < 1){
		   ?>
			
                <a href="#" id="erp-traveldeskbankdetails-new" class="add-new-h2"><?php _e( 'Add New', 'erp' ); ?></a>
            <?php
        } }
        ?>
    </h2>
	    <div class="erp-single-container">
		<?php
			global $wpdb;
			
            $table = new WeDevs\ERP\Traveldesk\TravelDesk_Bankdetails_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-traveldeskbankdetails-wrap">
        <div class="list-table-inner erp-traveldeskbankdetails-wrap-inner">
			 <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			</form>
			
            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>	
    </div>
    
</div>
