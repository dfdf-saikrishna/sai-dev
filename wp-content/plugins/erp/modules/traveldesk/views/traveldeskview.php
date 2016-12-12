<?php 

//$filename="";
//$compid = $_SESSION['compid'];
//$emppendingcount= count_query("requests req, request_details rd, booking_status bs","DISTINCT(req.REQ_Id)", "WHERE COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND BS_Active=1 AND bs.BS_Status=1 AND bs.BA_Id=1", $filename,0);
//$emppendingcancelcount= count_query("requests req, request_details rd, booking_status bs","DISTINCT(req.REQ_Id)", "WHERE COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND bs.BS_Status=3 AND bs.BA_Id=1", $filename,0);
//$empbookingcount= count_query("requests req, request_details rd, booking_status bs","DISTINCT(req.REQ_Id)", "WHERE COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND bs.BS_Status=1", $filename,0);
//$empcancellationcount= count_query("requests req, request_details rd, booking_status bs","DISTINCT(req.REQ_Id)", "WHERE COM_Id='$compid' AND req.REQ_Id=rd.REQ_Id AND rd.RD_Id=bs.RD_Id AND REQ_Active !=9 AND RD_Status=1 AND bs.BS_Status=3", $filename,0);
//        global $wpdb;
//$companylist=$wpdb->get_row("SELECT * FROM tolerance_limits WHERE COM_Id='$compid' AND TL_Status=1 AND TL_Active=1");
//$empcount= count_query("requests", "REQ_Id", "WHERE COM_Id='$compid' AND REQ_Active !=9 AND REQ_Type IN (2,3,4)", $filename,0);
//	
//$count_approved=count_query("requests", "REQ_Id", "WHERE COM_Id='$compid' AND REQ_Status=2 AND REQ_Active!=9  AND REQ_Type IN (2,3,4)", $filename);
//				  
//$count_pending = count_query("requests", "REQ_Id", "WHERE COM_Id='$compid' AND REQ_Status=1 AND REQ_Active!=9  AND REQ_Type IN (2,3,4)", $filename);
//$count_rejected = count_query("requests", "REQ_Id", "WHERE COM_Id='$compid' AND REQ_Status=3 AND REQ_Active!=9  AND REQ_Type IN (2,3,4)", $filename);
?>

<div class="wrap erp hrm-dashboard">
    <h2><?php _e( 'Dashboard / Individual Employee Request [Without Approval]', 'superadmin' ); ?></h2>
	   

        <!--/div--><!-- .erp-area-left -->

        <!--div class="erp-area-right">
		
        </div-->
       
        <div class="wrap">
           
			<a href="#" id="erp-employee-new" class="add-new-h2"><?php _e( 'Raise Invoice', 'erp' ); ?></a>
            <?php echo $message;?>
			<form method="post">
			  <input type="hidden" name="page" value="my_list_test" />
			  <?php $table->search_box('search', 'search_id'); ?>
			</form>
			
            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>	
    </div>
    
</div>
