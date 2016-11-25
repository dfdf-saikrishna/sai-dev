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
class Employee_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct( array(
            'singular' => 'employee',
            'plural'   => 'employees',
            'ajax'     => false
        ) );
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    
    function column_repm($item){
		//print_r($employeelist);
        global $wpdb;
		$found=0;			  
		if($selrepmng=$wpdb->get_results("SELECT * FROM employees WHERE EMP_Code='".$item['EMP_Reprtnmngrcode']."'"));
		{
			if(count($selrepmng)!=0){
			$repMngid		=	$selrepmng[0]->EMP_Id;
			$repMngName		=	$selrepmng[0]->EMP_Name;
			$repMngCode		=	$selrepmng[0]->EMP_Code;
			}else{
			$repMngid		=	'___';
			$repMngName		=	'___';
			$repMngCode		=	'___';	
			}
			$found=1;
		}
			return sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_employeeview($repMngid).'"><strong>' . $repMngName . '</strong></br>' . $repMngCode .'</a>',''
        );
			
    }
	
	function column_frepm($item){
		global $wpdb;
		$user = wp_get_current_user();
		$comId = $_SESSION['compid'];
		//$comId ='56';
		$found=0;			  
		if($selfrepmng=$wpdb->get_results("SELECT * FROM employees WHERE EMP_Code='".$item['EMP_Funcrepmngrcode']."'"));
		{
			if(count($selfrepmng)!=0){
			$repMngid		=	$selfrepmng[0]->EMP_Id;
			$repMngName		=	$selfrepmng[0]->EMP_Name;
			$repMngCode		=	$selfrepmng[0]->EMP_Code;
			}else{
			$repMngid		=	'___';
			$repMngName		=	'___';
			$repMngCode		=	'___';	
			}
			$found=1;
		}
			return sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_employeeview($repMngid).'"><strong>' . $repMngName . '</strong></br>' . $repMngCode .'</a>',''
        );
			
    }
    
	function column_depdes($item){
			return $item['DEP_Name'] .'<br>'. $item['DES_Name'] ;
    }
	
    function column_emailcontact($item){

        return $item['EMP_Email'] .'<br>'. $item['EMP_Phonenumber'] ;
    }
    
    function column_grade($item){
        return $item['EG_Name'];
    }

	function column_requests($item){
		global $wpdb;
		$compid = $_SESSION['compid'];
		//$compid ='56';
		$count_total=0;$count_approved=0;$count_pending=0;$count_rejected=0;$filename="";
		
		$count_total=count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='".$item['EMP_Id']."' AND REQ_Active != 9 AND RE_Status=1 AND REQ_Type !=5"));
		$count_approved=count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='".$item['EMP_Id']."' AND req.REQ_Id=re.REQ_Id  AND COM_Id='$compid' AND REQ_Status=2 AND REQ_Active != 9 AND RE_Status=1 AND REQ_Type !=5"));
		$count_pending=count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='".$item['EMP_Id']."' AND req.REQ_Id=re.REQ_Id   AND COM_Id='$compid' AND REQ_Status=1 AND REQ_Active != 9 AND RE_Status=1 AND REQ_Type !=5"));
		$count_rejected=count($wpdb->get_results("SELECT DISTINCT (req.REQ_Id) FROM requests req, request_employee re WHERE req.REQ_Id=re.REQ_Id AND re.EMP_Id='".$item['EMP_Id']."' AND req.REQ_Id=re.REQ_Id   AND COM_Id='$compid' AND REQ_Status=3 AND REQ_Active != 9 AND RE_Status=1 AND REQ_Type !=5"));

	$count_total = sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_reqview($item['EMP_Id']).'"><strong>' . $count_total . '</strong></a>',''
        );  
		
    $count_approved = sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_reqview($item['EMP_Id']).'"><strong>' . $count_approved . '</strong></a>',''
        ); 
		
    $count_pending = sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_reqview($item['EMP_Id']).'"><strong>' . $count_pending . '</strong></a>',''
        );
	$count_rejected = sprintf('%s %s %s','',
            '<a href="'.erp_company_url_single_reqview($item['EMP_Id']).'"><strong>' . $count_rejected . '</strong></a>',''
        );
		
		return $count_total .'/'. $count_approved .'/'. $count_pending.'/'.$count_rejected;
    }
	
    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_name($item)
    {
		//var_dump($item);
        $actions = array(
            'edit' => sprintf('<a href="?page=menu" data-id=%s>%s</a>', $item['EMP_Id'], __('Edit', 'employees_table_list')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['EMP_Id'], __('Delete', 'custom_table_example')),
        );
		if($item['EMP_Photo']){
            $image = '<img src=' . $item['EMP_Photo'] . ' alt="" class="avatar avatar-32 photo" height="auto" width="32">';  
        }
        else{
            $image = '<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo" height="32" width="32">';
        }
		
        // return sprintf( '%4$s <a href="%3$s"><strong>%1$s</strong></a> %2$s',$image,$item['EMP_Name'], $this->row_actions($actions), erp_company_url_single_employeeview(''),'');
    return sprintf('%s %s %s',
            $image,
            '<a href="'.erp_company_url_single_employeeview('').'"><strong>' . $item['EMP_Name'] . '</strong></a>',
            $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['EMP_Id']
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
            'cb'           => '<input type="checkbox" />',
            'name'         => __( 'Employee Name Employee code', 'employees_table_list' ),
			'grade'		   => __( 'Grade', 'employees_table_list' ),
            'emailcontact' => __( 'Email-Id Contact No.', 'employees_table_list' ),
            'repm'   	   => __( 'Reporting Manager', 'employees_table_list' ),
            'depdes'       => __( 'Department Designation', 'employees_table_list' ),
            'frepm'        => __( 'Func. Rep. Manager', 'employees_table_list' ),
            'requests'     => __( 'Requests', 'employees_table_list' ),
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
    function get_sortable_columns()
    {
        $sortable_columns = array(
			'name'         =>array('Employee Name Employee code', true),
			'grade'		   => array( 'Grade', true),
            'emailcontact' => array( 'Email-Id Contact No.', true),
            'repm'   	   => array('Reporting Manager', true),
            'depdes'       => array( 'Department Designation', true),
            'frepm'        => array('Func. Rep. Manager', true),
            'requests'     => array('Requests', true),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions()
    {
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
    function process_bulk_action()
    {
        global $wpdb;
        //$table_name = $wpdb->prefix . 'user'; // do not forget about tables prefix
        $table_name = "employees";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

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
    function prepare_items()
    {
		global $wpdb;
        //$table_name = 'employees'; // do not forget about tables prefix

        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

		$user = wp_get_current_user();
		$userid = $user->ID;
		$companyid = $_SESSION['compid'];
		//$companyid ='56';
        // will be used in pagination settings
        $total1_items = $wpdb->get_results("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$companyid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 ");
		$total_items = count($total1_items);		
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'EMP_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		if(!empty($_POST["s"])) {
            $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'EMP_Name',
			'EMP_Email'
			);
			$i =0;
			foreach( $searchcol as $col) {
				if($i==0) {
					$sqlterm = 'AND';
				} else {
					$sqlterm = 'OR';
				}
				if(!empty($_REQUEST["s"])) {$query .=  ' '.$sqlterm.' '.$col.' LIKE "'.$search.'"';}
				$i++;
			}
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$companyid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1".$query."ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM company cmp, employees emp, department dep, designation des, employee_grades eg WHERE emp.COM_Id='$companyid' AND emp.COM_Id=cmp.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND emp.EMP_Status=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
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
function custom_table_example_validate_person($item)
{
    $messages = array();

    if (empty($item['name'])) $messages[] = __('Name is required', 'custom_table_example');
    if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'custom_table_example');
    if (!ctype_digit($item['age'])) $messages[] = __('Age in wrong format', 'custom_table_example');
    //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
    //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
    //...

    if (empty($messages)) return true;
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
function custom_table_example_languages()
{
    load_plugin_textdomain('custom_table_example', false, dirname(plugin_basename(__FILE__)));
}

add_action('init', 'custom_table_example_languages');