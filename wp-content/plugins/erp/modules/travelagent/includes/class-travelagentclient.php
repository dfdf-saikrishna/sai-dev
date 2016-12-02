<?php
namespace WeDevs\ERP\Travelagent;

/**
 * Employee Class
 */
class Travelagentclient {

    /**
     * array for lazy loading data from ERP table
     *
     * @see __get function for this
     * @var array
     */
    private $erp_rows = array(
        
    );

  
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
	$supid = $_SESSION['supid']; 
	$defaults = array(
		'COM_Name' =>'',
		'COM_Prefix' =>'',
		'COM_Email' =>'',
		'COM_Mobile' =>'',
		'COM_Landline' =>'',
		'COM_Address' =>'',
		'COM_Location' =>'',
		'COM_City' =>'',
		'COM_State' =>'',
		'COM_Cp1username' =>'',
		'COM_Cp1email' =>'',
		'COM_Cp1mobile' =>'',
		'COM_Cp2username' =>'',
		'COM_Cp2email' =>'',
		'COM_Cp2mobile' =>'',
		'COM_Spname' =>'',
		'COM_Spemail' =>'',
		'COM_Spcontactno' =>'',
		'COM_Descdeal' =>'',
		'SUP_Id'=>$supid,
		'CT_Id' =>'',
		'COM_Flight'=>'',
		'COM_Bus'=>'',
		'COM_Hotel'=>'',
		'COM_Logo'=>'',
    );
        return apply_filters( 'erp_hr_get_travelagentclient_fields', $defaults, $this->id, $this->user );
        //return $defaults;
    }
  
}
