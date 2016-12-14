<?php

namespace WeDevs\ERP\Company;

//define( 'WP_DEBUG', true );
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
class Mileage_List_Table extends \WP_List_Table {

    private $page_status;
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'mileage',
            'plural' => 'mileage',
        ));
    }

    /* function column_your_image_column_name($item)
      {
      return sprintf(
      '<img src="%s" />',
      $item['your_image_column_name']
      );
      } */

//      function column_units($item) {
//        //print_r ($item);die;
//        $limits = $item['MIL_Units'];
//        return $limits;
//    }
    function column_units($item) {
        $units = $item['MIL_Units'];
        return $units;
    }
    function column_amount($item) {
        $units = $item['MIL_Amount'];
        return $units;
    }
    function column_Added_Date($item) {
        $date = date('d/M/Y h:i a', strtotime($item['MIL_AddedDate']));
        return $date;
    }
    function column_status($item) {
        if ($item['MIL_Status'] ||( $this->page_status == '2' )) {
         return '<span class="status-2">OPEN</span>';
        } else {
            return '<span class="status-4">N/A</span>';
        }
       // return $closeDate;
    }
    function column_Closed_Date($item) {

        if ($item['MIL_ClosedDate']) {
            return date('d-m-y h:i a', strtotime($item['MIL_ClosedDate']));
        } else {
            return '<span class="satus-4">N/A</span>';
        }

        return $closeDate;
    }

    function column_name($item) {
        $actions = array(
            'edit' => sprintf('<a href="?page=Mileage" data-id=%s">%s</a>', $item['MIL_Id'], __('Edit', 'mileage_table_list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['MIL_Id'], __('Delete', 'mileage_table_list')),
        );
             return sprintf('%s %s',$item['MOD_Name'], $this->row_actions($actions)
//        return sprintf('%s %s',
//            '<a href="'.erp_company_url_single_mileage( $item['MIL_Id']).'"><strong>' . $item['MOD_Name'] . '</strong></a>',
//            $this->row_actions($actions)
       // return sprintf('%s %s', $item['MOD_Name'], $this->row_actions($actions)
        );
    }
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['MOD_Id']
        );
    }

    function no_items() {
        _e('No requests found.', 'erp');
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __('Mileage Type', 'mileage_table_list'),
            'units' => __('Units', 'mileage_table_list'),
            'amount' => __('Amount (Rs)', 'mileage_table_list'),
            'status' => __('Status', 'mileage_table_list'),
            'Added_Date' => __('Added Date', 'mileage_table_list'),
            'Closed_Date' => __('Closed Date', 'mileage_table_list'),
        );
        return $columns;
        //return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
                //'Company Name' => array('company_name', true),
                //'Company Logo' => array('company_logo', false),
                // 'num' => array('Sl.No', false),
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        global $wpdb;
        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
        $table_name = "mileage";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE MIL_Id IN($ids)");
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
        //$table_name = 'mileage'; // do not forget about tables prefix
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
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'MIL_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
       
        $total_items = count($wpdb->get_results("SELECT * FROM mileage mil, mode mo WHERE mil.COM_Id = '$compid' AND mil.MOD_Id=mo.MOD_Id AND MIL_Active=1"));

       $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM mileage mil, mode mo WHERE mil.COM_Id = '$compid' AND mil.MOD_Id=mo.MOD_Id AND MIL_Active=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
      //print_r($test);die;
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

}

/**
 * Simple function that validates data and retrieve bool on success
 * and error message(s) on error
 *
 * @param $item
 * @return bool|string
 */

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
