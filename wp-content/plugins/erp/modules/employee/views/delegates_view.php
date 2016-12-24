<div class="wrap erp-hr-companyadmin" id="wp-erp">
    <h2><?php _e( 'View / Modify Delegate', 'employee' ); ?></h2>
    <code>View Delegate</code>
        <?php
        //require '/../includes/class_table_view.php';
            
            global $wpdb;
            
            $table = new WeDevs\ERP\Employee\Delegate_List();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items Successfully reverted from delegation: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">
            <?php echo $message;?>
            <?php //$table->views(); ?>
			<form method="post">
			  <input type="hidden" name="page" value="Requests" />
			  <?php //$table->search_box('Search Request Code', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>

