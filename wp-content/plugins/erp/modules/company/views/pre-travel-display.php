<?php
global $wpdb;
$compid = $_SESSION['compid'];
$reqid = $_GET['reqid'];
$row = $wpdb->get_row("SELECT * FROM requests WHERE COM_Id='$compid' AND REQ_Id='$reqid' AND RT_Id IN (1,2) AND REQ_Active != 9");

$et = 1;

$showProCode = 1;

$curDate = date('Y-m-d');

$empdetails = $wpdb->get_results("SELECT * FROM employees emp, company com, department dep, designation des,requests req, request_employee re, employee_grades eg WHERE req.REQ_Id='$reqid'  AND req.REQ_Id=re.REQ_Id AND emp.EMP_Id=re.EMP_Id  AND emp.COM_Id=com.COM_Id AND emp.DEP_Id=dep.DEP_Id AND emp.DES_Id=des.DES_Id AND emp.EG_Id=eg.EG_Id AND req.REQ_Active=1 AND re.RE_Status=1");
$code = $empdetails[0]->EMP_Reprtnmngrcode;
$repmngname = $wpdb->get_results("SELECT EMP_Name FROM employees WHERE EMP_Code='$code' AND COM_Id='$compid'");

$workflow = $wpdb->get_results("SELECT COM_Pretrv_POL_Id, COM_Posttrv_POL_Id, COM_Othertrv_POL_Id, COM_Mileage_POL_Id, COM_Utility_POL_Id FROM company WHERE COM_Id='$compid'");
//$selsql =$wpdb->get_results("SELECT * FROMrequest_details rd, expense_category ec, mode mot", "*", "rd.REQ_Id=$row[REQ_Id] AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Dateoftravel ASC", $filename, 0);
//print_r($row);
$selsql = $wpdb->get_results("SELECT * FROM request_details rd, expense_category ec, mode mot WHERE rd.REQ_Id='$row->REQ_Id' AND rd.EC_Id=ec.EC_Id AND rd.MOD_Id=mot.MOD_Id AND rd.RD_Status=1 ORDER BY rd.RD_Dateoftravel ASC");
?>
<style type="text/css">
    #my_centered_buttons { text-align: center; width:100%;}
</style>
<div class="postbox">
    <div class="inside">
        <h2><?php _e('Pre Travel Requests Details', 'employee'); ?></h2>
        <code>Request Details Display</code>
        <div class="wrap pre-travel-request" id="wp-erp">
            <?php
            require WPERP_COMPANY_PATH . '/includes/employee-details.php';

            require WPERP_COMPANY_PATH . '/includes/employee-request-details.php';
            ?>
            <div style="margin-top:60px;">
                <form id="request_form" name="input" action="#" method="post">
                    <table class="wp-list-table widefat striped admins" border="0" id="table1">
                        <thead class="cf">
                            <tr>
                                <th class="column-primary">Date</th>
                                <th class="column-primary">Expense Description</th>
                                <th class="column-primary" colspan="2">Expense Category</th>
                                <th class="column-primary" >Place</th>
                                <th class="column-primary">Estimated Cost</th>
