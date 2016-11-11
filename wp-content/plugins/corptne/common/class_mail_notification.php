<?php 
error_reporting(0);

require_once("PHPMailer/mailer.php");

//$$assetimgpath="http://www.dev.corptne.com/assets/img/";

$domain = "http://www.dev.corptne.com/";

$assetimgpath = $domain.'assets/img/';





$mail_header1='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;">###</td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';

 
 
 
 $mail_header2='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;">&nbsp;</td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';



$mail_footer='</td>
			  </tr>
			  <tr>
				<td height="10" align="left" valign="top">&nbsp;</td>
			  </tr>
			</table>';		


/*

	NON CORPTNE USER REQUEST CANCELLATION

*/



function requestCancellation($reqcode, $compid){
	

		global $compid;
		
		
		$mail_sub = "CorpTnE - Request Cancellation";
		
		
		$row=select_query("company", "COM_Name, COM_Logo", "COM_Id='$compid'", $filename);
		
		
		
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>To Travel Agent, <br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					 
					  <tr>
						<td colspan="2" >
						<table width="100%" border="0" cellpadding="0" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
						  <tr>
							<td colspan=3>A Booking Request has been removed by '.$row['COM_Name'].'. Please note the request code.</td>
							 
						  </tr>
						   <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						   <tr>
							<td width="35%">Request Code</td>
							<td width="5%">:</td>
							<td>'.$reqcode.'</td>
						  </tr>
						 
						  <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						</table>
						
						</td>
					  </tr>
					  
					 
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.$row["COM_Name"].'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
			
			
			if($row['COM_Logo']){
				$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$row["COM_Logo"].'">', $GLOBALS['mail_header1']);
			} else {
				$head = str_replace("###", '', $GLOBALS['mail_header1']);
			}
			
	
			$mail_mesg = $head . $mail_body . $GLOBALS['mail_footer'];
	
	
			//echo $mail_mesg; exit;
		
		
		
		$selacc=select_all("assign_company ac, superadmin sup", "sup.SUP_Email, sup.SUP_Name", "ac.COM_Id = '$compid' and ac.SUP_Id = sup.SUP_Id AND AC_Active = 1 AND AC_Status = 1 AND SUP_Status = 1 AND SUP_Type = 4 AND SUP_Access = 1", $filename);		
				
				
		foreach($selacc as $rowsql){
		
			$mail_to	=	$rowsql['SUP_Email'];
			
			$toname		=	$rowsql['SUP_Name'];
			
	
			$mail_from	=	"CorpTnE <notification@corptne.com>";
		
			$headers  	= 	'MIME-Version: 1.0' . "\r\n";
		
			$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
			$headers 	.= 	'From:'.$mail_from;
			
			SendPHPMailer($mail_to, $toname, $mail_sub, $mail_mesg, $headers);
		
			//mail($mail_to, $mail_sub, $message_body, $headers);
		}	
		
}







/*
	TALLY CONNECT MAIL

*/

function tallyConnectMail($supid, $comid){

	global $filename;
	
	global $compid;
	
	
	
	$row=select_query("company", "*", "COM_Id='$comid'", $filename);
	
	
	$mail_sub='CorpTnE - FTP Details Of '.stripslashes($row['COM_Name']);

	
	
	
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" colspan="3" style="font-size:16px;font-weight: bold;" align="center"><u>Travel Agent Company Creation</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>To CorpTnE, <br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					 
					  <tr>
						<td colspan="2" >
						<table width="100%" border="0" cellpadding="0" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
						  <tr>
							<td colspan=3>Please find the FTP details below:</td>
							 
						  </tr>
						  <tr>
							<td width="16%">Folder Name</td>
							<td width="4%">:</td>
							<td width="80%">'.$row['COM_TallyFolder'].'</td>
						  </tr>
						  <tr>
							<td width="16%">Username</td>
							<td width="4%">:</td>
							<td width="80%">'.$row['COM_TallyUsername'].'</td>
						  </tr>
						  <tr>
							<td>Password</td>
							<td>:</td>
							<td>'.$row['COM_TallyPwd'].'</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						</table>
						
						</td>
					  </tr>
					  
					 
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;  font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					 
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
			
			
			if($row['COM_Logo']){
				$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$row["COM_Logo"].'">', $GLOBALS['mail_header1']);
			} else {
				$head = str_replace("###", '', $GLOBALS['mail_header1']);
			}
			
	
	$mail_mesg = $head.$mail_body.$GLOBALS['mail_footer'];

	
	
	//echo $mail_mesg."<br>"; exit;
		
			
		
	$mail_to	=	'info@corptne.com';
	
	//$mail_to	=	'rahul@3aces.in';

	$mail_from	=	"CorpTnE <notification@corptne.com>";

	$headers  	= 	'MIME-Version: 1.0' . "\r\n";

	$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers 	.= 	'From:'.$mail_from;
	
	SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	

}



/*
	MAIL TO CORPTNE

*/

function mailtoCorptne($supid, $comid){

	global $filename;
	
	//global $compid;
	
	$row=select_query("company com, superadmin sup", "*", "sup.SUP_Id='$supid' and com.COM_Id='$comid' AND sup.SUP_Id=com.SUP_Id", $filename);
	
	
	$mail_sub='Travel Agent: '.$row['SUP_AgencyName'].stripslashes($row['COM_Name'])." [ Company Creation ]";

	
	
	
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" colspan="3" style="font-size:16px;font-weight: bold;" align="center"><u>Travel Agent Company Creation</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>To CorpTnE, <br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					 
					  <tr>
						<td colspan="2" >
						<table width="100%" border="0" cellpadding="0" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
						  <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td width="16%">Travel Agent Name</td>
							<td width="4%">:</td>
							<td width="80%">'.$row['SUP_Name'].' -- { '.$row['SUP_AgencyName'].' }</td>
						  </tr>
						  <tr>
							<td>Company Name</td>
							<td>:</td>
							<td>'.$row['COM_Name'].'</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						</table>
						
						</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					
					 
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
					
			
	
	if($row['COM_Logo']){
				$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$row["COM_Logo"].'">', $GLOBALS['mail_header1']);
			} else {
				$head = str_replace("###", '', $GLOBALS['mail_header1']);
			}
			
	
	$mail_mesg = $head.$mail_body.$GLOBALS['mail_footer'];

	
	
	//echo $mail_mesg."<br>"; exit;
		
			
		
	$mail_to	=	'info@corptne.com';
	
	//$mail_to	=	'rahul@3aces.in';

	$mail_from	=	"CorpTnE <notification@corptne.com>";

	$headers  	= 	'MIME-Version: 1.0' . "\r\n";

	$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers 	.= 	'From:'.$mail_from;
	
	SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	

}

/*

	FINANCE TRAVEL DESK CLAIM NOTIFICATION

*/


