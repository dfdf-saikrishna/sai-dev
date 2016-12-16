<?php
global $wpdb;
$reqid = $_GET['reqid'];
$compid = $_SESSION['compid'];
$et = 2;
$showProCode = 1;
//require_once WPERP_EMPLOYEE_PATH . '/includes/employee-details.php';
//require_once WPERP_EMPLOYEE_PATH . '/includes/employee-request-details.php';
$row = $wpdb->get_results("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Id='$reqid' AND RT_Id=5 AND REQ_Active=1 AND REQ_Type=1");
?>
<style type="text/css">
    #my_centered_buttons { text-align: center; width:100%;}
</style>
<div class="postbox">
    <div class="inside">
        <h2><?php _e('Mileage Requests Details', 'employee'); ?></h2>
        <code>Request Details Display</code>
        <div class="wrap pre-travel-request" id="wp-erp">
            <form action="" method="post" name="form1" id="form1">
                <?php
                require_once WPERP_COMPANY_PATH . '/includes/employee-details.php';
                require_once WPERP_COMPANY_PATH . '/includes/employee-request-details.php';
                ?>
                <table class="table table-bordered table-hover" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="15%">Expense Description</th>
                            <th width="20%" colspan="2">Expense Category</th>
                            <th width="15%">City / Location</th>
                            <th width="10%" style="text-align:right;">Distance (in km)</th>
                            <th width="10%" style="text-align:right;">Cost / km</th>
                            <th width="10%" style="text-align:right;">Total Cost</th>
                            <th width="10%">Upload<br />
                                bills / tickets</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selsql = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id='$row->REQ_Id' AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Id ASC");

                        foreach ($selsql as $rowsql) {
                            ?>
                            <tr>
                                <td align="center"><?php echo date('d-M-Y', strtotime($rowsql['RD_Dateoftravel'])); ?></td>
                                <td><div style="height:40px; overflow:auto;"><?php echo stripslashes($rowsql['RD_Description']); ?></div></td>
                                <td><?php echo $rowsql['EC_Name']; ?></td>
                                <td><?php echo $rowsql['MOD_Name']; ?></td>
                                <td style="font-size:11px;"><?php
                                    echo '<b>From:</b> ' . $rowsql['RD_Cityfrom'] . '<br />';
                                    echo '<b>To:</b> ' . $rowsql['RD_Cityto'];
                                    ?></td>

                                <td align="right" style="padding-right:2px;"><b><?php echo $rowsql['RD_Distance']; ?> Km</b></td>
                                <td align="right" style="padding-right:2px;"><b><?php echo $rowsql['RD_Rate']; ?> / Km</b></td>
                                <td align="right"><?php echo IND_money_format($rowsql[RD_Cost]) . ".00"; ?></td>

                                <td><?php
                                    $selfiles = $wpdb->get_results("SELECT * FROM requests_files WHERE RD_Id='$rowsql[RD_Id]'");

                                    if (count($selfiles)) {

                                        $j = 1;
                                        foreach ($selfiles as $rowfiles) {
                                            $temp = explode(".", $rowfiles['RF_Name']);
                                            $ext = end($temp);

                                            $fileurl = "upload/" . $compid . "/bills_tickets/" . $rowfiles['RF_Name'];
                                            ?>
                                            <?php echo $j . ") "; ?><a href="download-file.php??file=<?php echo $fileurl; ?>"><?php echo 'file' . $j . "." . $ext; ?></a><br />
                                            <?php
                                            $j++;
                                        }
                                    } else {

                                        echo approvals(5);
                                    }
                                    ?>
                                </td>

                            </tr>
                            <?php
                            $totalcost = "";
                            $totalcost+=$rowsql[RD_Cost];
                        }
                        ?>
                    </tbody>
                </table>