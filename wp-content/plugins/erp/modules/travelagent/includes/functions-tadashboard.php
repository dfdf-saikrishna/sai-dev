<?php
// TOTAL BOOKING CANCELLATION REQUEST COUNT. ONLY USED IN TRAVEL AGENT, NON CORPTNE USER. THIS IS INCLUDING REMOVED REQUEST COUNT ALSO

function getCountRequests($type, $compid) {	
	global $wpdb;			
	switch ($type) {

		case 1:
			$q = 'AND bs.BS_Status=1 AND bs.BA_Id=1';
			break;
	
		case 2:
			$q = 'AND bs.BS_Status=3 AND bs.BA_Id=1';
			break;
	
		case 3:
			$q = 'AND bs.BS_Status=1';
			break;
	
		case 4:
			$q = 'AND bs.BS_Status=3';
			break;
	}

	global $filename;

	//global $compid;

	$sel = $wpdb->get_results("SELECT DISTINCT(req.REQ_Id), req.* FROM requests req, request_details rd, booking_status bs WHERE req.COM_Id='$compid' $q AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND BS_Active=1 ORDER BY bs.BS_Id DESC");

	return count($sel);
}

/*
 * [BOOKING REQUEST VIEW]
 * @return string  url of the booking request view details page
 */
function travel_agent_request_listing($com_id) {

    $url = admin_url( 'admin.php?page=&action=view&id=' . $com_id);

    return apply_filters( 'travel_agent_request_listing', $url, $com_id );
}






