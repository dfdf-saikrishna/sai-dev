<?php
namespace WeDevs\ERP\Travelagent;

/**
 * Employee Class
 */
class Clientview {
    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
			'COM_Logo',
            'user_id',
            'COM_Address',
            'COM_Bus',
            'COM_City',
            'COM_ComidOld',
            'COM_Cp1email',
            'COM_Cp1mobile',
            'COM_Cp1username',
            'COM_Cp2email',
            'COM_Cp2mobile',
            'COM_Cp2username',
            'COM_Descdeal',
            'COM_Email',
            'COM_Flight',
            'COM_Hotel',
            'COM_Id',
            'COM_Landline',
            'COM_Location',
            'COM_Name',
            'txtSalespersname',
            'txtSalesperemail',
            'txtSalespercontno',
            'txtadescdeal'
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct( $companyview = null ) {

        $this->id   = $_GET['id'];
       // $this->user = new \stdClass();
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
           'COM_Logo'        => '',
            'user_id'         => '',
            'COM_Address'     => '',
            'COM_Bus'      => '',
            'COM_City'     => '',
            'COM_ComidOld'       => '',
            'COM_Cp1email'     => '',
            'COM_Cp1mobile'           => '',
            'COM_Cp1username'      => '',
            'COM_Cp2email'          => '',
            'COM_Cp2mobile'         => '',
            'COM_Cp2username'          => '',
            'COM_Descdeal'  => '',
            'COM_Email'     => '',
            'COM_Flight' => '',
            'COM_Hotel'         => '',
            'COM_Id'        => '',
            'COM_Landline'     => '',
            'COM_Location'        => '',
            'COM_Name'        => '',
            'txtSalespersname'            => '',
            'txtSalesperemail'         => '',
            'txtSalespercontno'           => '',
            'txtadescdeal'     => '', 
        );

      /*  if ( $this->id ) {
            $fields['COM_id'] = $this->id;
            $fields['COM_Email']  = $this->COM_Email;
            $fields['COM_Name'] = $this->COM_Name;
			$fields['COM_Logo'] = $this->COM_Logo;
        } */
        return apply_filters( 'erp_hr_get_clientview_fields', $fields, $this->id);
    }

    /**
     * Get data from ERP employee table
     *
     * @param boolean $force if force from cache
     *
     * @return object the wpdb row object
     */
    private function get_erp_row( $force = false ) {
        global $wpdb;

        global $wpdb;

        if ( $this->id ) {
            $cache_key = 'erp-comv-' . $this->id;
            $row       = wp_cache_get( $cache_key, 'erp');

            if ( false === $row ) {
                $query = "SELECT * FROM company 
                    WHERE COM_Id = %d";
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
            return admin_url( 'admin.php?page=clientview&action=view&id=' . $this->id );
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
