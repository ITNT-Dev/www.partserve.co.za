<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account Profile</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<? include "include/header.php" ?>
<table summary="content" width="965" cellpadding="0" cellspacing="0">
  <tr><td width="31" class="title" headers="nameofpage"><img src="../images/titlebg_left.jpg" width="31" height="56" /></td>
<td  class="titletext" nowrap="nowrap">Account Profile Page</td>
<td width="38"><img src="../images/titlebg_right.jpg" width="38" height="56" /></td>
<td width="573" class="titleline">&nbsp;</td></td><td width="13"><a href="../contactus.php"><img src="../images/titleend_line.jpg" width="154" height="56" /></a></td>
</tr>
</table>

<tr>
<td><a href="account_profile.php">Go back</a>

<?php 
require_once('include/functions.php');
if(!isOnLine() )
redirect ("login.php");
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_POST['update']) ){
	require_once("../newlib/index.php");
	require_once('include/functions.php');
	$dbObject = new dbObject();
	$dbObject->dbConnect(); 
		
		@extract($_POST);
		$sql="UPDATE jobinfoweb 
				SET
					SalesContactName='".mysql_escape_string($SalesContactName)."',
					SalesContactEmail='".mysql_escape_string($SalesContactEmail)."',
					SalesContactTel='".mysql_escape_string($SalesContactTel)."',
					SalesContactCell='".mysql_escape_string($SalesContactCell)."'
				WHERE 
					customer='".mysql_escape_string($customer)."'
				";
				
		$db = IOC::make('database', array());
		$results = $db->make_query($sql);
		if ($results){
		
		
		  $body = "<BR/>Please See user details Changed Request<br/><br/>
					<table>
						<tr>
							<td>Customer:</td>
							<td>'".$Customer."'- </td>
							<td>'".$CustomerName."'</td>
						</tr>
						<tr>
							<td>Requests the following details to be changed:</td>
							
						</tr>
						<tr>
							<td>Sales Contact:</td>
							<td>".$SalesContactName."</td>
						</tr>
						<tr>
							<td>Sales Email:</td>
							<td>".$SalesContactEmail."</td>
						</tr>
						<tr>
							<td>Sales Tel:</td>
							<td>".$SalesContactTel."</td>
						</tr>
						<tr>
							<td>Sales Cell:</td>
							<td>".$SalesContactCell."</td>
						</tr>";
			  
		  $body .="	<tr>
						<td><br><br><br>Regards<br>Partserve Online</td>
					</tr>
				</table>";
		  
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  $headers .= "From: ITNT<support@itnt.co.za>" . "\r\n";
		  
		  $firstMail='csteam@partserve.co.za';

		  mail($firstMail, 'User Details update request', $body, $headers,'-fsupport@itnt.co.za');
		redirect("account_profile.php","Sales Details Edited");
		}

}

function accountDetails(){
	$user = $_SESSION['userId']; //get the user id from the session
	require_once("../newlib/index.php");
		
	$sql="SELECT *
			FROM users u
			LEFT JOIN jobinfoweb j ON ( u.customer = j.customer )
			WHERE userId ='".$user."' ";
	$db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($sql);
		foreach ($datad as $row)
		{
	@extract($row);//extract all columns as variables
	
	$string = " <div >
						<form method='POST'>
							<div>
								<br>
								<table >
									<tr>
										<td colspan='2'>
										<h3>Sales Information</h3>
										</td>
									</tr>
									<tr>
										<td align='right'>
											<input name='Customer' type='hidden' value='".$Customer."' />
											<input name='CustomerName' type='hidden' value='".$CustomerName."' />
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Contact:&nbsp</strong>
										</td>
										<td align='right'>
											<input name='SalesContactName' type='text' value='".$SalesContactName."' />											
										</td>
									</tr>
									<tr>
										<td align='left' width=''>
											<strong>Email:&nbsp</strong>
										</td>
										<td align='right'>
											<input name='SalesContactEmail' type='text' value='".$SalesContactEmail."' />
											
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Tel:&nbsp</strong>
										</td>
										<td align='right'>
											<input name='SalesContactTel' type='text' value='".$SalesContactTel."' />
											
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Cell:&nbsp</strong>
										</td>
										<td align='right'>
											<input name='SalesContactCell' type='text' value='".$SalesContactCell."' />
											
										</td>
									</tr>
									<tr>
										<td></td>
										<td align='right'><input type='button' onclick='checkForm(this.form)' value='Update'/></td>
										<td align='right'><input name='update' type='hidden'  /></td>
									</tr>
							</div>	
							
								<br>
							</form>
							
							<SCRIPT>
								
								function checkForm(Frm){
							   
								if(Frm.SalesContactName.value.length == 0){
									alert('Contact cannot be empty');
									Frm.SalesContactName.focus(); return false;
								}
								
								if(Frm.SalesContactEmail.value.length == 0){
									alert('Email cannot be empty');
									Frm.SalesContactEmail.focus(); return false;
								}
								 var str=Frm.SalesContactEmail.value;
								 var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;   
								 
								 if(emailPattern.test(str)) {} 
								 else
								 {
									 alert('Invalid email address format');
									 Frm.SalesContactEmail.focus(); return false;
								 }	 
									
												
								if(Frm.SalesContactTel.value.length == 0){
									alert('Tel cannot be empty');
									Frm.SalesContactTel.focus(); return false;
								}
								
								if(Frm.SalesContactCell.value.length ==0){
									alert('Cell cannot be empty');
									Frm.SalesContactCell.focus(); return false;
								}
								
															
									var sText=Frm.SalesContactCell.value;
									var ValidChars = '0123456789';
									var IsNumber=true;
									var Char;       
									for (i = 0; i < sText.length && IsNumber == true; i++){
											Char = sText.charAt(i);
										   if (ValidChars.indexOf(Char) == -1){
												alert('Please enter the cell number in this following format: 0821234567');
												Frm.SalesContactCell.focus(); return false;
										   }
									 } 
								Frm.submit();
								}
							</SCRIPT>
					</div>";
return $string;
}
print accountDetails();

include "include/footer.php"

?>

</body>
</html>
