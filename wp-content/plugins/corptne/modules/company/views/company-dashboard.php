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
<div class="wrap erp hrm-dashboard">
    <h2>Dashboard</h2>

    <div class="erp-single-container">

        <!--div class="erp-area-left"-->
                <div class="badge-container">
                    <div class="badge-wrap badge-green">
                        <div class="badge-inner">
                            <h3>22</h3>
                            <p>TOTAL <b>EMPLOYEES</b></p>
                        </div>

                        <div class="badge-footer wp-ui-highlight">
                            <a href="">View Employees</a>
                        </div>
                    </div><!-- .badge-wrap -->

                    <div class="badge-wrap badge-red">
                        <div class="badge-inner">
                            <h3>34</h3>
                            <p>TOTAL <b>FINANCE APPROVERS</b></p>
                        </div>

                        <div class="badge-footer wp-ui-highlight">
                            <a href="">View Finance Approvers</a>
                        </div>
                    </div><!-- .badge-wrap -->

                    <div class="badge-wrap badge-aqua">
                        <div class="badge-inner">
                            <h3>4</h3>
                            <p>TOTAL <b>TRAVEL DESK USERS</b></p>
                        </div>

                        <div class="badge-footer wp-ui-highlight">
                            <a href="">View Travel Desk Users</a>
                        </div>
                    </div><!-- .badge-wrap -->
					
					
                </div><!-- .badge-container -->
				<div class="badge-container">
					<div class="badge-wrap badge-aqua">
						<div class="badge-inner">
							<h3>51 / 12 / 39 / 0</h3>
							<div class="progress" style="height: 10px;margin-right:20px;">
							  <div class="progress-bar progress-bar-striped active" role="progressbar"
							  aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
							  </div>
							</div>
							<p class="help-block">40% Approval Rate</p>
							<p>TOTAL / <b>APPROVED</b> / <b>PENDING</b> / <b>REJECTED EXPENSE REQUESTS</b></p>
						</div>

						<div class="badge-footer wp-ui-highlight">
							<a href="">View Requests</a>
						</div>
					</div><!-- .badge-wrap -->
				</div>

        <!--/div--><!-- .erp-area-left -->

        <!--div class="erp-area-right">
		
        </div-->

		<div class="panel-body">
              <div class="table-responsive">

				  </div>
		</div>
		
    </div>
</div>