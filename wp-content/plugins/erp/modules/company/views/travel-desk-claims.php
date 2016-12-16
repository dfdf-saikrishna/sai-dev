<?php
global $wpdb;
$tdcid = $_GET['tdcid'];
//echo $tdcid;die;
$compid = $_SESSION['compid'];
$rows = $wpdb->get_results("SELECT * FROM travel_desk_claims WHERE TDC_Id='$tdcid' AND COM_Id='$compid'");
//print_r($rows);die;
?>
<div class="postbox">
    <div class="inside">
        <h2><?php _e('Claims Details', 'employee'); ?></h2>
        <code>Claim Details Display</code>
        <div class="wrap invoice-request" id="wp-erp">
            <div class="panel-body">
                <div class="invoice">
                    <h3>Reference NO. #<?php echo $rows[0]->TDC_ReferenceNo ?></h3>
                    <span><?php echo date('d F Y', strtotime($rows[0]->TDC_Date)) ?></span> </div>
                <div class="erp-area-right erp-hide-print" style="margin:-108px 0px 0px 1063px" >
                    <div class="col-sm-12">
                        <h4>Payment Details :</h4>
                    </div>

                    <div class="col-sm-8"> <strong>Service Tax:</strong> </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" parsley-type="number" parsley-required="true" name="txtServiceTax" id="txtServiceTax" readonly="readonly" value="<?php echo $rows[0]->TDC_ServiceTax ?>">
                            <span class="input-group-addon">&nbsp;%&nbsp;</span> </div>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="col-sm-8"> <strong>Service Charges:</strong> </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" parsley-type="digits" parsley-required="true" name="txtServiceChrgs" id="txtServiceChrgs" readonly="readonly" value="<?php echo $rows[0]->TDC_ServiceCharges / $rows[0]->TDC_Quantity ?>">
                            <span class="input-group-addon">.00</span> </div>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="col-sm-8"> <strong>Account No:</strong> </div>
                    <div class="input-group">
                        <?php
                        $tdbaId = $rows[0]->TDBA_Id;
                        $bank_details = $wpdb->get_results("SELECT TDBA_AccountNumber FROM travel_desk_bank_account WHERE TDBA_Id='$tdbaId'");
                        ?>
                        <input type="text" class="form-control"  name="txtAccNo" id="txtAccNo" readonly="readonly" parsley-required="true" value="<?php echo $bank_details[0]->TDBA_AccountNumber; ?>">
                    </div>
                </div>
            </div>
            <br>
            <br>
            <!--  /////////////////////////////////////////-->
            <div class="panel-group">
                <div class="table-responsive">
                    <table class="wp-list-table widefat striped admins">
                        <thead>
                            <tr height="35">
                                <th width="10%" style="text-align:left;">Sl.no. </th>
                                <th width="28%" style="text-align:left; padding-left:5px;">Request Code</th>
                                <th width="25%" style="text-align:left;">Quantity</th>
                                <th width="35%" >Date</th>
                                <th width="20%" style="text-align:left;">Amount (Rs)</th>
                                <th width="5%" style="text-align:left; padding-left:5px;">&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <?php
                $selsql = $wpdb->get_results("SELECT * FROM travel_desk_claim_requests tdcr, requests req WHERE TDC_Id='" . $tdcid . "' and tdcr.REQ_Id = req.REQ_Id");

                $totqty = 0;
                $totalamnt = 0;

                $i = 1;
                $j = 1;

                foreach ($selsql as $rowsql) {
                    ?>
                    <div class="panel panel-shadow">
                        <header class="panel-heading" style="padding:0 10px">
                            <div class="table-responsive">
                                <table class="wp-list-table widefat striped admins" onmouseover="this.style.fontWeight = 'bold'" onmouseout="this.style.fontWeight = 'normal'">

                                    <tr>
                                        <td  width="10%"><?php echo $i; ?>. </td>
                                        <?php
                                        $getvals = $wpdb->get_results("SELECT DISTINCT (rd.RD_Id)  FROM request_details rd, booking_status bs WHERE rd.REQ_Id='$rowsql->REQ_Id' AND rd.RD_Id=bs.RD_Id AND bs.BS_Status IN (1,3)  AND BS_Active=1 AND RD_Status=1");

                                        foreach ($getvals as $values) {

                                            $rdids = "";
                                            $rdids.=$values->RD_Id . ",";

                                            $countAll = count($wpdb->get_results("SELECT BS_Id FROM booking_status WHERE RD_Id='$values->RD_Id' AND BS_Active=1"));


                                            if ($countAll == 2) {

                                                if ($rowcn = $wpdb->get_results("SELECT BA_Id, BS_CancellationAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=3 AND BS_Active=1")) {

                                                    if ($rowcn->BA_Id == 4 || $rowcn->BA_Id == 6) {

                                                        $totalcosts += $rowcn->BS_CancellationAmnt;
                                                    }
                                                } else {

                                                    $rowbk = $wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=1 AND BS_Active=1");

                                                    $totalcosts += $rowbk[0]->BS_TicketAmnt;
                                                }
                                            } else {
                                                $totalcosts = "";
                                                $rowbk = $wpdb->get_results("SELECT BS_TicketAmnt FROM booking_status WHERE RD_Id='$values->RD_Id' and BS_Status=1 AND BS_Active=1");

                                                $totalcosts += $rowbk[0]->BS_TicketAmnt;
                                            }
                                        }

                                        //echo 'totalcost='.$totalcosts."<br>";

                                        $rdids = rtrim($rdids, ",");

                                        if (!$rdids)
                                            $rdids = "'" . "'";

                                        //echo 'Reqids='.$rdids;

                                        $totqty += count($getvals);


                                        $totalamnt += $totalcosts;
                                        ?>  
                                        <td  width="25%"><?php echo $rowsql->REQ_Code; ?></td>
                                        <td width="10%" style="text-align:center;"><?php echo count($getvals); ?></td>
                                        <td width="35%" style="text-align:center; padding-left:30px;"><?php echo date('d-M-Y', strtotime($rowsql->REQ_Date)) ?></td>
                                        <td width="20%" style="text-align:center;"><?php
                                            echo IND_money_format($totalcosts) . ".00";
                                            $totalcosts = NULL;
                                            ?></td>
                                        <td><a data-toggle="collapse" href="#collapse"><i  class="collapse-caret fa fa-angle-down"></i> </a> </td>
                                    </tr>
                                </table> </div>
                        </header>
                        <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="hide-table<?php echo $rowsql->TDC_Id; ?> init-invoice wp-list-table widefat fixed striped collapse" style="font-size:11px;">
                                        <thead>
                                            <tr>
                                                <th width="10%">Date</th>
                                                <th width="20%">Expense<br />
                                                    Description</th>
                                                <th width="10%" colspan="2">Expense <br />
                                                    Category</th>
                                                <th width="10%">Place</th>
                                                <th width="10%">Estimated <br />
                                                    Cost</th>
                                                <th width="20%">Booking Status</th>
                                                <th  width="20%">Cancellation <br />
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $rddetails = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mo WHERE REQ_Id='$rowsql->REQ_Id' AND rd.RD_Id IN($rdids) AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mo.MOD_Id AND RD_Status=1 ORDER BY RD_Id ASC");

                                            $rdids = "";

                                            foreach ($rddetails as $rowsql) {
                                                //print_r($rowsql);die;
                                                ?>
                                                <tr>
                                                    <td align="center"><?php echo date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); ?></td>
                                                    <td><div style="height:40px; overflow-y:auto;"><?php echo stripslashes($rowsql->RD_Description); ?></div></td>
                                                    <td width="5%"><?php echo $rowsql->EC_Name; ?></td>
                                                    <td width="5%"><?php echo $rowsql->MOD_Name; ?></td>
                                                    <td><?php
                                                        if ($rowsql->EC_Id == 1) {

                                                            echo '<b>From:</b> ' . $rowsql->RD_Cityfrom . '<br />
							<b>To:</b> ' . $rowsql->RD_Cityto;
                                                        } else {

                                                            echo '<b>Loc:</b> ' . $rowsql->RD_Cityfrom;

                                                            if ($rowsd = $wpdb->get_results("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql->SD_Id'")) {

                                                                echo '<br>Stay :' . $rowsd->SD_Name;
                                                            }
                                                        }
                                                        ?></td>
                                                    <td align="right"><?php echo IND_money_format($rowsql->RD_Cost) . ".00"; ?></td>
                                                    <!----- BOOKING STATUS STATUS ------>
                                                    <td><?php
                                                        $selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=1 AND BS_Active=1");

                                                        if ($selrdbs[0]->RD_Id) {

                                                            echo ($selrdbs[0]->BA_Id == 1) ? bookingStatus($selrdbs[0]->BA_Id) . "<br>" : '';

                                                            echo '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BS_Date)) . "<br>";

                                                            echo '----------------------------------<br>';

                                                            $query = "BA_Id IN (2,3)";
                                                        }

                                                        echo bookingStatus($selrdbs[0]->BA_Id);

                                                        //echo 'baid='.$selrdbs->BA_Id;
                                                        //$imdir = "company/upload/$compid/bills_tickets/";
                                                        $imdir = "../company/upload/$compid/bills_tickets/";

                                                        $doc = NULL;

                                                        if ($selrdbs[0]->BA_Id == 2) {
                                                            $bsId = $selrdbs[0]->BS_Id;
                                                            $seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$bsId'");

                                                            $f = 1;

                                                            foreach ($seldocs as $docs) {

                                                                $doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

                                                                $f++;
                                                            }
                                                        }



                                                        switch ($selrdbs[0]->BA_Id) {

                                                            case 2:
                                                                echo '<br>';
                                                                echo '<b>Booked Amnt:</b> ' . IND_money_format($selrdbs[0]->BS_TicketAmnt) . '.00</span><br>';
                                                                echo $doc;
                                                                echo '<b>Booked Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
                                                                break;

                                                            case 3:
                                                                echo '<br>';
                                                                echo '<strong>Failed Date</strong>: ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate));
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <!----- CANCELLATION STATUS ------>
                                                    <td><?php
                                                $selrdcs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=3 AND BS_Active=1");
                                                //print_r($selrdcs);die;
                                                if (!empty($selrdcs[0]->RD_Id)) {
                                                    if ($selrdcs[0]->RD_Id) {

                                                        echo ($selrdcs[0]->BA_Id == 1) ? bookingStatus($selrdcs[0]->BA_Id) . "<br>" : '';

                                                        echo '<b title="cancellation request date">Request Date: </b>' . date('d-M-y (h:i a)', strtotime($selrdcs->BS_Date)) . "<br>";

                                                        echo '----------------------------------<br>';

                                                        $query = "BA_Id IN (4,5)";
                                                    }
                                                }
                                                if (!empty($selrdcs[0]->BA_Id)) {
                                                    echo bookingStatus($selrdcs[0]->BA_Id);
                                                }
                                                $doc = NULL;
                                                if (!empty($selrdcs[0]->BA_Id)) {
                                                    if ($selrdcs[0]->BA_Id == 4) {

                                                        $seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$selrdcs->BS_Id'");

                                                        $f = 1;

                                                        foreach ($seldocs as $docs) {

                                                            $doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

                                                            $f++;
                                                        }
                                                    }
                                                }

                                                if (!empty($selrdcs[0]->BA_Id)) {
                                                    switch ($selrdcs[0]->BA_Id) {

                                                        case 4:
                                                            echo '<br><b>Cancellation Amnt</b>: ' . IND_money_format($selrdcs->BS_CancellationAmnt) . '.00<br>';
                                                            echo $doc;
                                                            echo '<b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
                                                            break;

                                                        case 5:
                                                            echo '<br><b>Cancellation Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdcs->BA_ActionDate));
                                                            break;
                                                    }
                                                }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- //panel-body -->
                        </div>
                        <!-- //panel-collapse -->
                    </div>
                    <?php
                    $i++;
                }

//mysqli_free_result($ressql); 
                ?>
                <!-- //panel -->
            </div>
            <!-- ////////////////////////////////////////-->
            <br>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <!--<div class="align-lg-left"> 795 Park Ave, Suite 120 <br>
                      San Francisco, CA 94107 <br>
                      P: (234) 145-1810 <br>
                      Full Name <br>
                      first.last@email.com </div>-->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Invoice No.</label>
                            <div>
                                <input type="text" name="txtInvoiceNo" id="txtInvoiceNo" class="form-control" disabled="disabled" value="<?php echo $rows[0]->TDC_InvoiceNo ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Invoice Doc.</label>
                            <div> <a href="download-file.php?file=../company/upload/<?php echo $compid; ?>/bills_tickets/<?php echo $rows[0]->TDC_Filename ?>">download</a> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Remarks</label>
                        <div>
                            <textarea data-height="auto" name="txtaRemarks" id="txtaRemarks" class="form-control" disabled="disabled"><?php echo stripslashes($rows[0]->TDC_Remarks) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <p>&nbsp;</p>
            </div>
            <div class="col-sm-6">
                <div class="erp-area-right erp-hide-print" style="margin:-108px 0px 0px 1063px" >
                    <ul>
                        <li> Total Quantity: <strong><?php echo $totqty; ?></strong> </li>
                        <?php
                        $servTax = $rows[0]->TDC_ServiceCharges * ($rows[0]->TDC_ServiceTax / 100);
                        ?>
                        <li id="servicetaxlistid">Service Tax: <strong id="servicetaxid"><?php echo $servTax ?></strong></li>
                        <li id="serviceamntlistid">Service Charges: <strong id="servicechargesid"><?php echo $rows[0]->TDC_ServiceCharges; ?></strong></li>
                        <li> Total amount: <strong><?php echo IND_money_format($totalamnt + $servTax + $rows[0]->TDC_ServiceCharges) . '.00'; ?> </strong> </li>
                        <!--  <li> Discount: ----- </li>
                          <li> Grand Total: <strong>$3,485</strong> </li>-->
                    </ul>
                    <br>
                    <!--<a href="javascript:window.print();" class="btn btn-theme hidden-print"><i class="fa fa-print"></i> </a>-->
                    <!--<a href="#" class="btn btn-theme-inverse hidden-print"> SAVE </a>-->
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
        $selq = $wpdb->get_results("SELECT * FROM travel_desk_claims_notes WHERE TDC_Id=$tdcid");

        if (count($selq) > 0) {
            ?>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <h4>Notes</h4>
                    <hr>
                    <dd id="sumitnotes">
                        <?php
                        foreach ($selq as $results):

                            switch ($results->TDCN_Type):

                                case 1:
                                    echo '<dl><b>Finance: </b>' . stripslashes($results->TDCN_Text) . '<br><span style="font-size:9px;">' . date('d/m/y h:i a', strtotime($results->TDCN_Date)) . '</span></dl>';
                                    break;

                                case 2:
                                    echo '<dl><b>Travel Desk: </b>' . stripslashes($results->TDCN_Text) . '<br><span style="font-size:9px;">' . date('d/m/y h:i a', strtotime($results->TDCN_Date)) . '</span></dl>';
                                    break;

                            endswitch;

                        endforeach;
                        ?>
                    </dd>
                </div>
            </div>
        <?php } ?>
        <div class="clearfix"></div>
        <p>&nbsp;</p>
        <?php
        if ($rows[0]->TDC_Status == 1) {

            echo '<div class="col-sm-12 text-right"><label class=control-label>Claim Status </label>: ';

            switch ($rows[0]->TDC_Level):

                case 1:
                    echo approvals(1);
                    break;

                case 2:
                    echo approvals(2);
                    break;

                case 3:
                    echo approvals(4);
                    break;

            endswitch;

            echo '</div>';
        }
        ?>
        </form>
        <div class="clearfix"></div>
        <p>&nbsp;</p>
        <?php
        if ($rows[0]->TDC_Level == 2) {

            if ($rows[0]->TDC_Status == 1) {

                echo '<div class="col-sm-12 text-right"><span class="label label-warning">Payment not updated.</span></div>';
            } else if ($rows[0]->TDC_Status == 2) {


                $selrow = $wpdb->get_results("SELECT * FROM travel_desk_claim_payments WHERE TDC_Id='$tdcid' AND TDCP_Status=1");

                echo '<div class="col-lg-6" align="center"> <a href="javascript:void(0);" class="btn btn-success">Request Claimed on ' . date("d/m/y", strtotime($selrow[0]->TDCP_AddedDate)) . '</a> </div> ';
                ?>

                <div class="erp-area-right erp-hide-print" style="margin:-108px 0px 0px 1063px">
                    <h3>Payment Details</h3>

                    <label class="control-label">Payment mode</label>
                    <div>
                        <select class="form-control" name="selPaymentMode" id="selPaymentMode" parsley-required="true" disabled="disabled">
                            <option value="">Select</option>
                            <?php
                            // $selsql=
                            $selsql = $wpdb->get_results("SELECT * FROM payment_modes");

                            foreach ($selsql as $rowsql) {
                                ?>
                                <option value="<?php echo $rowsql->PM_Id; ?>" <?php echo ($selrow[0]->PM_Id == $rowsql->PM_Id) ? 'selected="selected"' : ''; ?> ><?php echo $rowsql->PM_Name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div id="chequeid" <?php echo ($selrow[0]->PM_Id == 1) ? 'style="display:block;"' : 'style="display:none;"'; ?>  >
                        <div class="form-group">
                            <label class="control-label">Cheque Number</label>
                            <div>
                                <input type="text" class="form-control" name="txtChequeNumber" id="txtChequeNumber"  <?php echo ($selrow[0]->TDCP_ChequeNumber) ? 'value="' . $selrow[0]->TDCP_ChequeNumber . '"' : ''; ?> disabled="disabled" />
                            </div>
                        </div>
                        <label class="control-label">Cheque Date</label>
                        <div class="input-group date form_datetime col-lg-12" data-picker-position="bottom-left"  data-date-format="dd MM yyyy - HH:ii p" >
                            <input type="text" <?php /* ?>name="txtDate->"<?php */ ?> name="txtCqDate" id="txtCqDate" class="form-control"  <?php echo ($selrow[0]->TDCP_ChequeDate) ? 'value="' . $selrow[0]->TDCP_ChequeDate . '"' : ''; ?> disabled="disabled" >
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-times"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                            </span> </div>
                    </div>

                    <label class="control-label">Issuing Bank</label>
                    <div>
                        <input type="text" class="form-control" name="txtBankBranch" id="txtBankBranch"  <?php echo ($selrow[0]->TDCP_ChequeIssuingbb) ? 'value="' . $selrow[0]->TDCP_ChequeIssuingbb . '"' : ''; ?> disabled="disabled"/>
                    </div>
                </div>
            </div>
            <div id="cashid" <?php echo ($selrow[0]->PM_Id == 2) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                <div class="form-group">
                    <label class="control-label">Payment Details</label>
                    <div>
                        <textarea class="form-control" data-height="auto" name="txtaCshComments" id="txtaCshComments" disabled="disabled"><?php echo ($selrow[0]->TDCP_CashPaymentDetails) ? stripslashes($selrow[0]->TDCP_CashPaymentDetails) : ''; ?>
                        </textarea>
                    </div>
                </div>
            </div>
            <div id="banktransferid" <?php echo ($selrow[0]->PM_Id == 3) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                <div class="form-group">
                    <label class="control-label">Transaction Id</label>
                    <div>
                        <input type="text" class="form-control" name="txtTransId" id="txtTransId"  disabled="disabled" <?php echo ($selrow[0]->TDCP_BTTransactionId) ? 'value="' . $selrow[0]->TDCP_BTTransactionId . '"' : ''; ?>/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Bank Name</label>
                    <div>
                        <input type="text" class="form-control" name="txtBankdetails" id="txtBankdetails" disabled="disabled" <?php echo ($selrow[0]->TDCP_BTBankDetails) ? 'value="' . $selrow[0]->TDCP_BTBankDetails . '"' : ''; ?>/>
                    </div>
                </div>

                <label class="control-label">Transaction Date</label>
                <div class="input-group date form_datetime col-lg-12" data-picker-position="bottom-left"  data-date-format="dd MM yyyy - HH:ii p" >
                    <input type="text" <?php /* ?>name="txtDate->"<?php */ ?> name="txtBBDate" id="txtBBDate" class="form-control" disabled="disabled" <?php echo ($selrow->TDCP_BTTransferDate) ? 'value="' . $selrow->TDCP_BTTransferDate . '"' : ''; ?>>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-times"></i></button>
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span> </div>
            </div>
            <div id="othersid" <?php echo ($selrow[0]->PM_Id == 4) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                <div class="erp-area-right erp-hide-print" style="margin:-108px 0px 0px 1063px" >
                    <label class="control-label">Payment Details</label>
                    <div>
                        <textarea class="form-control" data-height="auto" name="txtaOtherComments" disabled="disabled"><?php echo ($selrow->TDCP_OthersPaymentDetails) ? stripslashes($selrow->TDCP_OthersPaymentDetails) : ''; ?>
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        </section>
        </div>
        <?php
    }
}
?>
<script>
    $(document).ready(function () {
        alert("test3");
        var self = $(this);
        var id = self.data('id')
        //var state = $('.hide-table' + id).attr('class').split(' ')[1];
        var state = $('.hide-table' + id).hasClass("collapse");
        var caret = $(this).find(".collapse-caret");
        if (state) {
            $('.hide-table' + id).removeClass('collapse');
            $('.hide-table' + id).removeClass('init-invoice');
            $('.hide-table' + id).slideDown();
            caret.removeClass("fa-angle-down").addClass("fa-angle-up");
        } else {
            //$(".hide-table").not($(this)).hide('slow');
            //$(this).closest('tr').hide('slow');
            $('.hide-table' + id).addClass('collapse');
            $('.hide-table' + id).addClass('init-invoice');
            $('.hide-table' + id).slideUp();
            caret.removeClass("fa-angle-up").addClass("fa-angle-down");
            //$(this).find('.hide-table').hide();
        }
    });
</script>