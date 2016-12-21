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
class Company_List_Table extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'dashboard',
            'plural' => 'dashboard',
        ));
    }

    function column_department($item) {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $count = $wpdb->get_results("SELECT * FROM department WHERE COM_Id='$compid' AND DEP_Status=1 ORDER BY DEP_Name ASC");
        return $count[0]->DEP_Name;
    }

    function column_rpcmgr($item) {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $depid = $item['DEP_Id'];
        $count = count($wpdb->get_results("SELECT DISTINCT(EMP_Reprtnmngrcode) AS mangercode FROM employees WHERE DEP_Id='$depid'"));

        return "<a href= 'admin.php?page=Department&filter_depid=$item[DEP_Id]' >" . $count . "</a>";
        //print_r($count);die;
    }

    function column_total($item) {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $depid = $item['DEP_Id'];
        $emp = $wpdb->get_results("SELECT EMP_Id FROM employees WHERE DEP_Id='$depid'  AND EMP_Status=1 AND COM_Id=$compid");
        $count = count($emp);
        return "<a href= 'admin.php?page=menu&depId=$item[DEP_Id]'>" . $count . "</a>";
    }

    function get_columns() {
        $columns = array(
            'department' => __('Department', 'companies_table_list'),
            'rpcmgr' => __('Reporting Managers', 'companies_table_list'),
            'total' => __('Employee', 'companies_table_list'),
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'department' => array('MOD_Name', true),
            'total' => array('MOD_Name', true),
            'rpcmgr' => array('EC_Name', true),
        );
        return $sortable_columns;
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items() {
        global $wpdb;

        $compid = $_SESSION['compid'];
        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'DEP_Name';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';
        $total_items = count($this->items = $wpdb->get_results("SELECT * FROM department WHERE COM_Id='$compid' AND DEP_Status=1 ORDER BY DEP_Name"));
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM department WHERE COM_Id='$compid' AND DEP_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

}
