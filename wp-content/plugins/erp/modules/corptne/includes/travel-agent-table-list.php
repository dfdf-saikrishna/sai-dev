<?php

namespace WeDevs\ERP\Corptne;

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
class Travel_Agent_List_Table extends \WP_List_Table {

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

    function column_default($item, $column_name) {
        
    }

//    function column_supname($item)
//    {
//        return '<em>' . $item['SUP_Username'] . '</em>';
//    }
//    
    function column_contact($item) {
        $contact = $item['SUP_Contact'];
        return $contact;
    }

    function column_sname($item) {
        $sname = $item['SUP_Name'];
        return $sname;
    }

    function column_email($item) {
        $email = $item['SUP_Email'];
        return $email;
    }

    function column_agency($item) {
        $agency = $item['SUP_AgencyName'];
        return $agency;
    }

    function column_Tot_Logs($item) {
        global $wpdb;
        $table_name = "super_admin_logs";
        $supId = $item['SUP_Id'];
        $logcount = $wpdb->get_var("SELECT SAL_In FROM $table_name WHERE SUP_Id=$supId");
        if ($logcount == 0) {
            return "nil";
        } else {
            $count = "_(" . $wpdb->get_var("SELECT COUNT(SAL_In) FROM $table_name WHERE SUP_Id=$supId") . ")";

            return $logcount . $count;
        }
    }

    function column_address($item) {
        $contact = $item['SUP_Address'];
        return $contact;
    }

    function column_Created_Date($item) {

        return date('d/M/Y', strtotime($item['SUP_Date']));
    }

    function column_name($item) {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=travelagentsmenu" data-id=%s>%s</a>', $item['SUP_Id'], __('Edit', 'travelagent-table-list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['SUP_Id'], __('Delete', 'custom_table_example')),
        );
//        if($item['COM_Logo']){
//            $image = '<img src=' . $item['COM_Logo'] . ' alt="" class="avatar avatar-32 photo" height="auto" width="32">';  
//        }
//        else{
//            $image = '<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32">';
//        }
        /* return sprintf('%s %s %s',
          $image,
          '<a href="#"><strong>' . $item['COM_Name'] . '</strong></a>',
          $this->row_actions($actions)
          ); */
        return sprintf('%s %s', '<a href="' . erp_company_url_single_travelagents($item['SUP_Id']) . '"><strong>' . $item['SUP_Name'] . '</strong></a>', $this->row_actions($actions)
//                    return $emp_count;
        );
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item['SUP_Id']
        );
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'name' => __('Username', 'travelagent-table-list'),
            'agency' => __('Agency Name', 'travelagent-table-list'),
            'sname' => __('Name', 'travelagent-table-list'),
            'email' => __('Email', 'travelagent-table-list'),
            'contact' => __('Contact', 'travelagent-table-list'),
            'Tot_Logs' => __('Last Login Total Logins', 'travelagent-table-list'),
            'address' => __('Address', 'travelagent-table-list'),
            'Created_Date' => __('Added On', 'travelagent-table-list'),
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
            'agency' => array('agency', true),
                //'Company Logo' => array('company_logo', false),
                //'Contact' => array('contact', false),
                // 'Tot. Admins' => array('admins', false),
                //'Tot. Employees' => array('employees', false),
                //'Tot. Requests' => array('requests', false),
                //'Created Date' => array('date', false),
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
        $table_name = "superadmin";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids))
                $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE SUP_Id IN($ids)");
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
        $table_name = 'superadmin'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();
        $total_items = count($this->items = $wpdb->get_results("SELECT * FROM superadmin WHERE SUP_Status=1 AND SUP_Type=3 ORDER BY SUP_Id"));

        // will be used in pagination settings
        //$total_items = $wpdb->get_var("SELECT COUNT(SUP_Id) FROM $table_name");
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'SUP_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        if (!empty($_POST["s"])) {
            $search = $_POST["s"];
            $query = "";
            $searchcol = array(
                'SUP_Name',
                'SUP_Email'
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


            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM superadmin WHERE SUP_Status=1 AND SUP_Type=3 " . $query . " ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        } else {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM superadmin WHERE SUP_Status=1 AND SUP_Type=3 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
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
