<?php
namespace WeDevs\ERP\Traveldesk;

use WeDevs\ERP\Framework\Traits\Ajax;
use WeDevs\ERP\Framework\Traits\Hooker;
use WeDevs\ERP\HRM\Models\Dependents;
use WeDevs\ERP\HRM\Models\Education;
use WeDevs\ERP\HRM\Models\Work_Experience;

/**
 * Ajax handler
 *
 * @package WP-ERP
 */
class Ajax_Handler {

    use Ajax;
    use Hooker;

    /**
     * Bind all the ajax event for HRM
     *
     * @since 0.1
     *
     * @return void
     */
    public function __construct() {
        
        //Travel Desk
        $this->action( 'wp_ajax_traveldesk_request_create', 'traveldesk_request_create' );
	$this->action( 'wp_ajax_traveldeskbankdetails_create', 'traveldeskbankdetails_create' );
        $this->action( 'wp_ajax_traveldeskbankdetails_get', 'traveldeskbankdetails_get' );
	$this->action( 'wp_ajax_traveldeskclaims_create', 'traveldeskclaims_create' );
	$this->action( 'wp_ajax_traveldeskclaims_update', 'traveldeskclaims_update' );
        $this->action( 'wp_ajax_group-req-claim', 'group_req_claim' );
    }
    
    public function group_req_claim(){
        global $wpdb;
        $posted = array_map( 'strip_tags_deep', $_POST );
        $reqid = $posted['id'];
        if($reqid){
                
		$wpdb->update( 'requests', array( 'RT_Id' => 2, 'REQ_Active' => 1, 'REQ_DraftUpdatedDate' => 'NOW()', 'REQ_PreToPostStatus' => 1, 'REQ_PreToPostDate' => 'NOW()' ), array( 'REQ_Id' => $reqid ));
		
		$response = array('status'=>'success','message'=>"You have successfully updated this request for submit claims");
                $this->send_success($response);
	
	} else {
	
		$response = array('status'=>'failure','message'=>"<b>OOps!</b> Error !! Please try again. ");
                $this->send_success($response);
	
	}
        
    }
	
    public function traveldeskclaims_create() {
		
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $traveldeskclaims_id  = traveldeskclaims_create( $posted );
        $data = $posted;
        $this->send_success( $data );
    }
	
    public function traveldeskclaims_update() {
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $traveldeskclaimsupdate_id  = traveldeskclaims_update( $posted );
        $data = $posted;
        $this->send_success( $data );
    }
	/*** Create/update an travelagentbankdetails */

    public function traveldeskbankdetails_create() {
        $posted               = array_map( 'strip_tags_deep', $_POST );
        $traveldeskbankdetails_id  = traveldeskbankdetails_create( $posted );
        $data = $posted;
        $this->send_success( $data );
    }
    
