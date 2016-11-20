<?php
function crp_process_import_export() {
    //$this->send_success( __( 'successfully!', 'erp' ) );die;
    if ( isset( $_POST['crp_import_excel'] ) ) {
        //$compid	= $_SESSION['compid'];
        $compid = '38';
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
        
        //$fileDirectory = ();
        $objPHPExcel = PHPExcel_IOFactory::load($fileDirectory);
        $worksheet = $objPHPExcel->getActiveSheet();
        
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();
            $highestColumn = $worksheet->getHighestDataColumn();
            $headings = $worksheet->rangeToArray('A1:' . $highestColumn . 1,NULL,TRUE,FALSE);
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                $rowData[0] = array_combine($headings[0], $rowData[0]);
                print_r($rowData[0]);
                echo $rowData[0]['Employee Code'];
            }
        }
        
        //header("Location:admin.php?page=Export-Employees");
        //print_r($data);die;
    }
}
?>