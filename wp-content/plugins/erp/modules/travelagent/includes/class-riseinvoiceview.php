<?php
namespace WeDevs\ERP\Travelagent;

/**
 * Employee Class
 */
class Riseinvoiceview {
    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
			'TDBA_Id',
			'REQ_Code',
            'REQ_Id',
			'SUP_Id',
			'COM_Id',
			'REQ_Date',
			'EC_Name',
			'MOD_Name',
			'RD_Cityfrom',
			'RD_Cityto',
			'SD_Name',
			'RD_Cost',
			'BS_Date',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct( $riseinvoiceview = null ) {

        $this->id   = $_GET['id'];
		 $this->cmpid   = $_GET['cmpid'];
		//$this->id = isset( $_POST['employee_id'] ) && $_POST['employee_id'] ? intval( $_POST['employee_id'] ) : false;

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
			'TDBA_Id',
			'REQ_Code',
            'REQ_Id',
			'SUP_Id',
			'COM_Id',
			'REQ_Date',
			'EC_Name',
			'MOD_Name',
			'RD_Cityfrom',
			'RD_Cityto',
			'SD_Name',
			'RD_Cost',
			'BS_Date',
        );

        return apply_filters( 'erp_hr_get_riseinvoiceview_fields', $fields, $this->id);
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
		$supid = $_SESSION['supid'];
		$cmpid = $this->cmpid;
        if ( $this->id ) {
            $cache_key = 'erp-empv-' . $this->id;
            $row       = wp_cache_get( $cache_key, 'erp');
            if ( false === $row ) {
                $query = "SELECT tdc.TDC_Id FROM travel_desk_claims tdc,travel_desk_claim_requests tdcr WHERE tdc.SUP_Id = '$supid' AND tdc.COM_Id = '$cmpid' AND tdcr.REQ_Id IN ($id) AND tdc.TDC_Id = tdcr.TDC_Id AND TDCR_Status = 1 
";
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
