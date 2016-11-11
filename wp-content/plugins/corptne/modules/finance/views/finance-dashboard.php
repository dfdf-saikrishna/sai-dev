<?php
//require(plugin_dir_path( __FILE__ ) . "function.php");
//$rowdep=count_query("employees", "*", "WHERE EMP_Status=1 AND COM_Id='$compid'", $filename);

//print_r($rowdep);
//echo "test";
//echo $_SESSION['comid'];
//global $wpdb;
//$results = count($wpdb->get_results( 'SELECT * FROM employees WHERE EMP_Status = 1', OBJECT ));
//print_r($results);
?>
<style>
.posts{
    width: 20%;
    padding: 0 10px 0 0;
    float: right;
    margin-right: 0px;
    /* border-radius: 50px; */
    padding-left: 30px;
	color:#FFFFFF;
	text-align: center;
}
</style>
<div class="wrap erp hrm-dashboard">
    <h2>Finance Dashboard</h2>

    <div class="erp-single-container">

        <!--div class="erp-area-left"-->
                
				<div class="badge-container">
					<div class="badge-wrap badge-aqua">
					<h1 style="text-align:center;"><b>Employee's Travel & Expense Request</b></h1>
						<div class="badge-inner">
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Pending Requests
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: orange;">
							11
							</div>
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Approved Requests
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: #2ecc71;">
							2
							</div>
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Rejected Requests
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: #f35958;">
							21
							</div>
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Total Requests
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: #0090d9;">
							2
							</div>
							<div style="width:100%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								<div class="progress" style="height: 10px;margin-right:20px;">
								  <div class="progress-bar progress-bar-striped active" role="progressbar"
								  aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width:5%">
								  </div>
								</div>
								<p class="help-block">5% Approval Rate</p>
							</div>
						</div>
					</div><!-- .badge-wrap -->
					<div class="badge-wrap badge-aqua">
					<h1 style="text-align:center;">&nbsp <b>Travel Desk Claims</b></h1>
						<div class="badge-inner">
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Pending Requests
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: orange;">
							11
							</div>
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Approved Requests
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: #2ecc71;">
							2
							</div>
							<div style="width:80%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								Total Claims
							</div>
							<div class="posts" style="width:20%;padding:0 5px 0 0;float:right;margin-bottom: 10px;background: #0090d9;">
							2
							</div>	
							<div style="width:100%;padding:0 10px 0 0;float:left;margin-bottom: 10px;">
								<div class="progress" style="height: 10px;margin-right:20px;">
								  <div class="progress-bar progress-bar-striped active" role="progressbar"
								  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
								  </div>
								</div>
								<p class="help-block">50% Approval Rate</p>
							</div>
						</div>
					</div><!-- .badge-wrap -->
				</div>
				

    </div>
</div>