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
    <h2>Master Dashboard</h2>

    <div class="erp-single-container">

        <!--div class="erp-area-left"-->
                <div class="badge-container">
                    <div class="badge-wrap badge-green">
                        <div class="badge-inner">
                            <h3>48 / 23</h3>
                            <p>TOTAL <b>COMPANIES</b> / <b>ADMINS</b></p>
                        </div>
                    </div><!-- .badge-wrap -->
					<div class="badge-wrap badge-green">
                        <div class="badge-inner">
                            <h3>131</h3>
                            <p>TOTAL <b>EMPLOYEES</b></p>
							<div class="progress" style="height: 10px;margin-right:20px;">
							  <div class="progress-bar progress-bar-striped active" role="progressbar"
							  aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
							  </div>
							</div>
							<p class="help-block">Up 5% from last month</p>
                        </div>
						
                    </div><!-- .badge-wrap -->
					<div class="badge-wrap badge-aqua">
						<div class="badge-inner">
							<h3>121 / 71</h3>
							<p><b>REQUEST</b> / <b>APPROVAL</b></p>
							<div class="progress" style="height: 10px;margin-right:20px;">
							  <div class="progress-bar progress-bar-striped active" role="progressbar"
							  aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
							  </div>
							</div>
							<p class="help-block">59% Approval Rate</p>
						</div>
					</div><!-- .badge-wrap -->
                </div><!-- .badge-container -->


        <!--/div--><!-- .erp-area-left -->

        <!--div class="erp-area-right">
		
        </div-->
    </div>
</div>