<!--                                <th class="column-primary">Select</th>-->
                                    <?php
                                    if ($row[0]->REQ_Status == 2) {
                                        ?>
                                    <th class="column-primary">Booking Status</th>
                                    <th class="column-primary">Cancellation Status</th>
                                </tr>
                            <?php } ?>
                        </thead>
                        <tbody>
                                <?php
                                $rdidarry = array();
                                foreach ($selsql as $rowsql) {
                                    //echo $rowsql->RD_Duplicate;
                                    //print_r($rowsql);die;
                                    ?>
                                <tr>
                                    <td data-title="Date" style="width: 9%;"><?php echo date('d-M-Y', strtotime($rowsql->RD_Dateoftravel)); ?></td>
                                    <td data-title="Description"><?php echo stripslashes($rowsql->RD_Description); ?></td>
                                    <td data-title="Category"><?php echo $rowsql->EC_Name; ?></td>
                                    <td data-title="Category"><?php echo $rowsql->MOD_Name; ?></td>
                                    <td data-title="Place"><?php
                            if ($rowsql->EC_Id == 1) {

                                echo '<b>From:</b> ' . $rowsql->RD_Cityfrom . '<br />';
                                echo '<b>To:</b> ' . $rowsql->RD_Cityto;
                            } else {

                                echo '<b>Loc:</b> ' . $rowsql->RD_Cityfrom;


                                if ($rowsd = $wpdb->get_row("SELECT SD_Name FROM stay_duration WHERE SD_Id='$rowsql->SD_Id'"))
                                    echo '<br>Stay :' . $rowsd->SD_Name;
                            }
                            ?></td>
                                    <td data-title="Estimated Cost"><?php echo $rowsql->RD_Cost ? IND_money_format($rowsql->RD_Cost) . ".00" : approvals(5); ?>
                                    </td>
                                <?php
                                if ($row[0]->REQ_Status == 2) {
                                    ?>
                                        <td><?php
                                        if ($row[0]->REQ_Status == 2) {

                                            $imdir = "upload/$compid/bills_tickets/";

                                            if (in_array($rowsql->MOD_Id, array(1, 2, 5))) {

                                                // check for self booking

                                                if ($selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=2 AND BS_Active=1")) {

                                                    echo bookingStatus(8);
                                                    echo '<br><b>Date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BS_Date));
                                                } else {

                                                    $selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rowsql->RD_Id' AND BS_Status=1 AND BS_Active=1");
                                                    if (!empty($selrdbs[0]->RD_Id)) {
                                                        if ($selrdbs[0]->RD_Id) {

                                                            echo '<b>Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BS_Date)) . "<br>";

                                                            echo '----------------------------------<br>';

                                                            echo bookingStatus($selrdbs[0]->BA_Id);
                                                            $bsId = $selrdbs[0]->BS_Id;

                                                            $seldocs = $wpdb->get_results("SELECT * FROM booking_documents WHERE BS_Id='$bsId'");

                                                            $doc = NULL;

                                                            $f = 1;

                                                            foreach ($seldocs as $docs) {

                                                                $doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="#?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

                                                                $f++;
                                                            }



                                                            switch ($selrdbs[0]->BA_Id) {
                                                                case 2:
                                                                    echo '<br><b>Booked Amnt:</b> ' . IND_money_format($selrdbs[0]->BS_TicketAmnt) . '.00</span><br>';
                                                                    echo $doc;
                                                                    echo '<b>Booked Date:</b> ' . date('d-M-y (h:i a)', strtotime($selrdbs[0]->BA_ActionDate));
                                                                    break;

                                                                case 3:
                                                                    echo '<br><b>Failed Date</b>: ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate));
                                                                    break;
                                                            }
                                                        }
                                                    } else {

                                                        echo bookingStatus(NULL);
                                                    }
                                                }
                                            } else {

                                                echo bookingStatus(NULL);
                                            }
                                        }
                                        ?></td>   <td><?PHP
                                            $rdId = $rowsql->RD_Id;
                                            //echo $rdId;die;
                                            if ($row[0]->REQ_Status == 2) {

                                                $imdir = "company/upload/$compid/bills_tickets/";


                                                if (in_array($rowsql->MOD_Id, array(1, 2, 5))) {

                                                    if ($selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rdId' AND BS_Status=2 AND BS_Active=1")) {

                                                        echo bookingStatus(NULL);
                                                    } else {

                                                        $selrdbs = $wpdb->get_results("SELECT * FROM booking_status WHERE RD_Id='$rdId' AND BS_Status=3 AND BS_Active=1");
                                                        //print_r($selrdbs);die;
                                                        //$rdbId=$selrdbs[0]->RD_Id;
                                                        if (!empty($selrdbs->RD_Id)) {
                                                            if ($selrdbs->RD_Id) {


                                                                echo '<b title="Cancellation Request Date">Request date: </b>' . date('d-M-y (h:i a)', strtotime($selrdbs->BS_Date)) . "<br>";

                                                                echo '----------------------------------<br>';

                                                                //echo ($selrdbs->BA_Id==1) ? bookingStatus($selrdbs->BA_Id)."<br>" : '';

                                                                if ($selrdbs->BA_Id == 1) {

                                                                    echo bookingStatus($selrdbs->BA_Id) . "<br>";
                                                                } else {


                                                                    echo bookingStatus($selrdbs->BA_Id);

                                                                    $seldocs = $wpdb->get_results("SELECT * FROM booking_documents", "*", "BS_Id='$selrdbs[BS_Id]'");

                                                                    $doc = NULL;

                                                                    $f = 1;

                                                                    foreach ($seldocs as $docs) {

                                                                        $doc.='<b>Uploaded File no. ' . $f . ': </b> <a href="download-file.php?file=' . $imdir . $docs->BD_Filename . '" class="btn btn-link">download</a><br>';

                                                                        $f++;
                                                                    }

                                                                    switch ($selrdbs->BA_Id) {

                                                                        case 4:
                                                                            echo '<br><b>Cancellation Amnt:</b> ' . IND_money_format($selrdbs->BS_CancellationAmnt) . '.00<br>';
                                                                            echo $doc;
                                                                            echo '<b>Cancellation Date:</b> ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate)) . "<br>";
                                                                            break;

                                                                        case 5:
                                                                            echo '<br><b>Cancellation Date:</b> ' . date('d-M-y (h:i a)', strtotime($selrdbs->BA_ActionDate)) . "<br>";
                                                                            break;
                                                                    }
                                                                }
                                                            }
                                                        } else {

                                                            echo bookingStatus(NULL);
                                                        }
                                                    }
                                                } else {

                                                    echo bookingStatus(NULL);
                                                }

                                                //}
                                                ?></td>
                                        <?php } ?></tr>
                                    </tr>
                                    <?php
                                    $totalcost = "";
                                    if (!$rowsql->RD_Duplicate) {
                                        $totalcost+=$rowsql->RD_Cost;
                                        array_push($rdidarry, $rowsql->RD_Id);
                                    }
//                                        else{
//                                            $totalcost+="";
//                                              array_push($rdidarry, $rowsql->RD_Id);
//                                        }   
                                }
                                ?>
                            <?php } ?>
                        </tbody>
                    </table>

                    <table class="wp-list-table widefat striped admins" style="font-weight:bold;">
                        <?php
                        $totalcost = "";
                        $totalcost+=$rowsql->RD_Cost;
                        ?>

                        <tr>
                            <td align="right" width="85%">Total Estimated Cost</td>
                            <td align="center" width="5%">:</td> 

                            <td align="right" width="10%"><?php echo IND_money_format($totalcost) . ".00"; ?></td>
                        </tr>
                    </table>

                    <br />
                    <br />

                    <table class="wp-list-table widefat striped admins">  
                        <?php
                        $view_claim = "<tr>
                    <td width=\"90%\" align=\"right\">&nbsp;</td>
                    <td align=\"right\" width=\"10%\"><a class=\"btn btn-palevioletred\" href=\"admin-employee-pre-travel-request-view-claim.php?reqid=$reqid\">View Claim</a></td>
                  </tr>";

                        $claim_not_submitted = "<tr>
                    <td align=\"right\" width=\"70%\">&nbsp;</td>
                    <td align=\"right\" width=\"30%\"><a  class=\"btn btn-warning\" href=\"javascript:void(0);\">Claim Not Submitted </a></td>
                  </tr>";

                        //if($curDate >= $rowsql->RD_Dateoftravel){
                        //echo 'ptac='.$selclaim->PTC_Status;

                        if ($selclaim = $wpdb->get_results("SELECT * FROM pre_travel_claim WHERE REQ_Id='$reqid'")) {

                            //if($selclaim->PTC_Status==2 || $selclaim->PTC_Status==3)
                            echo $view_claim;
                        } else {

                            if ($row[0]->REQ_Status == 2)
                                echo $claim_not_submitted;
                        }


                        //}
                        ?>

                    </table>

                    <br />
                    <br />
                    <div class="clearfix"></div>
                    <p>&nbsp;</p>
                    <div id="quoteDivId">
                        <?php
                        //print_r($rdidarry);

                        $a = 1;
                        foreach ($rdidarry as $rdid) {

                            //echo 'Rdid='.$rdid;


                            $selrgquote = $wpdb->get_results("SELECT * FROM request_getquote rg, get_quote_flight gqf WHERE RD_Id='$rdid' AND rg.GQF_Id=gqf.GQF_Id AND RG_Active=1 ORDER BY GQF_Price ASC");

                            if (count($selrgquote)) {


                                if ($rowRdDetails = $wpdb->get_results("SELECT * FROM request_details rd, mode mo WHERE RD_Dateoftravel, MOD_Name, RD_Cityfrom, RD_Cityto, rd.MOD_Id, SD_Id", "RD_Id='$rdid' AND rd.MOD_Id=mo.MOD_Id")) {
                                    ?>
                                    <div id="field<?php echo $i; ?>" class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="wp-list-table widefat striped admins">
                                                <thead>
                                                    <tr>
                                                        <th><?PHP echo $rowRdDetails->MOD_Name; ?></th>
                                                        <?php if ($rowRdDetails->MOD_Name == "Flight" || $rowRdDetails->MOD_Name == "Bus") { ?>
                                                            <th><?php echo date('D, d F, Y', strtotime($rowRdDetails->RD_Dateoftravel)); ?></th>
                                                            <th><?php echo $rowRdDetails->RD_Cityfrom ?> to <?php echo $rowRdDetails->RD_Cityto ?></th>
                                                            <?php
                                                        }

                                                        if ($rowRdDetails->MOD_Name == "Hotel") {

                                                            $staydays = "+" . $rowRdDetails->SD_Id . " day";

                                                            $date = strtotime($staydays, strtotime($rowRdDetails->RD_Dateoftravel));

                                                            $checkoutdate = date("Y-m-d", $date);
                                                            ?>
                                                            <th>
                                                                <?php echo " Check-In: " . date('D, d F Y', strtotime($rowRdDetails->RD_Dateoftravel)) . ", <br> Check-Out: " . date('D, d F Y', strtotime($checkoutdate)); ?>
                                                            </th>
                                                            <th><?php echo $rowRdDetails->RD_Cityfrom ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <?php if ($rowRdDetails->MOD_Name == "Flight" || $rowRdDetails->MOD_Name == "Bus") { ?>
                                            <div class="table-responsive">
                                                <table class="wp-list-table widefat striped admins" style="font-size:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>DEPARTURE</th>
                                                            <th>ARRIVAL</th>
                                                            <th><?php if ($rowRdDetails->MOD_Id == '1')
                                echo 'DURATION';
                            else
                                echo 'Seats';
                            ?></th>
                                                            <th style="text-align:right">PRICE (Rs)&nbsp;&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody align="center">
                                                        <?php
                                                        foreach ($selrgquote as $rowrgquote) {


                                                            if ($rowrgquote->MOD_Id == '2') {

                                                                $flightname = 'Bus';
                                                            } else {

                                                                $flightname = $rowrgquote["GQF_AirlineName"];

                                                                $flightname = preg_replace('~[\r\n]+~', '', $flightname);
                                                            }


                                                            $style = NULL;

                                                            if ($rowrgquote->RG_Pref == 2)
                                                                $style = 'style="background-color:#E0F0FF;"';
                                                            ?>
                                                            <tr >
                                                                <td <?php echo $style; ?>><span class="logo pull-left text-left <?php echo getFlightLogo($flightname); ?>"></span><br />
                                                                    <?php echo $rowrgquote["GQF_AirlineName"]; ?><br />
                                                                    <?php echo ($rowRdDetails->MOD_Name == 'Flight') ? $rowrgquote["GQF_AirlineCode"] : NULL; ?> - <?php echo $rowrgquote["GQF_FlightNumber"]; ?></td>
                                                                <td  <?php echo $style; ?>><?php echo date('h:i a', strtotime($rowrgquote["GQF_DepTIme"])); ?><br />
                                                                    <?php echo $rowrgquote["GQF_Origin"]; ?> </td>
                                                                <td <?php echo $style; ?>><?php echo date('h:i a', strtotime($rowrgquote["GQF_ArrTime"])); ?> <br />
                                                                    <?php echo $rowrgquote["GQF_Destination"]; ?></td>
                                                                <td <?php echo $style; ?>><?php echo $rowrgquote["GQF_Duration"]; ?> [
                                                                    <?php
                                                                    if ($rowRdDetails->MOD_Name == 'Flight') {

                                                                        if ($rowrgquote["GQF_Stops"] == 0)
                                                                            echo "Non Stop";
                                                                        else
                                                                            echo $rowrgquote["GQF_Stops"] . " Stop";
                                                                    } else if ($rowRdDetails->MOD_Name == 'Bus') {

                                                                        echo $rowrgquote["GQF_Stops"] . " Seats";
                                                                    }
                                                                    ?>
                                                                    ]</td>
                                                                <td <?php echo $style; ?> class="text-right"><?php echo IND_money_format($rowrgquote["GQF_Price"]); ?>&nbsp;&nbsp;</td>
                                                            </tr>

                    <?php
                }
                ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                        }
                                        if ($rowRdDetails->MOD_Name == "Hotel") {
                                            ?>

                                            <table class="wp-list-table widefat striped admins" style="font-size:10px;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>HOTEL NAME</th>
                                                        <th>ROOM CATEGORY</th>
                                                        <th>ROOM TYPE</th>
                                                        <th style="text-align:right">PRICE (Rs)&nbsp;&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody align="center">
                                                    <?php
                                                    foreach ($selrgquote as $rowrgquote) {

                                                        $style = NULL;

                                                        if ($rowrgquote->RG_Pref == 2)
                                                            $style = 'style="background-color:#E0F0FF; text-align:center;"';
                                                        ?>
                                                        <tr >
                                                            <td data-title="ROOM IMAGE" style="width:10%" <?php echo $style; ?>><?PHP if ($rowrgquote->GQF_DepTIme) { ?>
                                                                    <img class="img-responsive img-rounded" width="50" height="50" align="absmiddle" src="<?php echo $rowrgquote->GQF_DepTIme; ?>" />
                    <?php } else echo '<span>N/A</span>'; ?></td>
                                                            <td data-title="HOTEL"  <?php echo $style; ?>><?php echo strip_tags($rowrgquote["GQF_AirlineName"]); ?></td>
                                                            <td data-title="ROOM CATEGORY" <?php echo $style; ?>><?php echo $rowrgquote["GQF_FlightNumber"]; ?></td>
                                                            <td data-title="ROOM TYPE" <?php echo $style; ?>><?php echo $rowrgquote["GQF_ArrTime"]; ?></td>
                                                            <td data-title="PRICE" <?php echo $style; ?> align="right" ><?php echo IND_money_format($rowrgquote["GQF_Price"]); ?></td>
                                                        </tr>
                                                        <!-- end ngRepeat: flt in (filterdlist=(flights|masterfilter:journeyFilterRequest:filterData.dep))|orderBy:sortFn:order|limitTo:displayed -->
                    <?php
                }
                ?>
                                                </tbody>
                                            </table>

                                    <?php } ?>
                                    </div>
                                    <?php
                                }
                            }


                            $a++;
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <p>&nbsp;</p>    
            </div>
            </section>
        </div>
    </div>
</div>
</form>

                                <?php _e(chat_box(2)); ?>  

