<?php
namespace WeDevs\ERP\Corptne;

/**
 * Employee Class
 */
class TravelAgentview {
   //echo"fgjfkb";
    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
            'SUP_Username',
            'SUP_AgencyName',
            'SUP_Address',
            'SUP_Name',
            'SUP_Email',
            'SUP_Contact',
            'SUP_Type',
    );

    /**
     * [__construct description]
     *
     * @param int|WP_User|email user id or WP_User object or user email
     */
    public function __construct( $travelagentview = null ) {

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
            'SUP_Username'  => '',
            'SUP_AgencyName'     => '',
            'SUP_Address' => '',
            'SUP_Name'         => '',
            'SUP_Email'        => '',
            'SUP_Contact'     => '',
            'SUP_Type'=>   '3',	

        );

      /*  if ( $this->id ) {
            $fields['COM_id'] = $this->id;
            $fields['COM_Email']  = $this->COM_Email;
            $fields['COM_Name'] = $this->COM_Name;
			$fields['COM_Logo'] = $this->COM_Logo;
        } */
        return apply_filters( 'erp_hr_get_travelagents_fields', $fields, $this->id);
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
        if ( $this->id ) {
            $cache_key = 'erp-travelagent-' . $this->id;
            $row       = wp_cache_get( $cache_key, 'erp');

            if ( false === $row ) {
                $query = "SELECT * FROM superadmin 
                    WHERE SUP_Id = %d";
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
            return admin_url( 'admin.php?page=travelagents&action=view&id=' . $this->id );
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