function td_to_finance_Claims_Notify($tdcid, $compid = false, $type = false){
	
	
	global $filename;
	
	if(!$compid) global $compid;
	
	
	$row=select_query("travel_desk_claims tdc, company com", "*", "tdc.TDC_Id='$tdcid' AND tdc.COM_Id='$compid' and tdc.COM_Id=com.COM_Id", $filename, 0);
	

	
	$mailsub	=	'Travel Desk Claim Invoice';
	
	$text		=	'Travel desk requested for claims invoices. Reference No. '.$row['TDC_ReferenceNo'];
	
	
	
	
	$mail_sub=stripslashes($row['COM_Name'])." [ Invoice Payment Update ]";
	
	
	if($type){
		
		$toAddrssd = 'To Client Travel Desk,';
	
	} else {
	
		$toAddrssd = 'To Finance,';
	}

	
	
	
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" colspan="3" style="font-size:16px;font-weight: bold;" align="center"><u>'.$mailsub.'</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td  align="left" colspan="3" style="font-size:14px;font-weight: bold;" align="center"><u>Invoice No. : '.$row['TDC_InvoiceNo'].'</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>'.$toAddrssd.'<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.' </p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					 <!-- <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: Its recommended that you change your password on the first login itself.</td>
					  </tr>-->
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<!--<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</p>-->
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.stripslashes($row["COM_Name"]).'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
					
			
	
		if($row['COM_Logo']){
			$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$row["COM_Logo"].'">', $GLOBALS['mail_header1']);
		} else {
			$head = str_replace("###", '', $GLOBALS['mail_header1']);
		}
			
	
	$mail_mesg = $head.$mail_body.$GLOBALS['mail_footer'];

	
	
	//echo $mail_mesg."<br>"; exit;
	
	
	if($type){
			 
		
			$mail_to	=	$row['COM_Email'];
	
			//$mail_from	=	stripslashes($empdetails['COM_Name'])."<".$empdetails['COM_Email'].">";
			
			$mail_from	=	"CorpTnE <notification@corptne.com>";
		
			$headers  	= 	'MIME-Version: 1.0' . "\r\n";
		
			$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
			$headers 	.= 	'From:'.$mail_from;
			
			SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
		
			//mail($mail_to, $mail_sub ,$mail_mesg, $headers);
		 
	
	
	} else {
	
	
	
		$selacc=select_all("employees", "*", "COM_Id='$compid' AND EMP_AccountsApprover=1 AND EMP_Access=1", $filename, 0);
		
		foreach($selacc as $rowsql){
		
			$mail_to	=	$rowsql['EMP_Email'];
	
			//$mail_from	=	stripslashes($empdetails['COM_Name'])."<".$empdetails['COM_Email'].">";
			
			$mail_from	=	"CorpTnE <notification@corptne.com>";
		
			$headers  	= 	'MIME-Version: 1.0' . "\r\n";
		
			$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
			$headers 	.= 	'From:'.$mail_from;
			
			SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
		
			//mail($mail_to, $mail_sub ,$mail_mesg, $headers);
		}
		
	
	}

}




/*
	
	TRAVEL DESK CLAIM PAYMENT UPDATE
	
	&
	
	NON CORPTNE USER

*/




function travelDeskClaims($tdcid, $type, $status = false){

	global $filename;
	
	global $compid;
	
	
	if($status){
	
		$row=select_query("travel_desk_claims tdc, company com", "TDC_ReferenceNo, COM_Name, TDC_InvoiceNo, COM_Logo", "tdc.TDC_Id='$tdcid' AND tdc.COM_Id='$compid' and tdc.COM_Id=com.COM_Id", $filename, 0);
	
	} else {
	
		$row=select_query("travel_desk_claims tdc, company com, travel_desk td", "*", "tdc.TDC_Id='$tdcid' AND tdc.COM_Id='$compid' and tdc.COM_Id=com.COM_Id and tdc.TD_Id=td.TD_Id", $filename, 0);
	
	}
	
	
	switch ($type){
	
		case 1:
		$mailsub	=	"Payment details added by Finance";
		$name		=	"To Travel Desk";
		$text		=	"Payment details added by the finance department for the reference no. ".$row['TDC_ReferenceNo'].". Please verify payment details";		
		break;
		
		case 2: 
		$mailsub	=	"Payment details updated by Finance";
		$name		=	"To Travel Desk";
		$text		=	"Payment updated by the finance department for the reference no. ".$row['TDC_ReferenceNo']." Please verify payment details";		
		break;
		
		
		case 3: 
		$mailsub	=	"Payment update by - ".$row['COM_Name'];
		$name		=	"To Travel Agent";
		$text		=	"Payment updated by the client for the reference no. ".$row['TDC_ReferenceNo']." Please verify payment details";		
		break;
	
	}
	
	
	
	
	$mail_sub='CorpTnE - Invoice Payment Update - '.stripslashes($row['COM_Name']);

	
	
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" colspan="3" style="font-size:16px;font-weight: bold;" align="center"><u>'.$mailsub.'</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td  align="left" colspan="3" style="font-size:14px;font-weight: bold;" align="center"><u>Invoice No. : '.$row['TDC_InvoiceNo'].'</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>'.$name.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.' </p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<!--<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</p>-->
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.stripslashes($row["COM_Name"]).'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
					
			
	
	
		if($row['COM_Logo']){
		
			$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$row["COM_Logo"].'">', $GLOBALS['mail_header1']);
			
		} else {
		
			$head = str_replace("###", '', $GLOBALS['mail_header1']);
			
		}
			
	
	$mail_mesg = $head.$mail_body.$GLOBALS['mail_footer'];

	
	
	//echo $mail_mesg."<br>"; exit;
	
	
	if($status){ // send message to travel agent
	
		
		
		$selsql = " SELECT SUP_Name, SUP_Email FROM company com, superadmin sup WHERE com.COM_Id = $compid AND com.SUP_Id = sup.SUP_Id  ";
		
		$row = rawSelectQuery($selsql, $filename, $show=false);
		
		
		
		$toname 	=	$row['SUP_Name'];
		
		$mail_to	=	$row['SUP_Email'];	
	
	
	} else {
		
		$mail_to	=	$row['TD_Email'];	
	
	}
	
	
	$mail_from	=	"CorpTnE <notification@corptne.com>";
	
	$headers  	= 	'MIME-Version: 1.0' . "\r\n";
	
	$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$headers 	.= 	'From:'.$mail_from;
	
	SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
	
	//mail($mail_to,$mail_sub,$mail_mesg,$headers);
	

}




/*
////////////////////////////////////////////////
		PASSPORT / VISA EXPIRY NOTIFICATION
////////////////////////////////////////////////
*/

function visa_passport_expiry_reminder($empid, $type, $expdate, $vdid=false)
{

	global $filename;

	$company	=	select_query("employees emp, company com", "*", "emp.EMP_Id=$empid AND emp.COM_Id=com.COM_Id", $filename, 0);
	
	//echo $company['COM_Id']; exit;
	
	$mail_sub="CorpTnE Profile Notification";
	
	switch ($type){
	
		case 1:
		$text="As per the CorpTnE profile records, your passport due for renewal on ".$expdate.". If you have already renewed your passport, please update the new expiry date with corptne.";
		break;
		
		case 2:
		$text="As per the CorpTnE profile records, your visa is due for renewal on ".$expdate.". If you have already renewed your visa, please update the new expiry date with corptne. Visa Details are given below.";
		break;
	
	}
	
	if($vdid){
		
		$selvisa	=	select_query("visa_details", "*", "VD_Id=$vdid", $filename);
		
		$visadetails	=	'<tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>Please click the below link to take you to the corptn.</p></td>
					  </tr>
					  <tr>
							<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<th align="left" valign="middle">Visa No.</th>
								<td align="center" valign="middle">:</td>
								<td align="left" valign="middle">'.$selvisa['VD_VisaNumber'].'</td>
							  </tr>
							  <tr>
								<th align="left" valign="middle">Type of Visa</th>
								<td align="center" valign="middle">:</td>
								<td align="left" valign="middle">'.$selvisa['VD_Typeofvisa'].'</td>
							  </tr>
							</table></td>
						  </tr>';
		
	}
	
	
	
	

	
	
	
	
	$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <!--<td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;"><img src="'.$GLOBALS['domain'].'admin/'.$company["COM_Logo"].'"></td>-->
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
	
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$company['EMP_Name'].',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.' </p>
						 </td>
					  </tr>'.$visadetails.'
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">CorpTnE Team</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
		
						

	$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];

	//echo $mail_mesg."<br>"; exit;
	

	$mail_to	=	$company['EMP_Email'];
	
	$mail_from	=	"CorpTnE <notification@corptne.com>";

	$headers  	= 	'MIME-Version: 1.0' . "\r\n";

	$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers 	.= 'From:'.$mail_from;
	
	SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($mail_to, $mail_sub, $mail_mesg, $headers);

}


