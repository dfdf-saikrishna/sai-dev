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
class ExpenseGrade_List_Table extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'company',
            'plural' => 'companies',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name) {
    }

//    function column_num($item)
//    {
//        //return '<em>' . $item['user_nicename'] . '</em>';
//        for($i=1;$i<n;$i++){
//            echo $i;
//            
//        }
//    }
    function column_flight($item) {
        $flight = $item['GL_Flight'];
        return $flight;
    }

    function column_bus($item) {
        $bus = $item['GL_Bus'];
        return $bus;
    }

    function column_Car($item) {
        $Car = $item['GL_Car'];
        return $Car;
    }

    function column_other($item) {
        $other = $item['GL_Others_Travels'];
        return $other;
    }

    function column_hotel($item) {
        $hotel = $item['GL_Hotel'];
        return $hotel;
    }

    function column_self($item) {
        $expense = $item['GL_Self'];
        return $expense;
    }

    function column_local($item) {
        $expense = $item['GL_Local_Conveyance'];
        return $expense;
    }

    function column_mobile($item) {
        $expense = $item['GL_Mobile'];
        return $expense;
    }

    function column_client($item) {
        $expense = $item['GL_ClientMeeting'];
        return $expense;
    }

    function column_others($item) {
        $expense = $item['GL_Other_Te_Others'];
        return $expense;
    }

    function column_halt($item) {
        $expense = $item['GL_Halt'];
        return $expense;
    }

    function column_Boarding($item) {
        $expense = $item['GL_Boarding'];
        return $expense;
    }

    function column_others1($item) {
        $expense = $item['GL_Others_Other_te'];
        return $expense;
    }

    function column_Data($item) {
        $expense = $item['GL_DataCard'];
        return $expense;
    }

    function column_market($item) {
        $expense = $item['GL_Marketing'];
        return $expense;
    }

    function column_internet($item) {
        $expense = $item['GL_Internet'];
        return $expense;
    }

    function column_two($item) {
        $expense = $item['GL_Twowheeler'];
        return $expense;
    }

    function column_four($item) {
        $expense = $item['GL_Fourwheeler'];
        return $expense;
    }

    function column_grades($item) {
        global $wpdb;
        $table_name = "employee_grades";
        $comId = $item['COM_Id'];
        //echo $comId;die;
        $grades = $wpdb->get_var("SELECT * FROM $table_name WHERE COM_Id='$comId' AND EG_Status=1");
        //echo $grades ['EG_Name'];die;
//        if($admin_count == 0){
//            return "nil";
//        }
//        else{
//            return '(' . $admin_count . ')';
//        }
        $expense = $grades['EG_Name'];
        //echo $expense;die;
        return $expense;
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_name($item) {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        $actions = array(
            'edit' => sprintf('<a href="?page=persons_form&id=%s">%s</a>', $item['EG_Id'],__('Edit', 'custom_table_example')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'],$item['EG_Id'], __('Delete', 'custom_table_example')),
        );
        return sprintf('%s %s', $item['EG_Id'], $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['EG_Id']
        );
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
            'name' => __('ID', 'expensegrade_table'),
            //'grades' => __('Grade', 'expensegrade_table'),
            'flight' => __('Flight', 'expensegrade_table'),
            'bus' => __('Bus', 'expensegrade_table'),
            'car' => __('Car', 'expensegrade_table'),
            'other' => __('Others', 'expensegrade_table'),
            'hotel' => __('Hotel', 'expensegrade_table'),
            'self' => __('Self', 'expensegrade_table'),
            'local' => __('Local Conveyance', 'expensegrade_table'),
            'mobile' => __('Mobile', 'expensegrade_table'),
            'client' => __('Client Meeting	', 'expensegrade_table'),
            'others' => __('Others', 'expensegrade_table'),
            'halt' => __('Halt', 'expensegrade_table'),
            'boarding' => __('Boarding', 'expensegrade_table'),
            'others1' => __('Others', 'expensegrade_table'),
            'data' => __('Data Card', 'expensegrade_table'),
            'market' => __('Marketing', 'expensegrade_table'),
            'internet' => __('Internet', 'expensegrade_table'),
            'two' => __('Two wheeler', 'expensegrade_table'),
            'four' => __('Two wheeler', 'expensegrade_table'),
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
            //'Company Name' => array('company_name', true),
            //'Company Logo' => array('company_logo', false),
            //'num' => array('Sl.No', true),
//            'code' => array('Employee Name & Employee Code', true),
//            'grades' => array('Grade', true),
//            'email' => array('Email & Contact NO.', true),
//            'rpmgr' => array('Reporting Manager', true),
//            'dep' => array('Department & Designation', true),
//            'frmgr' => array('Func. Rep.Manager', true),
//            'request' => array('Request', true),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
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
        $table_name = "grade_limits";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE EG_Id IN($ids)");
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
        $table_name = 'grade_limits'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(EG_Id) FROM $table_name");
        // print_r($total_items);die;
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : '';
        //$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
//        $comId = '55';
        $egId = $wpdb->get_var("SELECT EG_Id FROM $table_name");
        //print_r($egId);die;
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM `grade_limits` WHERE EG_Id='$egId' AND GL_Status=1 $orderby ", $per_page, $paged), ARRAY_A);
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
