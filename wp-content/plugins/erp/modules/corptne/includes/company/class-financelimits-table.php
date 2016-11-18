<?php

namespace WeDevs\ERP\Corptne;

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
class FinanceLimits_List_Table extends \WP_List_Table {

    //private $page_status;
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
    function column_default1($item, $column_name) {
//        switch ( $column_name ) {
//        case 'Contact':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Tot_Admins':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Tot_Employees':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Tot_Request':
//            return $item['COM_Spcontactno'];
//            break;
//        case 'Created_Date':
//            return $item['COM_Spcontactno'];
//            break;
//        }
        //return $item['COM_Name'];
    }

    /* function column_your_image_column_name($item)
      {
      return sprintf(
      '<img src="%s" />',
      $item['your_image_column_name']
      );
      } */

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
//    function column_num($item)
//    {
//        //return '<em>' . $item['user_nicename'] . '</em>';
//        for($i=1;$i<;$i++){
//            echo $i;
//            
//        }
//    }
    function column_code($item) {
        $code = $item['EMP_Name'] . ',</br>' . $item['EMP_Code'];
        return $code;
    }

    function column_limits($item) {
        //print_r ($item);die;
        $limits = $item['APL_LimitAmount'];
        return $limits;
    }

    function column_default($item, $column_name) {
        
        switch ($column_name) {

            case 'status':
                return '<span class="status-' . $item->status . '">' . erp_hr_financelimits_get_statuses($item->status) . '</span>';

            default:
                return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

//    function column_status($item, $column_name) {
//       // if ($column_name) {
//
//            return '<span class="status-' . $item->status . '">' . erp_hr_financelimits_get_statuses($item->status) . '</span>';
//            //return $code;
//       // }
//       // return isset($item->$column_name) ? $item->$column_name : '';
//    }

    function column_Added_Date($item) {

        $date = date('d/M/Y', strtotime($item['APL_AddedDate']));
        return $date;

        //return erp_format_date( $item['APL_AddedDate'] );
        // return date('d/M/Y', strtotime($item['APL_AddedDate']));
    }

    function column_Closed_Date($item) {

        if ($item['APL_ClosedDate']) {
            $closeDate = date('d-m-y h:i a', strtotime($item['APL_ClosedDate']));
        } else {
            return '<span class="status-' . $item->status . '">' . erp_hr_financelimits_get_statuses($item->status) . '</span>';
        }

        return $closeDate;
    }

    function column_edit($item) {
        $actions = array(
            'edit' => sprintf('<a href="?page=limitsmenu" data-id=%s>%s</a>', $item['EMP_Id'], __('Edit', 'FinanceLIMITS_table_list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['EMP_Id'], __('Delete', 'custom_table_example')),
        );
        $image = '<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32">';
        return sprintf('%s %s %s', $image, '<a href="' . erp_company_url_single_financlimitseview($item['EMP_Id']) . '"><strong>' . $item['EMP_Name'] . '</strong></a>', $this->row_actions($actions)
        );
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['COM_Id']
        );
    }

    function no_items() {
        _e('No requests found.', 'erp');
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
            //'num' => __('Sl.No', 'financelimits_table_list'),
            'code' => __('Employee', 'financelimits_table_list'),
            'limits' => __('Limit Amount (Rs)', 'financelimits_table_list'),
            'name' => __('Status', 'financelimits_table_list'),
            'Added_Date' => __('Added Date', 'financelimits_table_list'),
            'Closed_Date' => __('Closed Date', 'financelimits_table_list'),
                //'frmgr' => __('Func. Rep.Manager', 'finance_table_list'),
                //'request' => __('Request', 'finance_table_list'),
        );
        if (isset($_GET['status']) && $_GET['status'] == 3) {
            $columns['comment'] = __('Reject Reason', 'erp');
        }
        return $columns;
        //return $columns;
    }

    function column_name($item) {
        $tpl = '?page=financelimits&Finance_action=%s&id=%d';
        $nonce = 'erp-hr-leave-req-nonce';
        $actions = array();

        $delete_url = wp_nonce_url(sprintf($tpl, 'delete', $item->id), $nonce);
        $reject_url = wp_nonce_url(sprintf($tpl, 'reject', $item->id), $nonce);
        $approve_url = wp_nonce_url(sprintf($tpl, 'approve', $item->id), $nonce);
        $pending_url = wp_nonce_url(sprintf($tpl, 'pending', $item->id), $nonce);
        if (erp_get_option('erp_debug_mode', 'erp_settings_general', 0)) {
            $actions['delete'] = sprintf('<a href="%s">%s</a>', $delete_url, __('Delete', 'erp'));
        }

        if ($item->status == '2') {

            $actions['reject'] = sprintf('<a class="erp-hr-leave-reject-btn" data-id="%s" href="%s">%s</a>', $item->id, $reject_url, __('Reject', 'erp'));
            $actions['approved'] = sprintf('<a href="%s">%s</a>', $approve_url, __('Approve', 'erp'));
        } elseif ($item->status == '1') {

            $actions['pending'] = sprintf('<a href="%s">%s</a>', $pending_url, __('Mark Pending', 'erp'));
        } elseif ($item->status == '3') {
            $actions['approved'] = sprintf('<a href="%s">%s</a>', $approve_url, __('Approve', 'erp'));
        }

        return sprintf('<a href="%3$s"><strong>%1$s</strong></a> %2$s', $item->display_name, $this->row_actions($actions), erp_hr_url_single_employee($item->user_id));
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
            // 'num' => array('Sl.No', false),
            'code' => array('Employee Name & Employee Code', true),
            'limits' => array('Limit Amount (Rs)', false),
            'name' => array('Status.', false),
            'Added_Date' => array('Added Date', false),
            'Closed_Date' => array('Closed Date', false),
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
        $table_name = "employees";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE COM_Id IN($ids)");
            }
            if ($this->page_status == '2') {
                $actions['reject'] = __('Reject', 'erp');
                $actions['approved'] = __('Approve', 'erp');
            } elseif ($this->page_status == '1') {
                $actions['pending'] = __('Mark Pending', 'erp');
                $actions['reject'] = __('Reject', 'erp');
            } elseif ($this->page_status == '3') {
                $actions['approved'] = __('Approve', 'erp');
                $actions['pending'] = __('Mark Pending', 'erp');
            } else {
                $actions['reject'] = __('Reject', 'erp');
                $actions['approved'] = __('Approve', 'erp');
                $actions['pending'] = __('Mark Pending', 'erp');
            }
            return $actions;
        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items() {
        global $wpdb;
        $table_name = 'employees'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(EMP_Id) FROM $table_name");
        // print_r($total_items);die;
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'al.APL_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        $comId = $wpdb->get_var("SELECT COM_Id FROM $table_name");
        //print_r($comId);die;
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM approval_limit al, employees emp", "*", "al.APL_Active=1 AND al.EMP_Id = emp.EMP_Id AND emp.COM_Id='$comId' AND EMP_Status=1 AND EMP_AccountsApprover=1 AND EMP_Access=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
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