// sending username and password to company email address


function travelDeskLoginDetails($cmpid, $email, $username, $password)
{
	
	$filename="mailnotification.php";
	
	if($selcom=select_query("company", "COM_Email, COM_Logo", "COM_Id=$cmpid AND COM_Status = 0", $filename))
	{
					
		$mail_sub="CorpTnE - Company Profile Creation Successful";
		
		
		
	
		$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;"><img src="'.$GLOBALS['domain'].'admin/'.$selcom["COM_Logo"].'"></td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">Company Profile has been  successfully created in the CorpTnE Travel Expense Management System. </p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>Given below are the Username &amp; Password for the Travel Desk.</p></td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle" >Username</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$username.'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Password</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$password.'</td>
							</tr>
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: Its recommended that you change your password on the first login itself.</td>
					  </tr>
					  
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">CorpTnE</p>
						  	</td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
		
		
		
			
		
		$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];
	
					
		//echo $mail_mesg;exit;
		
		$mail_to	=	$email;

		$mail_from	=	"CorpTnE <notification@corptne.com>";
	
		$headers  	= 	'MIME-Version: 1.0' . "\r\n";
	
		$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		$headers 	.= 	'From:'.$mail_from;
		
		SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
	
		//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	}
	
	
	
}



// mail to contact person during company creation

function mailtoContactperson($cmpid, $name, $email)
{
	
	$filename="mailnotification.php";
	
	if($selcom=select_query("company", "COM_Email, COM_Logo", "COM_Id=$cmpid AND COM_Status = 0", $filename))
	{
					
		$mail_sub="CorpTnE - Company Profile Creation Successful";
		
		
		
	
		$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;"><img src="'.$GLOBALS['domain'].'admin/'.$selcom["COM_Logo"].'"></td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$name.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">Company Profile has been created successfully in the CorpTnE Travel Expense Management System. </p>
						  </td>
					  </tr>
					  <!--<tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>Given below are username &amp; password for your Travel &amp; Expense Management System.</p></td>
					  </tr>-->
					  <!--<tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle" >Username</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$seladmin['ADM_Username'].'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Password</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$pwd.'</td>
							</tr>
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>-->
					  
					 <!-- <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>-->
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					 <!-- <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: Its recommended that you change your password on the first login itself.</td>
					  </tr>-->
					  
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">CorpTnE</p>
						  	</td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
		
		
		
			
		
		$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];
	
					
		//echo $mail_mesg;exit;
		
		$mail_to	=	$email;

		$mail_from	=	"CorpTnE <notification@corptne.com>";
	
		$headers  	= 	'MIME-Version: 1.0' . "\r\n";
	
		$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		$headers 	.= 	'From:'.$mail_from;
		
		SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
	
		//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	}
	
	
	
}



/*
////////////////////////////////////////////////
		RESET PASSWORD 
////////////////////////////////////////////////
*/

function resetPassword($toEmail, $toName, $memberid, $token, $entity)
{
	

	//$company	=	select_query("employees emp, company com", "*", "emp.EMP_Id=$memberid AND emp.COM_Id=com.COM_Id", $filename);
	
	//echo $company['COM_Id']; exit;

	$mail_sub="CorpTnE Password Reset";
	
	
	
	
	
	$verifylink="memberid=".$memberid."&token=".$token."&entity=".$entity;
	
	
						
						
	
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$toName.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">You have successfully requested for your password reset !! </p>
						 </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>Please click the below link to take you to the password reset page.</p></td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							<tr >
							<td style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" colspan=3>
							<a href="'.$GLOBALS['domain'].'employee-reset-onetime-password.php?'.$verifylink.'" >Reset Password</a>
							</td>
							</tr>
							
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					 
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  
					  <tr>
						<td colspan="2">
						
						
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">';
						 
						 //if($compadmin){
						 
							$mail_body.='CorpTnE Team';
						 
						// } else {
							
							//$mail_body.=$company["COM_Name"];
							
							//}							
							
							$mail_body.='</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
		
		
		if($row['COM_Logo']){
		
			$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$company["COM_Logo"].'">', $GLOBALS['mail_header1']);
			
		} else {
		
			$head = str_replace("###", '', $GLOBALS['mail_header1']);
			
		}
	
						

	$mail_mesg	=	$head.$mail_body.$GLOBALS['mail_footer'];
	
	

	//echo $mail_mesg."<br>	";
	

	$mail_to	=	$Email_Id;
	
	

	$mail_from	=	"CorpTnE <notification@corptne.com>";

	$headers  	= 	'MIME-Version: 1.0' . "\r\n";

	$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers 	.= 'From:'.$mail_from;
	
	SendPHPMailer($toEmail, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($toEmail,$mail_sub,$mail_mesg,$headers);

}

/*
////////////////////////////////////////////////
		SEND  USERNAME AND PASSWORD TO EMPLOYEE
////////////////////////////////////////////////
*/

function sendRegMail($toEmail, $toName, $memberid, $password)
{

	global $compid;
	
	global $adminid;
	
	
	$company	=	select_query("company cmp, admin adm", "*", "cmp.COM_Id='$compid' AND cmp.COM_Id=adm.COM_Id AND adm.ADM_Id='$adminid'", $filename);
	
	$mail_sub="CorpTnE LOGIN DETAILS";
	
	
						
			
			
	
	
	$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$toName.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">Your Profile has been successfully created in the CorpTnE Travel Expense Management System. </p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>Your username &amp; password for your Travel &amp; Expense Management System.</p></td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle" >Username</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$memberid.'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Password</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$password.'</td>
							</tr>
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: We recommended you to change your password on the first login.</td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.$company["ADM_Name"].'</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.stripslashes($company["COM_Name"]).'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
	
		if($row['COM_Logo']){
		
			$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$company["COM_Logo"].'">', $GLOBALS['mail_header1']);
			
		} else {
		
			$head = str_replace("###", '', $GLOBALS['mail_header1']);
			
		}
	


	$mail_mesg=$head . $mail_body . $GLOBALS['mail_footer'];
	
	

	//echo $mail_mesg."<br>	";exit;
	

	$mail_to	=	$Email_Id;
		
	$mailfrom	=	"CorpTnE <notification@corptne.com>";

	$mail_from	=	$mailfrom;

	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From:'.$mail_from;
	
	SendPHPMailer($toEmail, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($toEmail,$mail_sub,$mail_mesg,$headers);

}

/*
////////////////////////////////////////////////
 SEND  CHANGE PASWORD NOTIFICATION TO EMPLOYEE
////////////////////////////////////////////////
*/

