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
class AddCategory_List_Table extends \WP_List_Table {

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

//    function column_expense($item) {
//        return $item['EC_Name'];
//    }

    function column_mode($item) {
        global $wpdb;
        $ecId = $item['EC_Id'];
        $compid = $_SESSION['compid'];
        $selexpcat = $wpdb->get_results("SELECT * FROM mode WHERE EC_Id=$ecId AND COM_Id ='$compid' AND MOD_Status=1");
        //print_r($selexpcat);die;
        if (count($selexpcat)) {

            $modes = array();

            foreach ($selexpcat as $rowexpcat)
                array_push($modes, $rowexpcat->MOD_Name);

            //$modes=join(', ', $modes);

            $ol = "<ol>";

            $k = 1;

            foreach ($modes as $mo) {

                $ol.='<li type="none">' . $k . ". " . $mo . '</li>';

                $k++;
            }

            $modes = $ol . "</ol>";
        } else {

            $modes = 'N/A';
        }
        return $modes;
    }
      function column_expense($item) {
        $actions = array(
            'edit' => sprintf('<a href="?page=SubCategory" data-id=%s">%s</a>', $item['EC_Id'], __('Edit', 'subcat-table-list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['EC_Id'], __('Delete', 'subcat-table-list')),
        );
             return sprintf('%s %s',$item['EC_Name'], $this->row_actions($actions)
//        return sprintf('%s %s',
//            '<a href="'.erp_company_url_single_mileage( $item['MIL_Id']).'"><strong>' . $item['MOD_Name'] . '</strong></a>',
//            $this->row_actions($actions)
       // return sprintf('%s %s', $item['MOD_Name'], $this->row_actions($actions)
        );
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
            'expense' => __('Expense Category', 'subcat-table-list'),
            'mode' => __('Modes', 'subcat-table-list'),
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

    function process_bulk_action() {
        global $wpdb;
        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
        $table_name = "expense_category";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE EC_Id IN($ids)");
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

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM expense_category  ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

}
