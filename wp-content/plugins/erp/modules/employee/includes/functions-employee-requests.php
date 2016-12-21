<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function post_travel_request(){
    if ( isset( $_POST['submit-post-travel-request'] ) ) {
        global $wpdb;
        $compid = $_SESSION['compid'];
        $empuserid = $_SESSION['empuserid'];
        $posted = array_map( 'strip_tags_deep', $_POST );
        
        $expenseLimit                           = 	$posted['expenseLimit'];

	$etype					=	$posted['ectype'];
	
	$expreqcode				=	genExpreqcode($etype);
		
	$date					=	$posted['txtDate'];
	
	$txtStartDate                           =	$posted['txtStartDate'];
	
	$txtEndDate				=	$posted['txtEndDate'];
	
	$txtaExpdesc                            =	$posted['txtaExpdesc'];
	
	$selExpcat				=	$posted['selExpcat'];
	
	$selModeofTransp                        =	$posted['selModeofTransp'];
	
	$from					=	$posted['from'];
	
	$to					=	$posted['to'];
	
	$selStayDur				=	$posted['selStayDur'];
	
	$txtdist				=	$posted['txtdist'];
	
	$txtCost				=	$posted['txtCost'];
	
	
	//  QUOTATION 
	
	//$sessionid				=	$posted['sessionid'];
	
	//$hiddenPrefrdSelected                 =	$posted['hiddenPrefrdSelected'];
	
	//$hiddenAllPrefered                    =	$posted['hiddenAllPrefered'];
	
	//$selProjectCode			=	$posted['selProjectCode'];
        $selProjectCode                         =	"0";
	$selCostCenter                          =	"0";
	//$selCostCenter			=	$posted['selCostCenter'];
	
	$textBillNo				=	$posted['textBillNo'];
	
	
	$count=count($txtCost);

        if($etype=="" || $expreqcode==""){
		$response = array('status'=>'failure','message'=>"Some fields went missing");
                //$this->send_success($response);
                exit;
	
	} else {
	
		$checked=false;
		
		for($i=0;$i<$count;$i++){
						
			if($date[$i]=="" || $txtaExpdesc[$i]=="" || $selExpcat[$i]=="" || $selModeofTransp[$i]=="" || $txtdist[$i]=="" || $textBillNo[$i]=="" || $txtCost[$i]=="" || $txtStartDate[$i]=="" || $txtEndDate[$i]==""){
                                
				$checked=true;
				break;
			
			}
                        
		
		}
                if($checked){
                        $response = array('status'=>'notice','message'=>"Some fields went missing");
                        //$this->send_success($response);
			exit;
		}
                
        }
        // check for grade limit
	
//	if($etype==1)
//	{		
//	
//            for($i=0;$i<$count;$i++)
//            {		
//
//                $returnValue=getGradeLimit($selModeofTransp[$i], $empuserid, $filename);
//
//                $returnVal=explode("###",$returnValue);
//
//
//                if($returnVal[0] != 0){
//
//                    if($selModeofTransp[$i]==5 || $selModeofTransp[$i]==6)
//                    $estCost	=	$txtCost[$i] / $selStayDur[$i];					
//
//
//                    if($estCost > $returnVal[0]){					
//
//                            //header("location:$filename?msg=4&mode=$returnVal[1]&amnt=$returnVal[0]");exit;
//
//
//                    }
//                }
//
//            }
//	}
        $workflow = workflow();
        switch($etype)
		{
                case 1:
                //pre travel
                $polid=$workflow->COM_Pretrv_POL_Id;
                break;

                case 2:
                //post travel
                $polid=$workflow->COM_Posttrv_POL_Id;
                break;

                case 3:
                //other travel
                $polid=$workflow->COM_Othertrv_POL_Id;
                break;

                case 5:
                //mileage
                $polid=$workflow->COM_Mileage_POL_Id;
                break;

                case 6:
                //utility
                $polid=$workflow->COM_Utility_POL_Id;
                break;


        }
        $setreqstatus=0;

        // Retrieving my details
        $mydetails=myDetails();

        switch ($polid)
        {
                //-------- employee -->  rep mngr  -->  finance
                case 1:
                   
                if($expenseLimit > 0){
                   //-------- employee -->  2nd level manager  -->  finance
//                   if($mydetails->EMP_Code==$mydetails->EMP_Funcreprtnmngrcode)
//                    {
//                            
//                            // insert into request
//                            $wpdb->insert('requests', array('POL_Id' => 8,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
//                            $reqid=$wpdb->insert_id;
//                            // insert into request_status
//                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));
//
//                    }
//                    else
//                    {       
                            $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                            $reqid=$wpdb->insert_id;
//                    }
                }
                else{
                    if($mydetails->EMP_Code==$mydetails->EMP_Funcrepmngrcode)
                    {
                            // insert into request
                            $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                            $reqid=$wpdb->insert_id;
                            // insert into request_status
                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));

                    }
                    else
                    {
                            $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                            $reqid=$wpdb->insert_id; 
                    }	
                }
                break;
                



                //  employee --> rep mngr 
                case 3:

                if($expenseLimit > 0){
                        if($mydetails->EMP_Code==$mydetails->EMP_Funcrepmngrcode)
                        {

                                // insert into request
                                $wpdb->insert('requests', array('REQ_Status' => 2,'POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                                $reqid=$wpdb->insert_id; 

                                // insert into request_status
                                $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));
                                $setreqstatus=1;


                        }
                        else
                        {
                            $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                            $reqid=$wpdb->insert_id;
                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 3,'RS_EmpType' => 3));
                        }
                }
                else{

                        if($mydetails->EMP_Code==$mydetails->EMP_Reprtnmngrcode)
                        {

                                // insert into request
                                
                                $wpdb->insert('requests', array('REQ_Status' => 2,'POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                                $reqid=$wpdb->insert_id; 

                                // insert into request_status
                                $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));


                                $setreqstatus=1;


                        }
                        else
                        {
                            $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                            $reqid=$wpdb->insert_id;
                                
                        }	

                }
                break;

                //--------- employee --> finance --> rep mngr
                case 2:
                if($expenseLimit > 0){
                        
                        $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                        $reqid=$wpdb->insert_id;
                }   
                else{
                        $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                        $reqid=$wpdb->insert_id;
                }
                break;


                //--------- employee  --> finance
                case 4:
                if($expenseLimit > 0){
                   //-------- employee -->  2nd level manager  -->  finance
                   if($mydetails->EMP_Code==$mydetails->EMP_Funcrepmngrcode)
                    {

                            // insert into request
                            $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                            $reqid=$wpdb->insert_id;                           

                            // insert into request_status
                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));
                            
                    }
                    else
                    {
                        $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));   
                        $reqid=$wpdb->insert_id;
                    }
                }
                else{
                        $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter));
                        $reqid=$wpdb->insert_id;
                }				
                break;

        }
        if($reqid){
			
        // insert into request_employee
        $wpdb->insert('request_employee', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid));    
        //$this->send_success("success");
        } else {

                 $response = array('status'=>'failure','message'=>"Some fields went missing");
                 //$this->send_success($response);
        }
        if($reqid){			
                $rdid=0; $explodeVal=0; $countExpldVal=0;

                //echo 'count='.$count; exit;

                for($i=0;$i<$count;$i++)
                {
                        
                        if($date[$i]=="n/a"){

                                $dateformat=NULL;

                        } else {

                                $dateformat=$date[$i];
                                $dateformat=explode("-",$dateformat);
                                $dateformat=$dateformat[2]."-".$dateformat[1]."-".$dateformat[0];
                        }


                        if($txtStartDate[$i]=="n/a"){

                                $startdate=NULL;

                        } else {

                                $startdate=$txtStartDate[$i];
                                $startdate=explode("-",$startdate);
                                $startdate=$startdate[2]."-".$startdate[1]."-".$startdate[0];				

                        }

                        if($txtEndDate[$i]=="n/a"){

                                $enddate=NULL;

                        } else {

                                $enddate=$txtEndDate[$i];
                                $enddate=explode("-",$enddate);
                                $enddate=$enddate[2]."-".$enddate[1]."-".$enddate[0];				

                        }



                        if($to[$i]=="n/a")	$to[$i]=NULL;

                        if($selStayDur[$i]=="n/a")	$selStayDur[$i]=NULL;

                        if($txtdist[$i]=="n/a")	$txtdist[$i]=NULL;


                        $to[$i] ? $to[$i]="".$to[$i]."" : $to[$i]="NULL";

                        $selStayDur[$i] ? $selStayDur[$i]="".$selStayDur[$i]."" : $selStayDur[$i]="NULL";
                        
                        //$selStayDur[$i]="NULL";

                        $txtdist[$i] ? $txtdist[$i]="'".$txtdist[$i]."'" : $txtdist[$i]="NULL";

                        $textBillNo[$i] ? $textBillNo[$i]="".$textBillNo[$i]."" : $textBillNo[$i]="NULL";


                        $desc	=	addslashes($txtaExpdesc[$i]);

                        $rate=0;

                        // select mileage rate

                        if($etype==5){
                                
                                $selmilrate=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' and MOD_Id='$selModeofTransp[$i]' and MIL_Status='1' and MIL_Active=1");	

                                $rate=$selmilrate->MIL_Amount;

                                if($rate && $txtdist[$i])					
                                $txtCost[$i]=$rate * trim($txtdist[$i], "'");


                        }
                        //$rate ? $rate="'".$rate."'" : $rate="NULL";	
                        
                        $wpdb->insert('request_details', array('REQ_Id' => $reqid,'RD_Dateoftravel' => $dateformat,'RD_StartDate' => $startdate,'RD_EndDate' => $enddate,'RD_Description' => $desc,'EC_Id' => $selExpcat[$i],'MOD_Id' => $selModeofTransp[$i],'RD_Cityfrom' => $from[$i],'RD_Cityto' => $to[$i],'SD_Id' => $selStayDur[$i],'RD_Distance' => $txtdist[$i],'RD_Rate' => $rate,'RD_BillNumber' => $textBillNo[$i],'RD_Cost' => $txtCost[$i]));
                        $rdid=$wpdb->insert_id;
                        


                        // FILES ATTACHMENT

                        $j=$i+1;

                        $files=$_FILES['file'.$j]['name'];

                        $countbills=count($files);


                        for($f=0;$f<$countbills;$f++)
                        {			
                                //Get the temp file path
                          $tmpFilePath = $_FILES['file'.$j]['tmp_name'][$f];

                          //Make sure we have a filepath
                          if ($tmpFilePath != ""){
                                //Setup our new file path


                                $ext = substr(strrchr($files[$f], "."), 1); //echo $ext;
                                // generate a random new file name to avoid name conflict
                                // then save the image under the new file name

                                $filePath = md5(rand() * time()).".".$ext;

                                $newFilePath = WPERP_COMPANY_PATH . "/upload/$compid/bills_tickets/";
                                if (!file_exists($newFilePath)) {
                                    wp_mkdir_p($newFilePath);
                                }

                                $result    = move_uploaded_file($tmpFilePath, $newFilePath . $filePath);

                                //Upload the file into the temp dir
                                if($result) {
                                  $wpdb->insert( 'requests_files', array( 'RD_Id' => $rdid, 'RF_Name' => $filePath ));	

                                }
                          }
                        }



                        // GET QUOTATION 

//                        if($etype == 1){				
//
//                                $explodeVal		=	explode(",", $hiddenAllPrefered[$i]);
//
//                                //$countExpldVal	=	count($explodeVal);
//
//
//                                if($sessionid[$i] && $hiddenPrefrdSelected[$i] && $hiddenAllPrefered[$i]){
//
//
//                                        foreach($explodeVal as $gqfid){
//
//                                                $pref=1;
//
//                                                if($gqfid==$hiddenPrefrdSelected[$i])
//                                                $pref=2;
//
//                                                insert_query("request_getquote", "RD_Id, RG_SessionId, GQF_Id, RG_Pref", "$rdid, '$sessionid[$i]', $gqfid, $pref", $filename);	
//
//                                        }
//
//
//                                }
//
//                        }



                }
                
            }
            else{
		
                     $response = array('status'=>'failure','message'=>"Request Couldn\'t be added. Please try again");
                     //$this->send_success($response);
		
		}
		
                    if($etype==5){
                        header('Location: /wp-admin/admin.php?page=Mileage');
                    }
                    else if($etype==6){
                        header('Location: /wp-admin/admin.php?page=Utilities');
                    }
                    else if($etype==3){
                        header('Location: /wp-admin/admin.php?page=others');
                    }
                    $response = array('status'=>'success','message'=>"You have successfully added a Pre Travel Expense Request  <br> Your Request Code: $expreqcode <br> Please wait for approval..  ");
                    //$this->send_success($response);
    }
     if ( isset( $_POST['update-pre-travel-request'] ) ) {
         global $wpdb;
        $compid = $_SESSION['compid'];
        $empuserid = $_SESSION['empuserid'];
        $posted = array_map( 'strip_tags_deep', $_POST );
        //$this->send_success($posted);
        
        $expenseLimit                           = 	$posted['expenseLimit'];

	$etype					=	$posted['ectype'];
	
	$expreqcode				=	genExpreqcode($etype);
		
	$date					=	$posted['txtDate'];
	
	$txtStartDate                           =	$posted['txtStartDate'];
	
	$txtEndDate				=	$posted['txtEndDate'];
	
	$txtaExpdesc                            =	$posted['txtaExpdesc'];
	
	$selExpcat				=	$posted['selExpcat'];
	
	$selModeofTransp                        =	$posted['selModeofTransp'];
	
	$from					=	$posted['from'];
	
	$to					=	$posted['to'];
        
        $hidrowno                               =	$_POST['hidrowno'];
	
	$selStayDur				=	$posted['selStayDur'];
	
	$txtdist				=	$posted['txtdist'];
	
	$txtCost				=	$posted['txtCost'];
        
	$rdids                                  =	$_POST['rdids'];
        
        $reqid                                  =	$_POST['reqid'];
	
	//  QUOTATION 
	
	//$sessionid				=	$posted['sessionid'];
	
	//$hiddenPrefrdSelected                 =	$posted['hiddenPrefrdSelected'];
	
	//$hiddenAllPrefered                    =	$posted['hiddenAllPrefered'];
	
	//$selProjectCode			=	$posted['selProjectCode'];
        $selProjectCode                         =	"0";
	$selCostCenter                          =	"0";
	//$selCostCenter			=	$posted['selCostCenter'];
	
	$textBillNo				=	$posted['textBillNo'];
	
	
	$count=count($rdids);
	
	$cnt=count($wpdb->get_results("SELECT RD_Id FROM request_details WHERE REQ_Id='$reqid' AND RD_Status=1"));
                                
        $selreq		=	$wpdb->get_row("SELECT req.REQ_Code FROM requests req, request_employee re WHERE req.REQ_Id='$reqid' and req.REQ_Id=re.REQ_Id AND RE_Status=1 AND REQ_Active=1 and re.EMP_Id='$empuserid'");
	
	$expreqcode	=	$selreq->REQ_Code;
        
        if($etype=="" || $reqid=="" || $expreqcode==""){
		$response = array('status'=>'failure','message'=>"Some fields went missing. Please enable javascript in your browser and try again");
                $this->send_success($response);
	
	}else {
	
		$checked=false;
		
		for($i=0;$i<$count;$i++):
			
			
			if($date[$i]=="" || $txtaExpdesc[$i]=="" || $selExpcat[$i]=="" || $selModeofTransp[$i]=="" || $txtdist[$i]=="" || $textBillNo[$i]=="" || $txtCost[$i]=="" || $txtStartDate[$i]=="" || $txtEndDate[$i]==""){
			
				$checked=true;
				
				break;
			
			}
		
		endfor;
		
		
		
		if($checked){
                        $response = array('status'=>'failure','message'=>"Some fields went missing. Please enable javascript in your browser and try again");
                        $this->send_success($response);
		}
		
		
	
	} 
        
        // updating project code if set 
		
//        $selprocod=$wpdb->get_row("SELECT * FROM PC_Id, CC_Id WHERE REQ_Id='$reqid'");
//
//        if($selprocod->PC_Id != $selProjectCode){
//
//                update_query("requests", "PC_Id='$selProjectCode'", "REQ_Id='$reqid'", $filename, 0);
//
//        }
//
//        if($selprocod->CC_Id != $selCostCenter){
//
//                update_query("requests", "CC_Id='$selCostCenter'", "REQ_Id='$reqid'", $filename, 0);
//
//        }
        
        for($i=0;$i<$cnt;$i++)
        {
                if($date[$i]=="n/a"){

                        $dateformat=NULL;

                } else {

                        $dateformat=$date[$i];
                        $dateformat=explode("-",$dateformat);
                        $dateformat=$dateformat[2]."-".$dateformat[1]."-".$dateformat[0];				
                        //$this->send_success($dateformat);
                }


                if($txtStartDate[$i]=="n/a"){

                        $startdate=NULL;

                } else {

                        $startdate=$txtStartDate[$i];
                        $startdate=explode("-",$startdate);
                        $startdate=$startdate[2]."-".$startdate[1]."-".$startdate[0];				

                }

                if($txtEndDate[$i]=="n/a"){

                        $enddate=NULL;

                } else {

                        $enddate=$txtEndDate[$i];
                        $enddate=explode("-",$enddate);
                        $enddate=$enddate[2]."-".$enddate[1]."-".$enddate[0];				

                }



                        if($to[$i]=="n/a")	
                        $to[$i]=NULL;

                        if($selStayDur[$i]=="n/a")	
                        $selStayDur[$i]=NULL;

                        if($txtdist[$i]=="n/a")	
                        $txtdist[$i]=NULL;


                        $to[$i] ? $to[$i]="".$to[$i]."" : $to[$i]="NULL";

                        $selStayDur[$i] ? $selStayDur[$i]="".$selStayDur[$i]."" : $selStayDur[$i]="NULL";

                        $txtdist[$i] ? $txtdist[$i]="".$txtdist[$i]."" : $txtdist[$i]="NULL";

                        $textBillNo[$i] ? $textBillNo[$i]="".$textBillNo[$i]."" : $textBillNo[$i]="NULL";
                        //$selStayDur=NULL;
                        
                        if($etype==5){
                                                        
                                        $selmilrate=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' and MOD_Id='$selModeofTransp[$i]' and MIL_Status='1' and MIL_Active=1");

                                        $rate=$selmilrate->MIL_Amount;

                                        if($rate && $txtdist[$i])					
                                        $txtCost[$i]=$rate * trim($txtdist[$i], "'");


                                }
                                 
                        if($etype != 1){
				

                        //file upload 
                        $j=$i+1;	
                        $files=$_FILES['file'.$j]['name'];
                        $countbills=count($files);

                        for($f=0; $f<$countbills; $f++)
                        {			

                                //Get the temp file path
                          $tmpFilePath = $_FILES['file'.$j]['tmp_name'][$f];

                          //echo $tmpFilePath."<br>"; 

                          //Make sure we have a filepath
                          if ($tmpFilePath != ""){
                                //Setup our new file path

                                $newFilePath = WPERP_COMPANY_PATH . "/upload/$compid/bills_tickets/";
                                if (!file_exists($newFilePath)) {
                                    wp_mkdir_p($newFilePath);
                                }


                                $ext = substr(strrchr($files[$f], "."), 1); //echo $ext;
                                // generate a random new file name to avoid name conflict
                                // then save the image under the new file name

                                $filePath = md5(rand() * time()).".".$ext;

                                $newFilePath = WPERP_COMPANY_PATH . "/upload/$compid/bills_tickets/";
                                if (!file_exists($newFilePath)) {
                                    wp_mkdir_p($newFilePath);
                                }

                                $result    = move_uploaded_file($tmpFilePath, $newFilePath . $filePath);

                                //Upload the file into the temp dir
                                if($result) {
                                  $rdid=$rdids[$i];
                                  $wpdb->insert( 'requests_files', array( 'RD_Id' => $rdid, 'RF_Name' => $filePath ));
                                  $lastinsertid = $wpdb->insert_id;
                                }
                          }
                        }				
                        }

                              
                        $rate="NULL";	


                        $rdid=$rdids[$i];	

                        $desc	=	addslashes($txtaExpdesc[$i]);
                        
                        $wpdb->update('request_details', array('REQ_Id' => $reqid,'RD_Dateoftravel' => $dateformat,'RD_StartDate' => $startdate,'RD_EndDate' => $enddate,'RD_Description' => $desc,'EC_Id' => $selExpcat[$i],'MOD_Id' => $selModeofTransp[$i],'RD_Cityfrom' => $from[$i],'RD_Cityto' => $to[$i],'SD_Id' => $selStayDur[$i],'RD_Distance' => $txtdist[$i],'RD_Rate' => $rate,'RD_BillNumber' => $textBillNo[$i],'RD_Cost' => $txtCost[$i]), array( 'RD_Id' => $rdid ));
                         
        }        
                        // insert those newly added row details if any 
        if($hidrowno != $cnt){
           
            
            for($i=$cnt;$i<$hidrowno;$i++)
            {	

                    //echo 'hidrow='.$hidrowno." cnt=".$cnt; exit;			

                    if($date[$i]=="n/a"){

                            $dateformat=NULL;

                    } else {

                            $dateformat=$date[$i];
                            $dateformat=explode("-",$dateformat);
                            $dateformat=$dateformat[2]."-".$dateformat[1]."-".$dateformat[0];				

                    }


                    if($txtStartDate[$i]=="n/a"){

                            $startdate=NULL;

                    } else {

                            $startdate=$txtStartDate[$i];
                            $startdate=explode("/",$startdate);
                            $startdate=$startdate[2]."-".$startdate[1]."-".$startdate[0];				

                    }


                    if($txtEndDate[$i]=="n/a"){

                            $enddate=NULL;

                    } else {

                            $enddate=$txtEndDate[$i];
                            $enddate=explode("/",$enddate);
                            $enddate=$enddate[2]."-".$enddate[1]."-".$enddate[0];				

                    }



                            if($to[$i]=="n/a")	$to[$i]=NULL;

                            if($selStayDur[$i]=="n/a")	$selStayDur[$i]=NULL;

                            if($txtdist[$i]=="n/a")	$txtdist[$i]=NULL;


                            $to[$i] ? $to[$i]="".$to[$i]."" : $to[$i]="NULL";

                            $selStayDur[$i] ? $selStayDur[$i]="".$selStayDur[$i]."" : $selStayDur[$i]="NULL";

                            $txtdist[$i] ? $txtdist[$i]="".$txtdist[$i]."" : $txtdist[$i]="NULL";

                            $textBillNo[$i] ? $textBillNo[$i]="".$textBillNo[$i]."" : $textBillNo[$i]="NULL";


                            $desc	=	addslashes($txtaExpdesc[$i]);


                            $rate=0;

                            // select mileage rate

                    if($etype==5){

                            $selmilrate=$wpdb->get_row("SELECT MIL_Amount FROM mileage WHERE COM_Id='$compid' and MOD_Id='$selModeofTransp[$i]' and MIL_Status='1' and MIL_Active=1");

                            $rate=$selmilrate->MIL_Amount;

                            if($rate && $txtdist[$i])					
                            $txtCost[$i]=$rate * trim($txtdist[$i], "'");


                    }
                    
                    if($etype != 1){
				

                    //file upload 
                    $j=$i+1;	
                    $files=$_FILES['file'.$j]['name'];
                    $countbills=count($files);

                    for($f=0; $f<$countbills; $f++)
                    {			

                            //Get the temp file path
                      $tmpFilePath = $_FILES['file'.$j]['tmp_name'][$f];

                      //echo $tmpFilePath."<br>"; 

                      //Make sure we have a filepath
                      if ($tmpFilePath != ""){
                            //Setup our new file path
                            
                            $newFilePath = WPERP_COMPANY_PATH . "/upload/$compid/bills_tickets/";
                            if (!file_exists($newFilePath)) {
                                wp_mkdir_p($newFilePath);
                            }
   
                            $ext = substr(strrchr($files[$f], "."), 1); //echo $ext;
                            // generate a random new file name to avoid name conflict
                            // then save the image under the new file name

                            $filePath = md5(rand() * time()).".".$ext;

                            $newFilePath = WPERP_COMPANY_PATH . "/upload/$compid/bills_tickets/";
                            if (!file_exists($newFilePath)) {
                                wp_mkdir_p($newFilePath);
                            }

                            $result    = move_uploaded_file($tmpFilePath, $newFilePath . $filePath);

                            //Upload the file into the temp dir
                            if($result) {

                              $lastinsertid=$wpdb->insert( 'requests_files', array( 'RD_Id' => $rdid, 'RF_Name' => $filePath ));

                            }
                      }
                    }				
                    }

                    //echo $rate; exit;

                    //$rate ? $rate="'".$rate."'" : $rate="NULL";	

                    $wpdb->insert('request_details', array('REQ_Id' => $reqid,'RD_Dateoftravel' => $dateformat,'RD_StartDate' => $startdate,'RD_EndDate' => $enddate,'RD_Description' => $desc,'EC_Id' => $selExpcat[$i],'MOD_Id' => $selModeofTransp[$i],'RD_Cityfrom' => $from[$i],'RD_Cityto' => $to[$i],'SD_Id' => $selStayDur[$i],'RD_Distance' => $txtdist[$i],'RD_Rate' => $rate,'RD_BillNumber' => $textBillNo[$i],'RD_Cost' => $txtCost[$i]));
                    $rdid=$wpdb->insert_id;

            } // end of for loop
		
		
	} // end of outer most if loop

        // update new details
        
        $wpdb->update('request_status', array( 'RS_Status' => '2' ), array( 'REQ_Id' => $reqid ));
        
        $wpdb->update('requests', array( 'REQ_Status' => '1' ), array( 'REQ_Id' => $reqid ));

        //echo 'reqtype='.$reqtype; exit;

        /*if($reqtype){*/
                $workflow = workflow();
                switch ($etype)
                {
                        case 1:
                        $polid=$workflow->COM_Pretrv_POL_Id;
                        break;

                        case 2:
                        $polid=$workflow->COM_Posttrv_POL_Id;
                        break;

                        case 3:
                        $polid=$workflow->COM_Othertrv_POL_Id;
                        break;

                        case 5:
                        $polid=$workflow->COM_Mileage_POL_Id;
                        break;

                        case 6:
                        $polid=$workflow->COM_Utility_POL_Id;
                        break;

                }
                        
                // Retrieving my details
			$mydetails=myDetails();
                        
			switch ($polid)
			{
				//-------- employee -->  rep mngr  -->  finance
				case 1:
				
					if($mydetails->EMP_Code==$mydetails->EMP_Reprtnmngrcode)
					{						
						//mail to accounts
						//notify($expreqcode, $etype, 1);
						
						// insert into request_status
                                                $wpdb->insert('request_status', array( 'REQ_Id' => $reqid, 'EMP_Id' => $empuserid, 'REQ_Status' => 2 ));
		
					}
					else
					{						
						//mail to reporting manager
						//notify($expreqcode, $etype, 2);
					}	
				
				break;
				
				
				
				
				//  employee --> rep mngr 
				case 3:
									
					if($mydetails->EMP_Code==$mydetails->EMP_Reprtnmngrcode)
					{
						// mail to himself saying that he can make the journey
						//notify($expreqcode, $etype, 19);
						
						// insert into request_status
                                                $wpdb->insert('request_status', array( 'REQ_Id' => $reqid, 'EMP_Id' => $empuserid, 'REQ_Status' => 2 ));
						
                                                $wpdb->update('requests', array( 'REQ_Status' => 2),array('REQ_Id' => $reqid));
					}
					else
					{
						//mail to reporting manager
						//notify($expreqcode, $etype, 2);
					}	
				
				
				break;
				
				//--------- employee --> finance --> rep mngr
				case 2:
					
					if($mydetails->EMP_Code==$mydetails->EMP_Reprtnmngrcode)
					{
						//mail to finance
						//notify($expreqcode, $etype, 1);
					}
					else
					{
						//mail to finance
						//notify($expreqcode, $etype, 20);
					}
									
				break;
				
				
				//--------- employee  --> finance
				case 4:	
					
					//mail to finance
					//notify($expreqcode, $etype, 20);
				
				break;
				
				
			}
			
		
		/*}*/
		
		
		$response = array('status'=>'success','message'=>"You have successfully update this Request");
                //$this->send_success($response);
     }
     /**
    * BOOKING REQUEST
    *
    */

    if(isset($_POST['bookTickets']))
    {
            global $wpdb;
            global $booking_rdids;
            $reqid		=	$_POST['reqid'];

            $rdid		=	$_POST['rdid'];

            $rdids		=	join(",",$rdid);

            $actionButton	=	$_POST['bookTickets'];

            $selreqcode		=	$_POST['reqcode'];

             $a=0; 
             $c=0; // check for cancellation
             $b=0;
             $d=0; // duplicate rows
             $m=0;
             $s=0;
             $p=0;
             $h=0;
             $f=0;
             
             $add_booking_request=0;

            foreach($rdid as $values){

                    // if booking request raised by employee
                            
                    if($selrdbs=$wpdb->get_row("SELECT RD_Id, BA_Id FROM booking_status WHERE RD_Id='$values' AND BS_Status=1 AND BS_Active=1")){ 


                            switch ($selrdbs->BA_Id){

                            // case 1 pending

                            // case 2 booked

                                    case 1: case 2:
                                            $a++; 
                                            $c=1;
                                    break;


                                    case 3:
                                            $f++; // failed to book
                                            $c=0;
                                    break;

                            }


                            if($c){

                                    // check for cancellation
                                               
                                    if($selrdcn=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id = '$values' AND BS_Status = 3 AND BS_Active = 1")){

                                            if ($selrdcn->BA_Id==5){

                                                    // update the bs to history
                                                    $wpdb->update( 'booking_status', array( 'BS_Active' => '2', 'BS_HistoryDate' => "NOW()" ), array( 'BS_Id' => $selrdcn->BS_Id ));

                                                    // insert a new booking request 
                                                    $wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 1, 'BA_Id' => 1 ));

                                                    $b++;

                                                    $booking_rdids.=$values.",";

                                            } else {
                                                           
                                                    if($oldrd=$wpdb->get_row("SELECT * FROM request_details WHERE RD_Id='$values' AND RD_Status=1")){
                                                            
                                                                    
                                                            if(!$selquery=$wpdb->get_row("SELECT RD_Id FROM request_details WHERE RD_Duplicate='$oldrd->RD_Id' AND RD_Status=1")){

                                                                    $wpdb->insert( 'request_details', array( 'RD_Id' => $oldrd->REQ_Id, 'RD_Dateoftravel' => $oldrd->RD_Dateoftravel, 'RD_Description' => $oldrd->RD_Description, 'EC_Id' => $oldrd->EC_Id, 'MOD_Id' => $oldrd->MOD_Id, 'RD_Cityfrom' => $oldrd->RD_Cityfrom, 'RD_Cityto' => $oldrd->RD_Cityto, 'SD_Id' => $oldrd->SD_Id, 'RD_Cost' => $oldrd->RD_Cost, 'RD_Duplicate' => $oldrd->RD_Id ));
                                                                    $lastid = $wpdb->insert_id;

                                                                    $d++; // duplicated the row

                                                                    $wpdb->insert( 'booking_status', array( 'RD_Id' => $lastid, 'BS_Status' => 1, 'BA_Id' => 1 ));

                                                                    $booking_rdids.=$lastid.",";


                                                            }

                                                    }

                                            }



                                    } // end of if cancellation with no cancellation charges condition and no cancellation request sent


                            }  else { 

                                    $add_booking_request=1;


                            }// end of c if else condition


                    } else {

                            $add_booking_request=1;

                    } // end of first if else condition



                    if($add_booking_request){

                            // if self booking is done, history them
                            
                            if($selfb=$wpdb->get_row("SELECT RD_Id, BS_Id FROM booking_status WHERE RD_Id='$values' AND BS_Status IN (1,2) AND BS_Active=1")){
                                    $wpdb->query("UPDATE booking_status SET BS_Active=2, BS_HistoryDate=NOW() WHERE RD_Id='$values' AND BS_Status IN (1,2) AND BS_Active=1");

                            }

                            // insert a new booking request 
                            $wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 1, 'BA_Id' => 1 ));

                            $b++;

                            $booking_rdids.=$values.",";

                    }



            } // end of for loop


            if($b){

                    $rdids=rtrim($booking_rdids,",");

                    $actionButton=1;

                    //require("book-now-details.php");

                    //travelBooking($message_body, 1);

            }


            $msg=7;
            
            header("location:/wp-admin/admin.php?page=View-Request&reqid=$reqid&msg=$msg&a=$a&b=$b&d=$d&m=$m&c=$c&s=$s&p=$p&h=$h&f=$f");exit;

    }
    if(isset($_POST['buttonSelfbooking']))
    {	
	global $wpdb;
        global $cancel_ids;
	$reqid			=	$_POST['reqid'];
	
	$rdid			=	$_POST['rdid'];
	
	$rdids			=	join(",",$rdid);
	
	$actionButton           =	$_POST['buttonSelfbooking'];
	
	$selreqcode		=	$_POST['reqcode'];

			
	$s=0; $a=0; $pb=0; $f=0; $c=0; $d=0;$c=0;$b=0;$d=0;$p=0;$h=0;$f=0; $cancel_duplicate=0;

	foreach($rdid as $values){
                
		if(!$selrdbs=$wpdb->get_row("SELECT RD_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1")){
			
			$wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 2));
			
			$s++; // inserted successfully
		
		} else {
                        
			if($selrdbs=$wpdb->get_row("SELECT RD_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1 AND BS_Status=2")){
		
				$a++; 
				
				/*
				this detail was already set as self booking
				*/
		
		
			} else {
			
				
				
				// if booking request raised by employee
                                
				if($selrdbs=$wpdb->get_row("SELECT RD_Id, BA_Id, BS_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1 AND BS_Status=1")){ 
				
				
					switch ($selrdbs->BA_Id){
					
					// case 1 pending
					
					// case 2 booked
					
						case 1: case 2:
							$pb++; 
							$c=1;
						break;
						
						
						case 3:
							$f++; // failed to book
							$c=0;
						break;
					
					}
					
					
					if($c){
					
					
						// check for cancellation
						
						if($selrdcn=$wpdb->get_row("SELECT * FROM booking_status WHERE RD_Id='$values' AND BS_Active=1 AND BS_Status=3")){
						
						
							if ($selrdcn->BA_Id==5){
							
								// update the bs to history
                                                                
								$wpdb->update( 'booking_status', array( 'BS_Active' => '2', 'BS_HistoryDate' => "NOW()" ), array( 'BS_Id' => $selrdcn->BS_Id, 'BS_Active' => 1 ));
								
								
								// insert a new self booking request 
								
								$wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 2, 'BA_Id' => 1 ));
								
								$s++;
																
							} else {
							
								// do the cancellation and then duplicate the value
							
								$cancel_duplicate=1;
							
							}
						
							
						
						}  else  { 
						
						// do the cancellation and then duplicate the value
						
						
							$cancel_duplicate=1;
													
						
						}// end of if else cancellation with no cancellation charges condition
						
												
						
						// cancellation and duplication of the requst
						
						if($cancel_duplicate){
                                                        
							$wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 3, 'BA_Id' => 1 ));
							
                                                                    
							if($oldrd=$wpdb->get_row("SELECT * FROM request_details WHERE RD_Id='$values' AND RD_Status=1")){
                                                                
								$wpdb->insert('request_details', array('REQ_Id' => $oldrd->REQ_Id,'RD_Dateoftravel' => $oldrd->RD_Dateoftravel,'RD_Description' => $oldrd->RD_Description,'EC_Id' => $oldrd->EC_Id,'MOD_Id' => $oldrd->MOD_Id,'RD_Cityfrom' => $oldrd->RD_Cityfrom,'RD_Cityto' => $oldrd->RD_Cityto,'SD_Id' => $oldrd->SD_Id,'RD_Cost' => $oldrd->RD_Cost,'RD_Duplicate' => $oldrd->RD_Id));
								$lastid = $wpdb->insert_id;
								$d++; // duplicated the row
								
								$wpdb->insert( 'booking_status', array( 'RD_Id' => $lastid, 'BS_Status' => 2));
								
								$s++;
								
								$cancel_ids.=$values.",";
																
							} // end of if request details condition
						
						} // end of if cancel duplication condition
						
						
					}  else {
					
						if($f){
													
						// update the bs to history
                                                       
							 $wpdb->update( 'booking_status', array( 'BS_Active' => '2', 'BS_HistoryDate' => "NOW()" ), array( 'BS_Id' => $selrdbs->BS_Id, 'BS_Active' => 1 ));
							
							
							// insert a new self booking request 
							
							$wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 2));
							
							$s++;
						
						}
					
					}// end of c if condition
					
					
				} // end of if booking request raised by employee
					
					
			
			} // end of if else  condition of self booking
		
		
		} // end of if else condition if row is there			
	
	} // end of for loop

	
	
	
	if($d){
	
		$rdids=rtrim($cancel_ids,",");
		
		$actionButton=3;
		
		// these ids need to be cancelled bcoz employee going to self book it.
		
		//require("book-now-details.php");
		
		//travelBooking($message_body, 2);
	
	}


	$msg=8;

    //$s=0; $a=0; $pb=0; $f=0; $c=0; $d=0; $cancel_duplicate=0;
    header("location:/wp-admin/admin.php?page=View-Request&reqid=$reqid&msg=$msg&s=$s&a=$a&c=$c&b=$b&d=$d&p=$p&h=$h&f=$f");exit;   
    }
    if(isset($_POST['cancelTickets']))
    {
	global $wpdb;
	
	$reqid			=	$_POST['reqid'];
	
	$rdid			=	$_POST['rdid'];
	
	$rdids			=	join(",",$rdid);
		
	$selreqcode		=	$_POST['reqcode'];
	
	
	$h=0; $p=0; $c=0; $f=0; $b=0;$s=0; $a=0; $f=0; $c=0; $d=0;
	
	
	foreach($rdid as $values){
	
		
		
		
	
		// checking first row is present or not
                            
		if(!$selrdbs=$wpdb->get_row("SELECT RD_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1")){ 
						
				$h++;
				
				/*
					you haven't booked those details to cancel
				*/
				
				
			
		} else {
                        
			if($selrdbs=$wpdb->get_row("SELECT RD_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1 AND BS_Status=2")){
		
				$h++;
				
				/*
						you haven't booked those details to cancel
					*/
					
			
			} else {			
                                
				if($selrdbs=$wpdb->get_row("SELECT BS_Id, RD_Id, BA_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1 AND BS_Status=3")){
				
										
					switch($selrdbs->BA_Id){
					
					case 1:
						$p++;
						
						/*
							your cancellation request is under processing from the travel desk, please wait for the acknowledgement
						*/
					break;
					
					
					case 2:
						$b++;
                                                
						$wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 3, 'BA_Id' => 1));
						/*
						ticket was booked, but employee raised cancellation
						*/
					break;
					
					
					case 3:
						$f++;
						
						/*
						this ticket was failed to book by the travel desk, so it is already cancelled, 
						if you want the travel desk to try booking it again, please book it.
						*/
					break;
					
					
					case 4: case 5:
					
						$c++;
						
						/*
						Already been cancelled somehow either from employee or travel desk tickets
						*/
					
					break;
					
					}
					
				} else {
				
                                    
					if($selrdbs=$wpdb->get_row("SELECT BS_Id, RD_Id, BA_Id FROM booking_status WHERE RD_Id='$values' AND BS_Active=1 AND BS_Status=1")){
									
						switch ($selrdbs[BA_Id]){
						
							case 1: case 2:
								$b++;
                                                            
								$wpdb->insert( 'booking_status', array( 'RD_Id' => $values, 'BS_Status' => 3, 'BA_Id' => 1));
								
								/*
								 not yet requested for cancellation but now sent to travel desk
								*/
								
							break;
							
							case 3:
							
								$f++;
							break;
						
						}
					
					} 
										
					
				}
			
			}
			
		}
		
	}
					
	if($b){
							
		$actionButton=3;
		
		//require("book-now-details.php");
		
		//travelBooking($message_body, 8);
	
	}
	
	$msg=9;

	
	header("location:/wp-admin/admin.php?page=View-Request&reqid=$reqid&msg=$msg&h=$h&p=$p&f=$f&b=$b&c=$c&s=$s&a=$a&d=$d");exit;		
    }
}

