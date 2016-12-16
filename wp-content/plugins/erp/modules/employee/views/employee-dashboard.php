<?php

global $wpdb;
    $filename="";
    $compid = $_SESSION['compid'];
    //echo $compid;die;
    $empID = $_SESSION['empuserid'];
    $emp_code=$_SESSION['emp_code'];  
    // Retrieving my details
    $mydetails=myDetails();

    $approver='0';
    // checking approver(y/n)
    if($selrow=isApprover()){
        //print_r($selrow);die;
    $approver=1;

    $delegate=0;

    if($cnt=ihvdelegated(1)){
            $delegate=1;
    }
    $_SESSION['delegate']=NULL;

    if($cnt=ihvdelegated(2)){

            if(!$_SESSION['delegate'])
            $_SESSION['delegate']=time();


            foreach($cnt as  $value){

                    $empcodes.="'".$value['EMP_Code']."'".",";
            }

            $empcodes=rtrim($empcodes,",");		

    }}
    if($approver){
	//checking that whether i'm the approver of my requests
	$myselfApprvr=0;
        $empcode=$mydetails->EMP_Code;
        $rprmgr=$mydetails->EMP_Reprtnmngrcode;
        
	if($empcode==$rprmgr){
		$myselfApprvr=1;
	}
    }
        $count_total = count_query("requests req, request_employee re", "DISTINCT (req.REQ_Id)", "WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empID' AND RE_Status=1 AND  REQ_Active != 9 AND REQ_Type != 5", $filename, 0);
        $count_approved = count_query("requests req, request_employee re", "DISTINCT (req.REQ_Id)", "WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empID' AND RE_Status=1 AND REQ_Status=2 AND REQ_Active != 9 AND REQ_Type != 5",$filename);
        $count_pending = count_query("requests req, request_employee re", "DISTINCT (req.REQ_Id)", "WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empID' AND RE_Status=1 AND REQ_Status=1 AND REQ_Active != 9 AND REQ_Type != 5",$filename,$filename);
        $count_rejected = count_query("requests req, request_employee re", "DISTINCT (req.REQ_Id)", "WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empID' AND RE_Status=1 AND REQ_Status=3 AND REQ_Active != 9 AND REQ_Type != 5",$filename);
        
        $approver_total=0;
        $approver_approved=0;
        $approver_pending=0;
        $approver_rejected=0;
          if($approver && !$delegate)
	  {
                if($_SESSION['delegate'])
                {
                        $approver_total=count_query("employees emp, requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE emp.EMP_Reprtnmngrcode IN ($empcodes) AND emp.EMP_Id != '$empuserid' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Active != 9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename);

                        $approver_approved=count_query("employees emp, requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE emp.EMP_Reprtnmngrcode IN ($empcodes) AND emp.EMP_Id != '$empuserid' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id  AND req.REQ_Status=2 AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename); 

                        $approver_pending=count_query("employees emp, requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE emp.EMP_Reprtnmngrcode IN ($empcodes) AND emp.EMP_Id != '$empuserid' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Status=1 AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename);  

                        $approver_rejected=count_query("employees emp, requests req, request_employee re","DISTINCT (req.REQ_Id)","WHERE emp.EMP_Reprtnmngrcode IN ($empcodes) AND emp.EMP_Id != '$empuserid' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Status=3 AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename);  
                }
            $rprcode=$selrow->EMP_Reprtnmngrcode;
            $frprcode=$selrow->EMP_Funcrepmngrcode;
            $approver_total+=count_query("employees emp, requests req, request_employee re","DISTINCT req.REQ_Id","WHERE emp.EMP_Reprtnmngrcode='$rprcode' AND emp.EMP_Id != '$empID' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename,0);
            $approver_approved+=count_query("employees emp, requests req, request_employee re","DISTINCT req.REQ_Id","WHERE emp.EMP_Reprtnmngrcode='$rprcode' AND emp.EMP_Id != '$empID' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Status=2 AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename); 
            $approver_pending+=count_query("employees emp, requests req, request_employee re","DISTINCT req.REQ_Id","WHERE emp.EMP_Reprtnmngrcode='$rprcode' AND emp.EMP_Id != '$empID' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Status=1 AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename);  
            $approver_rejected+=count_query("employees emp, requests req, request_employee re","DISTINCT req.REQ_Id","WHERE emp.EMP_Reprtnmngrcode='$rprcode' AND emp.EMP_Id != '$empID' AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id AND req.REQ_Status=3 AND req.REQ_Active !=9 AND re.RE_Status=1 AND emp.EMP_Status=1 AND emp.EMP_Access=1",$filename);  
         }              
    
     
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
                                <td colspan="2"><h1 style="text-align:center;">&nbsp <b>My</b> Expense Requests</h1></td>
                                </tr>
                                <tr>
                                <td width="90%">Pending Requests</td>
                                <td width="10%"><a href="/wp-admin/admin.php?page=View-My-Requests&selReqstatus=1"><span class="oval-1"><?php echo $count_pending?></span></a></td>
                                </tr>
                                <tr>
                                <td width="90%">Approved Requests</td>
                                <td width="20%"><a href="/wp-admin/admin.php?page=View-My-Requests&selReqstatus=2"><span class="oval-3"><?php echo $count_approved?></span></a></td>
                                </tr>
                                <tr>
                                <td width="90%">Rejected Requests</td>
                                <td width="10%"><a href="/wp-admin/admin.php?page=View-My-Requests&selReqstatus=3"><span class="oval-4"><?php echo $count_rejected ?></span></a></td>
                                </tr>
                                <tr>
                                <td width="90%">Total Requests</td>
                                <td width="10%"><a href="/wp-admin/admin.php?page=View-My-Requests"><span class="oval-2"><?php echo $count_total ?></span></a></td>
                                </tr>
                            </table>
<!--                               <label class="progress-bar"><?php echo $appRate; ?>% approval rate</label>-->
                            </div><!-- .badge-wrap -->

                            <div class="badge-wrap badge-aqua">
                                <table class="wp-list-table widefat striped admins">
                                    <tr>
                                    <td colspan="2"><h1 style="text-align:center;">&nbsp <b>Requests</b>  For My Approval</h1></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Pending Requests</td>
                                    <td width="10%"><a href="/wp-admin/admin.php?page=View-Emp-Requests&selReqstatus=1"><span class="oval-1"><?php echo $approver_pending?></span></a></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Approved Requests</td>
                                    <td width="10%"><a href="/wp-admin/admin.php?page=View-Emp-Requests&selReqstatus=2"><span class="oval-3"><?php echo $approver_approved ?></span></a></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Rejected Requests</td>
                                    <td width="10%"><a href="/wp-admin/admin.php?page=View-Emp-Requests&selReqstatus=3"><span class="oval-4"><?php echo $approver_rejected?></span></a></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Total Requests</td>
                                    <td width="10%"><a href="/wp-admin/admin.php?page=View-Emp-Requests"><span class="oval-2"><?php echo $approver_total ?></span></a></td>
                                    </tr>
                                </table>
                            </div><!-- .badge-wrap -->
                        
					       </div>
                        </div>
                    </div>
            <div class="postbox">
                <div class="inside">
                    <h2>My Pre Travel Expense Requests</h2>
                    <?php
                    $table = new WeDevs\ERP\Employee\My_Pre_Travel_Expenses();
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
            <div class="postbox">
                <div class="inside">
                    <h2>My Post Travel Expense Requests</h2>
                    <?php
                    $table = new WeDevs\ERP\Employee\My_Post_Travel_Expenses();
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