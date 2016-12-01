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
class Default_expense extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'default',
            'plural' => 'default',
        ));
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
//    function column_Slno($item)
//    {
//        return '<em>' . $item['COM_Id'] . '</em>';
//    }
//
//    function column_company($item) {
//
//        return sprintf('%4$s <a href="%3$s"><strong>%1$s</strong></a> %2$s', $item['COM_Name'], '', erp_company_url_single_companyview($item['COM_Id']), '');
//    }

    function column_expense($item) {
        
        return $item['EC_Name'];
        //$table_name = '';
//        global $wpdb;
//        $ecId = $item['EC_Id'];
//         $compid = $item['COM_Id'];
//        $expense = $wpdb->get_results("SELECT * FROM expense_category WHERE 1 ORDER BY EC_Id ASC");
//         print_r($expense);
//        foreach ($expense as $rowcom) {
//            
//            $mode = $wpdb->get_results("SELECT * FROM mode WHERE EC_Id=$ecId AND COM_Id IN (0, '$compid') AND MOD_Status=1");
//            $modes = array();
//            foreach ($mode as $expense)
//            //print_r($expense);die;
//                array_push($modes, $expense->MOD_Name);
//            $ol = "<ol>";
//            $k = 1;
//            foreach ($modes as $mo) {
//                $ol.='<li type="none">' . $k . ". " . $mo . '';
//                $k++;
//            }
//
//            $modes = $ol . "</ol>";
//            print_r( $rowcom->EC_Name);
//        }
    }

    function column_mode($item) {
        global $wpdb;
        $ecId = $item['EC_Id'];
        //$compid = $mode['COM_Id'];
        $mode = $wpdb->get_results("SELECT * FROM mode WHERE EC_Id=$ecId AND COM_Id IN (0, '55') AND MOD_Status=1");
        $modes = array();
        foreach ($mode as $expense)
        //print_r($expense);die;
            array_push($modes, $expense->MOD_Name);
        $ol = "";
        $k = 1;
        foreach ($modes as $mo) {
            $ol.='<li type="none">' . $k . ". " . $mo . '';
            $k++;
        }

        $modes = $ol . "";
        return $modes;
    }

    //$selexpcat=select_all("mode", "*", "EC_Id=$rowcom[EC_Id] AND COM_Id IN (0, '$compid') AND MOD_Status=1", $filename, 0);
//
//            $modes=array();
//
//            foreach($selexpcat as $rowexpcat)
//            array_push($modes, $rowexpcat[MOD_Name]);
//
//            //print_r($modes);
//
//            //$modes=join(', ', $modes);
//
//            $ol="<ol>";
//
//            $k=1;
//
//            foreach($modes as $mo){
//
//                    $ol.='<li>'.$k.". ".$mo.'</li>';
//
//                    $k++;
//
//            }
//
//            $modes=$ol."</ol>";
    function no_items() {
        _e('No requests found.', 'erp');
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['EC_Id']
        );
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'expense' => __('Expense Category', 'expensecategory_table_list'),
            'mode' => __('Modes', 'expensecategory_table_list'),
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
        
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action() {
        global $wpdb;
        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
        $table_name = "mode";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE MOD_Id IN($ids)");
            }
        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items() {
        global $wpdb;
        $table_name = 'expense_category'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(EC_Id) FROM $table_name");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'EC_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name  ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

}
