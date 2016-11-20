<div class="wrap erp-hr-companyadmin" id="wp-erp">
    <h2><?php _e( 'Employee Approval Limits', 'company' ); ?></h2>
    <?php
    $compid = $_SESSION['compid'];
    global $wpdb;
    $allemps=$wpdb->get_results("SELECT EMP_Id, EMP_Code, EMP_Name FROM employees WHERE COM_Id='$compid' AND EMP_Status=1 AND EMP_AccountsApprover=1 AND EMP_Access=1 ORDER BY EMP_Name ASC");
    ?>
    <div style="text-align:center">
    <label for="erp-hr-leave-req-employee-id">Select Finance Approver<span class="required">*</span></label>
    <select name="employee_id" id="select-finance-approver" required="required">
    <option value="0">- Select -</option>
    <?php
    foreach($allemps as $value){
    ?>
    <option value="<?php echo $value->EMP_Id;?>"><?php echo $value->EMP_Code." - ".$value->EMP_Name; ?></option>
    <?php } ?>
    </select>
    </div>
    </br>
    <div id="approvers_limit" style="display:none;text-align: center">
    <input type="text" value="" id="limit_amount">
    <input type="submit" class="button button-primary">
    </div>
        <?php
            global $wpdb;

            $table = new WeDevs\ERP\Company\Approval_Limits();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">
            <?php echo $message;?>
            <?php //$table->views(); ?>
			<form method="post">
			  <input type="hidden" name="page" value="Requests" />
			  <?php $table->search_box('Search Employee Code', 'search_id'); ?>
			</form>
			
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>
        </div>

    
</div>
