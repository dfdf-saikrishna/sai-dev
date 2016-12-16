<?php
global $wpdb;
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$et = 3;
$showProCode = 1;

//$row = $wpdb->get_results("SELECT * FROM requests", "*", "COM_Id='$compid' AND REQ_Id='$reqid' AND RT_Id=6 AND REQ_Active=1");
$row = $wpdb->get_results("SELECT * FROM requests req, request_employee re WHERE COM_Id='$compid' AND req.REQ_Id='$reqid' AND RT_Id=3 AND req.REQ_Id=re.REQ_Id AND REQ_Active=1 AND RE_Status=1");
$selsql = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id='$row->REQ_Id' AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1");
?>
<style type="text/css">
    #my_centered_buttons { text-align: center; width:100%;}
</style>
<div class="postbox">
    <div class="inside">
        <div class="wrap pre-travel-request" id="wp-erp">
            <h2><?php _e('Other  Travel Requests Details', 'employee'); ?></h2>
            <code class="description">Request Details Display</code>
            </header>
            <form action="" method="post" name="form1" id="form1">
                <?php
                require WPERP_COMPANY_PATH . '/includes/employee-details.php';

                if ($row[0]->REQ_Type == 1) {

                    require WPERP_COMPANY_PATH . '/includes/employee-request-details.php';
                } else {

                    echo '<div class="text-left">Request Code: <b>' . $row[0]->REQ_Code . '</b></div>';
                }
                ?>
                <div style="margin-top:60px;">
                        <div class="table-responsive">
                            <table class="wp-list-table widefat striped admins" id="table1">
                                <thead>
                                    <tr>
                                        <th width="15%">Date</th>
                                        <th width="20%">Expense Description</th>
                                        <th width="20%">Expense Category</th>
                                        <th width="15%">Upload<br />
                                            bills / tickets</th>
                                        <th width="15%">Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                    $selsql = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id='$row->REQ_Id' AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1");

                                    foreach ($selsql as $rowsql) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); ?></td>
                                            <td><div style="height:20px; overflow:auto;" align="justify"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                                            <td align="center"><?php echo $rowsql->MOD_Name; ?></td>
                                            <td><?php
                                    $selfiles = select_all("requests_files", "*", "RD_Id=$rowsql->RD_Id]", $filename, 0);

                                    $j = 1;

                                    foreach ($selfiles as $rowfiles) {
                                        $temp = explode(".", $rowfiles->RF_Name);
                                        $ext = end($temp);

                                        $fileurl = "upload/" . $compid . "/bills_tickets/" . $rowfiles->RF_Name;
                                            ?>
                                                    <?php echo $j . ") "; ?><a href="d#.php?file=<?php echo $fileurl; ?>"><?php echo 'file' . $j . "." . $ext; ?></a><br />
                                                    <?php $j++;
                                                } ?>
                                            </td>
                                            <td align="right"><?php echo IND_money_format($rowsql->RD_Cost) . ".00"; ?></td>
                                        </tr>
                                            <?php
                                            $totalcost+=$rowsql->RD_Cost;
                                        }
                                        ?>
                                                                        </tbody>
                            </table>
                        </div>
                        <input type="hidden" value="<?php echo $filename; ?>" name="filename" id="filename"  />
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table table-hover" style="font-weight:bold;">
                                <tr>
                                    <td align="right" width="85%">Total Cost</td>
                                    <td align="center" width="5%">:</td>
                                    <td align="right" width="10%"><?php echo IND_money_format($totalcost) . ".00"; ?></td>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <br />
                    <br />
                    <?php
                    if ($row->REQ_Type == 1)
                         _e(chat_box(2)); 
                    ?>
                    <div class="col-sm-12 align-sm-center">
                    <?php
                    if ($row->REQ_Claim) {
                        ?>
                            <a class="btn btn-green" onclick="javascript:void(0);" style="width:200px;">Request Claimed <br />
                                on <?php echo date('d/M/y', strtotime($row->REQ_ClaimDate)); ?></a>
                            <? } ?>
                        </div>
                        <div class="col-sm-12">
                        <?php require("admin-employee-payment-details.php"); ?>
                    </div>
                </div>
                </section>
        </div>
    </div>
</div>
                    <?php } ?>
