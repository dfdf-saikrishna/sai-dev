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
class All_Expense_Requests_List extends \WP_List_Table {

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
        $compid = $_SESSION['compid'];
        global $wpdb;
        if ($which != 'top') {
            return;
        }

        $selected_request = ( isset($_GET['filter_request']) ) ? $_GET['filter_request'] : 0;
        //$selected_status = ( isset($_GET['filter_status']) ) ? $_GET['filter_status'] : 0;
        $emp = ( isset($_GET['filter_emp']) ) ? $_GET['filter_emp'] : '';
        ?>
        <div class="alignleft actions">

            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
            <select name="filter_request" id="filter_request">
                <option value="">- Select -</option>
                <?php
                $selsql = $wpdb->get_results("SELECT * From expense_category WHERE EC_Id IN (1,3,6)");
                foreach ($selsql as $rowsql) {
                    ?>
                    <option value="<?php echo $rowsql->EC_Id; ?>" <?php if ($selected_request == $rowsql->EC_Id) echo 'selected="selected"'; ?> ><?php echo $rowsql->EC_Name; ?></option>
                <?php } ?>
            </select>
<!--
            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
            <select name="filter_status" id="filter_status">
                <option value="">- All -</option>
                <option value="2" <?php if ($selected_status == 2) echo 'selected="selected"'; ?> >Approved</option>
                <option value="1" <?php if ($selected_status == 1) echo 'selected="selected"'; ?> >Pending</option>
                <option value="3" <?php if ($selected_status == 3) echo 'selected="selected"'; ?> >Rejected</option>
            </select>-->

            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Designation', 'erp') ?></label>
            <select name="filter_emp" id="filter_emp">
                <option value="">- Select Finance Approver -</option>
                <?php
                $selsql = $wpdb->get_results("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 AND emp.EMP_Access=1 AND emp.EMP_AccountsApprover=1");
                foreach ($selsql as $rowemp) {
                    ?>
                    <option value="<?php echo $rowemp->EMP_Id; ?>" <?php if ($emp == $rowemp->EMP_Id) echo 'selected="selected"'; ?> ><?php echo $rowemp->EMP_Code . " - " . $rowemp->EMP_Name; ?></option>
                    <?php } ?>
                </select>
                <?php
                submit_button(__('Filter'), 'button', 'filter_employee', false);
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
                    $href = "#";
                    break;

                case 2:
                    $href = "#";
                    break;

                case 3:
                    $href = "#";
                    break;

                case 5:
                    $href = "#";
                    break;

                case 6:
                    $href = "#";
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

