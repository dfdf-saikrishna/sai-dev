<div class="wrap erp-companyinvoicecreate" id="wp-erp">

<h2>
        <?php
        _e( 'COMPANY Invoice', 'erp' );
        ?>
    </h2>

	<?php
        $companyinvoice_table = new \WeDevs\ERP\Travelagent\Travel_Agent_Company_Invoicecreate_Table();
        $companyinvoice_table->prepare_items();
        $message = '';
            if ('delete' === $companyinvoice_table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'employee_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
                ?>

     <div class="list-table-wrap erp-companyinvoicecreate-wrap">
        <div class="list-table-inner erp-companyinvoicecreate-wrap-inner">
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $companyinvoice_table->search_box('Search', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $companyinvoice_table->display() ?>
            </form>

        </div>
        </div>

</div>

