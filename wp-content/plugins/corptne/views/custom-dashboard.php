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
        <?php
        require '/../modules/admin/includes/class_table_view.php';

            global $wpdb;

            $table = new Custom_Table_Example_List_Table();
            $table->prepare_items();

            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_example'), count($_REQUEST['id'])) . '</p></div>';
            }
            ?>
        <div class="wrap">

            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2><?php _e('Persons', 'custom_table_example')?> <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=persons_form');?>"><?php _e('Add new', 'custom_table_example')?></a>
            </h2>
            <?php echo $message; ?>

            <form id="persons-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                <?php $table->display() ?>
            </form>

        </div>	
    </div>
</div>