            return "<a href='$href?reqid=$item[REQ_Id]'>$item[REQ_Code]</a>&nbsp;$type";
        }

        function column_total_cost($item) {
            global $wpdb;
            $totalcost = $wpdb->get_row("SELECT SUM(RD_Cost) AS total  FROM request_details WHERE REQ_Id='$item[REQ_Id]'");
            //print_r($totalcost);die;

        return IND_money_format($totalcost->total ).".00";
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

            return $claimdata;
        } else {

            if ($item['REQ_Status'] == 2)
                return approvals(1);
            else
                return approvals(5);
        }
    }
    
        function column_action($item) {
            global $wpdb;
            global $claimdata;
           
        $post_view_clm = '<span class="tooltip-area"> <a href="employee-post-travel-request-details.php?reqid=' . $item['REQ_Id'] . '" class="btn btn-default btn-sm" title="View Details"><i class="fa fa-file-text-o"></i></a></span>';

        $oth_view_clm = '<span class="tooltip-area"> <a href="employee-other-expense-details.php?reqid=' . $item['REQ_Id'] . '" class="btn btn-default btn-sm" title="View Details"><i class="fa fa-file-text-o"></i></a></span>';

        $utl_view_clm = '<span class="tooltip-area"> <a href="employee-utility-request-details.php?reqid=' . $item['REQ_Id'] . '" class="btn btn-default btn-sm" title="View Details"><i class="fa fa-file-text-o"></i></a></span>';

        if ($item['REQ_Claim']) {

            switch ($item['RT_Id']) {

                case 2:
                    return $post_view_clm;
                    break;

                case 3:
                    return $oth_view_clm;
                    break;

                case 5:
                    return $mil_view_clm;
                    break;

                case 6:
                    return $utl_view_clm;
                    break;
            }
        } else {

            if ($item['REQ_Claim']) {

                $href = "#elExpType=" . $item['RT_Id'];

                echo '<span class="tooltip-area"> <a href="' . $href . '&reqid=' . $item['REQ_Id'] . '" class="btn btn-default btn-sm" title="View Details"><i class="fa fa-file-text-o"></i></a></span>';
            } else {

                $href = "#selExpType=" . $item['RT_Id'];
                echo '<span class="tooltip-area"> <a href="' . $href . '&reqid=' . $item['REQ_Id'] . '" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-pencil"></i></a></span>';
            }
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
         * [REQUIRED] This method return columns to display in table
         * you can skip columns that you do not want to show
         * like content, or description
         *
         * @return array
         */
        function get_columns() {
            $columns = array(
                'request_code' => __('Request Code', 'expense_table_list'),
                'total_cost' => __('Total Cost', 'expense_table_list'),
                //'rep_manager_code' => __('Reporting Manager Approval', 'expense_table_list'),
                //'finance_approval' => __('Finance Approval', 'expense_table_list'),
                //'request_date' => __('Request Date', 'expense_table_list'),
                'claim_status' => __('Claim Status', 'expense_table_list'),
                //'action' => __('Action', 'expense_table_list'),
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
               // 'rep_manager_code' => array('Reporting Manager Approval', true),
                //'finance_approval' => array('Finance Approval', true),
                'request_date' => array('Request Date', true),
                'claim_status' => array('Claim Status', true)
            );
            return $sortable_columns;
        }
        function prepare_items() {
            $compid = $_SESSION['compid'];
            global $wpdb;
            global $query;
            $mydetails = myDetails();
              $empid=$mydetails->EMP_Id;
            $table_name = 'requests'; // do not forget about tables prefix

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
                if ($selExpenseType == 1) {
                    $selExpType=2;
                    $query.=" ";
                } else {
                    $query.="AND RT_Id = $selExpenseType";
                }
            }
            // filter status
//            if (isset($_REQUEST['filter_status']) && $_REQUEST['filter_status']) {
//                $selReqstatus = $_REQUEST['filter_status'];
//                $query.=" AND REQ_Status=$selReqstatus";
//            }
//            // filter employee		
//            if (isset($_REQUEST['filter_emp']) && $_REQUEST['filter_emp']) {
//                $empid = $_REQUEST['filter_emp'];
//                $query.=" AND $empid";
//            }

            // will be used in pagination settings
            //$total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");
            // prepare query params, as usual current page, order by and order direction
            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'REQ_Id';
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
                       // print_r($query);die; 
                    }
                    $i++;
                }
               
                $total_items = $wpdb->get_var("SELECT COUNT(REQ_Code) FROM $table_name" . $query);              
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests " . $query . " AND COM_Id='$compid' AND REQ_Type =5 AND REQ_Active != 9 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            } else {
                $total_items = count($wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Type =5 AND REQ_Active !=9 ". $query));

                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM requests WHERE REQ_Type =5 AND COM_Id='$compid' AND REQ_Active != 9  " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            }
            // [REQUIRED] configure pagination
            $this->set_pagination_args(array(
                'total_items' => $total_items, // total items defined above
                'per_page' => $per_page, // per page constant defined at top of method
                'total_pages' => ceil($total_items / $per_page) // calculate pages count
            ));
        }

    }

//}

    /**
     * Simple function that validates data and retrieve bool on success
     * and error message(s) on error
     *
     * @param $item
     * @return bool|string
     */
//    function custom_table_example_validate_person($item) {
//        $messages = array();
//
//        if (empty($item['name']))
//            $messages[] = __('Name is required', 'custom_table_example');
//        if (!empty($item['email']) && !is_email($item['email']))
//            $messages[] = __('E-Mail is in wrong format', 'custom_table_example');
//        if (!ctype_digit($item['age']))
//            $messages[] = __('Age in wrong format', 'custom_table_example');
//        //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
//        //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
//        //...
//
//        if (empty($messages))
//            return true;
//        return implode('<br />', $messages);
//    }

    /**
     * Do not forget about translating your plugin, use __('english string', 'your_uniq_plugin_name') to retrieve translated string
     * and _e('english string', 'your_uniq_plugin_name') to echo it
     * in this example plugin your_uniq_plugin_name == custom_table_example
     *
     * to create translation file, use poedit FileNew catalog...
     * Fill name of project, add "." to path (ENSURE that it was added - must be in list)
     * and on last tab add "__" and "_e"
     *
     * Name your file like this: [my_plugin]-[ru_RU].po
     *
     * http://codex.wordpress.org/Writing_a_Plugin#Internationalizing_Your_Plugin
     * http://codex.wordpress.org/I18n_for_WordPress_Developers
     */
    function custom_table_example_languages() {
        load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
    }

    add_action('init', 'custom_table_example_languages');
    