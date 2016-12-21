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
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Flight ? IND_money_format($rowsum[0]->GL_Flight) . ".00" : 0;
    }

    function column_bus($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Bus ? IND_money_format($rowsum[0]->GL_Bus) . ".00" : 0;
    }

    function column_Car($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Car ? IND_money_format($rowsum[0]->GL_Car) . ".00" : 0;
    }

    function column_other($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Others_Travels ? IND_money_format($rowsum[0]->GL_Others_Travels) . ".00" : 0;
    }

    function column_hotel($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Hotel ? IND_money_format($rowsum[0]->GL_Hotel) . ".00" : 0;
    }

    function column_self($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Self ? IND_money_format($rowsum[0]->GL_Self) . ".00" : 0;
    }

    function column_local($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Local_Conveyance ? IND_money_format($rowsum[0]->GL_Local_Conveyance) . ".00" : 0;
    }

    function column_mobile($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Mobile ? IND_money_format($rowsum[0]->GL_Mobile) . ".00" : 0;
    }

    function column_client($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_ClientMeeting ? IND_money_format($rowsum[0]->GL_ClientMeeting) . ".00" : 0;
    }

    function column_others($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Other_Te_Others ? IND_money_format($rowsum[0]->GL_Other_Te_Others) . ".00" : 0;
    }

    function column_halt($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Halt ? IND_money_format($rowsum[0]->GL_Halt) . ".00" : 0;
    }

    function column_Boarding($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Boarding ? IND_money_format($rowsum[0]->GL_Boarding) . ".00" : 0;
    }

    function column_others1($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Others_Other_te ? IND_money_format($rowsum[0]->GL_Others_Other_te) . ".00" : 0;
    }

    function column_Data($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_DataCard ? IND_money_format($rowsum[0]->GL_DataCard) . ".00" : 0;
    }

    function column_market($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Marketing ? IND_money_format($rowsum[0]->GL_Marketing) . ".00" : 0;
    }
    function column_internet($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Internet ? IND_money_format($rowsum[0]->GL_Internet) . ".00" : 0;
    }

    function column_two($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Twowheeler ? IND_money_format($rowsum[0]->GL_Twowheeler) . ".00" : 0;
    }

    function column_four($item) {
        global $wpdb;
        $rowsum = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$item[EG_Id]' AND GL_Status=1");
        return $rowsum[0]->GL_Fourwheeler ? IND_money_format($rowsum[0]->GL_Fourwheeler) . ".00" : 0;
    }

    function column_grades($item) {
		$id = $item['EG_Id'];
		global $wpdb;
		$which_column="AB";
     $dr=$wpdb->get_results("SELECT $which_column FROM mode WHERE EC_Id=1 AND COM_Id=$compid AND MOD_Status=1 ID=$ids");
		$which_column = 'MOD_Name';
	$compid = $_SESSION['compid'];
$data_check = $wpdb->get_results("SELECT $which_column FROM mode WHERE EC_Id=1 AND COM_Id=$compid AND MOD_Status=1",$id);
//        global $wpdb;
//        $table_name = "employee_grades";
//        $compid = $_SESSION['compid'];
//        $selcom = $wpdb->get_results("SELECT * FROM $table_name WHERE COM_Id='$compid' AND EG_Status=1");
//        //$selcom = select_all("employee_grades", "*", "COM_Id='$compid' AND EG_Status=1 ORDER BY EG_Id DESC", $filename, 0);
//        $selmodes = $wpdb->get_results("SELECT * FROM mode WHERE COM_Id='0' AND MOD_Status='1'");
//        foreach ($selmodes as $value) {
//            return $value->MOD_Name;
//        }
//        foreach ($selcom as $rowcom) {
//            return $rowcom['EG_Name'];
//            $rowsum = $wpdb->get_results("SELECT * FROM grade_limits EG_Id='$rowcom[EG_Id]' AND GL_Status=1");
//            return $rowsum['GL_Flight'] ? IND_money_format($rowsum['GL_Flight']) . ".00" : 0;
//            return $rowsum['GL_Bus'] ? IND_money_format($rowsum['GL_Bus']) . ".00" : 0;
//            return $rowsum['GL_Car'] ? IND_money_format($rowsum['GL_Car']) . ".00" : 0;
//            return $rowsum['GL_Others_Travels'] ? IND_money_format($rowsum['GL_Others_Travels']) . ".00" : 0;
//            return $rowsum['GL_Hotel'] ? IND_money_format($rowsum['GL_Hotel']) . ".00" : 0;
//            return $rowsum['GL_Self'] ? IND_money_format($rowsum['GL_Self']) . ".00" : 0;
//            return $rowsum['GL_Halt'] ? IND_money_format($rowsum['GL_Halt']) . ".00" : 0;
//            return $rowsum['GL_Boarding'] ? IND_money_format($rowsum['GL_Boarding']) . ".00" : 0;
//            return $rowsum['GL_Other_Te_Others'] ? IND_money_format($rowsum['GL_Other_Te_Others']) . ".00" : 0;
//            return $rowsum['GL_Local_Conveyance'] ? IND_money_format($rowsum['GL_Local_Conveyance']) . ".00" : 0;
//            return $rowsum['GL_Mobile'] ? IND_money_format($rowsum['GL_Mobile']) . ".00" : 0;
//            return $rowsum['GL_ClientMeeting'] ? IND_money_format($rowsum['GL_ClientMeeting']) . ".00" : 0;
//            return $rowsum['GL_Others_Other_te'] ? IND_money_format($rowsum['GL_Others_Other_te']) . ".00" : 0;
//            return $rowsum['GL_DataCard'] ? IND_money_format($rowsum['GL_DataCard']) . ".00" : 0;
//            return $rowsum['GL_Marketing'] ? IND_money_format($rowsum['GL_Marketing']) . ".00" : 0;
//            return $rowsum['GL_Twowheeler'] ? IND_money_format($rowsum['GL_Twowheeler']) . ".00" : 0;
//            return $rowsum['GL_Fourwheeler'] ? IND_money_format($rowsum['GL_Fourwheeler']) . ".00" : 0;
//            return $rowsum['GL_Internet'] ? IND_money_format($rowsum['GL_Internet']) . ".00" : 0;
//        }
    }

    function column_name($item) {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $actions = array(
            'edit' => sprintf('<a href="?page=gradeslimits" data-id=%s>%s</a>', $item['GL_Id'], __('Edit', 'expensegrade_table')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['GL_Id'], __('Delete', 'expensegrade_table')),
        );
        $selcom = $wpdb->get_row("SELECT * FROM employee_grades WHERE COM_Id='$compid' AND EG_Status=1 ORDER BY EG_Id DESC");
        return sprintf('%s %s', $selcom->EG_Name, $this->row_actions($actions)
        );
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['GL_Id']
        );
    }
	
	

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __('Grade', 'expensegrade_table'),
            'grades' => __('2dgdg', 'expensegrade_table'),
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
                $wpdb->query("DELETE FROM $table_name WHERE GL_Id IN($ids)");
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
        $compid = $_SESSION['compid'];
        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

// here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

// [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

// will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(GL_Id) FROM $table_name");

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'GL_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
        $selcom = $wpdb->get_row("SELECT * FROM employee_grades WHERE COM_Id='$compid' AND EG_Status=1 ORDER BY EG_Id DESC");
        $egid = $selcom->EG_Id;
        $total_items = count($this->items = $wpdb->get_results("SELECT * FROM grade_limits WHERE EG_Id='$egid' AND GL_Status=1 ORDER BY GL_Id"));
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM grade_limits WHERE EG_Id='$egid' AND GL_Status=1 ORDER BY  $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
// [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

}

function custom_table_example_languages() {
    load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
}

add_action('init', 'custom_table_example_languages');
