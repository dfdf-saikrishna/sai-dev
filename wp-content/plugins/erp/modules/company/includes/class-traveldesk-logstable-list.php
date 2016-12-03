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
class TravelDeskLogs_List_Table extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'logs',
            'plural' => 'logs',
        ));
    }

    function extra_tablenav($which) {
        $compid = $_SESSION['compid'];
        global $wpdb;
        if ($which != 'top') {
            return;
        }
        $selUsers = ( isset($_GET['filter_emp']) ) ? $_GET['filter_emp'] : '';
        ?>
        <div class="alignleft actions">
            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Travel Desk Employee', 'erp') ?></label>
            <select name="filter_emp" id="filter_emp">
                <option value="">--Select All--</option>
                <?php
                $selsql = $wpdb->get_results("SELECT * FROM travel_desk  WHERE COM_Id='$compid' AND TD_Status=1 ORDER BY TD_Username ASC");
                foreach ($selsql as $rowemp) {
                    ?>
                    <option value="<?php echo $rowemp->TD_Id; ?>" <?php if ($selUsers == $rowemp->TD_Id) echo 'selected="selected"'; ?> ><?php echo $rowemp->TD_Username ?></option>
            <?php } ?>
            </select>
            <?php
            submit_button(__('Search'), 'button', 'filter_employee', false);
            echo '</div>';
        }

        function column_name($item) {
            return $item['TD_Username'];
        }

        function column_LogOut($item) {
            return ($item['TDL_Status']) ? date('d-M-y (h:i a)', strtotime($item['TDL_Out'])) : 'Dint Logout';
        }

        function column_LogIn($item) {
            return date('d-M-y', strtotime($item['TDL_In']));
        }

        function no_items() {
            _e('No requests found.', 'erp');
        }

        function column_cb($item) {
            return sprintf(
                    '<input type="checkbox" name="id[]" value="%s" />', $item['TDL_Id']
            );
        }

        function get_columns() {
            $columns = array(
                'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
                'name' => __('Username', 'logs_table_list'),
                'LogIn' => __('Logged In', 'logs_table_list'),
                'LogOut' => __('Logged Out', 'logs_table_list'),
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
                'name' => array('Username', true),
                'LogIn' => array('Logged In', true),
                'LogOut' => array('Log Out', true),
            );
            return $sortable_columns;
        }

        function prepare_items() {
            $compid = $_SESSION['compid'];
            global $wpdb;
            //$table_name = 'travel_desk_claims'; // do not forget about tables prefix
            global $query;
//            $mydetails = myDetails();
//            $empid = $mydetails->EMP_Id;
            $per_page = 5; // constant, how much records will be shown per page

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            // here we configure table headers, defined in our methods
            $this->_column_headers = array($columns, $hidden, $sortable);

            // [OPTIONAL] process bulk action if any
            $this->process_bulk_action();
            // filter employee		
            if (isset($_REQUEST['filter_emp']) && $_REQUEST['filter_emp']) {
                $selUsers = $_REQUEST['filter_emp'];
                $query.="AND td.TD_Id=$selUsers";
            }
            // will be used in pagination settings
            $total_items = count($wpdb->get_results("SELECT* FROM travel_desk td, travel_desk_logs tdl WHERE td.COM_Id='$compid' AND tdl.COM_Id=td.COM_Id AND td.TD_Id=tdl.TD_Id ORDER BY TDL_Id DESC"));

            // prepare query params, as usual current page, order by and order direction
            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'TDL_Id';
            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';


            $this->items = $wpdb->get_results($wpdb->prepare("SELECT* FROM travel_desk td, travel_desk_logs tdl WHERE td.COM_Id='$compid' AND tdl.COM_Id=td.COM_Id AND td.TD_Id=tdl.TD_Id " . $query . " AND td.TD_Id=tdl.TD_Id ORDER BY  $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            //SELECT* FROM travel_desk td, travel_desk_logs tdl WHERE td.COM_Id='55' AND tdl.COM_Id=td.COM_Id AND td.TD_Id=tdl.TD_Id AND td.TD_Id=39 AND td.TD_Id=tdl.TD_Id ORDER BY TDL_Id desc LIMIT 5 OFFSET 0
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
    function custom_table_example_validate_person($item) {
        $messages = array();

        if (empty($item['name']))
            $messages[] = __('Name is required', 'custom_table_example');
        if (!empty($item['email']) && !is_email($item['email']))
            $messages[] = __('E-Mail is in wrong format', 'custom_table_example');
        if (!ctype_digit($item['age']))
            $messages[] = __('Age in wrong format', 'custom_table_example');

        if (empty($messages))
            return true;
        return implode('<br />', $messages);
    }

    function custom_table_example_languages() {
        load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
    }

    add_action('init', 'custom_table_example_languages');
    