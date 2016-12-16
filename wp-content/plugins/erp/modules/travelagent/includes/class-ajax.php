<?php
namespace WeDevs\ERP\Travelagent;

use WeDevs\ERP\Framework\Traits\Ajax;
use WeDevs\ERP\Framework\Traits\Hooker;

/**
 * Ajax handler
 *
 * @package WP-ERP
 */
class Ajax_Handler {

    use Ajax;
    use Hooker;

    /**
     * Bind all the ajax event for HRM
     *
     * @since 0.1
     *
     * @return void
     */
    public function __construct() {
		// Travel Agent User Create
        $this->action( 'wp_ajax_travelagentuser_create', 'travelagentuser_create' );
		$this->action( 'wp_ajax_travelagentuser_get', 'travelagentuser_get' );
		
		// Travel Agent Client Create
		$this->action( 'wp_ajax_travelagentclient_create', 'travelagentclient_create' );
		$this->action( 'wp_ajax_travelagentclient_get', 'travelagentclient_get' );
		
		$this->action( 'wp_ajax_companyinvoice_view', 'companyinvoice_view' );
		
		$this->action( 'wp_ajax_travelagentbankdetails_create', 'travelagentbankdetails_create' );
		$this->action( 'wp_ajax_travelagentbankdetails_get', 'travelagentbankdetails_get' );
		$this->action( 'wp_ajax_travelagentclaims_create', 'travelagentclaims_create' );

    }
	
	 public function rise_invoice() {
        global $wpdb;
         $supid = $_SESSION['supid']; 
		 $cmpid = '52';
        $posted = array_map('strip_tags_deep', $_POST);
        $data = $posted;
        $array = $data['select'];
        foreach ($array as $value) {
          //$response = $wpdb->get_results("SELECT tdc.TDC_Id FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE
	 // tdc.SUP_Id = '$supid' AND tdc.COM_Id = '$cmpid' AND tdcr.REQ_Id IN ($value) AND tdc.TDC_Id = tdcr.TDC_Id AND TDCR_Status = 1"); 
		 $response = $wpdb->get_row("SELECT TDBA_Id, TDBA_AccountNumber FROM travel_desk_bank_account WHERE SUP_Id = '$supid' AND  TDBA_Status=1 AND TDBA_Type = 2");
	      $this->send_success($response);
        }
    }
	
	
/*** Create/update an travelagentuser */

    public function travelagentuser_create() {
        unset( $_POST['_wp_http_referer'] );
        unset( $_POST['_wpnonce'] );
        unset( $_POST['action'] );
//alert($posted);
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $travelagentuser_id  = travelagentuser_create( $posted );
        // user notification email
            $emailer    = wperp()->emailer->get_email( 'New_Employee_Welcome' );
            $send_login = isset( $posted['login_info'] ) ? true : false;

            if ( is_a( $emailer, '\WeDevs\ERP\Email') ) {
                $emailer->trigger( $travelagentuser_id, $send_login );
            }

        $data = $posted;
        $this->send_success( $data );
    }
	
	public function travelagentuser_get() {
        global $wpdb;
        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
		$supid = $_SESSION['supid']; 
        $response = $wpdb->get_row("SELECT * FROM superadmin WHERE SUP_Id='$id' AND SUP_Status=1 AND SUP_Type=4 AND SUP_Refid='$supid'");
        $this->send_success( $response );
    }
	
	public function travelagentclaims_create() {
		
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $travelagentclaims_id  = travelagentclaims_create( $posted );
        $data = $posted;
        $this->send_success( $data );
    }
	/*** Create/update an travelagentclient */

    public function travelagentclient_create() {
        unset( $_POST['_wp_http_referer'] );
        unset( $_POST['_wpnonce'] );
        unset( $_POST['action'] );
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $travelagentclient_id  = travelagentclient_create( $posted );
        // user notification email
             $emailer    = wperp()->emailer->get_email( 'New_Employee_Welcome' );
            $send_login = isset( $posted['login_info'] ) ? true : false;

            if ( is_a( $emailer, '\WeDevs\ERP\Email') ) {
                $emailer->trigger( $travelagentclient_id, $send_login );
            } 

        $data = $posted;
        $this->send_success( $data );
    }
	
	public function travelagentclient_get() {
		// $this->send_success( "sfsdf" ); 
        global $wpdb;
         $id = $_REQUEST['id'];
		 $supid = $_SESSION['supid']; 
        $response = $wpdb->get_row("SELECT * FROM company WHERE COM_Id = '$id' AND COM_Status=0 AND SUP_Id='$supid'");
        $this->send_success( $response ); 
    }
	
	/*** Create/update an travelagentbankdetails */

    public function travelagentbankdetails_create() {
        unset( $_POST['_wp_http_referer'] );
        unset( $_POST['_wpnonce'] );
        unset( $_POST['action'] );
//alert($posted);
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $travelagentbankdetails_id  = travelagentbankdetails_create( $posted );
        $data = $posted;
        $this->send_success( $data );
    }
	
	public function travelagentbankdetails_get() {
        global $wpdb;
        $id = $_REQUEST['id'];
		$supid = $_SESSION['supid']; 
        $response = $wpdb->get_row("SELECT * FROM travel_desk_bank_account WHERE TDBA_Id = '$id' AND SUP_Id='$supid' AND TDBA_Status=1");
        $this->send_success( $response );
    }
	
	  /**
     * Gets the leave dates
     *
     * Returns the date list between the start and end date of the
     * two dates
     *
     * @since 0.1
     *
     * @return void
     */
    public function companyinvoice_view() {
		//$this->send_success( "teststsfd" );
		global $wpdb;
       // $this->verify_nonce( 'wp-erp-hr-nonce' );
	   $posted = array_map( 'strip_tags_deep', $_POST );
	   $id = $posted['id'];
      
		$response = $wpdb->get_results("SELECT tdc.TDC_Id,TDC_ReferenceNo,TDC_PaidAmount,TDC_Arrears,TDC_Status,TDC_Date,TDC_ServiceCharges,TDC_ServiceTax,COUNT(DISTINCT tdcr.TDCR_Id) AS cntReqs,
SUM(tdcr.TDCR_Quantity) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalQty,SUM(tdcr.TDCR_Amount) * COUNT(DISTINCT tdcr.TDCR_Id) / COUNT(*) AS totalAmnt FROM  travel_desk_claims tdc INNER JOIN travel_desk_claim_requests tdcr USING(TDC_Id) WHERE COM_Id = '$id' GROUP BY tdcr.TDC_Id ORDER BY TDC_Id DESC");			
		$this->send_success($response);
        //$this->send_success( array( 'id' => $id));
    }
}