	public function traveldeskbankdetails_get() {
        global $wpdb;
        $id = $_REQUEST['id']; 
        $response = $wpdb->get_row("SELECT * FROM travel_desk_bank_account WHERE TDBA_Id = '$id' AND TDBA_Status=1");
        $this->send_success( $response );
    }
        function traveldesk_request_create(){
        ob_end_clean();
        global $wpdb;
        $compid = $_SESSION['compid'];
        $empuserid = $_POST['hiddenEmp'];
        $posted = array_map( 'strip_tags_deep', $_POST );
        
        $expenseLimit                           = 	$posted['expenseLimit'];
        
        $selEmployees                           =	$_POST['hiddenEmp'];
        
        $hiddenDraft                            =	$_POST['hiddenDraft'];

	$etype					=	$posted['ectype'];
        
	$addnewRequest                          =	$_POST['addnewrequest'];
        
	$expreqcode				=	genExpreqcode(4); // 4 is for creating requests with TRA
		
	$date					=	$posted['txtDate'];
	
	$txtStartDate                           =	$posted['txtStartDate'];
	
	$txtEndDate				=	$posted['txtEndDate'];
	
	$txtaExpdesc                            =	$posted['txtaExpdesc'];
	
	$selExpcat				=	$posted['selExpcat'];
	
	$selModeofTransp                        =	$posted['selModeofTransp'];
	
	$from					=	$posted['from'];
	
	$to					=	$posted['to'];
	
	//$selStayDur				=	$posted['selStayDur'];
	
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
	//$expenseLimit                           =       "0";
	
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
                        $this->send_success($response);
			exit;
		}
                
        }
     
        //$this->send_success("here");
        if($comp=$wpdb->get_row("SELECT COM_Pretrv_POL_Id FROM company WHERE COM_Id='$compid'")){
	
        switch ($addnewRequest){
                
                // individual without approval
                case 1:
                $reqtype=2; $reqstatus=2;
                break;

                // individual with approval
                case 2:
                $reqtype=3;
                break;

                // group request
                case 3:
                $reqtype=4; $reqstatus=2;
                break;

        }
        
        $polid=$comp->COM_Pretrv_POL_Id;
        
        if($addnewRequest==2){
				
        // Retrieving employee details
        $mydetails=myDetails($selEmployees);

        $type=0;

        switch ($polid)
        {
            
                //-------- employee -->  rep mngr  -->  finance
                case 1:
                   
                if($expenseLimit > 0){
                            $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                            $reqid=$wpdb->insert_id;
                            $type=2;
                }
                else{
                    if($mydetails->EMP_Code==$mydetails->EMP_Funcreprtnmngrcode)
                    {
                            // insert into request
                            $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                            $reqid=$wpdb->insert_id;
                            // insert into request_status
                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));
                            $type=1;
                    }
                    else
                    {
                            $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                            $reqid=$wpdb->insert_id; 
                            $type=2;
                    }       
                }
                break;
                



                //  employee --> rep mngr 
                case 3:

                if($expenseLimit > 0){
                        if($mydetails->EMP_Code==$mydetails->EMP_Funcreprtnmngrcode)
                        {

                                // insert into request
                                $wpdb->insert('requests', array('REQ_Status' => 2,'POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                                $reqid=$wpdb->insert_id; 

                                // insert into request_status
                                $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));
                                $setreqstatus=1;
                                $type=3;

                        }
                        else
                        {
                            $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                            $reqid=$wpdb->insert_id;
                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 3,'RS_EmpType' => 3));
                            $type=4;
                        }
                }
                else{

                        if($mydetails->EMP_Code==$mydetails->EMP_Reprtnmngrcode)
                        {

                                // insert into request
                                
                                $wpdb->insert('requests', array('REQ_Status' => 2,'POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                                $reqid=$wpdb->insert_id; 

                                // insert into request_status
                                $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));


                                $setreqstatus=1;
                                $type=3;

                        }
                        else
                        {
                            $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                            $reqid=$wpdb->insert_id;
                            $type=4;    
                        }	

                }
                break;

                //--------- employee --> finance --> rep mngr
                case 2:
                if($expenseLimit > 0){
                        
                        $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                        $reqid=$wpdb->insert_id;
                        $type=6;
                }   
                else{
                        $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                        $reqid=$wpdb->insert_id;
                        $type=6;
                }
                break;


                //--------- employee  --> finance
                case 4:
                if($expenseLimit > 0){
                   //-------- employee -->  2nd level manager  -->  finance
                   if($mydetails->EMP_Code==$mydetails->EMP_Funcreprtnmngrcode)
                    {

                            // insert into request
                            $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                            $reqid=$wpdb->insert_id;                           

                            // insert into request_status
                            $wpdb->insert('request_status', array('REQ_Id' => $reqid,'EMP_Id' => $empuserid,'REQ_Status' => 2));
                            $type=7;
                    }
                    else
                    {
                        $wpdb->insert('requests', array('POL_Id' => 5,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));   
                        $reqid=$wpdb->insert_id;
                        $type=7;
                    }
                }
                else{
                        $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Type' => $reqtype));
                        $reqid=$wpdb->insert_id;
                        $type=7;
                }				
                break;

        }


        if($setreqstatus)
        $wpdb->insert('requests', array('REQ_Status' => 2), array('REQ_Id' => $reqid));

        }else {
			
                if($reqtype==2)
                $reqactive=1;
                else
                $reqactive=2;

                $wpdb->insert('requests', array('POL_Id' => $polid,'REQ_Code' => $expreqcode,'COM_Id' => $compid,'RT_Id' => $etype,'PC_Id' => $selProjectCode,'CC_Id' => $selCostCenter,'REQ_Status' => $reqstatus,'REQ_Active' => $reqactive,'REQ_Type' => $reqtype));
                $reqid=$wpdb->insert_id;

        }
        if($reqid){
			
            if($reqtype==4){

                    $selEmployees	=	$_POST['selEmployees'];

                    //echo 'Emps='.join(",",$selEmployees); exit;

                    foreach($selEmployees as $value){

                            // insert into request_employee
                            $wpdb->insert('request_employee', array('REQ_Id' => $reqid,'EMP_Id' => $value));
                            
                            // mail to employee required or not

                    }


            } else {

                    // insert into request_employee
                    $wpdb->insert('request_employee', array('REQ_Id' => $reqid,'EMP_Id' => $selEmployees));
                    
                    // mail to employee required or not

            }

    } else {

            //header("location:$filename?msg=2");exit;
            $this->send_success("2");

    }

    } else {

            //header("location:$filename?msg=2");exit;
            $this->send_success("2");
    }

    if($reqid)
        {

                for($i=0;$i<$count;$i++)
                {		
                        $dateformat=$date[$i];
                        $dateformat=explode("/",$dateformat);
                        $dateformat=$dateformat[2]."-".$dateformat[1]."-".$dateformat[0];

                        ($from[$i]=="n/a") ? $from[$i]="NULL" : $from[$i]="'".$from[$i]."'";

                        ($to[$i]=="n/a") ? $to[$i]="NULL" : $to[$i]="'".$to[$i]."'";

                        ($selStayDur[$i]=="n/a") ? $selStayDur[$i]="NULL" : $selStayDur[$i]="'".$selStayDur[$i]."'";	



                        $desc	=	addslashes($txtaExpdesc[$i]);

                        $wpdb->insert('request_details', array('REQ_Id' => $reqid,'RD_Dateoftravel' => $dateformat,'RD_Description' => $desc,'EC_Id' => $selExpcat[$i],'MOD_Id' => $selModeofTransp[$i],'RD_Cityfrom' => $from[$i],'RD_Cityto' => $to[$i],'SD_Id' => $selStayDur[$i],'RD_Cost' => $txtCost[$i],'RD_Type' => 2));
                        $rdid = $wpdb->insert_id;


                        // GET  QUOTE

//                        if($addnewRequest==2){
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
//                                                $wpdb->insert('request_getquote', array('RD_Id' => $rdid,'RG_SessionId' => $sessionid[$i],'GQF_Id' => $gqfid,'RG_Pref' => $pref));
//
//                                        }
//
//                                }
//
//                        }



                        if($addnewRequest==1 || $addnewRequest==3){

                                // insert into booking status
                                $wpdb->insert('booking_status', array('RD_Id' => $rdid,'BS_Status' => 1,'BS_TicketAmnt' => $txtCost[$i],'BA_Id' => 2,'BA_ActionDate' => "NOW()"));
                                $bsid = $wpdb->insert_id;


                                $j=$i+1;
                                $files=$_FILES['file'.$j]['name'];
                                $countbills=count($files);




                                for($f=0;$f<$countbills;$f++)
                                {			
                                        //Get the temp file path
                                        $tmpFilePath = $_FILES['file'.$j]['tmp_name'][$f];



                                        //Make sure we have a filepath
                                        if ($tmpFilePath != ""){						

                                                $ext = substr(strrchr($files[$f], "."), 1); //echo $ext;
                                                // generate a random new file name to avoid name conflict
                                                // then save the image under the new file name

                                                $filePath = md5(rand() * time()).".".$ext;

                                                $newFilePath = "../company/upload/$compid/bills_tickets/";

                                                $result    = move_uploaded_file($tmpFilePath, $newFilePath . $filePath);

                                                //echo 'count='.$result;exit;

                                                //Upload the file into the temp dir
                                                if($result){

                                                        if($addnewRequest==2){

                                                                // insert into request files
                                                                $wpdb->insert('requests_files', array('RD_Id' => $rdid,'RF_Name' => $filePath));

                                                        } else {

                                                                // insert into bs documents.	
                                                                $wpdb->insert('booking_documents', array('BS_Id' => $bsid,'BD_Filename' => $filePath));

                                                        }





                                                }
                                        }
                                }

                        }



                }


                switch ($type){

                        case 1:

                        //mail to accounts
                        //notify($expreqcode, $etype, 1);

                        break;


                        case 2:

                        //mail to reporting manager
                        //notify($expreqcode, $etype, 2);

                        break;


                        case 3:

                        // mail to himself saying that he can make the journey
                        //notify($expreqcode, $etype, 19, $mydetails['EMP_Id']);

                        break;

                        case 4:

                        //mail to reporting manager
                        //notify($expreqcode, $etype, 2, $mydetails['EMP_Id']);

                        break;


                        case 5:

                        //mail to finance
                        //notify($expreqcode, $etype, 1, $mydetails['EMP_Id']);

                        break;


                        case 6:

                        //mail to finance
                        //notify($expreqcode, $etype, 20, $mydetails['EMP_Id']);

                        break;


                        case 7:

                        //mail to finance
                        //notify($expreqcode, $etype, 20, $mydetails['EMP_Id']);

                        break;

                }



        } else {

                //header("location:$filename?msg=7");exit;
                $response = array('status'=>'failure','message'=>"Request Couldn\'t be added. Please try again");
                $this->send_success($response);

        }


        //header("location:$filename?msg=1&reqid=$expreqcode");exit;    
	//$this->send_success("1");	
			
        $response = array('status'=>'success','message'=>"You have successfully added a Pre Travel Expense Request  <br> Your Request Code: $expreqcode <br> Please wait for approval..  ");
        $this->send_success($response);
        
    }
}
