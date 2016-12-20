<?php
namespace WeDevs\ERP\Traveldesk;

/**
 * Employee Class
 */
class TDRiseinvoiceview {
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
    public function __construct( $tdriseinvoiceview = null ) {

        $this->id   = $_GET['reqid'];
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

        return apply_filters( 'erp_hr_get_tdriseinvoiceview_fields', $fields, $this->id);
    }

}
