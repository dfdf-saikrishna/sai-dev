<div class="wrap erp-hr-expensecategory" id="wp-erp">
<h2><?php _e( 'Default Expense Category', 'superadmin' ); ?></h2>
      <?php
            global $wpdb;

            $table = new WeDevs\ERP\Corptne\Expensecategory_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-hr-expensecategory-wrap">
        <div class="list-table-inner erp-hr-expensecategory-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('Search Category', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>