function sendRegUpdateMail($toEmail, $toName, $memberid, $date)
{
	//global $compid;
	
	//global $adminid;
	
	
	//$company	=	select_query("company cmp, admin adm", "*", "cmp.COM_Id='$compid' AND cmp.COM_Id=adm.COM_Id AND adm.ADM_Id='$adminid'", $filename);
	
	$mail_sub="YOUR CorpTnE PASSWORD HAS BEEN CHANGED";
	
	
						
			
			
	
	
	$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$toName.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">This is a confirmation that the password for your CorpTnE Travel Expense Management System account '.$memberid.' is changed on '.$date.'. </p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>If you didnot request a password change, try signing in and reset your password if necessary.</p></td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: If you are having trouble, please email to <a href="mailto:notification@corptne.com">CorpTne</a></td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	</td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
	
		if($row['COM_Logo']){
		
			$head = str_replace("###", '<img src="'.$GLOBALS['domain'].'admin/'.$company["COM_Logo"].'">', $GLOBALS['mail_header1']);
			
		} else {
		
			$head = str_replace("###", '', $GLOBALS['mail_header1']);
			
		}
	


	$mail_mesg=$head . $mail_body . $GLOBALS['mail_footer'];
	
	

	//echo $mail_mesg."<br>	";exit;
	

	$mail_to	=	$toEmail;
		
	$mailfrom	=	"CorpTnE <notification@corptne.com>";

	$mail_from	=	$mailfrom;

	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From:'.$mail_from;
        
	SendPHPMailer($toEmail, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($toEmail,$mail_sub,$mail_mesg,$headers);

}



/*
/////////////////////////////////////////////////////////////////////
		SEND  USERNAME AND PASSWORD TRAVEL DESK
////////////////////////////////////////////////////////////////////
*/

function logindetails($toEmail, $username, $password, $status)
{

	global $compid;global $adminid;
	
	
	
	$company	=	select_query("company cmp, admin adm", "*", "cmp.COM_Id='$compid' AND cmp.COM_Id=adm.COM_Id AND adm.ADM_Id='$adminid'", $filename);
	
	$mail_sub="CorpTnE LOGIN DETAILS";
	
	$title="Your Login details has been success created in the CorpTnE Travel Expense Management System.";
	
	switch($status)
	{
		case 2:
		$title="Your Profile has been successfully created in the CorpTnE Travel Expense Management System.";
		$title1="User name &amp; password are as follows, ";
		break;
		
		case 3:
		$title="Your Login details has been updated by the company administrator";
		$title1="Given below are the updated details of your profile";
		break;
	}
		

	
	
	$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;"><img src="'.$GLOBALS['domain'].'admin/'.$company["COM_Logo"].'"></td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
						
						
			$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$username.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$title.'</p></td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>'.$title1.'</p></td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>';
				
				if($status==2)			
				{
							
					$mail_body.='<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
								  <th align="left" valign="middle" >Username</th>
								  <td align="center" valign="middle">:</td>
								  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$username.'</td>
								</tr>
								<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
								  <th align="left" valign="middle">Password</th>
								  <td align="center" valign="middle">:</td>
								  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$password.'</td>
								</tr>';
				}
				else
				{
					$mail_body.='<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
								  <th align="left" valign="middle" >Username</th>
								  <td align="center" valign="middle">:</td>
								  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$username.'</td>
								</tr>
								<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
								  <th align="left" valign="middle">Email-Id</th>
								  <td align="center" valign="middle">:</td>
								  <td align="left" valign="middle" style="font-size:14px; color:white;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$toEmail.'</td>
								</tr>
								<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
								  <td colspan=3>No change is your password</td>
								</tr>';
				}
				
				$mail_body.='<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: We recommended you to change your password on the first login.</td>
					  </tr>
					  <tr>
						<td colspan="2" ><p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  <p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.$company["ADM_Name"].'</p>
						  <p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.stripslashes($company["COM_Name"]).'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';			
						
						
						
						

	$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];

	//echo $mail_mesg."<br>	";EXIT;

	$mail_to=$Email_Id;
	

	$mail_to	=	$Email_Id;
	
	//$mail_from='"thefirstventure"<info@corptne.com>';
	
	$mailfrom	=	"CorpTnE <notification@corptne.com>";

	$mail_from	=	$mailfrom;

	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From:'.$mail_from;
	
	SendPHPMailer($toEmail, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($toEmail,$mail_sub,$mail_mesg,$headers);

}




function companyAdminLoginDetails($id, $pwd)
{
	
	$filename="mailnotification.php";
	
	if($seladmin=select_query("admin adm, company com", "*", "adm.ADM_Id='$id' AND adm.COM_Id=com.COM_Id", $filename))
	{
					
		$mail_sub="CorpTnE LOGIN DETAILS";
		
		
		
	
		$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;"><img src="'.$GLOBALS['domain'].'admin/'.$seladmin["COM_Logo"].'"></td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi  '.$seladmin[ADM_Name].',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">Your Profile has been successfully created in the CorpTnE Travel Expense Management System. </p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>User name &amp; password for CorpTnE are as follows, </p></td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle" >Username</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$seladmin['ADM_Username'].'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Password</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$pwd.'</td>
							</tr>
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: We recommended you to change your password on the first login.</td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">CorpTnE</p>
						  	</td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
		
		
		
			
		
		$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];
	
					
		//echo $mail_mesg;exit;
		
		$mail_to	=	$seladmin['ADM_Email'];

		$mail_from	=	"CorpTnE <notification@corptne.com>";
	
		$headers  	= 	'MIME-Version: 1.0' . "\r\n";
	
		$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		$headers 	.= 	'From:'.$mail_from;
		
		SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
	
		//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	}
	
	
	
}




// TRAVEL AGENT USER ASSIGN / RE ASSIGN COMPANY MAIL


function travelAgentUserAssignRe($supid, $comid, $type)
{
	
	$filename="mailnotification.php";
	
	
	
	// get superadmin details
		
	$seladmin=select_query("superadmin", "*", "SUP_Id='$supid' AND SUP_Type = 4 AND SUP_Status=1", $filename);
	
	
	// get company details
		
	$selsql = " SELECT * FROM company WHERE COM_Id IN ($comid) ";
	
	
		
	$result = rawSelectAllQuery($selsql, $filename, $show=false);
		
		
	
	if(!empty($seladmin) && !empty($result))
	{
		
	
		
						
						
						
						
						
				switch($type){
				
					case 1: // allocation
						$text='Please note that the following client has been assigned to you for servicing.';
						$text1='Please get in touch with the primary contact and introduce yourself. <br> Also offer any help or support with using the CorpTNE software until they are comfortable with it.';
						$mail_sub="CorpTnE - New Client being attached to you";
					break;
					
					case 2: // deallocation
					
						$values = array();
			
						
						foreach($result as $row)
						$values[] = '<i>'.$row['COM_Name'].'</i>';
						
						$companies = join(", ", $values);
						
					
						$text="Please note that ".$companies." will not be directly serviced by you from now on:<br>We have informed the client accordingly.";
						
						
						$mail_sub="CorpTnE - Change in client support";
						
					break;
				
				}
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi '.$seladmin['SUP_Name'].',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.'</p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top">
						<table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
						';
					  
					  
					  // SUP_Name
					  
					  
	 	if($type == 1){
	
			foreach($result as $row){
						  
				$mail_body.='
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle" >Company Name</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$row['COM_Name'].'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Contact Person</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$row['COM_Cp1username'].'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Contact No.</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$row['COM_Cp1mobile'].'</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Email Id</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$row['COM_Cp1email'].'</td>
							</tr>';
								
			}
		
		}
							
							
							$mail_body.='
							<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr>
						<td colspan="3" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>'.$text1.'</p></td>
					  </tr>';
							
							$mail_body.='<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">CorpTnE</p>
						  	</td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
		
		
		
			
		
		$mail_mesg=$GLOBALS['mail_header2'].$mail_body.$GLOBALS['mail_footer'];
	
					
		//echo $mail_mesg;exit;
		
		$mail_to	=	$seladmin['SUP_Email'];

		$mail_from	=	"CorpTnE <notification@corptne.com>";
	
		$headers  	= 	'MIME-Version: 1.0' . "\r\n";
	
		$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		$headers 	.= 	'From:'.$mail_from;
		
		SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
	
		//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	}
	
	
	
}


// TRAVEL AGENT / TRAVEL AGENT EMPLOYEE'S LOGIN MAILS


function travelAgentLoginDetails($id, $pwd, $type=false, $trvagntuser)
{
	
	$filename="mailnotification.php";
	
	if($type==1){
		
		$text='Your Profile has been successfully created in the CorpTnE Travel Expense Management System. ';
		$text1='User name &amp; password for CorpTnE are as follows, ';
		
	} else {
	
		$text="Your Profile has been updated by the admin";
		$text1='Username is given below.';
		
	}
	
	
	if($seladmin=select_query("superadmin", "*", "SUP_Id='$id' AND SUP_Type IN (3, 4) AND SUP_Status=1", $filename))
	{
					
		$mail_sub="CorpTnE Travel Agent Login Details";
		
		
		
	
		
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>Hi '.$seladmin['SUP_Name'].',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.'</p>
						  </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p>'.$text1.'</p></td>
					  </tr>
					  <tr>
						<td colspan="2" align="left" valign="top"><table width="86%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <th width="20%" align="left" valign="middle" scope="row">&nbsp;</th>
							  <td width="5%" align="left" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle" >Username</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$seladmin['SUP_Username'].'</td>
							</tr>';
							
							//if($type==1){
							
							$mail_body.='<tr style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">
							  <th align="left" valign="middle">Password</th>
							  <td align="center" valign="middle">:</td>
							  <td align="left" valign="middle" style="font-size:14px;font-family:segoe UI, Arial, Helvetica, sans-serif;">'.$pwd.'</td>
							</tr>';
							
							//}
							
							// put assigned companies here
							
							/*if($trvagntuser){
							
							
									$selassigndcompanies = "SELECT * FROM assign_company ac, company com WHERE ac.SUP_Id = $id and ac.COM_Id = com.COM_Id AND AC_Status = 1 and AC_Active = 1 AND COM_Status = 0";
									
									$result = rawSelectAllQuery($selassigndcompanies, $filename, $show=false);
									
									foreach($result as $row){
							
										$mail_body.='<tr>
										  <td align="left" valign="middle">Company Name</td>
										  <td align="center" valign="middle">:</td>
										  <td align="left" valign="middle">'.$row['COM_Name'].'</td>
										</tr>';				
								
									}
							}*/
							
							
							$mail_body.='<tr>
							  <th align="left" valign="middle">&nbsp;</th>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="left" valign="middle">&nbsp;</td>
							</tr>
							
							
						  </table></td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;" onmouseover="this.style.textDecoration=\'underline\'" onmouseout="this.style.textDecoration=\'none\'">Note: We recommended you to change your password on the first login.</td>
					  </tr>
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">CorpTnE</p>
						  	</td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
		
		
		
			
		
		$mail_mesg=$GLOBALS['mail_header'].$mail_body.$GLOBALS['mail_footer'];
	
					
		//echo $mail_mesg;exit;
		
		$mail_to	=	$seladmin['SUP_Email'];

		$mail_from	=	"CorpTnE <notification@corptne.com>";
	
		$headers  	= 	'MIME-Version: 1.0' . "\r\n";
	
		$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		$headers 	.= 	'From:'.$mail_from;
		
		SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
	
		//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	}
	
	
	
}



/*
////////////////////////////////////////////////
		EXPENSE REQUEST NOTIFICATION 
////////////////////////////////////////////////
*/

function notify($requestcode, $et, $type, $employee=false)
{
	global $compid; 
	
	global $filename;
	
	global $empuserid;
	
	if($employee)$empuserid=$employee;
	
	$selempid=$selsql	=	select_query("requests req, request_employee re", "re.EMP_Id", "REQ_Code='$requestcode' and req.REQ_Id=re.REQ_Id AND re.RE_Status=1 AND REQ_Active=1", $filename, 0);
	
	
	$empdetails=select_query("employees emp, company com", "*", "emp.EMP_Id='$selempid[EMP_Id]' AND emp.COM_Id=com.COM_Id", $filename);
	
	//echo 'Employee Code='.$empdetails[EMP_Code]; exit;

	
	switch($et)
	{
		
		case 1:
		$ettype="Pre Travel Expense Request";
		break;
		
		case 2:
		$ettype="Post Travel Expense Request";
		break;
		
		case 3:
		$ettype="General Expense Request";
		break;
		
		case 4:
		$ettype="Employee Group Travel Request";
		break;
		
		case 5:
		$ettype="Mileage Requests";
		break;
		
		case 6:
		$ettype="Utility Expense Requests";
		break;
		
	}
	
	
	$selrepmngrname	=	select_query("employees", "EMP_Name", "EMP_Code='$empdetails[EMP_Reprtnmngrcode]' AND EMP_Status=1", $filename);
	
	$totAmount		=	sum_query("requests req, request_details rd", "rd.RD_Cost", "req.REQ_Code='$requestcode' AND req.REQ_Id=rd.REQ_Id AND RD_Status=1 AND REQ_Active != 9 ", $filename, 0);
	
	$reqDetails="<BR><table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-size:12px;font-weight: bold;\">
				  <tr>
					<th width=\"35%\" height=\"30\" align=\"left\" valign=\"middle\" >Request Code</th>
					<td colspan=\"6\">:</td>
					<td width=\"60%\" height=\"30\" align=\"left\" valign=\"middle\">".$requestcode."</td>
				  </tr>
				  <tr>
					<th width=\"35%\" height=\"30\" align=\"left\" valign=\"middle\" >Expense Type</th>
					<td colspan=\"6\">:</td>
					<td width=\"60%\" align=\"left\" valign=\"middle\">".$ettype."</td>
				  </tr>
				  <tr>
					<th width=\"35%\" height=\"30\" align=\"left\" valign=\"middle\" >Created By</th>
					<td colspan=\"6\">:</td>
					<td width=\"60%\" align=\"left\" valign=\"middle\">".$empdetails['EMP_Name'].", ".$empdetails['EMP_Code']."</td>
				  </tr>
				  <tr>
					<th width=\"35%\" height=\"30\" align=\"left\" valign=\"middle\" >Reporting To</th>
					<td colspan=\"6\">:</td>
					<td width=\"60%\" align=\"left\" valign=\"middle\">".$empdetails['EMP_Reprtnmngrcode'].", ".$selrepmngrname['EMP_Name']."</td>
				  </tr>
				  <tr>
					<th width=\"35%\" height=\"30\" align=\"left\" valign=\"middle\" >Total Amount (Rs)</th>
					<td colspan=\"6\">:</td>
					<td width=\"60%\" align=\"left\" valign=\"middle\">".IND_money_format($totAmount).".00"."</td>
				  </tr>
				</table>";
	
	
	switch($type)
	{
		
		case 1: //mail to accounts
		$mailsub	=	$ettype;
		$name		=	"To Finance";
		$text		=	"The requested employee is the reporting manager itself.<br>Approval waiting from the Finance.";
		$text.=$reqDetails;
		break;
		
		
		case 2: //mail to reporting manager
		$mailsub	=	$ettype;
		$repmngr	=	select_query("employees", "*", "EMP_Code='$empdetails[EMP_Reprtnmngrcode]'", $filename);
		$mailto		=	$repmngr['EMP_Email'];
		$name		=	"Hi ".$repmngr['EMP_Name'];
		$text		=	"<br>You have an expense request waiting for your approval.<br>";
		$text.=$reqDetails;
		break;
		
		
		case 3: //mail to employee
		$mailsub	=	"Reporting Manager Approved";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request have been approved by your reporting manager & have been sent to finance for further verifications.";
		break;
		
		
		case 4: // mail to the finance 
		$mailsub	=	"Waiting for Finance approval";
		$name		=	"To Finance ";
		$text		=	"The above mentioned expense request has been approved by the reporting manager.<br>Awaiting approval from Finance.";
		$text.=$reqDetails;		
		break;
		
		
		case 5: // mail to employee
		$mailsub	=	"Reporting Manager Rejected";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request have been rejected by your reporting manager.<br>Please revise your expense request & submit later.";
		break;
		
		
		case 6: // mail to the employee 
		$mailsub	=	"Finance Approved";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request has been approved by the Finance.<br>";
		
		if($et==1)
		$text.="You are allowed to make the journey.";		
		
		break;
		
		
		case 7: // mail to the employee 
		$mailsub	=	"Finance Rejected";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename, 0);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request has been rejected by the Finance.<br>	You may please revise your request.";		
		break;
		
		
		case 8: // mail to the employee 
		$mailsub	=	"Finance Approved";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request has been approved by the Finance.<br>";
		
		if($et==1)
		$text.="You are allowed to make the journey.";
			
		break;
		
		
		case 9: // mail to the employee 
		$mailsub	=	"Finance Approved";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text="The above mentioned expense request have been approved by Finance & have been sent to your reporting manager for further verification.";
		break;
		
		
		//--------------------------------CLAIMS
		
		case 10: // mail to accounts
		$mailsub	=	"Claim Submitted, Waiting For Approval";
		$name		=	"To Finance ";
		$text		=	"The requested employee is the reporting manager itself.<br>Approval waiting from Finance.";
		break;
		
		
		case 11: // mail to rep manager
		$mailsub	=	"Claim Submitted, Waiting For Approval";
		$repmngr	=	select_query("employees", "*", "EMP_Code='$empdetails[EMP_Reprtnmngrcode]'", $filename);
		$mailto		=	$repmngr['EMP_Email'];
		$name		=	"Hi ".$repmngr['EMP_Name'];
		$text		=	"The above mentioned expense requested has been submitted for claim. <br> Waiting for claim approval.";
		break;
		
		
		case 12: // mail to accounts
		$mailsub	=	"Claim Updated, Waiting For Approval";
		$name		=	"To Finance ";
		$text		=	"The requested employee is the reporting manager itself.<br>Approval waiting from finance.";
		break;
		
		
		case 13: // mail to rep manager
		$mailsub	=	"Claim Updated, Waiting For Approval";
		$repmngr	=	select_query("employees", "*", "EMP_Code='$empdetails[EMP_Reprtnmngrcode]'", $filename);
		$mailto		=	$repmngr['EMP_Email'];
		$name		=	"Hi ".$repmngr['EMP_Name'];
		$text		=	"The above request has been updated for claim. <br> Waiting for claim approval.";
		break;
		
		
		case 14: // mail to accounts
		$mailsub	=	"Claim Approved By Reporting Manager";
		$name		=	"To Finance ";
		$text		=	"The request bills have been verified by the reporting manager and approved.<br>Approval waiting from Finance.";
		break;
		
		case 15: // mail to employee
		$mailsub	=	"Claim Approved By Reporting Manager";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request's claim have been approved by your reporting manager & have been sent to finance for further verifications.";
		break;
		
		
		case 16: // mail to employee
		$mailsub	=	"Claim Rejected By Reporting Manager";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request's claim have been rejected by your reporting manager.<br>Please revise your expense request's claim & submit later.";
		break;
		
		
		case 17: // mail to the employee 
		$mailsub	=	"Claim Approved By Finance";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request's claim has been approved by Finance.";		
		break;
		
		
		case 18: // mail to the employee 
		$mailsub	=	"Claim Rejected By Finance";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request's claim has been rejected by Finance.<br>You may please revise your request and submit later.";		
		break;
		//--------------------------------CLAIMS
		
		
		case 19: // mail to the employee (he is reporting manager himself)
		$mailsub	=	"Request Auto-Approved";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request's has been Auto-Approved.<br>";
		
		if($et==1)
		$text.="You are allowed to make the journey.";
		$text.=$reqDetails;
			
		break;
		
		
		case 20: //mail to finance
		$mailsub	=	$ettype;
		$name		=	"To Finance ";
		$text		=	"Expense request is waiting approval.";
		$text.=$reqDetails;
		break;
		
		
		case 21: // mail to finance
		$mailsub	=	$ettype;
		$name		=	"To Finance ";
		$text		=	"The above mentioned expense request is raised by the travel desk. Employee has put it for claim. Waiting for your approval";
		break;
		
		
		
		case 22: // mail to the employee 
		$mailsub	=	"Payment details updated by Finance";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		="The above mentioned expense request's payment details have been updated by the finance department. Please verify payment details";		
		break;
		
		case 23: // mail to the employee 
		$mailsub	=	"Payment details added by Finance";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request's payment details have been added by the finance department. Please verify payment details";		
		break;
		
		
		case 24: //mail to employee (travel desk raised & normal)
		$mailsub	=	"Reporting Manager Approved";
		$employee	=	select_query("requests req, request_employee re, employees emp", "*", "req.REQ_Code='$requestcode' AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", $filename);
		$mailto		=	$employee['EMP_Email'];
		$name		=	"Hi ".$employee['EMP_Name'];
		$text		=	"The above mentioned expense request have been approved by your reporting manager. You can make your journey";
		break;
		
		case 25: //mail to employee (travel desk raised request)
		$mailsub	=	"Reporting Manager Approved";
		$name		=	"To Travel Desk";
		$text		=	"The above mentioned expense request have been approved by reporting manager. ";
		break;
		
	
	}
	
	
		
	$mail_sub=stripslashes($empdetails['COM_Name'])." [ ".$mailsub." ]";

	
	
	$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;"><img src="'.$GLOBALS['domain'].'admin/'.$empdetails["COM_Logo"].'"></td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" colspan="3" style="font-size:16px;font-weight: bold;" align="center"><u>'.$mailsub.'</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td  align="left" colspan="3" style="font-size:14px;font-weight: bold;" align="center"><u>Request Code: '.$requestcode.'</u></td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p>'.$name.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.' </p>
						 </td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	<!--<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</p>-->
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.stripslashes($empdetails["COM_Name"]).'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
					
			
	
	$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];

	
	
	//echo $mail_mesg."<br>"; exit;
	
		//echo 'Mailto='.$mailto; exit;
	
	
	
	
	switch($type)
	{
		
		case 1:case 4: case 10: case 14: case 20: case 21: // MAIL TO THE FINANCE APPROVERS
			
			$selacc=select_all("employees", "*", "COM_Id='$compid' AND EMP_AccountsApprover=1 AND EMP_Id != '$empuserid' AND EMP_Access=1", $filename, 0);
			
			foreach($selacc as $rowsql){
			
				$mail_to	=	$rowsql['EMP_Email'];
		
				//$mail_from	=	stripslashes($empdetails['COM_Name'])."<".$empdetails['COM_Email'].">";
				
				$mail_from	=	"CorpTnE <notification@corptne.com>";
			
				$headers  	= 	'MIME-Version: 1.0' . "\r\n";
			
				$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
				$headers 	.= 	'From:'.$mail_from;
				
				SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
			
				//mail($mail_to,$mail_sub,$mail_mesg,$headers);
			}
		
		break;
		
		
		case 25:
		
			
		
			$selacc=select_all("travel_desk", "TD_Email", "COM_Id='$compid' AND TD_Status=1", $filename, 0);
			
			//echo $empdetails['COM_Name']; exit;
			
			foreach($selacc as $rowsql){
			
				$mail_to	=	$rowsql['TD_Email'];
		
				$mail_from	=	"CorpTnE <notification@corptne.com>";
			
				$headers  	= 	'MIME-Version: 1.0' . "\r\n";
			
				$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
				$headers 	.= 	'From:'.$mail_from;
				
				SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
			
				//mail($mail_to,$mail_sub,$mail_mesg,$headers);
			}
		
		break;
		
		
		
		default:
		
			$mail_to	=	$mailto;
		
			$mail_from	=	"CorpTnE <notification@corptne.com>";
		
			$headers  	= 	'MIME-Version: 1.0' . "\r\n";
		
			$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
			$headers 	.= 	'From:'.$mail_from;
			
			SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);
		
			//mail($mail_to,$mail_sub,$mail_mesg,$headers);
		
			
		
		
	}
	
	
	
}


