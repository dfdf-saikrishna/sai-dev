<div class="wrap erp-hr-masteradmin" id="wp-erp">
    <h2><?php _e( 'Master Admin View / Edit / Delete', 'superadmin' ); ?><a href="#" id="masteradmin-new" class="add-new-h2"><?php _e( 'Add New', 'superadmin' ); ?></a></h2>
        <?php
        global $wpdb;
            $table = new WeDevs\ERP\Corptne\Masteradmin_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'masteradmin_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-hr-masteradmin-wrap">
        <div class="list-table-inner erp-hr-masteradmin-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('Search Admin', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>
