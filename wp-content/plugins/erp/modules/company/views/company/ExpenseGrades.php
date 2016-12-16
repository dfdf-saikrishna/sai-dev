<?php 

?>
<div class="wrap erp-company-gradelimits" id="wp-erp">
    <!--<h2>DashBoard</h2>-->
    <h2><?php _e( ' Employee Grade Limits', 'company' ); ?></h2>
        <?php
        //require '/../includes/class_table_view.php';

            global $wpdb;

            $table = new WeDevs\ERP\Company\ExpenseGrade_List_Table();
            $table->prepare_items();

//            $message = '';
//            if ('delete' === $table->current_action()) {
//                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
//            }
            ?>
        <div class="list-table-wrap erp-company-gradelimits-wrap">
        <div class="list-table-inner erp-company-gradelimits-wrap-inner">
            
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>