/*

	BOOKING DETAILS & CANCELLATION DETAILS

*/



function travelBooking($message_body, $type, $status=1){
	

		global $compid;
		
		switch ($type){
		
			case 1:
			$mail_sub='Request For Booking Tickets';
			break;
			
			case 2:
			$mail_sub='Cancellation of Tickets [Employee opted for Self Booking]';
			break;
			
			case 3:
			$mail_sub='Cancellation of Tickets';
			break;
			
			case 4:
			$mail_sub='Payment Details Updated';
			break;
			
			case 5:
			$mail_sub='Payment Details Added';
			break;
			
			case 6:
			$mail_sub='Claim Approved By Finance Department';
			break;
			
			case 7:
			$mail_sub='Claim Rejected By Finance Department';
			break;
			
			case 8:
			$mail_sub='Cancellation After Booking Request';
			break;
			
			case 9:
			$mail_sub='Group Booking Employee Removed Cancellation Request';
			break;
		
		}
		
		$mail_sub = "CorpTnE - ".$mail_sub;
		
		
		switch($status){
		
			case 1:
				
				// mail to travel desk for ticket booking only		
		
				$selacc=select_all("travel_desk td, company co", "*", "td.COM_Id=co.COM_Id AND td.COM_Id='$compid' AND td.TD_Status=1", $filename);			
				
				
				foreach($selacc as $rowsql){
				
					$mail_to	=	$rowsql['TD_Email'];
			
					$mail_from	=	"CorpTnE <notification@corptne.com>";
				
					$headers  	= 	'MIME-Version: 1.0' . "\r\n";
				
					$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
					$headers 	.= 	'From:'.$mail_from;
					
					SendPHPMailer($mail_to, $toname=false, $mail_sub, $message_body, $headers);
				
					//mail($mail_to, $mail_sub, $message_body, $headers);
				}	
			
			break;
			
			
			case 2:
				
				// mail to travel agent user for ticket booking only		
							
				$selacc=select_all("assign_company ac, superadmin sup", "sup.SUP_Email, sup.SUP_Name", "ac.COM_Id = $compid and ac.SUP_Id = sup.SUP_Id AND AC_Active = 1 AND AC_Status = 1 AND SUP_Status = 1 AND SUP_Type = 4 AND SUP_Access = 1", $filename);		
				
				
				foreach($selacc as $rowsql){
				
					$mail_to	=	$rowsql['SUP_Email'];
					
					$toname		=	$rowsql['SUP_Name'];
					
			
					$mail_from	=	"CorpTnE <notification@corptne.com>";
				
					$headers  	= 	'MIME-Version: 1.0' . "\r\n";
				
					$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
					$headers 	.= 	'From:'.$mail_from;
					
					SendPHPMailer($mail_to, $toname, $mail_sub, $message_body, $headers);
				
					//mail($mail_to, $mail_sub, $message_body, $headers);
				}	
				
			break;
		}
		
		
}


