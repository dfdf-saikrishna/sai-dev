<?php
global $wpdb;
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$et = 2;
$showProCode = 1;

$row = $wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Id='$reqid' AND RT_Id=2 AND REQ_Active=1 AND REQ_Type IN (1,2,5)");
?>
<style type="text/css">
    #my_centered_buttons { text-align: center; width:100%;}
</style>
<div class="postbox">
    <div class="inside">
        <h2><?php _e('Post Travel Requests Details', 'employee'); ?></h2>
        <code>Request Details Display</code>
        <div class="wrap pre-travel-request" id="wp-erp">
                <form action="" method="post" name="form1" id="form1">
                    <?php
                    require WPERP_COMPANY_PATH . '/includes/employee-details.php';

                    if ($row[0]->REQ_Type == 1 || $row[0]->REQ_Type == 2) {

                        require WPERP_COMPANY_PATH . '/includes/employee-request-details.php';
                    } else {

                        echo '<div class="text-left">Request Code: <b>' . $row[0]->REQ_Code . '</b></div>';
                    }
                    ?>
                    <p>&nbsp;</p>
                  <div style="margin-top:30px;">
                        <table class="wp-list-table widefat striped admins" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <th width="20%">Date</th>
                                    <th width="15%">Expense Description</th>
                                    <th width="10%" colspan="2">Expense Category</th>
                                    <th width="25%">Place</th>
                                    <th width="10%">Upload<br />
                                        bills / tickets</th>
                                    <th width="10%" style="text-align:right;">Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $reqId=$row[0]->REQ_Id;
                                $selsql = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id='$reqId' AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1");

                                foreach ($selsql as $rowsql) {
                                    ?>
                                    <tr>
                                        <td data-title="Date" style="width: 9%;"><?php echo date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); ?></td>
                                        <td data-title="Description"><div style="height:20px; overflow:auto;" align="justify"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                                        <td data-title="Category" ><?php echo $rowsql->EC_Name; ?></td>
                                        <td data-title="Category"><?php echo $rowsql->MOD_Name; ?></td>
                                        <td style="font-size:11px;"><?php
                                if ($rowsql->EC_Id == 1) {

                                    echo '<b>From:</b> ' . $rowsql->RD_Cityfrom . '<br />';
                                    echo '<b>To:</b> ' . $rowsql->RD_Cityto;
                                } else {

                                    echo '<b>Loc:</b> ' . $rowsql->RD_Cityfrom;

                                    if ($rowsd = $wpdb->get_results("SELECT * FROM stay_duration", "SD_Name", "SD_Id='$rowsql[SD_Id]'"))
                                        echo '<br>Stay :' . $rowsd->SD_Name;
                                }
                                    ?></td>
                                        <td><?php
                                        $selfiles = $wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowsql->RD_Id'");

                                        $j = 1;

                                        foreach ($selfiles as $rowfiles) {

                                            $temp = explode(".", $rowfiles->RF_Name);
                                            $ext = end($temp);

                                            $fileurl = "upload/" . $compid . "/bills_tickets/" . $rowfiles->RF_Name;
                                        ?>
                                                <?php echo $j . ") "; ?><a href="download-file.php??file=<?php echo $fileurl; ?>"><?php echo 'file' . $j . "." . $ext; ?></a><br />
                                                <?php
                                                $j++;
                                            }
                                            ?>
                                        </td>
                                        <td align="right"><?php echo IND_money_format($rowsql->RD_Cost) . ".00"; ?></td>
                                    </tr>
                                    <?php
                                    $totalcost="";
                                    $totalcost+=$rowsql->RD_Cost;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
                if ($row[0]->REQ_Type == 1 || $row[0]->REQ_Type == 2)
                    //_e(chat_box(2));   
                ?>
                <div class="col-sm-12 align-sm-center">
                    <?php
                    if ($row[0]->REQ_Claim) {
                        ?>
                        <a class="btn btn-green" onclick="javascript:void(0);" style="width:200px;">Request Claimed <br />
                            on <?php echo date('d/M/y', strtotime($row->REQ_ClaimDate)); ?></a>
                    <?php } ?>
                </div>
                <div class="col-sm-12">

                </div>
            </div>
            </section>
        </div>
    </div>
</div>
<!-- //content-->
</div>

