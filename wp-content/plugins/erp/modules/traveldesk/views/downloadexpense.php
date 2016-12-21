<?php 	
	global $wpdb;
	$compid = $_SESSION['compid'];
		if($selpol=$wpdb->get_results("SELECT * FROM travel_expense_policy_doc WHERE COM_Id='$compid' AND TEPD_Status=1"))	
		{
		$fileurl = 	WPERP_COMPANY_DOWNLOADS .'/erp/modules/company/upload/'. $compid . '/' ;
?>
<div class="postbox leads-actions" style="margin:145px!important">
    <h3 class="hndle" style="margin: 50px 0px 0px 250px;"><span><?php _e( 'Download Company Expense Policy', 'erp' ); ?></span></h3>
    <div class="inside" style="margin: 50px 0px 0px 250px;">
    <a download="Company-Expolicy" href="<?php echo $fileurl . $selpol[0]->TEPD_Filename; ?>" title="Download Company Expense Policy"><i class="icon  fa fa-download"></i> Download Company Expense Policy</a>
	</div></div>
    <?php } ?>