<?php
function crp_process_import_export() {
    global $empError;
    global $wpdb;
    if(isset($_SESSION['adminid']))
    $adminid = $_SESSION['adminid'];
    if(isset($_SESSION['compid']))
    $compid = $_SESSION['compid'];
    //$this->send_success( __( 'successfully!', 'erp' ) );die;
    if ( isset( $_POST['crp_import_excel'] ) ) {
        //$compid	= $_SESSION['compid'];
        //$compid = '38';
        $objPHPExcel = new PHPExcel();
        $data = ['file' => $_FILES['csv_file'] ];
        $fileArray=$_FILES['csv_file'];
        $imagename = $fileArray['name'];
        $file = $fileArray['tmp_name'];
        //echo WPERP_COMPANY_PATH . "/upload/$compid/";die;
        $imdir = WPERP_COMPANY_PATH . "/upload/$compid/";
        
	$ext = substr(strrchr($imagename, "."), 1);
	$imagePath = md5(rand() * time()) . ".$ext";
        if (!file_exists($imdir)) {
            wp_mkdir_p($imdir);
        }
        move_uploaded_file($file, $imdir . $imagePath);

        $wpdb->insert('file_upload', array('FU_Addedby_ADM_Id' => $adminid,'COM_Id' => $compid,'FU_Filename' => $imagePath));
        $fuid = $wpdb->insert_id;
        
        if($rowsql=$wpdb->get_row("SELECT * FROM file_upload WHERE FU_Id='$fuid'")){
           $fileDirectory = WPERP_COMPANY_PATH . "/upload/$compid/".$rowsql->FU_Filename;
        }
         
        $objPHPExcel = PHPExcel_IOFactory::load($fileDirectory);
        $worksheet = $objPHPExcel->getActiveSheet();
        //$empnotadded = array();
        $count = 0;
        
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestDataColumn();
            $headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                $rowData[0] = array_combine($headings[0], $rowData[0]);
                //print_r($rowData[0]);
                //echo $rowData[0]['Employee Code'];
                $selEmpcode = $wpdb->get_row("SELECT * FROM COMPANY WHERE COM_Id='$compid'");
                $empcode=$rowData[0]['Employee Code'];
                $prefix = $username = NULL;
                $getPrefix=$wpdb->get_row("SELECT COM_Prefix FROM COMPANY WHERE COM_Id='$compid'");
                $prefix=$getPrefix->COM_Prefix;
                $username=$prefix."-".$empcode;
                
                $selempdup=$wpdb->get_row("SELECT EMP_Code FROM employees WHERE EMP_Code='$username' AND COM_Id='$compid'");
                if(!$selempdup)
                {  					
                    $name = $rowData[0]['Name'];
                    $email = $rowData[0]['Email ID'];

                    $password=wp_generate_password(12);

                    $pwd=$password;

                    //DEPARTMENT
                    $dep = $rowData[0]['Department'];

                    $dep=trim($dep);

                    if($dep)
                    {
                        
                        
                        if($seldep=$wpdb->get_row("SELECT DEP_Id FROM department WHERE DEP_Name = '$dep' AND DEP_Status=1 AND COM_Id='$compid'")){

                                $dep=$seldep->DEP_Id;

                        } else {
                            
                            

                            $dep=$wpdb->insert('department', array('DEP_Name' => $dep,'ADM_Id' => $adminid,'COM_Id' => $compid));

                            //$dep=insert_query("department","DEP_Name, ADM_Id, COM_Id","'$dep', '$adminid', '$compid'");

                        }
                    }
                    $RMC = $rowData[0]['Reporting Manager (Emp code)'];
                    $phn1 = $rowData[0]['Mobile Number'];
                    if($phn1 = " "){
                        $phn1 = "-";
                    }

                    $phn2 = $rowData[0]['Landline'];


                    //DESIGNATION
                    $des = $rowData[0]['Designation'];
                    $des=trim($des);
                    if($des)
                    {
                        if($seldes=$wpdb->get_row("SELECT DES_Id FROM designation WHERE DES_Name = '$des' AND COM_Id='$compid' AND DES_Status=1"))
                        {

                                $des=$seldes->DES_Id;

                        }else{
                                $des=$wpdb->insert('designation', array('DES_Name' => $des,'ADM_Id' => $adminid,'COM_Id' => $compid)); 
                        }
                    }
                    $RFMC = $rowData[0]['Functional Reporting manager (Emp Code)'];
                    //GRADES
                    $grade = $rowData[0]['Grade'];
                    $grade	= trim($grade);

                    if($grade)
                    {
                            if($selGrade=$wpdb->get_row("SELECT * FROM employee_grades WHERE EG_Name='$grade' AND COM_Id='$compid' AND EG_Status=1"))
                            {
                                    $grd=$selGrade->EG_Id;
                            }
                            else
                            {                                                                  
                                   $grd=$wpdb->insert('employee_grades', array('COM_Id' => $compid,'EG_Name' => $grade,'EG_AddedBy' => $adminid)); 
                                   $wpdb->insert('grade_limits', array('ADM_Id' => $adminid,'COM_Id' => $compid,'EG_Id' => $grd));
                            }

                    }
                    $added=0;
                                
                    if($empcode=="" || $name=="" || $email=="" || $username=="" || $dep=="" || $RMC=="" || $des=="" || $RFMC=="" || $grd=="")
                    {
                            //$empcode.=" - Missing Reqired Data";
                            if($empcode==""){
                               //$empError.=$empcode.", ";
                               $array = array('-'=>'empId Required');
                               //array_push($empnotadded, $array);
                               $count++; 
                            }
                            else{
                            $empError.=$empcode.", ";
                            $array = array($empcode=>'Missing Reqired Data');
                            //array_push($empnotadded, $array);
                            $count++;
                            }

                    }
                    else
                    {
                        if($selemail=$wpdb->get_row("SELECT user_email FROM wp_users users,employees emp WHERE users.user_email='$email' AND users.ID = emp.user_id AND emp.EMP_Status=1")){
                                //$empcode.=" - Employee Email Aready Exists";    
                                $empError.=$empcode.", ";
                                $array = array($empcode=>'Employee Email Aready Exists');
                                //array_push($empnotadded, $array);
                                $count++;

                        }              
                        else if($selemail=$wpdb->get_row("SELECT EMP_Code FROM employees WHERE EMP_Code='$empcode' AND EMP_Status=1")){
                                //$empcode.=" - Employee Code Aready Exists";
                                $empError.=$empcode.", "; 
                                $array = array($empcode=>'Employee Code Aready Exists');
                                //array_push($empnotadded, $array);
                                $count++;

                        }
                        else {
                            
                                $userdata = array(
                                    'user_login'   => $username,
                                    'user_email'   => $email,
                                    'first_name'   => $username,
                                    'display_name' => $username,     
                                );
                                $userdata['user_pass'] = $password;
                                $userdata['role'] = 'employee';
                                if($user_id  = wp_insert_user( $userdata )){
                                
                                    if($ins=$wpdb->insert('employees', array('ADM_Id' => $adminid,'COM_Id' => $compid,'DEP_Id' => $dep,'DES_Id' => $des,
                                        'EMP_Code' => $empcode,'EMP_Email' => $email,'EMP_Username' => $username,'user_id' => $user_id,'EMP_Password' => $password,
                                        'EMP_Name' => $name,'EMP_Reprtnmngrcode' => $RMC,'EMP_Phonenumber' => $phn1,'EMP_Phonenumber2' => $phn2
                                        ,'EMP_Funcrepmngrcode' => $RFMC,'EG_Id' => $grd,'Added_Mode' => "1")))
                                    {

                                            //send login details to the user

                                            //sendRegMail($email, $name, $username, $pwd);

                                            $added=1;
                                    }
                                }
                        }
                    }
                    if($added)
                    $wpdb->update( 'file_upload', array( 'FU_Status' => 2 ),array( 'FU_Id' => $fuid, 'FU_Status' => 1 ));
                    else
                    $wpdb->update( 'file_upload', array( 'FU_Active' => 9 ),array( 'FU_Id' => $fuid, 'FU_Status' => 1 ));

                }
                else
                {
                      $empError.=$empcode.", ";
                      $count++;

                }
            }
        }
        $empError=rtrim($empError,", ");
        header("Location:admin.php?page=Export-Employees&fuid=$fuid&count=$count&error=$empError");
        //print_r($data);die;
    }
}
?>