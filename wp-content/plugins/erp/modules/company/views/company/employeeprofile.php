<?php
global $wpdb;
$compid = $_SESSION['compid'];

$selEmployee = ( isset($_REQUEST['selEmployee']) ) ? $_REQUEST['selEmployee'] : '';
//echo $selEmployee;
$profilemanage = ( isset($_REQUEST['profilemanage']) ) ? $_REQUEST['profilemanage'] : 0;

//$selEmployee = $_REQUEST['selEmployee'];
//echo $selEmployee;
//$profilemanage = $_REQUEST['profilemanage'];

$imdir = 'upload/' . $compid . '/photographs/';
$allemps = $wpdb->get_results("SELECT EMP_Id, EMP_Code, EMP_Name FROM employees Where COM_Id='$compid' AND EMP_Status=1");
?>

<div class="postbox">
    <h2 class="inside" style="margin: 31px 10px 10px 30px"><?php _e('Employee Profile View', 'erp'); ?> </h2>
    <form class="form-horizontal" method="post" id="filter" name="filter" action="" data-collabel="3" data-alignlabel="left" parsley-validate enctype="multipart/form-data">
        <div class="col-sm-4">
            <div class="form-group" >
                <div class="inside" style="margin: 11px 10px 10px 30px">
                    <div style="text-align:center">
                        <h3 style="text-align:center">Employee's Profile Details </h3>
                        <select  class="" data-size="5" data-live-search="true" name="selEmployee">
                            <option value=""> search </option>
                            <?php
                            foreach ($allemps as $value) {
                                ?>
                                <option value="<?php echo $value->EMP_Id ?>" <?php echo ($selEmployee == $value->EMP_Id) ? 'selected="selected"' : ''; ?> ><?php echo $value->EMP_Code . " (" . $value->EMP_Name . ")" ?></option>
                            <?php } ?>
                        </select>
                        <select name="profilemanage" id="profilemanage">
                            <option value="-1">All</option>
                            <option value="1" <?php if ($profilemanage == 1) echo 'selected="selected"'; ?> >Profile Details</option>
                            <option value="2" <?php if ($profilemanage == 2) echo 'selected="selected"'; ?>>Family Members</option>
                            <option value="3" <?php if ($profilemanage == 3) echo 'selected="selected"'; ?> >Driving License</option>
                            <option value="4" <?php if ($profilemanage == 4) echo 'selected="selected"'; ?>>Bank Account Details</option>
                            <option value="5" <?php if ($profilemanage == 5) echo 'selected="selected"'; ?>>Passport Details</option>
                            <option value="6" <?php if ($profilemanage == 6) echo 'selected="selected"'; ?> >Visa Details</option>
                            <option value="7" <?php if ($profilemanage == 7) echo 'selected="selected"'; ?>>Frequent Flying Details</option>
                            <option value="8" <?php if ($profilemanage == 8) echo 'selected="selected"'; ?>>Medical Information</option>
                        </select>
                        <button type="submit" name="searchbutton" id="searchbutton"  class="button button-primary">Submit</button>
                    </div>
                </div>
            </div>
    </form>
    <?php
    /* -------------------------
      PERSONAL INFORMATION
      /------------------------- */
    if (($selEmployee && ($profilemanage == 1)) || ($selEmployee && ($profilemanage == -1))) {
        if ($resultd_details = $wpdb->get_results("SELECT * FRom personal_information pi, state st, city ci Where EMP_Id='$selEmployee' AND PI_Status=1 AND pi.STA_Id=st.STA_Id AND pi.city_id=ci.city_id")) {
            //print_r($resultd_details);die;
            ?>

    <h4 style="text-align:center;"><strong>PERSONAL INFORMATION</strong></h4>
            <br/>
            <div id="viewDetails">
                <div class="" style="text-align:center"> Gender : <?php echo $resultd_details[0]->PI_Gender ?></div>
                <br />
                <div style="text-align:center"> Date of Birth : <?php echo $resultd_details[0]->PI_DateofBirth ?></div>
                <br />
                <div style="text-align:center"> My Personal Email-Id : <?php echo $resultd_details[0]->PI_Email ?></div>
                <br />
                <div style="text-align:center"> Meal Prefered : <?php echo $resultd_details[0]->PI_MealPreference ?></div>
                <br />
                <div style="text-align:center"> Present Address : <?php echo $resultd_details[0]->PI_CurrentAddress ?></div>
                <br />
                <div style="text-align:center"> State : <?php echo $resultd_details[0]->STA_Name ?></div>
                <br />
                <div style="text-align:center"> City : <?php echo $resultd_details[0]->city_name ?></div>
                <br />
                <div style="text-align:center"> Pincode : <?php echo $resultd_details[0]->PI_Pincode ?></div>
                <br/>
            </div>
            <?php
        } else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?PHP
    /* -------------------------
      FAMILY MEMBERS
      /------------------------- */

    if (($selEmployee && ($profilemanage == 2)) || ($selEmployee && ($profilemanage == -1))) {
        //echo 'sdfi';

        if ($family = $wpdb->get_results("SELECT * FRom  family_members Where EMP_Id='$selEmployee' AND FM_Status=1")) {
            ?>
            <h4 style="text-align:center">FAMILY MEMBERS</h4>
            <br>
            <div class="table-responsive">
                <table class="wp-list-table widefat striped admins">
                    <thead>
                        <tr>
                            <th style="text-align:center">Sl.No.</th>
                            <th  style="text-align:center">Name</th>
                            <th>Gender</th>
                            <th>Relation</th>
                            <th>Age</th>
                            <th>Contact No</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody style="text-align:center" >
                        <?php
                        $i = 1;
                        foreach ($family as $value) {
                            ?>
                            <tr>
                                <td><?php
                                    echo $i;
                                    $i++;
                                    ?></td>
                                <td><?php echo $value->FM_Name; ?></td>
                                <td><?php echo $value->FM_Gender; ?></td>
                                <td><?php echo $value->FM_Relation; ?></td>
                                <td><?php echo $value->FM_Age; ?></td>
                                <td><?php echo $value->FM_Contact; ?></td>
                                <td><?php echo date('d-M, Y', strtotime($value->FM_Date)); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?pHP
    /* -------------------------
      DRIVING LICENSE
      /------------------------- */

    if (($selEmployee && ($profilemanage == 3)) || ($selEmployee && ($profilemanage == -1))) {

        if ($drv_lic = $wpdb->get_results("SELECT * FRom  driving_license where EMP_Id='$selEmployee' AND DL_Status=1")) {
            ?>
            <h4 style="text-align:center">DRIVING LICENSE</h4>
            <br>
            <div id="viewDetails">
                <div class="col-sm-4 h4" style="text-align:center"> Front &amp; Back View : </div>
                <div class="col-sm-5 h4" style="text-align:center">
                    <?php
                    if ($drv_lic[0]->DL_ImageFrontView)
                        echo '<img src="' . $imdir . $drv_lic[0]->DL_ImageFrontView . '" width="100" height="100" />';
                    else
                        echo '<img src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" />';
                    ?>
                    <?php
                    if ($drv_lic[0]->DL_ImageBackView)
                        echo '<img src="' . $imdir . $drv_lic[0]->DL_ImageBackView . '" width="100" height="100" />';
                    else
                        echo '<img src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" />';
                    ?>
                </div>
                <div class="clearfix"></div>
                <br />
                <br />
                <div style="text-align:center"> Name : <?php echo $drv_lic[0]->DL_Firstname ?></div>
                <br />
                <br />
                <div style="text-align:center">  Son/Wife/Daughter of <?php echo $drv_lic[0]->DL_CareOf ?></div>
                <br />
                <div style="text-align:center"> Date of Birth : <?php echo $drv_lic[0]->DL_Dateofbirth ?></div>
                <br />
                <div style="text-align:center">Driving License Number : <?php echo $drv_lic[0]->DL_DLno ?></div>
                <br />
                <div style="text-align:center">Issued Country : <?php echo $drv_lic[0]->DL_IssuedCountry ?></div>
                <br />
                <div style="text-align:center"> Issued Place : <?php echo $drv_lic[0]->DL_IssuedPlace ?></div>
                <br />
                <div style="text-align:center"> Issued Date : <?php echo $drv_lic[0]->DL_IssuedDate ?></div>
                <br />
                <div style="text-align:center"> Expiry Date : <?php echo $drv_lic[0]->DL_ExpiryDate ?></div>
                <br/>
                <br/>
            </div>
            <?Php
        }else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?pHP
    /* -------------------------
      BANK ACCOUNT DETAILS
      /------------------------- */


    if (($selEmployee && ($profilemanage == 4)) || ($selEmployee && ($profilemanage == -1))) {

        if ($family = $wpdb->get_results("SELECT * FRom  bank_account_details Where EMP_Id='$selEmployee' AND BAD_Status=1 ORDER BY BAD_Id DESC")) {
            ?>
            <h4 style="text-align:center">BANK ACCOUNT DETAILS</h4>
            <br>
            <div class="table-responsive" style="text-align:center">
                <table class="wp-list-table widefat striped admins">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Image</th>
                            <th>Account No.</th>
                            <th>Bank Name <br />
                                Branch Name</th>
                            <th>IFSC Code</th>
                            <th>Place</th>
                            <th>Account Type</th>
                            <th>Issued Date</th>
                            <th>Nominee Name</th>
                            <th>Nominee Relation</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php
                        $i = 1;
                        foreach ($family as $value) {
                            ?>
                            <tr>
                                <td><?php
                                    echo $i;
                                    $i++;
                                    ?></td>
                                <td>File <span class="tooltip-area"><a href="#?file=<?php echo $imdir . $value->BAD_ImageFrontView; ?>" title="download"><i class="fa fa-download" ></i></a></span></td>
                                <td><?php echo $value->BAD_AccountNumber; ?></td>
                                <td><?php echo $value->BAD_BankName; ?><br />
                                    <?php echo $value->BAD_BranchName; ?></td>
                                <td><?php echo $value->BAD_BankIfscCode; ?></td>
                                <td><?php echo $value->BAD_IssuedAt . ", " . $value->BAD_State . ",<br> " . $value->BAD_Country; ?></td>
                                <td><?php echo $value->BAD_AccountType; ?></td>
                                <td><?php echo $value->BAD_DateofIssue; ?></td>
                                <td><?php echo $value->BAD_NomineeName; ?></td>
                                <td><?php echo $value->BAD_NomineeRelation; ?></td>
                                <td><?php echo date('d-M, Y', strtotime($value->BAD_Date)) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <br/>
            <br/>
            <?Php
        } else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?PHP
    /* -------------------------
      PASSPORT DETAILS
      /------------------------- */


    if (($selEmployee && ($profilemanage == 5)) || ($selEmployee && ($profilemanage == -1))) {

        if ($passport = $wpdb->get_results("SELECT * FRom passport_detials Where EMP_Id='$selEmployee' AND PAS_Status=1")) {
            ?>
            <h4 style="text-align:center">PASSPORT DETAILS </h4>
            <br />
            <div id="viewDetails">
                <div class="col-sm-4 h4" style="text-align:center"> Front &amp; Back View :</div>
                <div class="col-sm-5 h4"  style="text-align:center">
                    <?php
                    if ($passport[0]->PAS_ImageFrontView)
                        echo '<img src="' . $imdir . $passport[0]->PAS_ImageFrontView . '" width="100" height="100" />';
                    else
                        echo '<img src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" />';
                    ?>
                    <?php
                    if ($passport[0]->PAS_ImageBackView)
                        echo '<img src="' . $imdir . $passport[0]->PAS_ImageBackView . '" width="100" height="100" />';
                    else
                        echo '<img src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" />';
                    ?>
                </div>
                <div class="clearfix"></div>
                <br />
                <div style="text-align:center">First Name : <?php echo $passport[0]->PAS_Firstname ?></div>
                <br />
                <div style="text-align:center">Last Name : <?php echo $passport[0]->PAS_Lastname ?></div>
                <br />
                <div style="text-align:center">Date of Birth :<?php echo date('d/M/Y', strtotime($passport[0]->PAS_Dateofbirth)); ?></div>
                <br />
                <div style="text-align:center">Passport Number: <?php echo $passport[0]->PAS_Passportno ?></div>
                <br />
                <div style="text-align:center">Issued Country : <?php echo $passport[0]->PAS_IssuedCountry ?></div>
                <br />
                <div style="text-align:center">Issued Place : <?php echo $passport[0]->PAS_IssuedPlace ?></div><br />
                <div style="text-align:center">Issued Date : <?php echo $passport[0]->PAS_IssuedDate ?></div>
                <br />
                <div style="text-align:center">Expiry Date : <?php echo $passport[0]->PAS_ExpiryDate ?></div>
                <br />
            </div>
            <?Php
        }else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?PHP
    /* -------------------------
      VISA DETAILS
      /------------------------- */


    if (($selEmployee && ($profilemanage == 6)) || ($selEmployee && ($profilemanage == -1))) {

        if ($family = $wpdb->get_results("SELECT * FRom  visa_details where EMP_Id='$selEmployee' AND VD_Status=1 ORDER BY VD_Id DESC")) {
            ?>
            <br />
            <h4 style="text-align:center">VISA DETAILS</h4>
            <br />
            <div class="table-responsive" style="text-align:center">
                <table class="wp-list-table widefat striped admins">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Visa Doc.</th>
                            <th>Visa No.</th>
                            <th>Country</th>
                            <th>Issued At</th>
                            <th>Type of Visa</th>
                            <th>No. of Entries</th>
                            <th>Date of Issue</th>
                            <th>Date of Expiry</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php
                        $i = 1;
                        foreach ($family as $value) {
                            ?>
                            <tr>
                                <td><?php
                                    echo $i;
                                    $i++;
                                    ?></td>
                                <td>File <span class="tooltip-area"><a href="#?file=<?php echo $imdir . $value->VD_Document; ?>" title="download"><i class="fa fa-download" ></i></a></span></td>
                                <td><?php echo $value->VD_VisaNumber; ?></td>
                                <td><?php echo $value->VD_Country; ?></td>
                                <td><?php echo $value->VD_IssueAt; ?></td>
                                <td><?php echo $value->VD_Typeofvisa; ?></td>
                                <td><?php echo $value->VD_NoofEntries; ?></td>
                                <td><?php echo $value->VD_DateofIssue; ?></td>
                                <td><?php echo $value->VD_DateofExpiry; ?></td>
                                <td><?php echo date('d-M, Y', strtotime($value->VD_Date)); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?Php
        } else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?pHP
    /* -------------------------
      FREQUENT FLYING  DETAILS
      /------------------------- */


    if (($selEmployee && ($profilemanage == 7)) || ($selEmployee && ($profilemanage == -1))) {

        if ($family = $wpdb->get_results("SELECT * FRom  frequent_flyers Where EMP_Id='$selEmployee' AND FF_Status=1 ORDER BY FF_Id DESC")) {
            ?>
            <h4 style="text-align:center">FREQUENT FLYER DETAILS</h4>
            <br />
            <div class="table-responsive">
                <table class="wp-list-table widefat striped admins">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Airline</th>
                            <th>Program </th>
                            <th>Frequent Flyer No.</th>
                            <th>Card Type</th>
                            <th>Issued Date</th>
                            <th>Expiry Date</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php
                        $i = 1;
                        foreach ($family as $value) {
                            ?>
                            <tr>
                                <td><?php
                                    echo $i;
                                    $i++;
                                    ?></td>
                                <td><?php echo $value->FF_Airline; ?></td>
                                <td><?php echo $value->FF_Program; ?></td>
                                <td><?php echo $value->FF_FrequentFlyerNumber; ?></td>
                                <td><?php echo $value->FF_CardType; ?></td>
                                <td><?php echo $value->FF_DateofIssue; ?></td>
                                <td><?php echo $value->FF_DateofExpiry; ?></td>
                                <td><?php echo date('d-M, Y', strtotime($value->FF_Date)) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?Php
        } else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
    <?php
    /* -------------------------
      MEDICAL INFORMATION
      /------------------------- */

    if (($selEmployee && ($profilemanage == 8)) || ($selEmployee && ($profilemanage == -1))) {

        if ($med_info = $wpdb->get_results("SELECT * FRom  medical_information where EMP_Id='$selEmployee' AND MI_Status=1")) {
            ?>
            <!--<header class="panel-heading sm" data-color="theme-inverse">-->
            <h4 style="text-align:center">MEDICAL INFORMATION</h4>
            <br />

            <div id="viewDetails" style="text-align:center">
                <?php if ($med_info[0]->MI_Document) { ?>
                    <div class="col-sm-4 h4"> Download Medical Document :</div>
                    <div class="col-sm-5 h4"><span class="tooltip-area"> <a href="#?file=<?php echo $imdir . $med_info[0]->MI_Document; ?>" class="btn btn-default btn-sm" title="download file"> <i class="glyphicon glyphicon-download-alt"></i> </a> </span> </div>
                    <br />
                <?php } ?>
                <br />
                <div style="text-align:center">Height : <?php echo $med_info[0]->MI_Height ?></div>
                <br />
                <div style="text-align:center">Weight : <?php echo $med_info[0]->MI_Weight ?></div>
                <br />
                <div style="text-align:center">Blood Group : <?php echo $med_info[0]->MI_BloodGroup ?></div>
                <br />
                <div style="text-align:center">Illness [If Any] : &nbsp;&nbsp;<?php echo $med_info[0]->MI_Illness ? $med_info[0]->MI_Illness : 'NIL'; ?></div>
                <br />
                <div style="text-align:center">Gadgets [If Any]: &nbsp;&nbsp;<?php echo $med_info[0]->MI_Gadgets ? $med_info[0]->MI_Gadgets : 'NIL'; ?></div>
                <br />
                <div style="text-align:center">Genetical Disease [If Any] : &nbsp;&nbsp;<?php echo $med_info[0]->MI_GeneticAbnormalities ? $med_info[0]->MI_GeneticAbnormalities : 'NIL'; ?></div>
                <br />
                <div style="text-align:center"> Allergy to Drugs [If Any]: &nbsp;&nbsp; <?php echo $med_info[0]->MI_DrugAllergies ? $med_info[0]->MI_DrugAllergies : 'NIL'; ?></div>
                <BR/>
                <div style="text-align:center">Emergency Contact No. :  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $med_info[0]->MI_EmergencyContactName ?></div>
                <br />
                <div style="text-align:center">Emergency Contact Person :  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $med_info[0]->MI_EmergencyContactNo ?></div>
                <br />
                <br />
            </div>
            <?Php
        } else {

            echo ' <div style="text-align:center;margin: 11px 10px 10px 30px;font-size:30px;"><div class="alert alert-warning">No Records Found</div></div>';
        }
    }
    ?>
</section>
</div>
</div>