/*

	---------- BOOKING STATUS ---------------------

*/


function travelDeskToEmpNotify($rdid, $bookingStatusVal, $type = false, $compid = false){

	if(!$compid)
	global $compid;
	
	
	$empDetails=select_query("employees emp, requests req, request_employee re, request_details rd, company com", 
	"com.COM_Name, com.COM_Logo, com.COM_Email, req.REQ_Type, req.REQ_Code, emp.EMP_Name, emp.EMP_Email, req.REQ_Code, req.REQ_Type", 
	"rd.RD_Id='$rdid' AND req.COM_Id='$compid' AND req.COM_Id=com.COM_Id AND 
	 rd.REQ_Id=req.REQ_Id AND req.REQ_Id=re.REQ_Id AND re.EMP_Id=emp.EMP_Id AND RE_Status=1", 
	$filename);
	
	
	switch($type){
		
		case 1:
			$mail_sub=stripslashes($empDetails['COM_Name'])." [ Travel Agent Booking Confirmation ]";
						
			$addressedTo = ' To Travel Desk';
			
			$mail_to	=	$empDetails['COM_Email'];
			
		break;
		
		default:
			$mail_sub=stripslashes($empDetails['COM_Name'])." [ Travel Desk Booking Confirmation ]";
			
			$addressedTo = 'Hi '.$empDetails['EMP_Name'];
			
			$mail_to	=	$empDetails['EMP_Email'];
			
			
	
	}




	switch ($bookingStatusVal){
	
		case 2:
		$text="The above mentioned tickets have been booked successfully, booked amount and tickets are uploaded.";
		break;
		
		case 3:
		$text="The above mentioned tickets has been failed to book by the travel desk, please arrange some other mode";
		break;
		
		case 4:
		$text="The above mentioned tickets has been cancelled by the travel desk as per employee's request. Cancellation charges applicable.";
		break;
		
		case 5:
		$text="The above mentioned tickets has been cancelled by the travel desk as per employee's request.";
		break;
		
		case 6:
		$text="The above mentioned tickets has been cancelled by the travel desk. Cancellation charges applicable.";
		break;
		
		case 7:
		$text="The above mentioned tickets has been cancelled by the travel desk.";
		break;
	
	
	}


	$compLogo = '&nbsp;';
	
	if($empDetails["COM_Logo"])
	$compLogo = '<img src="'.$GLOBALS['domain'].'admin/'.$empDetails["COM_Logo"].'">';

	
	
	$mail_header='<table  border="0" align="center" cellpadding="0" cellspacing="0"  style="color: #373737;font-family:segoe UI, Arial, Helvetica, sans-serif;">
					  <tr>
						<td height="10">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="3%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_01.gif" width="17" height="104"></td>
							  <td width="25%" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif"><a href="'.$GLOBALS['domain'].'"><img src="'.$GLOBALS['assetimgpath'].'logo_invice.png" ></a></td>
							  <td width="68%" align="center" valign="middle" background="'.$GLOBALS['assetimgpath'].'BusinessSimple_08.gif" style="font-size:24px;color:#443A8F;padding-left:9px;background-repeat: repeat-x;line-height: 98px;height: 98px;">
							  '.$compLogo.'</td>
							  <td width="4%"><img src="'.$GLOBALS['assetimgpath'].'BusinessSimple_03.gif" width="27" height="104"></td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="1"></td>
					  </tr>
					  <tr>
						<td align="left" valign="top" bgcolor="#FAFAFA">&nbsp;</td>
					  </tr>
					  <tr>
    					<td align="left" valign="top">';
						
						
					
						
						
		$mail_body='<table width="700"  height="324" border="0" cellpadding="0" cellspacing="0" style=" border:1px; border-radius:25px;">
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td   colspan="3" style="font-size:16px;font-weight: bold;" align="center">'.$mailsub.'</td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td   colspan="3" style="font-size:14px;font-weight: bold;" align="center">Request Code: '.$empDetails['REQ_Code'].'</td>
				</tr>
				<tr>
				  <td   colspan="3">&nbsp;</td>
				</tr>
				<tr>
				  <td height="298" ></td>
				  <td valign="top" ><table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" >
					  <tr>
						<td width="84%" style="font-size:14px;letter-spacing:1px;"><p> '.$addressedTo.',<br>
						  </p></td>
						<td width="16%" style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;"><p align="justify">'.$text.' </p></td>
					  </tr>
					  <tr>
					  	<td align="center" valign="top">';
					  
					$mail_body.=' 
					<table width="120%" border="1" cellspacing="0" cellpadding="4" bgcolor="#FFFFFF" style="color:#333333;font-size:11px;  border-collapse:collapse;">
					  <tr height="30" bgcolor="lightyellow">
						<th>Date</th>
						<th>Expense Description</th>
						<th colspan="2">Expense Category</th>
						<th width="10%">Place</th>
						<th width="5%">Estimated Cost</th>
						<th>Booking Status</th>
					  </tr>';
  
  
  
		  $selsql=select_query("request_details rd, expense_category ec, mode mot, booking_status bs, booking_actions ba", 
		  
		  "RD_Dateoftravel, RD_Description, EC_Name, MOD_Name, rd.EC_Id, RD_Cityfrom, RD_Cityto, RD_Cost, RD_TotalCost, BA_Name, BS_TicketAmnt, BA_ActionDate, BS_CancellationAmnt", 
		  
		  "
			  rd.RD_Id='$rdid' AND 
			  rd.EC_Id=ec.EC_Id AND 
			  rd.MOD_Id=mot.MOD_Id AND 
			  rd.RD_Id=bs.RD_Id AND 
			  (bs.BS_Status=1 AND bs.BA_Id=2) AND 
			  bs.BA_Id=ba.BA_Id AND 
			  BS_Active=1 AND rd.RD_Status=1 O
			  RDER BY rd.RD_Id ASC 
		  
		  ", $filename,0);
  
  
// 
 
  
  $mail_body.='
	  <tr style="">
		<td align="center">'.date('d-M-Y',strtotime($selsql['RD_Dateoftravel'])).'</td>
		<td><div style="height:40px; overflow-y:auto;">'.stripslashes($selsql['RD_Description']).'</div></td>
		<td>'.$selsql['EC_Name'].'</td>
		<td>'.$selsql['MOD_Name'].'</td>
		<td style="font-size:11px;">'; 
	
	if($selsql['EC_Id']==1) {
		$mail_body.='<b>From:</b> '.$selsql['RD_Cityfrom'].'<br />
		<b>To:</b> '.$selsql['RD_Cityto'];
	} else {
	
		$mail_body.='<b>Loc:</b> '. $selsql['RD_Cityfrom']; 
		
		if ($rowsd=select_query("stay_duration", "SD_Name", "SD_Id='$selsql[SD_Id]'", $filename)) {
			$mail_body.= '<br>Stay :'.$rowsd['SD_Name'];	
		}
				
	}
	
	switch($empDetails['REQ_Type']){
	
		case 2:
			$mail_body.='</td><td align="right">'.IND_money_format($selsql['RD_Cost']).'.00</td>';
		break;
		
		case 4:
			$mail_body.='</td><td align="right">'.IND_money_format($selsql['RD_TotalCost']).'.00</td>';
		break;
		
	}
	
	
	
	
	//
	
	switch ($bookingStatusVal){

		case 2:
			
			$mail_body.='
				<td><b>Booking Status: </b>'.$selsql['BA_Name'].'<br>
				<b>Booked Amnt: </b>'.IND_money_format($selsql['BS_TicketAmnt']).'<br>
				<b>Booked Date: </b>'.date('d-M-y (h:i a)', strtotime($selsql['BA_ActionDate'])).'</td>				
			</table>';
		
		break;
		
		case 3:
			$mail_body.='
				<td><b>Failed Date: </b>'.date('d-M-y (h:i a)', strtotime($selsql['BA_ActionDate'])).'</td>				
			</table>';
		break;
		
		case 4:
			
			$mail_body.='
				<td><b>Cancellation Status: </b>'.$selsql['BA_Name'].'<br>
				<b>Cancellation Charges: </b>'.IND_money_format($selsql['BS_CancellationAmnt']).'<br>
				<b>Cancellation Date: </b>'.date('d-M-y (h:i a)', strtotime($selsql['BA_ActionDate'])).'</td>				
			</table>';
		
		break;
		
		case 5:
			$mail_body.='
				<td><b>Cancellation Status: </b>'.$selsql['BA_Name'].'<br>
				<b>Cancellation Date: </b>'.date('d-M-y (h:i a)', strtotime($selsql['BA_ActionDate'])).'</td>				
			</table>';
		break;
		
		
		
		case 6:
			
			$mail_body.='
				<td><b>Cancellation Status: </b>'.$selsql['BA_Name'].'<br>
				<b>Cancellation Charges: </b>'.IND_money_format($selsql['BS_CancellationAmnt']).'<br>
				<b>Cancellation Date: </b>'.date('d-M-y (h:i a)', strtotime($selsql['BA_ActionDate'])).'</td>				
			</table>';
		
		break;
		
		case 7:
			$mail_body.='
				<td><b>Cancellation Status: </b>'.$selsql['BA_Name'].'<br>
				<b>Cancellation Date: </b>'.date('d-M-y (h:i a)', strtotime($selsql['BA_ActionDate'])).'</td>				
			</table>';
		break;
	
	
	}
	

						 
				$mail_body.=						  
						  '
						  </td></tr>
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif;font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Click here to <a href="'.$GLOBALS['domain'].'" >Login</a> to your Profile</td>
					  </tr>
					  
					  <tr>
						<td colspan="2" style="font-family:segoe UI, Arial, Helvetica, sans-serif; font-weight:bold; font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">&nbsp;</td>
					  </tr>
					  
					 
					  <tr>
						<td colspan="2">
							<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">Thank you,</p>
						  	 
						  	<p style="font-size:12px;line-height:14px;	letter-spacing:0.6px;padding-top: 5px;padding-bottom: 5px;">'.stripslashes($empDetails["COM_Name"]).'</p></td>
					  </tr>
					</table></td>
				  <td ></td>
				</tr>
			  </table>';
	
	
					
			
	
	$mail_mesg=$mail_header.$mail_body.$GLOBALS['mail_footer'];
	
	//echo $mail_mesg; exit;	
	
	
	
	
	
	
	
	$mail_from	=	"CorpTnE <notification@corptne.com>";

	$headers  	= 	'MIME-Version: 1.0' . "\r\n";

	$headers 	.= 	'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers 	.= 	'From:'.$mail_from;
	
	SendPHPMailer($mail_to, $toname=false, $mail_sub, $mail_mesg, $headers);

	//mail($mail_to, $mail_sub, $mail_mesg, $headers);
	
}	



?>
