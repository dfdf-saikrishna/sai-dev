<?php

//$compid		=	$_SESSION['compid'];
//$workflow=compPolicy($compid);

function get_expense() {
    global $wpdb;
    $compid = $_SESSION['compid'];
    $expense = $wpdb->get_results("SELECT * FROM travel_expense_policy_doc WHERE COM_Id='$compid' AND TEPD_Status=1");
    return $expense;
}

function policy_process_import_export() {
    global $wpdb;
	if(isset( $_SESSION['compid']))
	{
		$compid = $_SESSION['compid'];
		$selpol = $wpdb->get_results("SELECT * FROM travel_expense_policy_doc WHERE COM_Id='$compid' AND TEPD_Status=1");
	}
	if(isset( $_SESSION['adminid']))
    $adminid = $_SESSION['adminid'];

    if (isset($_POST['crp_import_pdf'])) {
        //if ($_FILES['csv_file']['error'] == "0") {
            if ($selpol = $wpdb->get_results("SELECT * FROM travel_expense_policy_doc WHERE COM_Id='$compid' AND TEPD_Status=1")) {
                
                $wpdb->update('travel_expense_policy_doc', array('TEPD_Id' => '$selpol->TEPD_Id'), array('UpdatedBy' => $adminid, 'TEPD_Status' => 2, 'UpdatedDate' => 'NOW()'));
                //update_query("travel_expense_policy_doc", "TEPD_Status=2, UpdatedDate=NOW(), UpdatedBy='$adminid'", "TEPD_Id=$selpol[TEPD_Id]");
            }
            $data = ['file' => $_FILES['csv_file']];
            $fileArray = $_FILES['csv_file'];
            $imagename = $fileArray['name'];
            $imtype = $fileArray['type'];
            $imsize = $fileArray['size'];
            $tmpname = $fileArray['tmp_name'];

            if ($imagename) {

                $allowedExts = array("pdf");
                $allowedMimeTypes = array(
                    'application/pdf', 'application/x-pdf', 'application/acrobat', 'applications/vnd.pdf', 'text/pdf', 'text/x-pdf'
                );

                $extension = end((explode('.', $imagename)));
                $extension = strtolower($extension);
                $matchExtns = in_array($extension, $allowedExts);

                if ($matchExtns) {
                    if (in_array($imtype, $allowedMimeTypes)) {
                        $photoAllowed = 1;
                    } else {
                        $photoAllowed = 0;
                    }
                } else {
                    $photoAllowed = 0;
                }
            } else {
                $photoAllowed = 0;
            }
            if (!$photoAllowed) {
                    header("location:/wp-admin/admin.php?page=expensemenu&status=failure");
                //echo "File uploading error. Please choose a appropriate file (.pdf)";
                exit;
            }

            //$imdir="../upload/";
            //$imdir = "upload/$compid/";
            $imdir = WPERP_COMPANY_PATH . "/upload/$compid/";


            if ($imagename != "") {
                $ext = substr(strrchr($imagename, "."), 1);

                $imagePath = md5(rand() * time()) . ".$ext";

                move_uploaded_file($tmpname, $imdir . $imagePath);

                //$impath = "upload/$compid/";
                 $impath = WPERP_COMPANY_PATH . "/upload/$compid/";

                $imagePath = str_replace($impath, "", $imagePath);
            } else {
                $imagePath = $_POST['oldfile'];
            }
            $wpdb->insert('travel_expense_policy_doc', array('AddedBy' => $adminid, 'COM_Id' => $compid, 'TEPD_Filename' => $imagePath));
            $lastid = $wpdb->insert_id;

            if ($lastid) {
                header("location:/wp-admin/admin.php?page=expensemenu&status=success");
                //echo "Uploaded successfully.";
                exit;
            } else {
                 header("location:/wp-admin/admin.php?page=expensemenu&status=failure");
                //echo "Uploading failed. Please try again.";
                exit;
            }
        //}
    } 
}
