<div class="wrap erp-hr-companyexpense" id="wp-erp">
<h2><?php _e( 'Companies Expense Category', 'superadmin' ); ?></h2>
    
      <?php
            global $wpdb;

            $table = new WeDevs\ERP\Corptne\Companyexpensecategory_List_Table();
            $table->prepare_items();
            ?>
        <div class="list-table-wrap erp-hr-companyexpense-wrap">
        <div class="list-table-inner erp-hr-companyexpense-wrap-inner">
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('Search Company', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>
