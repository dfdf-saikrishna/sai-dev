<?php

$filename="";
//$empcount=count_query("company","COM_Id","WHERE COM_Status=0",$filename,0);
$rowadmin=count_query("policy", "*", "POL_Id='$workflow'", $filename);

?>
<div class="wrap erp hrm-dashboard">
    <h2><?php _e( 'Dashboard', 'superadmin' ); ?></h2>
</div>