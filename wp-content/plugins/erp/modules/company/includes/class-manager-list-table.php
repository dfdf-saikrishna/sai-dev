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
class Manager_Department_List_Table extends \WP_List_Table {

    private $page_status;

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'limit',
            'plural' => 'limits',
        ));
    }

    function extra_tablenav($which) {
        $compid = $_SESSION['compid'];
        global $wpdb;
        if ($which != 'top') {
            return;
        }
        $emp = ( isset($_GET['filter_depid']) ) ? $_GET['filter_depid'] : '';
        ?>
        <div class="alignleft actions">
            <label class="screen-reader-text" for="new_role"><?php _e('Filter by Departments', 'erp') ?></label>
            <select name="filter_depid" id="filter_depid">
                <option value="">- All Departments-</option>
                <?php
                $selsql = $wpdb->get_results("SELECT * From department WHERE COM_Id='$compid' AND DEP_Status=1");
                foreach ($selsql as $rowemp) {
                    ?>
                    <option value="<?php echo $rowemp->DEP_Id; ?>" <?php if ($emp == $rowemp->DEP_Id) echo 'selected="selected"'; ?> ><?php echo $rowemp->DEP_Name; ?></option>
                <?php } ?>
            </select>
            <?php
            submit_button(__('Search'), 'button', 'filter_employee', false);
            echo '</div>';
            //}
        }

        function column_mgrname($item) {
            global $wpdb;
            $mangercode = $item['mangercode'];
            $rowmngr = $wpdb->get_results("SELECT * From employees Where EMP_Code='$mangercode'");
            $id = $rowmngr[0]->EMP_Id;
            $code = $rowmngr[0]->EMP_Code;
            $name = $rowmngr[0]->EMP_Name;
            return "<a href= 'admin.php?page=Employeesdisplay&empid=$id' >" . $code . "</a>" . '<br>' . $name;
            //return $rowmngr[0]->EMP_Id . '<br>' . $rowmngr[0]->EMP_Code . '<br>' . $rowmngr[0]->EMP_Name;
        }

        function column_EMAIL($item) {
            global $wpdb;
            $mangercode = $item['mangercode'];
            $rowmngr = $wpdb->get_results("SELECT * From employees Where EMP_Code='$mangercode'");
            $code = $rowmngr[0]->EMP_Email;
            $name = $rowmngr[0]->EMP_Phonenumber;

            return $rowmngr[0]->EMP_Email . '<br>' . $rowmngr[0]->EMP_Phonenumber;
        }

        function column_cb($item) {
            return sprintf(
                    '<input type="checkbox" name="id[]" value="%s" />', $item['mangercode']
            );
        }

        function no_items() {
            _e('No requests found.', 'erp');
        }

        function get_columns() {
            $columns = array(
                'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
                'mgrname' => __('Manager code / Name', 'dep_manager_table'),
                'email' => __('Manager Email-Id / Contact No.', 'dep_manager_table'),
            );
            return $columns;
            //return $columns;
        }

        function get_sortable_columns() {
            $sortable_columns = array(
                'email' => array('Manager Email-Id / Contact No.', true),
                'mgrname' => array('Manager code / Name', true),
                    // 'num' => array('Sl.No', false),
            );
            return $sortable_columns;
        }

//    function get_bulk_actions() {
//        $actions = array(
//            'delete' => 'Delete'
//        );
//        return $actions;
//    }
//
//    function process_bulk_action() {
//        global $wpdb;
//        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
//        //$table_name = "tolerance_limits";
//        if ('delete' === $this->current_action()) {
//            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
//            if (is_array($ids))
//                $ids = implode(',', $ids);
//
//            if (!empty($ids)) {
//                $wpdb->query("DELETE FROM employees WHERE TL_Id IN($ids)");
//            }
//        }
//    }

        /**
         * [REQUIRED] This is the most important method
         *
         * It will get rows from database and prepare them to be showed in table
         */
        function prepare_items() {
            global $wpdb;
            global $query;
            //$table_name = 'mileage'; // do not forget about tables prefix
            $compid = $_SESSION['compid'];
            $per_page = 5; // constant, how much records will be shown per page

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            // here we configure table headers, defined in our methods
            $this->_column_headers = array($columns, $hidden, $sortable);
            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : '';
            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : '';
            // [OPTIONAL] process bulk action if any
            $this->process_bulk_action();
            if (isset($_REQUEST['filter_depid']) && $_REQUEST['filter_depid']) {
                $depid = $_REQUEST['filter_depid'];
                $query.=" AND DEP_Id=$depid";
            }
            if (!empty($_POST["s"])) {
                $query = "";
                $search = trim($_POST["s"]);
                $searchcol = array(
                    ''
                );
                $i = 0;
                foreach ($searchcol as $col) {
                    if ($i == 0) {
                        $sqlterm = 'WHERE';
                    } else {
                        $sqlterm = 'OR';
                    }
                    if (!empty($_REQUEST["s"])) {
                        $query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
                    }
                    $i++;
                }

                // prepare query params, as usual current page, order by and order direction



                $total_items = count($wpdb->get_results("SELECT DISTINCT(EMP_Reprtnmngrcode) AS mangercode FROM employees WHERE COM_Id='$compid' AND EMP_Status=1" . $query));

                $this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(EMP_Reprtnmngrcode) AS mangercode FROM employees WHERE COM_Id='$compid' AND EMP_Status=1  " . $query . "   LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            } else {
                $total_items = count($wpdb->get_results("SELECT DISTINCT(EMP_Reprtnmngrcode) AS mangercode FROM employees WHERE COM_Id='$compid' AND EMP_Status=1" . $query));
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(EMP_Reprtnmngrcode) AS mangercode FROM employees WHERE COM_Id='$compid' AND EMP_Status=1  " . $query . "   LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            }//print_r($test);die;
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
    