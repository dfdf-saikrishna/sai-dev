<?php
//$compid		=	$_SESSION['compid'];
//$workflow=compPolicy($compid);

function get_expense() 
{
    global $wpdb;
     $compid = $_SESSION['compid'];
    $expense = $wpdb->get_results("SELECT * FROM travel_expense_policy_doc WHERE COM_Id='$compid' AND TEPD_Status=1");
    return $expense;
}