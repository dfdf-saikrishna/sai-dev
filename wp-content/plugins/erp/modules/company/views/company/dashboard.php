    <?php
    global $wpdb;
    $compid = $_SESSION['compid'];
    $empcount = count($wpdb->get_results("SELECT * FROM employees WHERE EMP_Status=1 AND COM_Id='$compid'"));
    $totalMasterAdmin = count($wpdb->get_results("SELECT * FROM employees WHERE EMP_AccountsApprover=1 AND COM_Id='$compid'"));
    $accgadmins = count($wpdb->get_results("SELECT * FROM travel_desk WHERE TD_Status=1 AND COM_Id='$compid'"));
    
    $count_total =count($wpdb->get_results("SELECT REQ_Id FROM  requests WHERE COM_Id='$compid' AND REQ_Active != 9"));
    $count_approved = count($wpdb->get_results("SELECT REQ_Id FROM  requests WHERE COM_Id='$compid' AND REQ_Status=2 AND REQ_Active != 9"));
    $count_pending = count($wpdb->get_results("SELECT REQ_Id FROM  requests WHERE COM_Id='$compid' AND REQ_Status=1 AND REQ_Active != 9"));
    $count_rejected =count($wpdb->get_results("SELECT REQ_Id FROM  requests WHERE COM_Id='$compid' AND REQ_Status=3 AND REQ_Active != 9"));
   // print_r($count_total);die;
    ?>
<div class="wrap erp hrm-dashboard">
    <h2><?php _e('Dashboard', 'companyadmin'); ?></h2>
    <div class="erp-single-container">

        <!--div class="erp-area-left"-->
        <div class="badge-container">
            <div class="badge-wrap badge-green">
                <div class="badge-inner">
                    <h3><?php echo $empcount ?></h3>
                    <p>TOTAL <b>EMPLOYEES</b></p>
                </div>
                <div class="badge-footer wp-ui-highlight">
                    <a href="admin.php?page=menu"> View Employees</a>
                </div>

                <!--                        <div class="badge-footer wp-ui-highlight">
                                            <a href="">View Companies</a>
                                        </div>-->
            </div><!-- .badge-wrap -->	
            <div class="badge-wrap badge-aqua">
                <div class="badge-inner">
                    <h3><?php echo $totalMasterAdmin ?></h3>
                    <p>TOTAL <b>FINANCE APPROVERS</b></p>
                </div>
                <div class="badge-footer wp-ui-highlight">
                    <a href="admin.php?page=finance"> View Finance Approvers</a>
                </div>
            </div><!-- .badge-wrap -->
            <div class="badge-wrap badge-aqua">
                <div class="badge-inner">
                    <h3><?php echo $totalMasterAdmin ?></h3>
                    <p>TOTAL <b>TRAVEL DESK USERS</b></p>
                </div>
                <div class="badge-footer wp-ui-highlight">
                    <a href="admin.php?page=Travel"> View Travel Desk Users</a>
                </div>
            </div><!-- .badge-wrap -->
        </div><!-- .badge-container -->
        <div class="badge-container">
            <div class="badge-wrap badge-aqua">
                <div class="badge-inner">
                    <!--<h2> <a <?php if ($count_total) echo 'href="admin.php?page=Expense-Requests"'; ?> title="Total Requests" style="color:#FFFFFF;"><?php echo $count_total; ?></a> / <a <?php if ($count_approved) { ?>href="admin-employee-request-listing.php?selReqstatus=2"<?php } ?>  title="Approved" style="color:#fff;"><?php echo $count_approved; ?></a> / <a <?php if ($count_pending) { ?>href="admin-employee-request-listing.php?selReqstatus=1"<?php } ?> title="Pending" style="color:#fff;"><?php echo $count_pending; ?></a> / <a <?php if ($count_rejected) { ?>href="admin-employee-request-listing.php?selReqstatus=3"<?php } ?> title="rejected" style="color:#fff;"><?php echo $count_rejected; ?></a></h2>-->

                    <h3><a href="admin.php?page=Expense-Requests"><?php echo $count_total ?> / <?php echo $count_approved ?> / <?php echo $count_pending ?> / <?php echo $count_rejected ?></a></h3>
                    <p></p>
                </div>
                <div class="badge-footer wp-ui-highlight">
                    <b>TOTAL</b> / <b>APPROVED</b> / <b>PENDING</b> / <b>REJECTED EXPENSE REQUESTS</b>
                </div>
            </div><!-- .badge-wrap -->
        </div><!-- .badge-container -->

        <?php
        global $wpdb;

        $table = new WeDevs\ERP\Company\Company_List_Table();
        $table->prepare_items();

        $message = '';
        if ('delete' === $table->current_action()) {
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
        }
        ?>
        <div class="wrap">

            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            </h2>
            <?php echo $message; ?>
<!--            <form method="post">
                <input type="hidden" name="page" value="my_list_test" />
                <?php $table->search_box('search', 'search_id'); ?>
            </form>-->

            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>	
    </div>

</div>
