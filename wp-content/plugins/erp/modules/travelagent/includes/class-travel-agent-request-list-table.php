<?php
namespace WeDevs\ERP\Travelagent;
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
class Travel_Agent_Request_List_Table extends \WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'travelagentrequest',
            'plural' => 'travelagentrequests',
        ));
    }
    
   
	 /**
     * how to render column with view,
     * @return HTML
     */
	function column_Request_Code($item)
    {
		$cmpid 	= $_REQUEST['id'];
		$type = $_REQUEST['selFilter'];	
		$void = 0; $icon = 0; $onclick = NULL;
									
									
									switch($item['REQ_Active']){
						
										case 1:
										$href="";
											$reqcode = $item['REQ_Code'];								
										break;
										
										case 9:
											$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
										break;
										
									
									}
									global $wpdb;
								$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id,
										  CHAR(8))) AS rdids,COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
										  ((SUM(rd.RD_Cost)*COUNT(DISTINCT rd.RD_Id))/COUNT(*)) as rdcost,SUM(rd.RD_TotalCost)*count(DISTINCT rd.RD_Id)/count(*) as rdGrpcost,
										 GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id,CHAR(8))) AS baids FROM requests req
										LEFT JOIN
										  request_details rd ON req.REQ_Id = rd.REQ_Id
										LEFT JOIN
										  request_employee re ON req.REQ_Id = re.REQ_Id
										LEFT JOIN
										  booking_status bs ON rd.RD_Id = bs.RD_Id
										WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
										AND BS_Active = 1 GROUP BY req.REQ_Id");
									
									//echo $selsql.'<br>';
									
									$getvals = $selsql;
									
									
									$reqtype = $item['REQ_Type'];
									
									$alertBadge = 0;
								
									switch ($item['REQ_Type']){
							
										
										case 2:
										
											$href='travel-agent-request-details.php';
											$type='<span style="font-size:10px;">[E]</span>';
											$title="Employee Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 
																		
										break;
										
										
									
										case 4:
										
											$href='travel-agent-group-request-details.php';
											$type='<span style="font-size:10px;">[G]</span>';
											$title="Group Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
											
										break;
										
										
									
									}
									
						$badge = $icon = $onclick = null; 			 
									
						if( in_array(1, explode(",", $getvals[0]->baids)) ) {
							
							
							$badge = '<span class="badge bg-warning">'.$getvals[0]->rdCnt.'</span>'; 
							
							//$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';
						}
						else { 
							
							$badge = '<span class="badge bg-success">'.$getvals[0]->rdCnt.'</span>'; 
							
							$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmpid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id=$item[REQ_Id]");
							
							//echo 'count='.count($selclmreqid)."<br>";
							
							if(count($selclmreqid) != "0"){
							
								//$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';
								
								$icon=1;
							}
							if(!empty($selclmreqid)){
							if($selclmreqid[0]->TDC_Status==2)
							$icon=2;
					}
					
							
						}
		
if($icon==1){ 
$icon =  '<i class="fa fa-thumbs-o-up"></i>'; 
$title = "sent for claims";
}else if($icon==2){ 
$icon = '<i class="fa fa-thumbs-up"></i>'; 
$title = "claimed"; 
}else{
	$title = "";
}
//return '<span  width="15%" title="'. $title .'"><a href="'. $href .'&reqid='. $item['REQ_Id'] .'" target="_blank">'. $reqcode . '</a></span>'; 
		//. '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"  style="font-size:11px;"><th style="width:160px!important">Date & Expense Desc</th><tr><td>'. $date .'<div style="height:40px; overflow-y:auto;">'. $RDDescription .'</div></td></tr></table>';
