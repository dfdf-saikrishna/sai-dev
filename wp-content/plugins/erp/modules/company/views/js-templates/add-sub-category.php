<?php
global $wpdb;
$compid = $_SESSION['compid'];
?>
<div class="erp-employee-form">
        <div class="inside">
            <input type="hidden" value="{{data.COM_Id}}" name="company[compid]" id="compid">
            <input type="hidden" value="{{data.EC_Id}}" name="company[ecId]" id="ecId">
              <input type="hidden" value="{{data.MOD_Id}}" name="company[modeID]" id="modeID">
            <?php erp_html_form_label(__('Expense Category', 'erp'), 'ExpenseCategory-type'); ?>
            <?php  $var= "{{data.EC_Id}}"; 
                if($var!=""){ ?><span class="field">
                <select  class="" data-size="5" data-live-search="true" name="company[selExpenseCategory]" id="selExpenseCategory" data-selected={{data.EC_Id}}>
                    <option value=""> Select</option>
                    <?php
                    $selmodes = $wpdb->get_results("SELECT * FROM expense_category ORDER BY EC_Id ASC");
                    foreach ($selmodes as $value) {
                        ?>
                        <option value="<?php echo $value->EC_Id ?>"><?php echo $value->EC_Name ?></option>
                    <?php } ?>
                </select></span> <?php } ?>
            <div class="row">   <span class="field">
                    <?php erp_html_form_label(__('Expense Sub Category', 'erp'), 'Expense-type'); ?>
                    <textarea class="form-control" rows="3" name="company[txtaModes]"  id="txtaModes" required>{{data.MOD_Name}}</textarea></span>
            </div>
    <?php //wp_nonce_field( 'wp-erp-hr-employee-nonce' );   ?>
    <input type="hidden" name="action" id="erp-subcategory-action" value="subcategory_get">
 <input type="hidden" name="action" id="erp_company_subcategory_create" value="subcategory_create">
</div>