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

    <div class="erp-single-container">

        <!--div class="erp-area-left"-->
                <div class="postbox">
                <div class="inside">
				    <div class="badge-container">
                        <div class="badge-wrap badge-aqua">

                            <table class="wp-list-table widefat striped admins">
                                <tr>
                                <td colspan="2"><h1 style="text-align:center;">&nbsp <b>My</b> Expense Requests</h1></td>
                                </tr>
                                <tr>
                                <td width="90%">Pending Requests</td>
                                <td width="10%"><span class="oval-1">20</span></td>
                                </tr>
                                <tr>
                                <td width="90%">Approved Requests</td>
                                <td width="10%"><span class="oval-3">1</span></td>
                                </tr>
                                <tr>
                                <td width="90%">Rejected Requests</td>
                                <td width="10%"><span class="oval-4">0</span></td>
                                </tr>
                                <tr>
                                <td width="90%">Total Requests</td>
                                <td width="10%"><span class="oval-2">21</span></td>
                                </tr>
                            </table>
                            </div><!-- .badge-wrap -->

                            <div class="badge-wrap badge-aqua">
                                <table class="wp-list-table widefat striped admins">
                                    <tr>
                                    <td colspan="2"><h1 style="text-align:center;">&nbsp <b>Requests</b>  For My Approval</h1></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Pending Requests</td>
                                    <td width="10%"><span class="oval-1">20</span></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Approved Requests</td>
                                    <td width="10%"><span class="oval-3">1</span></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Rejected Requests</td>
                                    <td width="10%"><span class="oval-4">0</span></td>
                                    </tr>
                                    <tr>
                                    <td width="90%">Total Requests</td>
                                    <td width="10%"><span class="oval-2">21</span></td>
                                    </tr>
                                </table>
                            </div><!-- .badge-wrap -->
                        
					       </div>
                        </div>
                    </div>
            <div class="postbox">
                <div class="inside">
                    <h2>My Pre Travel Expense Requests</h2>
                    <?php
                    $table = new WeDevs\ERP\Employee\My_Pre_Travel_Expenses();
                    $table->prepare_items();

                    $message = '';
                    if ('delete' === $table->current_action()) {
                        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
                    }
                    ?>
                <div class="list-table-wrap erp-hr-employees-wrap">
                    <div class="list-table-inner erp-hr-employees-wrap-inner">
                        <?php echo $message;?>
                        <?php //$table->views(); ?>
                        <form method="post">
                          <input type="hidden" name="page" value="Requests" />
                          <?php $table->search_box('Search Request Code', 'search_id'); ?>
                        </form>

                        <form method="GET">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                            <?php $table->display() ?>
                        </form>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>