return '<span  width="15%" title="'. $title .'">'. $reqcode . '</span>'; 
		//. '<table class="hide-table'.$item['REQ_Id'].' init-invoice wp-list-table widefat fixed striped collapse"  style="font-size:11px;"><th style="width:160px!important">Date & Expense Desc</th><tr><td>'. $date .'<div style="height:40px; overflow-y:auto;">'. $RDDescription .'</div></td></tr></table>';

    }
	/**
     *  Booking Request column with Count,
     * @return HTML
     */
	function column_Employee_No($item){
		$cmpid 	= $_REQUEST['id'];
		$type = $_REQUEST['selFilter'];	
       $void = 0; $icon = 0; $onclick = NULL;
									
									
									switch($item['REQ_Active']){
						
										case 1:	
											$reqcode = $item['REQ_Code'];								
										break;
										
										case 9:
											$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
										break;
										
									
									}
									global $wpdb;
								$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id,
										  CHAR(8))) AS rdids,COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
										  ((SUM(rd.RD_Cost)*COUNT(DISTINCT rd.RD_Id))/COUNT(*)) as rdcost,SUM(rd.RD_TotalCost)*count(DISTINCT rd.RD_Id)/count(*) as rdGrpcost,
										 GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id,CHAR(8))) AS baids FROM requests req
										LEFT JOIN
										  request_details rd ON req.REQ_Id = rd.REQ_Id
										LEFT JOIN
										  request_employee re ON req.REQ_Id = re.REQ_Id
										LEFT JOIN
										  booking_status bs ON rd.RD_Id = bs.RD_Id
										WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
										AND BS_Active = 1 GROUP BY req.REQ_Id");
									
									//echo $selsql.'<br>';
									
									$getvals = $selsql;
									
									
									$reqtype = $item['REQ_Type'];
									
									$alertBadge = 0;
								
									switch ($item['REQ_Type']){
							
										
										case 2:
										
											$href='travel-agent-request-details.php';
											$type='<span style="font-size:10px;">[E]</span>';
											$title="Employee Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 
																		
										break;
										
										
									
										case 4:
										
											$href='travel-agent-group-request-details.php';
											$type='<span style="font-size:10px;">[G]</span>';
											$title="Group Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
											
										break;
										
										
									
									}
									
						$badge = $icon = $onclick = null; 			 
									
						if( in_array(1, explode(",", $getvals[0]->baids)) ) {
							
							
							$badge = '<span class="badge bg-warning">'.$getvals[0]->rdCnt.'</span>'; 
							
							//$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';
						}
						else { 
							
							$badge = '<span class="badge bg-success">'.$getvals[0]->rdCnt.'</span>'; 
							
							$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmpid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id=$item[REQ_Id]");
							
							//echo 'count='.count($selclmreqid)."<br>";
							
							if(count($selclmreqid) != "0"){
							
								//$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';
								
								$icon=1;
							}
							if(!empty($selclmreqid)){
							if($selclmreqid[0]->TDC_Status==2)
							$icon=2;
					}
					
							
						}
						return $getvals[0]->empCnt;

    }
	
	function column_Quantity($item){
		$cmpid 	= $_REQUEST['id'];
		$type = $_REQUEST['selFilter'];	
         $void = 0; $icon = 0; $onclick = NULL;
									
									
									switch($item['REQ_Active']){
						
										case 1:	
											$reqcode = $item['REQ_Code'];								
										break;
										
										case 9:
											$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
										break;
										
									
									}
									global $wpdb;
								$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id,
										  CHAR(8))) AS rdids,COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
										  ((SUM(rd.RD_Cost)*COUNT(DISTINCT rd.RD_Id))/COUNT(*)) as rdcost,SUM(rd.RD_TotalCost)*count(DISTINCT rd.RD_Id)/count(*) as rdGrpcost,
										 GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id,CHAR(8))) AS baids FROM requests req
										LEFT JOIN
										  request_details rd ON req.REQ_Id = rd.REQ_Id
										LEFT JOIN
										  request_employee re ON req.REQ_Id = re.REQ_Id
										LEFT JOIN
										  booking_status bs ON rd.RD_Id = bs.RD_Id
										WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
										AND BS_Active = 1 GROUP BY req.REQ_Id");
									
									//echo $selsql.'<br>';
									
									$getvals = $selsql;
									
									
									$reqtype = $item['REQ_Type'];
									
									$alertBadge = 0;
								
									switch ($item['REQ_Type']){
							
										
										case 2:
										
											$href='travel-agent-request-details.php';
											$type='<span style="font-size:10px;">[E]</span>';
											$title="Employee Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 
																		
										break;
										
										
									
										case 4:
										
											$href='travel-agent-group-request-details.php';
											$type='<span style="font-size:10px;">[G]</span>';
											$title="Group Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
											
										break;
										
										
									
									}
									
						$badge = $icon = $onclick = null; 			 
									
						if( in_array(1, explode(",", $getvals[0]->baids)) ) {
							
							
							$badge = '<span class="badge bg-warning">'.$getvals[0]->rdCnt.'</span>'; 
							
							//$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';
						}
						else { 
							
							$badge = '<span class="badge bg-success">'.$getvals[0]->rdCnt.'</span>'; 
							
							$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmpid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id=$item[REQ_Id]");
							
							//echo 'count='.count($selclmreqid)."<br>";
							
							if(count($selclmreqid) != "0"){
							
								//$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';
								
								$icon=1;
							}
							if(!empty($selclmreqid)){
							if($selclmreqid[0]->TDC_Status==2)
							$icon=2;
					}
					
							
						}
						return $badge;
    }
	
	function column_Quote_Amount($item){
		$cmpid 	= $_REQUEST['id'];
		$type = $_REQUEST['selFilter'];	
         $void = 0; $icon = 0; $onclick = NULL;
									
									
									switch($item['REQ_Active']){
						
										case 1:	
											$reqcode = $item['REQ_Code'];								
										break;
										
										case 9:
											$reqcode = '<i title="Removed Request">'.$item['REQ_Code'].'</i>';
										break;
										
									
									}
									global $wpdb;
								$selsql = $wpdb->get_results("SELECT GROUP_CONCAT(DISTINCT CONVERT(rd.RD_Id,
										  CHAR(8))) AS rdids,COUNT(DISTINCT rd.RD_Id) AS rdCnt,COUNT(DISTINCT RE_Id) AS empCnt,
										  ((SUM(rd.RD_Cost)*COUNT(DISTINCT rd.RD_Id))/COUNT(*)) as rdcost,SUM(rd.RD_TotalCost)*count(DISTINCT rd.RD_Id)/count(*) as rdGrpcost,
										 GROUP_CONCAT(DISTINCT CONVERT(bs.BA_Id,CHAR(8))) AS baids FROM requests req
										LEFT JOIN
										  request_details rd ON req.REQ_Id = rd.REQ_Id
										LEFT JOIN
										  request_employee re ON req.REQ_Id = re.REQ_Id
										LEFT JOIN
										  booking_status bs ON rd.RD_Id = bs.RD_Id
										WHERE req.REQ_Id = '$item[REQ_Id]' AND bs.BS_Status IN (1,3) AND rd.RD_Status = 1
										AND BS_Active = 1 GROUP BY req.REQ_Id");
									
									//echo $selsql.'<br>';
									
									$getvals = $selsql;
									
									
									$reqtype = $item['REQ_Type'];
									
									$alertBadge = 0;
								
									switch ($item['REQ_Type']){
							
										
										case 2:
										
											$href='travel-agent-request-details.php';
											$type='<span style="font-size:10px;">[E]</span>';
											$title="Employee Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdcost)). ".00"; 
																		
										break;
										
										
									
										case 4:
										
											$href='travel-agent-group-request-details.php';
											$type='<span style="font-size:10px;">[G]</span>';
											$title="Group Request";
											
											$totalcosts = IND_money_format(floor($getvals[0]->rdGrpcost)). ".00"; 
											
										break;
										
										
									
									}
									
						$badge = $icon = $onclick = null; 			 
									
						if( in_array(1, explode(",", $getvals[0]->baids)) ) {
							
							
							$badge = '<span class="badge bg-warning">'.$getvals[0]->rdCnt.'</span>'; 
							
							//$void='onclick="alert(\'Please close the request for invoice.\'); return false;"';
						}
						else { 
							
							$badge = '<span class="badge bg-success">'.$getvals[0]->rdCnt.'</span>'; 
							
							$selclmreqid=$wpdb->get_results("SELECT REQ_Id, TDC_Status FROM travel_desk_claims tdc, travel_desk_claim_requests tdcr WHERE tdc.COM_Id='$cmpid' and tdc.TDC_Id=tdcr.TDC_Id AND tdcr.REQ_Id=$item[REQ_Id]");
							
							//echo 'count='.count($selclmreqid)."<br>";
							
							if(count($selclmreqid) != "0"){
							
								//$onclick='onclick="alert(\'Selected request is already sent for invoice. Please select another request.\'); return false;"';
								
								$icon=1;
							}
							if(!empty($selclmreqid)){
							if($selclmreqid[0]->TDC_Status==2)
							$icon=2;
					}
					
							
						}
						return $totalcosts;
    }
	
	function column_Date($item){
        return date('d-M-Y', strtotime($item['REQ_Date']));
    }
    /**
     * [REQUIRED] This method return columns to display in table
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'Request_Code' => __('Request Code', 'travelagentrequest_table_list'),
            'Employee_No' => __('Employee No.s', 'travelagentrequest_table_list'),
			'Quantity' => __('Quantity', 'travelagentrequest_table_list'),
			'Date' => __('Date', 'travelagentrequest_table_list'),
			'Quote_Amount' => __('Quote Amount (Rs)', 'travelagentrequest_table_list'),
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
            'Request_Code' => __('Request Code',true),
            'Employee_No' => __('Employee No.s',false),
			'Quantity' => __('Quantity',false),
			'Date' => __('Date',false),
			'Quote_Amount' => __('Quote Amount (Rs)',false),
        );
        return $sortable_columns;
    }

    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
		$supid = $_SESSION['supid'];
		$cmpid 	= $_REQUEST['id'];
		$type = $_REQUEST['selFilter'];						
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
   
        $per_page = 5; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total1_items = $wpdb->get_Results("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmpid' $q AND req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1 ORDER BY req.REQ_Id DESC");
        $total_items =count($total1_items);
		// prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'req.REQ_Id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
		if(!empty($_POST["s"])) {
                $search = $_POST["s"];
			$query="";
			$searchcol= array(
			'REQ_Code',
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
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmpid' $q AND "
        . "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1".$query." ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
		else{
			$this->items = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT(req.REQ_Id), req.* from requests req, request_details rd, booking_status bs WHERE req.COM_Id='$cmpid' $q AND "
        . "req.REQ_Id=rd.REQ_Id AND bs.BS_Status IN (1,3) AND rd.RD_Id=bs.RD_Id AND BS_Active=1 ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
		}
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}