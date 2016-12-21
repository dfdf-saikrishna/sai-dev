<div class="wrap erp-traveldeskclaims" id="wp-erp">
	<h2>
        <?php
        _e( 'Travel Desk Claims', 'erp' );
		
        ?>
    </h2>
	<code>All Claim Invoices</code>
	    <div class="erp-single-container">
		<?php
			global $wpdb;
			
            $traveldeskclaim_table = new WeDevs\ERP\Traveldesk\Traveldesk_Claims_List_Table();
            $traveldeskclaim_table->prepare_items();

            $message = '';
            if ('delete' === $traveldeskclaim_table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp--wrap">
        <div class="list-table-inner erp--wrap-inner">
			 <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			</form>
			
            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $traveldeskclaim_table->display() ?>
            </form>

        </div>	
    </div>
    
</div>
