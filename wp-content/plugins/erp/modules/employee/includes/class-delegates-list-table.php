<?php

namespace WeDevs\ERP\Employee;

class Delegate_List extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'employee',
            'plural' => 'employees',
            'ajax' => false
        ));
    }

    function extra_tablenav($which) {
        ?>
<!--`       <div class="alignleft">
        <a href="#" id="remove_access" class="button erp-button-danger">Remove</a>
        </div>-->
        <?php
        }

        function column_to_reporting_manager($item){
            return $item['EMP_Code'].", ".$item['EMP_Name'];
        }
        
        function column_from_date($item){
            return date('d-M, y', strtotime($item['DLG_FromDate']));
        }
        
        function column_to_date($item){
            return date('d-M, y', strtotime($item['DLG_ToDate']));
        }
        
        function column_activity($item){
            global $wpdb;
            $counts = count($wpdb->get_results("SELECT DA_Id FROM delegate_actions WHERE DA_FromEmpid = '$item[DLG_FromEmpid]' AND DA_ToEmpid='$item[DLG_ToEmpid]'"));
            if($counts)
                return '<a href="employee-delegate-actions.php?dlgid='.$item[DLG_Id].'">'.$counts.'</a>';
            else
                return '<a href="">'.$counts.'</a>';
        }
        
        function column_status($item){
            if($item['DLG_Status']==1)
                return '<span class="status-2">active</span>';
            else
                return '<span class="status-3">expired</span>';
        }
        
        function column_action($item){
            if($item['DLG_Status']==1)
                return '<a href="/wp-admin/admin.php?page=edit-delegate&dlgid='.$item['DLG_Id'].'" class="button-default" title="Edit"><i class="fa fa-pencil"></i></a>';
            else
                return '<span class="status-3">N/A</span>';
        }
            
        /**
         * [REQUIRED] this is how checkbox column renders
         *
         * @param $item - row (key, value array)
         * @return HTML
         */
        function column_cb($item) {
            return sprintf(
                    '<input type="checkbox" name="id[]" value="%s" />', $item['DLG_Id']
            );
        }

        /**
         * [REQUIRED] This method return columns to display in table
         * you can skip columns that you do not want to show
         * like content, or description
         *
         * @return array
         */

        /**
         * Get the column names
         *
         * @return array
         */
        function get_columns() {
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'to_reporting_manager' => __('To Reporting Manager', 'delegate_table_list'),
                'from_date' => __('From Date', 'delegate_table_list'),
                'to_date' => __('To Date', 'delegate_table_list'),
                'activity' => __('Activity', 'delegate_table_list'),
                'status' => __('Status', 'delegate_table_list'),
                'action' => __('Action', 'delegate_table_list'),
            );
            return $columns;
            //return apply_filters( 'erp_cr_employee_table_cols', $columns );
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
                'to_reporting_manager' => array('Employee Name Employee code', true),
                'from_date' => array('Grade', true),
                'to_date' => array('Email-Id Contact No.', true),
                'activity' => array('Reporting Manager', true),
                'status' => array('Department Designation', true),
                'action' => array('Func. Rep. Manager', false),
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
                'delete' => 'Remove'
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
            $table_name = "delegate";
            if ('delete' === $this->current_action()) {
                $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
                if (is_array($ids))
                    $ids = implode(',', $ids);

                if (!empty($ids)) {
                    $wpdb->query("UPDATE $table_name SET DLG_Status=2, DLG_ForcefullyRemovedDate=CURDATE() WHERE DLG_Id IN ($ids)");
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
            global $query;
            $compid = $_SESSION['compid'];
            $empuserid = $_SESSION['empuserid'];
            //$table_name = 'employees'; // do not forget about tables prefix

            $per_page = 5; // constant, how much records will be shown per page

            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();

            // here we configure table headers, defined in our methods
            $this->_column_headers = array($columns, $hidden, $sortable);

            // [OPTIONAL] process bulk action if any
            $this->process_bulk_action();
            // filter status
            if (isset($_REQUEST['filter_status']) && $_REQUEST['filter_status']) {
                $selaccess = $_REQUEST['filter_status'];
                $query.=" AND emp.EMP_Access=$selaccess";
            }
            // filter_dep		
            if (isset($_REQUEST['depId']) && $_REQUEST['depId']) {
                $depid = $_REQUEST['depId'];
                $query.=" AND emp.DEP_Id='$depid'";
            }
            //filter_grade
            if (isset($_REQUEST['egId']) && $_REQUEST['egId']) {
                $egid = $_REQUEST['egId'];
                $query.=" AND emp.EG_Id='$egid'";
            }
            //filter Desgination
            if (isset($_REQUEST['desId']) && $_REQUEST['desId']) {
                $desid = $_REQUEST['desId'];
                $query.=" AND emp.DES_Id='$desid'";
            }
            //account approver
            /* if (isset($_REQUEST['desId']) && $_REQUEST['desId']) {
                $accapprvr = $_REQUEST['accountapprover'];
                $query.=" AND emp.EMP_AccountsApprover='$accapprvr'";
            } */


            $user = wp_get_current_user();
            $userid = $user->ID;
            $companyid = $_SESSION['compid'];
            //$companyid ='56';
            // will be used in pagination settings
            $total_items = count($wpdb->get_results("SELECT * FROM delegate del, employees emp WHERE del.COM_Id='$compid' AND del.DLG_FromEmpid='$empuserid' AND del.DLG_ToEmpid=emp.EMP_Id AND del.DLG_Active=1"));

            // prepare query params, as usual current page, order by and order direction
            $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
            $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'del.DLG_AddedDate';
            $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

            // [REQUIRED] define $items array
            // notice that last argument is ARRAY_A, so we will retrieve array
            if (!empty($_POST["s"])) {
                $search = $_POST["s"];
                $query = "";
                $searchcol = array(
                    'EMP_Name',
                    'EMP_Email',
                    'EMP_Code'
                );
                $i = 0;
                foreach ($searchcol as $col) {
                    if ($i == 0) {
                        $sqlterm = 'AND';
                    } else {
                        $sqlterm = 'OR';
                    }
                    if (!empty($_REQUEST["s"])) {
                        $query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
                    }
                    $i++;
                }
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM delegate del, employees emp WHERE del.COM_Id='$compid' AND del.DLG_FromEmpid='$empuserid' AND del.DLG_ToEmpid=emp.EMP_Id AND del.DLG_Active=1 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            } else {
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM delegate del, employees emp WHERE del.COM_Id='$compid' AND del.DLG_FromEmpid='$empuserid' AND del.DLG_ToEmpid=emp.EMP_Id AND del.DLG_Active=1 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
            }
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
        //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
        //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
        //...

        if (empty($messages))
            return true;
        return implode('<br />', $messages);
    }

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
    