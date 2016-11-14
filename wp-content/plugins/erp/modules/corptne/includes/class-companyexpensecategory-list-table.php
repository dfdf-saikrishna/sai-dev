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
class Companyexpensecategory_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'companyexpensecategory',
            'plural' => 'companyexpensecategories',
        ));
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_Slno($item)
    {
        return '<em>' . $item['COM_Id'] . '</em>';
    }
    
    function column_company($item){
		
	 return sprintf( '%4$s <a href="%3$s"><strong>%1$s</strong></a> %2$s',$item['COM_Name'], '', erp_company_url_single_companyview( $item['COM_Id']),'');
   
    }
    
	function column_categorymodes($item){
        global $wpdb;
		$table_name = 'company';
		$selsql = $wpdb->get_results("SELECT * FROM $table_name WHERE COM_Status=0 ORDER BY COM_Id DESC");
            
		foreach($selsql as $result){
			$extable_name = 'expense_category';
			$modetable_name = 'mode';
                    $row="";
                    $selexpcat=$wpdb->get_results("SELECT * FROM $extable_name ORDER BY EC_Id ASC");
                    $i = 0;
                    $len = count($selexpcat);
                    foreach($selexpcat as $rowexpcat){
						$secId = $rowexpcat->EC_Id;
                        $selmode=$wpdb->get_results("SELECT MOD_Name FROM $modetable_name WHERE EC_Id=$secId AND MOD_Status=1");
                        $modes=array();
                        foreach($selmode as $rowmode)
                        array_push($modes, $rowmode->MOD_Name);
                        $modes=join(', ', $modes);
                        if ($i == 0) {
                             // first
                            $row .= "<table>";
                         }            
                       $row .= "<tr><td style='text-align:left;'>$rowexpcat->EC_Name</td><td>$modes</td></tr>";
                        if ($i == $len - 1) {
                            // last
                           $row .= "</table>";
                        }
                        $i++;  
                    }    
                    
                }
				return $row; 
    }
    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'slno' => __('SL.No.', 'companyexpensecategory_table_list'),
            'company' => __('Company', 'companyexpensecategory_table_list'),
			'categorymodes'=>__('Exapense Category & Modes', 'companyexpensecategory_table_list'),
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
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'Company Name' => array('COM_Name', true),
        );
        return $sortable_columns;
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
        $table_name = "company";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE COM_Id IN($ids)");
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
        $table_name = 'company'; // do not forget about tables prefix
		
        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(COM_Id) FROM $table_name");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'COM_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		if(!empty($_POST["s"])) {
            $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'COM_Name'
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
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE COM_Status=0".$query."ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE COM_Status=0  ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
	
}