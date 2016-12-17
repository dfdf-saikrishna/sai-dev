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
class Finance_Approvers_List extends \WP_List_Table {

    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct() {
        global $compid;
        global $status, $page;

        parent::__construct(array(
            'singular' => 'admin',
            'plural' => 'admins',
        ));
    }

    function extra_tablenav($which) {
        if ($which != 'top') {
            return;
        }
        ?>
        <div class="alignleft actions">
            <a href="#" id="remove_finance" class="button button-primary">Remove as Finance Approver</a> 
        </div>
        <?php
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name) {
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

    function column_Username($item) {
        $username = $item['ADM_Username'];
        return $username;
    }

    function column_Email($item) {
        $email = $item['ADM_Email'];
        return $email;
    }

    function column_Contact($item) {
        $contact = $item['ADM_Cont'];
        return $contact;
    }

    function column_Created_Date($item) {

        return date('d/M/Y', strtotime($item['ADM_Regdate'])) . date('h:i a', strtotime($item['ADM_Regdate']));
    }

    // function column_Tot_Requests($item){
    // global $wpdb;
    // $table_name = "requests";
    // $comId = $item['COM_Id'];
    // $req_count = $wpdb->get_var("SELECT COUNT(REQ_Id) FROM $table_name WHERE COM_Id=$comId");
    // return $req_count;
    // }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_empname_empcode($item) {
        ($item['EMP_Access'] == 1) ? $active = '<img src=' . WPERP_COMPANY_ASSETS . '/img/on.png title="active" alt="active" />' : $active = '<img src=' . WPERP_COMPANY_ASSETS . '/img/off.png title="blocked" alt="blocked" />';

        if ($item['EMP_AccountsApprover'] == 1)
            $acc = '<img src=' . WPERP_COMPANY_ASSETS . '/img/acc-apprv-icon.png title="finance approver" alt="finance approver" width=10 height=10 />';

        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=finance" data-id=%s>%s</a>', $item['EMP_Id'], __('Edit', 'companiesadmin_table_list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['EMP_Id'], __('Delete', 'companiesadmin_table_list')),
        );

        return sprintf('%s %s',
                // $image,
                $active . $acc . "<a href='#'?empid=$item[EMP_Id]'>" . $item['EMP_Name'] . "</a></br>" . $item['EMP_Code'], $this->row_actions($actions)
        );
    }

    function column_grade($item) {
        return $item['EG_Name'];
    }

    function column_email_contact($item) {
        return $item['EMP_Email'] . "., </br>" . $item['EMP_Phonenumber'];
    }

    function column_rep_manager($item) {
        $compid = $_SESSION['compid'];
        global $wpdb;
        if ($selrepmng = $wpdb->get_row("SELECT * FROM employees WHERE EMP_Code='$item[EMP_Reprtnmngrcode]' AND COM_Id='$compid'")) {
            $repMngid = $selrepmng->EMP_Id;
            $repMngName = $selrepmng->EMP_Name;
            $repMngCode = $selrepmng->EMP_Code;

            $found = 1;
        }
        if ($found)
            return "<a href='admin-employees-display.php?empid=$repMngid'>$repMngName</a><br>" . $repMngCode;
        else
            return "--";
    }

    function column_dep_des($item) {
        return $item['DEP_Name'] . "., </br>" . $item['DES_Name'];
    }

    function column_func_rep_manager($item) {
        $compid = $_SESSION['compid'];
        global $wpdb;
        if ($selrepmng = $wpdb->get_row("SELECT * FROM employees WHERE EMP_Code='$item[EMP_Funcrepmngrcode]' AND COM_Id='$compid'")) {
            $repMngid = $selrepmng->EMP_Id;
            $repMngName = $selrepmng->EMP_Name;
            $repMngCode = $selrepmng->EMP_Code;

            $found = 1;
        } else
            $found = 0;

        if ($found)
            return "<a href='admin-employees-display.php?empid=$repMngid'>$repMngName</a><br>" . $repMngCode;
        else
            return "--";
    }

    function column_requests($item) {
        $compid = $_SESSION['compid'];
        global $wpdb;
        $count_total = 0;
        $count_approved = 0;
        $count_pending = 0;
        $count_rejected = 0;

        $count_total = count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id=$item[EMP_Id] AND COM_Id='$compid' AND REQ_Active != 9 AND RE_Status=1"));
        $count_approved = count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id=$item[EMP_Id] AND req.REQ_Id=re.REQ_Id AND COM_Id='$compid' AND REQ_Status=2 AND REQ_Active != 9 AND RE_Status=1"));
        $count_pending = count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id=$item[EMP_Id] AND req.REQ_Id=re.REQ_Id AND COM_Id='$compid' AND REQ_Status=1 AND REQ_Active != 9 AND RE_Status=1"));
        $count_rejected = count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id=$item[EMP_Id] AND req.REQ_Id=re.REQ_Id AND COM_Id='$compid' AND REQ_Status=3 AND REQ_Active != 9 AND RE_Status=1"));

        return "<a href='#'>" . $count_total . "</a>" . "/" . "<a href='#'>" . $count_approved . "</a>" . "/" . "<a href='#'>" . $count_pending . "</a>" . "/" . "<a href='#'>" . $count_rejected . "</a>";
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" id="checkbox" name="id[]" value="%s" />', $item['EMP_Id']
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
            'empname_empcode' => __('Employee Name</br>Employee code', 'expense_table_list'),
            'grade' => __('Grade', 'expense_table_list'),
            'email_contact' => __('Email-Id</br>Contact No.', 'expense_table_list'),
            'rep_manager' => __('Reporting Manager', 'expense_table_list'),
            'dep_des' => __('Department</br>Designation', 'expense_table_list'),
            'func_rep_manager' => __('Func. Rep.</br>Manager', 'expense_table_list'),
            'requests' => __('Requests', 'expense_table_list'),
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
            'empname_empcode' => array('Employee Name</br>Employee code', true),
            'grade' => array('Grade', true),
            'email_contact' => array('Email-Id</br>Contact No.', true),
            'rep_manager' => array('Reporting Manager', true),
            'dep_des' => array('Department</br>Designation', true),
            'func_rep_manager' => array('Func. Rep.</br>Manager', true),
            'requests' => array('Requests', true)
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
        $compid = $_SESSION['compid'];
        $adminid = $_SESSION['adminid'];
        global $wpdb;
        global $blocked;
        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
        $table_name = "requests";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE EMP_Id IN($ids)");
            }
        }
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items() {
        $compid = $_SESSION['compid'];
        global $wpdb;
        global $query;

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = count($wpdb->get_results("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 AND emp.EMP_Access=1 AND emp.EMP_AccountsApprover=1"));

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'emp.EMP_Name';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'ASC';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
//        if (!empty($_POST["s"])) {
//            $query = "";
//            $search = trim($_POST["s"]);
//            $searchcol = array(
//                'EMP_Code'
//            );
//            $i = 0;
//            foreach ($searchcol as $col) {
//                if ($i == 0) {
//                    $sqlterm = 'WHERE';
//                } else {
//                    $sqlterm = 'OR';
//                }
//                if (!empty($_REQUEST["s"])) {
//                    $query .= ' ' . $sqlterm . ' ' . $col . ' LIKE "' . $search . '"';
//                }
//                $i++;
//            }
//            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 AND emp.EMP_Access=1 AND emp.EMP_AccountsApprover=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
//        } else {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$compid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 AND emp.EMP_Access=1 AND emp.EMP_AccountsApprover=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
       // }
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
