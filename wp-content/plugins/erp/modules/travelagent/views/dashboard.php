<div class="wrap erp hrm-dashboard">
    <h2><?php _e( 'Account Overview', 'travelagent' ); ?></h2>
	    <div class="erp-single-container">
		<?php
			global $wpdb;
			
            $table = new WeDevs\ERP\Travelagent\Travelagentdashboard_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="wrap">

            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
			 <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('search Company', 'search_id'); ?>
			</form>
			
            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>	
    </div>
    
</div>
