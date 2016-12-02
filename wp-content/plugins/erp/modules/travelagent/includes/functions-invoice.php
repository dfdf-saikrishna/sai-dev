<?php
function get_invoicecompany_list(){
	global $wpdb;
	$supid = $_SESSION['supid']; 
	$invoicecompanylist = $wpdb->get_results("SELECT com.COM_Id,com.COM_Name FROM company com WHERE
					  com.SUP_Id = $supid AND com.COM_Status = 0 ORDER BY 2");
	return $invoicecompanylist;
	}
?>



