<?php

namespace WeDevs\ERP\Employee;

/**
 * PART 2. Defining Custom Table List
 * ============================================================================
 *
 * In this part you are going to define custom table list class,
 * that will display your database records in nice looking table
 *
 * http://codex.wordpress.org/Class_Reference/WP_List_Table
 * http://wordpress.org/extend/plugins/custom-list-table-example/
 */
//if (!class_exists('WP_List_Table')) {
//require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
//}

/**
 * Custom_Table_Example_List_Table class that will display our custom table
 * records in nice table
 */
class My_Requests_List extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $compid;
        global $status, $page;

        parent::__construct(array(
            'singular' => 'admin',
            'plural' => 'admins',
        ));
    }

    /**
     * Render extra filtering option in
     * top of the table
     *
     * @since 0.1
     *
     * @param  string $which
     *
     * @return void
     */
    function extra_tablenav($which) {
        global $wpdb;
        if ($which != 'top') {
            return;
        }

        $selected_request = ( isset($_GET['filter_request']) ) ? $_GET['filter_request'] : 0;
        $selected_status = ( isset($_GET['filter_status']) ) ? $_GET['filter_status'] : 0;
        $emp = ( isset($_GET['filter_emp']) ) ? $_GET['filter_emp'] : '';
        if(isset($_REQUEST['selReqstatus'])){
        $selected_status = $_REQUEST['selReqstatus'];
        }
        ?>
        <div class="alignleft actions">

            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
            <select name="filter_request" id="filter_request">
                <option value="">- All -</option>
                <?php
                $selsql = $wpdb->get_results("SELECT * From request_type");
                foreach ($selsql as $rowsql) {
                    ?>
                    <option value="<?php echo $rowsql->RT_Id; ?>" <?php if ($selected_request == $rowsql->RT_Id) echo 'selected="selected"'; ?> ><?php echo $rowsql->RT_Name; ?></option>
                <?php } ?>
            </select>

            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
            <select name="filter_status" id="filter_status">
                <option value="">- All -</option>
                <option value="2" <?php if ($selected_status == 2) echo 'selected="selected"'; ?> >Approved</option>
                <option value="1" <?php if ($selected_status == 1) echo 'selected="selected"'; ?> >Pending</option>
                <option value="3" <?php if ($selected_status == 3) echo 'selected="selected"'; ?> >Rejected</option>
            </select>

            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
            <select name="filter_emp" id="filter_emp">
                <option value="">- All -</option>
                <?php
                $selrow=isApprover();
                $mydetails = myDetails();
                $selsql = $wpdb->get_results("SELECT EMP_Id, EMP_Code, EMP_Name From employees WHERE EMP_Reprtnmngrcode='$selrow->EMP_Reprtnmngrcode' AND EMP_Code!='$mydetails->EMP_Code' AND EMP_Status=1 ORDER BY EMP_Code ASC");
                foreach ($selsql as $rowemp) {
                    ?>
                    <option value="<?php echo $rowemp->EMP_Id; ?>" <?php if ($emp == $rowemp->EMP_Id) echo 'selected="selected"'; ?> ><?php echo $rowemp->EMP_Code . " - " . $rowemp->EMP_Name; ?></option>
                    <?php } ?>
                </select>
                <?php
                submit_button(__('Search'), 'button', 'filter_employee', false);
                echo '</div>';
            //}
        }

        function column_default($item, $column_name) {

        }

        function column_request_code($item) {
            //return "request_code";die;
            global $type;
            global $href;
            switch ($item['RT_Id']) {
                case 1:
                    $href = "/wp-admin/admin.php?page=View-Request&reqid=".$item['REQ_Id'];
                    break;

                case 2:
                    $href = "/wp-admin/admin.php?page=View-Post-Request&reqid=".$item['REQ_Id'];
                    break;

                case 3:
                    $href = "/wp-admin/admin.php?page=View-other-Request&reqid=".$item['REQ_Id'];
                    break;

                case 5:
                    $href = "/wp-admin/admin.php?page=View-Mileage-Request&reqid=".$item['REQ_Id'];
                    break;

                case 6:
                    $href = "/wp-admin/admin.php?page=View-Utility-Request&reqid=".$item['REQ_Id'];
                    break;
            }
            switch ($item['REQ_Type']) {

                case 1:
                    $type = '<span style="font-size:10px;">[E]</span>';
                    $title = "Employee Request";
                    break;

                case 2:
                    $type = '<span style="font-size:10px;">[W/A]</span>';
                    $title = "Without Approval";
                    break;

                case 3:
                    $type = '<span style="font-size:10px;">[AR]</span>';
                    $title = "Approval Required";
                    break;

                case 4:
                    $type = '<span style="font-size:10px;">[G]</span>';
                    $title = "Group Request Without Approval";
                    break;


                case 5:
                    $type = '<span style="font-size:10px;">[F]</span>';
                    $title = "Finance Expense";
                    break;
            }

            return "<a href='$href'>$item[REQ_Code]</a>&nbsp;$type";
        }

        function column_total_cost($item) {
            global $wpdb;
            global $totalcost;
            if ($item['REQ_PreToPostStatus']) {
                switch ($item['REQ_Type']) {

                    case 1:

                        $totalcost = $wpdb->get_row("SELECT SUM(ptac.PTAC_Cost) AS total FROM requests req, pre_travel_claim ptc, pre_travel_actual_cost ptac WHERE req.REQ_Id=$item[REQ_Id] AND req.REQ_Id=ptc.REQ_Id AND ptc.PTC_Id=ptac.PTC_Id AND ptac.PTAC_Status=1");

                        break;

                    case 2: case 3:


                        $totalcost = $wpdb->get_row("SELECT SUM(ptac.PTAC_Cost) AS total FROM requests req, pre_travel_claim ptc, pre_travel_actual_cost ptac WHERE req.REQ_Id=$item[REQ_Id] AND req.REQ_Id=ptc.REQ_Id AND ptc.PTC_Id=ptac.PTC_Id AND ptac.PTAC_Status=1");

                        break;


                    case 4:


                        $totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total FROM request_details WHERE REQ_Id=$item[REQ_Id] AND RD_Status='1'");

                        break;
                }
            } else {


                $totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total FROM request_details WHERE REQ_Id=$item[REQ_Id] AND RD_Status='1'");
            }

            return $this->IND_money_format($totalcost->total) . ".00";
        }

        function column_rep_manager_code($item) {
            global $wpdb;
            global $approvals;

            if($item['REQ_Type']==2 || $item['REQ_Type']==4 || $item['POL_Id'] ==5){

                $approvals=approvals(5);

            } else {

                // reporting manager status

                if($item['POL_Id'] !=4){

                    if($repmngrStatus=$wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=1"))
                    {
                        $approvals=approvals($repmngrStatus->REQ_Status);
                    }
                    else
                    {
                        $approvals=approvals(1);
                    }

                } else {

                    $approvals=approvals(5);

                }

            }
            return $approvals;
        }
        
        function column_skiplevel_manager_approval($item){

            global $wpdb;
            global $approvals;

            if($item['REQ_Type']==2 || $item['REQ_Type']==4 || $item['REQ_Type']==3){

                $approvals=approvals(5);

            } else {

                // skiplevel manager status
                //var_dump($item['POL_Id']);
                if($item['POL_Id'] !=3 && $item['POL_Id'] !=4 && $item['POL_Id'] !=2 && $item['POL_Id'] !=1){

                    if($repmngrStatus=$wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=5"))
                    {
                        $approvals=approvals($repmngrStatus->REQ_Status);
                    }
                    else
                    {
                        $approvals=approvals(1);
                    }

                } else {

                    $approvals=approvals(5);

                }

            }
            return $approvals;
        }

        function column_finance_approval($item) {
            global $wpdb;
            global $approvals;
            if ($item['REQ_Type'] == 2 || $item['REQ_Type'] == 4 || $item['REQ_Type'] == 5) {

                $approvals = approvals(5);
                
            } else {

                // finance status

                if ($item['POL_Id'] != 3) {
                    if ($repmngrStatus = $wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=2")) {
                        $approvals = approvals($repmngrStatus->REQ_Status);
                        
                    } 
                    else {
                        if($wpdb->get_row("SELECT REQ_Status FROM request_status WHERE REQ_Id='$item[REQ_Id]' AND RS_Status=1 AND RS_EmpType=3"))
                        $approvals = approvals(5);
                        else
                        $approvals = approvals(1);
                        
                    }
                } else {

                    $approvals = approvals(5);
                    
                }
            }
            return $approvals;
        }

        function column_request_date($item) {
            return date('d-M-y', strtotime($item['REQ_Date']));
        }

        function column_claim_status($item) {
            global $wpdb;
            global $claimdata;
            $claimdata = '<span class="status-2" title="Claimed on: ' . date("d/M/y", strtotime($item["REQ_ClaimDate"])) . '">Claimed</span>';

            // if its group request only finance approval required for claim

            if ($item['REQ_Claim']) {

                echo $claimdata;
            } else {

                if ($item['REQ_Type'] == 4) {

                    if ($item['REQ_PreToPostStatus'])
                        return $this->tdclaimapprovals(1);
                    else
                        return $this->tdclaimapprovals(5);
                } else {


                    if ($item['REQ_PreToPostStatus']) {
                        if ($selptc = $wpdb->get_row("SELECT PTC_Status FROM pre_travel_claim WHERE REQ_Id='$item[REQ_Id]'"))
                            return $this->tdclaimapprovals($selptc->PTC_Status);
                    }else {

                        if ($item['REQ_Status'] == 2)
                            return $this->tdclaimapprovals(1);
                        else
                            return $this->tdclaimapprovals(5);
                    }
                }
            }
        }
        
        function column_actions($item){
            $reqid = $item['REQ_Id'];
            $empuserid = $_SESSION['empuserid'];
            $compid = $_SESSION['compid'];
            global $wpdb;
            //$expPol = isset($_REQUEST['selReqstatus']) ? $_REQUEST['selReqstatus'] : 0;
            $expPol = $item['POL_Id'];
            $approver = isApprover();
            $row = $wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");
            if($approver)
            {       
                $rowpol = $wpdb->get_row("SELECT * FROM requests req, employees emp, request_employee re WHERE req.REQ_Id='$reqid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND emp.COM_Id='$compid' AND req.REQ_Active IN (1,2) AND RE_Status=1");
                $notmyreq=0;

            if($selreqs=$wpdb->get_row("SELECT EMP_Id FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND EMP_Id='$empuserid' AND req.REQ_Id='$reqid'")){

                    $notmyreq=1;

            }
            $workflow = workflow();
            $mydetails = myDetails();
            $emp_code=$mydetails->EMP_Code;
            switch ($expPol)
            {
                    // employee --> rep manager --> finance
                    
                    case 1:
                            
                            //if its not my request
                            if(!$notmyreq)
                            {
                                if($rowpol->POL_Id=="5"){
                                    if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)) 
                                    {

                                        return '<a href="#" id="subApprove" data-id='. $reqid .' title="Approve"><span class="dashicons dashicons-thumbs-up"></a>';

                                    }
                                    else
                                    return "<span title='Cannot Approve' class='dashicons dashicons-lock'>";
                                }
                                //if its not my request and approval is waiting from rep manager

                                else if(!$selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1")) 
                                {
                                    if(!($row->EMP_Funcrepmngrcode == $emp_code))
                                        return '<a href="#" id="subApprove" data-id='. $reqid .' title="Approve"><span class="dashicons dashicons-thumbs-up"></a>';
                                    else
                                    return "<span title='Cannot Approve' class='dashicons dashicons-lock'>";
                                }

                            }

                    break;
                    case 2:


                    //if its not my request
                    if(!$notmyreq)
                    {

                            // check for finance approval

                            if($selFinStat=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND REQ_Status=2 AND RS_EmpType=2 AND RS_Status=1")){
                                    if($rowpol->POL_Id=="5"){
                                        if(!($row->EMP_Reprtnmngrcode == $emp_code) || ($row->EMP_Id==$empuserid)){

                                            return '<a href="#" id="subApprove" data-id='. $reqid .' title="Approve"><span class="dashicons dashicons-thumbs-up"></a>';

                                        }
                                        else
                                        return "<span title='Cannot Approve' class='dashicons dashicons-lock'>";
                                    }
                                    //if its not my request and finance has apprvd & waiting for my approval

                                    else if(!$selMngrStatus=$wpdb->get_row("SELECT * FROM request_status WHERE REQ_Id='$reqid' AND RS_EmpType=1 AND RS_Status=1")){

                                            return '<a href="#" id="subApprove" data-id='. $reqid .' title="Approve"><span class="dashicons dashicons-thumbs-up"></a>';

                                    }

                            }
                            else
                            return "<span title='Cannot Approve' class='dashicons dashicons-lock'>";



                    }

                    break;
            
            
                }
            }
            else{
                return "<span title='Cannot Approve' class='dashicons dashicons-lock'>";
            }
        }

        function tdclaimapprovals($string) {
            global $getapprov;
            switch ($string) {

                case 1:
                    $getapprov = '<span class="status-1">Pending</span>';
                    break;

                case 2:
                    $getapprov = '<span class="status-2">Approved</span>';
                    break;

                case 3:
                    $getapprov = '<span class="status-4">Rejected</span>';
                    break;

                case 4:
                    $getapprov = '<span class="status-3">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
                    break;
            }

            return $getapprov;
        }

        function approvals($string) {
            global $getapprov;
            switch ($string) {
                case 1:
                    $getapprov = '<span class="status-1">Pending</span>';
                    break;

                case 2:
                    $getapprov = '<span class="status-2">Settled</span>';
                    break;

                case 5:
                    $getapprov = '<span class="status-3">&nbsp;&nbsp;&nbsp;N/A&nbsp;&nbsp;&nbsp;</span>';
                    break;

                case 4:
                    $getapprov = '<span class="status-4">Rejected</span>';
                    break;

                case 9:
                    $getapprov = '<span class="status-4">Rejected</span>';
                    break;
            }

            return $getapprov;
        }

        function IND_money_format($money) {
            $len = strlen($money);
            $m = '';
            $money = strrev($money);
            for ($i = 0; $i < $len; $i++) {
                if (( $i == 3 || ($i > 3 && ($i - 1) % 2 == 0) ) && $i != $len) {
                    $m .=',';
                }
                $m .=$money[$i];
            }
            return strrev($m);
        }
        
        /**
        * [REQUIRED] this is how checkbox column renders
        *
        * @param $item - row (key, value array)
        * @return HTML
        */
        function column_cb($item)
        {
            return '<input type="checkbox" id="checkbox" name="id[]" value="%s" />'; 
        }

        /**
         * [REQUIRED] This method return columns to display in table
         * you can skip columns that you do not want to show
         * like content, or description
         *
         * @return array
         */
        function get_columns() {
            $columns = array(
                'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
                'request_code' => __('Request Code', 'emp_req_table_list'),
                'total_cost' => __('Total Cost', 'emp_req_table_list'),
                'rep_manager_code' => __('Reporting Manager Approval', 'emp_req_table_list'),
                'skiplevel_manager_approval' => __('SkipLevel Manager Approval', 'emp_req_table_list'),
                'finance_approval' => __('Finance Approval', 'emp_req_table_list'),
                'request_date' => __('Request Date', 'emp_req_table_list'),
                'claim_status' => __('Claim Status', 'emp_req_table_list'),
                'actions'=> __('Actions', 'emp_req_table_list'),
            );
            return $columns;
        }

        /**
         * [OPTIONAL] This method return columns that may be used to sort table
         * all strings in array - is column names
         * notice that true on name column means that its default sort
         *
         * @return array
         */
        function get_sortable_columns() {
            $sortable_columns = array(
                'request_code' => array('Request Code', true),
                'total_cost' => array('Total Cost', true),
                'rep_manager_code' => array('Reporting Manager Approval', true),
                'skiplevel_manager_approval' => array('SkipLevel Manager Approval', true),
                'finance_approval' => array('Finance Approval', true),
                'request_date' => array('Request Date', true),
                'claim_status' => array('Claim Status', true)
            );
            return $sortable_columns;
        }

        /**
         * [REQUIRED] This is the most important method
         *
         * It will get rows from database and prepare them to be showed in table
         */
        function prepare_items() {
            $compid = $_SESSION['compid'];
            global $wpdb;
            global $query;
            //$mydetails->EMP_Code;
            //$table_name = 'requests'; // do not forget about tables prefix
            $empuserid = $_SESSION['empuserid'];
            $mydetails = myDetails();
            $per_page = 5; // constant, how much records will be shown per page

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            // here we configure table headers, defined in our methods
            $this->_column_headers = array($columns, $hidden, $sortable);

            // [OPTIONAL] process bulk action if any
            $this->process_bulk_action();
            // filter expense type
            if (isset($_REQUEST['filter_request']) && $_REQUEST['filter_request']) {
                $selExpenseType = $_REQUEST['filter_request'];
                if ($selExpenseType == 4) {
                    $query.=" AND req.REQ_Type IN (2, 3, 4)";
                } else {
                    $query.=" AND req.RT_Id=$selExpenseType";
                }
            }
            // filter status
            if (isset($_REQUEST['filter_status']) && $_REQUEST['filter_status']) {
                $selReqstatus = $_REQUEST['filter_status'];
                $query.=" AND req.REQ_Status=$selReqstatus";
            }
            // filter employee		
            if (isset($_REQUEST['filter_emp']) && $_REQUEST['filter_emp']) {
                $empid = $_REQUEST['filter_emp'];
                $query.=" AND re.EMP_Id=$empid";
            }
            if(isset($_REQUEST['selReqstatus'])){
            $selReqstatus = $_REQUEST['selReqstatus'];
            $query.=" AND REQ_Status=$selReqstatus";
            }
            // will be used in pagination settings
            //$total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");
            // prepare query params, as usual current page, order by and order direction
            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'req.REQ_Id';
            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

            // [REQUIRED] define $items array
            // notice that last argument is ARRAY_A, so we will retrieve array
            if (!empty($_POST["s"])) {
                $query = "";
                $search = trim($_POST["s"]);
                $searchcol = array(
                    'REQ_Code'
                );
                $i = 0;
                foreach ($searchcol as $col) {
                    if ($i == 0) {
                        $sqlterm = 'WHERE';
                    } else {
                        $sqlterm = 'OR';
                    }
                    if (!empty($_REQUEST["s"])) {
                        $query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
                    }
                    $i++;
                }
                $total_items = count($wpdb->get_results("SELECT * FROM employees emp, requests req, request_employee re" . $query . "AND emp.COM_Id='$compid' AND emp.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND emp.EMP_Id='$empuserid' AND req.REQ_Active != 9 AND re.RE_Status=1"));
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM employees emp, requests req, request_employee re" . $query . "AND emp.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND emp.EMP_Id='$empuserid' AND req.REQ_Active != 9 AND re.RE_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            } else {
                $total_items = count($wpdb->get_results("SELECT * FROM employees emp, requests req, request_employee re  WHERE emp.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND emp.EMP_Id='$empuserid' AND req.REQ_Active != 9 AND re.RE_Status=1 " . $query));

                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM employees emp, requests req, request_employee re  WHERE emp.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id='$empuserid' AND emp.EMP_Id='$empuserid' AND req.REQ_Active != 9 AND re.RE_Status=1 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            }
            // [REQUIRED] configure pagination
            $this->set_pagination_args(array(
                'total_items' => $total_items, // total items defined above
                'per_page' => $per_page, // per page constant defined at top of method
                'total_pages' => ceil($total_items / $per_page) // calculate pages count
            ));
        }

    }


    