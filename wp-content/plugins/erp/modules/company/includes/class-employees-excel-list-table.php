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
class Upload_List_Table extends \WP_List_Table {

    private $page_status;

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'CostCenter',
            'plural' => 'CostCenters',
        ));
    }

    function column_status($item) {
        if ($item['FU_Status'] == 1)
            echo '<span class="status-1">Pending</span>';
        else if ($item['FU_Status'] == 2)
            echo '<span class="status-2">Uploaded</span>';
    }

    function column_total($item) {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $ccid = $item['CC_Id'];
        $count = $wpdb->get_results("SELECT * FROM employees WHERE CC_Id='$ccid'  AND EMP_Status=1 AND COM_Id=$compid");
        return count($count);
    }

    function column_code($item) {
        return $item['ADM_Name'];
    }

    function column_added_date($item) {
        return date('d/m/y', strtotime($item['FU_Upladeddate']));
    }

    function column_file($item) {
        return "<a href= 'admin.php?page=Claims&fuid=$item[FU_Id]'>File</a>";
    }
    function column_download($item) {
        $compid = $_SESSION['compid'];
        $fileurl="/erp/modules/company/upload/".$compid."/".$item['FU_Filename'];
        return "<a href='".WPERP_COMPANY_DOWNLOADS.$fileurl."' download='import_file'>Download</a>";
    }   
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['FU_Id']
        );
    }

    function no_items() {
        _e('No requests found.', 'erp');
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'code' => __('Added by', 'costcenter_table_list'),
            'file' => __('File Name', 'costcenter_table_list'),
            'added_date' => __('Uploaded Date', 'costcenter_table_list'),
            'status' => __('Status', 'costcenter_table_list'),
            'download' => __('Download File', 'costcenter_table_list'),
        );
        return $columns;
        //return $columns;
    }

    function get_sortable_columns() {
        
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
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'fu.FU_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        //$pcid = $item['CC_Id'];

        $total_items = count($wpdb->get_results("SELECT * FROM  file_upload fu, admin adm WHERE fu.COM_Id='$compid' AND fu.FU_Addedby_ADM_Id=adm.ADM_Id ORDER BY fu.FU_Id DESC"));


        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM  file_upload fu, admin adm WHERE fu.COM_Id='$compid' AND fu.FU_Addedby_ADM_Id=adm.ADM_Id ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
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
