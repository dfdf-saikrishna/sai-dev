<?php
global $wpdb;
$compid = $_SESSION['compid'];
//echo $compid;die;
//$empID = $_SESSION['empuserid'];
// Retrieving my details
$mydetails=myDetails();


//if($mydetails['EMP_AccountsApprover'] != 1){
//	//session_destroy();
//} else if($mydetails['EMP_AccountsApprover']) {
//	if(!$_SESSION['accs-menu'])
//	$_SESSION['accs-menu']=time();
//}
    $empid=$mydetails->EMP_Id;
        //Eployee Travel Request
        $count_total=$wpdb->get_var("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id != '$empid' AND REQ_Active != 9 AND re.RE_Status=1");
	
        $count_approved=$wpdb->get_var("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id != '$empid' AND REQ_Status=2 AND REQ_Active != 9 AND re.RE_Status=1"); 
	
        $count_pending=$wpdb->get_var("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id != '$empid' AND REQ_Status=1 AND REQ_Active != 9 AND re.RE_Status=1"); 
	
        $count_rejected=$wpdb->get_var("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id != '$empid' AND REQ_Status=3 AND REQ_Active != 9 AND re.RE_Status=1");  
	
        //Travel Desk
        $cnttdc		=$wpdb->get_var("SELECT TDC_Id FROM travel_desk_claims WHERE COM_Id='$compid'");
       // print_r($cnttdc);die;
        $cntpendng	=$wpdb->get_var("SELECT TDC_Id FROM travel_desk_claims WHERE COM_Id='$compid' AND TDC_Status=1");
        $cntapprvd	=$wpdb->get_var("SELECT TDC_Id FROM travel_desk_claims WHERE COM_Id='$compid' AND TDC_Status=2");
?>
<div class="wrap erp hrm-dashboard">

    <div class="erp-single-container">

        <!--div class="erp-area-left"-->
                <div class="postbox">
                <div class="inside">
				    <div class="badge-container">
                        <div class="badge-wrap badge-aqua">

                            <table class="wp-list-table widefat striped admins">
                                <tr>
                                <td colspan="2"><h1 style="text-align:center;">&nbsp <b>Employee's Employee's Travel &amp; Expense Request</b></h1></td>
                                </tr>
                                <tr>
                                <td width="90%">Pending Requests</td>
                                <td width="10%"><span class="oval-1"><?php echo $count_pending?></span></td>
                                </tr>
                                <tr>
                                <td width="90%">Approved Requests</td>
                                <td width="20%"><span class="oval-3"><?php echo $count_approved?></span></td>
                                </tr>
                                <tr>
                                <td width="90%">Rejected Requests</td>
                                <td width="10%"><span class="oval-4"><?php echo $count_rejected ?></span></td>
                                </tr>
                                <tr>
                                <td width="90%">Total Requests</td>
                                <td width="10%"><span class="oval-2"><?php echo $count_total ?></span></td>
                                </tr>
                            </table>
<!--                               <label class="progress-bar"><?php echo $appRate; ?>% approval rate</label>-->
                            </div><!-- .badge-wrap -->

                            <div class="badge-wrap badge-aqua">
                                <table class="wp-list-table widefat striped admins">
                                    <tr>
                                        <td colspan="2"><h1 style="text-align:center;">&nbsp <b>Travel Desk Claims</b></h1></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Pending Requests</td>
                                    <td width="10%"><span class="oval-1"><?php echo $cntpendng?></span></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Approved Requests</td>
                                    <td width="10%"><span class="oval-3"><?php echo $cntapprvd ?></span></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Total Requests</td>
                                    <td width="10%"><span class="oval-2"><?php echo $cnttdc ?></span></td>
                                    </tr>
                                </table>
                            </div><!-- .badge-wrap -->
                        
					       </div>
                        </div>
                    </div>
            <div class="postbox">
                <div class="inside">
                    <h2>Requests For My Approval</h2>
                    <?php
                    $table = new WeDevs\ERP\Employee\Request_Travel_Expenses();
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
                          <?php $table->search_box('Search Request Code', 'search_id'); ?>
                        </form>

                        <form method="GET">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                            <?php $table->display() ?>
                        </form>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>