<?php 

?>
<div class="wrap erp-hr-travelagent" id="wp-erp">
    <h2><?php _e( 'Travel Agents', 'superadmin' ); ?><a href="#" id="travel-agent-new" class="add-new-h2"><?php _e( 'Add New', 'superadmin' ); ?></a></h2>
        <?php
        //require '/../includes/class_table_view.php';

            global $wpdb;

            $table = new WeDevs\ERP\Corptne\Travel_Agent_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'travelagent-table-list'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-hr-travelagent-wrap">
        <div class="list-table-inner erp-hr-travelagent-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('Search Travel Agent', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>
