<?php
namespace WeDevs\ERP\Company;

/**
 * Employee Class
 */
class Employeeview {
    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
			'EMP_Id',
			'user_id',
            'ADM_Id',
			'SUP_Id',
			'COM_Id',
            'DEP_Id',
            'DES_Id',
            'EMP_Code',
            'EMP_Email',
            'EMP_Username',
            'EMP_Name',
            'EMP_Reprtnmngrcode',
			'EMP_Phonenumber',
			'EMP_Phonenumber2',
			'EMP_Funcrepmngrcode',
			'EG_Id',
			'EMP_Photo',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct( $employeeview = null ) {

        //$this->id   = $_GET['id'];
		$this->id = isset( $_POST['employee_id'] ) && $_POST['employee_id'] ? intval( $_POST['employee_id'] ) : false;

        //$this->user = new \stdClass();
        //$this->erp  = new \stdClass();
    }

    /**
     * Magic method to get item data values
     *
     * @param  string
     *
     * @return string
     */
    public function __get( $key ) {

	
        // lazy loading
        // if we are requesting any data from ERP table,
        // only then query to get those row
        if ( in_array( $key, $this->erp_rows ) ) {
            $this->erp = $this->get_erp_row();
        }

        if ( isset( $this->erp->$key ) ) {
            return stripslashes( $this->erp->$key );
        }

        if ( isset( $this->user->$key ) ) {
            return stripslashes( $this->user->$key );
        }
    }

    /**
     * Get the user info as an array
     *
     * @return array
     */
    public function to_array() {
	        $fields = array(
			'EMP_Id',
			'user_id',
            'ADM_Id',
			'SUP_Id',
			'COM_Id',
            'DEP_Id',
            'DES_Id',
            'EMP_Code',
            'EMP_Email',
            'EMP_Username',
            'EMP_Name',
            'EMP_Reprtnmngrcode',
			'EMP_Phonenumber',
			'EMP_Phonenumber2',
			'EMP_Funcrepmngrcode',
			'EG_Id',
			'EMP_Photo',
        );

        return apply_filters( 'erp_hr_get_employeeview_fields', $fields, $this->id);
    }

    /**
     * Get data from ERP employee table
     *
     * @param boolean $force if force from cache
     *
     * @return object the wpdb row object
     */
    private function get_erp_row() {
        global $wpdb;
		$compid = $_SESSION['compid'];
        if ( $this->id ) {
            $cache_key = 'erp-empv-' . $this->id;
            $row       = wp_cache_get( $cache_key, 'erp');
            if ( false === $row ) {
                $query = "SELECT emp.*, dep.*, des.*, eg.*,adm.*
                    FROM employees AS emp
		    LEFT JOIN admin AS adm ON  emp.ADM_Id=adm.ADM_Id
                    LEFT JOIN department AS dep ON emp.DEP_Id=dep.DEP_Id
                    LEFT JOIN designation AS des ON emp.DES_Id=des.DES_Id
                    LEFT JOIN employee_grades AS eg ON emp.EG_Id=eg.EG_Id 
                    WHERE emp.COM_Id='' AND  emp.EMP_Id = %d";
                $row   = $wpdb->get_row( $wpdb->prepare( $query, $this->id ) );
                wp_cache_set( $cache_key, $row, 'erp' );
            }
            return $row;
        }

        return false;
    }
 /**
     * Get single employee page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ( $this->id ) {
            return admin_url( 'admin.php?page=Profile&action=view&id=' . $this->id );
        }
    }

    /**
     * Get an HTML link to single employee view
     *
     * @return string url to details
     */
    public function get_link() {
        return sprintf( '<a href="%s">%s</a>', $this->get_details_url(), $this->get_full_name() );
    }
   

}
