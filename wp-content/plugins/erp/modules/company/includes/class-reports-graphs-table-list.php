<?php

namespace WeDevs\ERP\Company;

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
class Reports_Graphs_List extends \WP_List_Table {

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
        $selected_status = ( isset($_GET['filter_status']) ) ? $_GET['filter_status'] : 0;
        $emp = ( isset($_GET['filter_emp']) ) ? $_GET['filter_emp'] : '';
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
                $selsql = $wpdb->get_results("SELECT EMP_Id, EMP_Code, EMP_Name From employees WHERE EMP_Status=1 AND COM_Id=$compid");
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

        /**
         * [REQUIRED] This method return columns to display in table
         * you can skip columns that you do not want to show
         * like content, or description
         *
         * @return array
         */
        function get_columns() {
            $columns = array(
                //'request_code' => __('Request Code', 'expense_table_list'),
                //'total_cost' => __('Total Cost', 'expense_table_list'),
                //'rep_manager_code' => __('Reporting Manager Approval', 'expense_table_list'),
                //'finance_approval' => __('Finance Approval', 'expense_table_list'),
                //'request_date' => __('Request Date', 'expense_table_list'),
               // 'claim_status' => __('Claim Status', 'expense_table_list'),
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
                'finance_approval' => array('Finance Approval', true),
                'request_date' => array('Request Date', true),
                'claim_status' => array('Claim Status', true)
            );
            return $sortable_columns;
        }
        function prepare_items() {
//            $compid = $_SESSION['compid'];
//            global $wpdb;
//            global $query;
//            $table_name = 'requests'; // do not forget about tables prefix
//
//            $per_page = 5; // constant, how much records will be shown per page
//
//            $columns = $this->get_columns();
//            $hidden = array();
//            $sortable = $this->get_sortable_columns();
//
//            // here we configure table headers, defined in our methods
//            $this->_column_headers = array($columns, $hidden, $sortable);
//
//            // [OPTIONAL] process bulk action if any
//            $this->process_bulk_action();
//            // filter expense type
//            if (isset($_REQUEST['filter_request']) && $_REQUEST['filter_request']) {
//                $selExpenseType = $_REQUEST['filter_request'];
//                if ($selExpenseType == 4) {
//                    $query.=" AND req.REQ_Type IN (2, 3, 4)";
//                } else {
//                    $query.=" AND req.RT_Id=$selExpenseType";
//                }
//            }
//            // filter status
//            if (isset($_REQUEST['filter_status']) && $_REQUEST['filter_status']) {
//                $selReqstatus = $_REQUEST['filter_status'];
//                $query.=" AND req.REQ_Status=$selReqstatus";
//            }
//            // filter employee		
//            if (isset($_REQUEST['filter_emp']) && $_REQUEST['filter_emp']) {
//                $empid = $_REQUEST['filter_emp'];
//                $query.=" AND re.EMP_Id=$empid";
//            }
//
//            // will be used in pagination settings
//            //$total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");
//            // prepare query params, as usual current page, order by and order direction
//            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
//            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'req.REQ_Id';
//            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
//
//            // [REQUIRED] define $items array
//            // notice that last argument is ARRAY_A, so we will retrieve array
//            if (!empty($_POST["s"])) {
//                $query = "";
//                $search = trim($_POST["s"]);
//                $searchcol = array(
//                    'REQ_Code'
//                );
//                $i = 0;
//                foreach ($searchcol as $col) {
//                    if ($i == 0) {
//                        $sqlterm = 'WHERE';
//                    } else {
//                        $sqlterm = 'OR';
//                    }
//                    if (!empty($_REQUEST["s"])) {
//                        $query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
//                    }
//                    $i++;
//                }
//                $total_items = $wpdb->get_var("SELECT COUNT(REQ_Code) FROM $table_name" . $query);
//                $this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* FROM $table_name req, request_employee re" . $query . "AND req.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND req.REQ_Active !=9 AND RE_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
//            } else {
//                $total_items = count($wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM $table_name req, request_employee re  WHERE req.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND req.REQ_Active !=9 AND RE_Status=1 " . $query));
//
//                $this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* FROM $table_name req, request_employee re  WHERE req.COM_Id='$compid' AND req.REQ_Id=re.REQ_Id AND req.REQ_Active !=9 AND RE_Status=1 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
//            }
//            // [REQUIRED] configure pagination
//            $this->set_pagination_args(array(
//                'total_items' => $total_items, // total items defined above
//                'per_page' => $per_page, // per page constant defined at top of method
//                'total_pages' => ceil($total_items / $per_page) // calculate pages count
//            ));
        }

    }
//    function custom_table_example_languages() {
//        load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
//    }
//
//    add_action('init', 'custom_table_example_languages');
//    