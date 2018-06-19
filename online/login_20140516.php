<!--// - login.php version 1.0-->

<?php
 require_once('include/functions.php');
// require_once "includes/header_login.php";
 @$option = ($_REQUEST['option']) ? $_REQUEST['option'] : 'form';
 switch($option){
  case 'form':
   print form();
  break;
  case 'login':
   print login();
  break; 
	case 'forgot':
   print forgotPrompt();
  break;
	case 'request':
   print requestPassword($date,$time); 
  break; 	 
  case 'logout':{
   echo "<div width='100%' align='center'> </br>You have been logged out<br>";
   echo "<a class='link' href='login.php'> Click HERE to login again</a> </div>";
   }
 }
 

function form($msg = ''){

@$goto = $_REQUEST['goto'];
 $string = "<center>
 			<div style='width:100%;'>
				<div align='center'>
				
					
						<form method='post' action='online/login.php?option=login&goto=$goto'>
  							<table align='center' border='0' width=''>
   								<tr>
									<td align='center' colspan='100%' nowrap>
										<strong><font color='red'>$msg</font></strong>
									</td>
								</tr>
   								<tr>
									<td align='center'><label> Username: </label></td>
									<td><input type='text' class='input' name='userLoginName'></td>
								</tr>
   								<tr>
									<td align='center'><label> Password: </label> </td>
									<td><input class='input' type='password' name='userLoginPassword'></td>
								</tr>
   								<tr>
									<td></td>
									<td><br />
										<input type='button' onclick='checkLoginForm(this.form);' class='button' value='Login'>
									</td>
								</tr>
   								<tr>
									<td align='center' nowrap colspan='100%'><br />
										<!--<a class='link' href='login.php?option=forgot'>Forgot password</a>&nbsp;&nbsp;|&nbsp;&nbsp;
										 <a class='link' href='login.php?register'>Register</a> --> </td>
								</tr>
   							</table>
						</form>
					</center>
				</div>
			</div>";

	$string.="	<SCRIPT>
				function checkLoginForm(Frm){
					if(Frm.userLoginName.value.length<=5){
						alert('Login name must be at least six characters');
						Frm.userLoginName.focus(); 
						return false;
					}
					if(Frm.userLoginPassword.value.length<=5){
						alert('Password must be at least six characters');
						Frm.userLoginPassword.focus(); 
						return false;
					}
					Frm.submit();
				}
				</SCRIPT>";
return $string;
}
 
function forgotPrompt($msg = ''){
	  
  $string = "<div style='width:100%;'><center><strong><font color='red'>$msg</font></strong>
  				<div align='center'> <h1>Request password</h1>
 					<form method='post' action='login.php?option=request'>
  						<table class='loginform' align='center' width='500px' border='1'>
  							<tr>
								<td align='center'></td>
							</tr>
  							<tr>
								<td align='center'>Email address&nbsp;&nbsp;
									<input name='userEmail' id='userEmail' size='18'>
								</td>
							</tr>
  							<tr>
								<td align='center'>
									<input type='button' onclick='checkEmail(this.form)' class='button2' value='Reset password'>
								</td>
							</tr>
  							<tr>
								<td nowrap align='center'>
									<a class='link' href='login.php'>Return to login</a>
									&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
							</tr>
  						</table>
					</form>
				</center>
			</div>
				
			<script>
				function checkEmail(frm){
					var str=frm.userEmail.value;
					 if(str == '')
					 {
						 alert('Email address can not be empty');
						 frm.userEmail.focus(); return false; 
					 }
	 				
	 				var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;   
					 if(emailPattern.test(str))
					 {} 
					 else{
						alert('Invalid email address format');
					 }
				frm.submit();
				}
			</script>";
return $string; 
}
 
function requestPassword($date,$time){ //30bb51
	
	
	
	
	require_once('../include/db_access.php');
  	$dbObject = new dbObject(); 
	
	$sql = "SELECT * FROM users WHERE userEmail='".$_REQUEST['userEmail']."';";
	$result = $dbObject->dbQuery($sql);
	
	
	if(mysql_num_rows($result) >= 1){ //valid email address
		$len = rand(6,9);	 
	 	$row = $dbObject->dbNextRecord($result);
		$now = md5(date('sihmydj'));
	 	$newPass = substr($now, 0, $len); 	 
	 	
		$update = "UPDATE users SET `userLoginPassword`=md5('".mysql_real_escape_string($newPass)."')
	  				WHERE userId='".mysql_real_escape_string($row['userId'])."' LIMIT 1;";
	 	
		$body = "Dear ".$row['userFirstName']."<BR/>Your new password is ' <b>".$newPass."</b> '";
	 	$headers  = 'MIME-Version: 1.0' . "\r\n";
	 	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 	$headers .= "From: ITNT Support<support@itnt.co.za>" . "\r\n";
	 		
		mail($_REQUEST['userEmail'], 'New Sports Call password', $body, $headers,'-fsupport@itnt.co.za') 
	 		or die(form('Password could not be reseted, please try again later'));		 
   
   		$dbObject->dbQuery($update);
		
		//log the event
		$event="request for Password";
		$log="INSERT INTO time_control
						(date,time,userId,event) 
						VALUES
						('".mysql_real_escape_string($date)."',	
						 '".mysql_real_escape_string($time)."',			
						 '".mysql_real_escape_string($row['userId'])."',
						 '".mysql_real_escape_string($event)."') ";
		$logEvent=$dbObject->dbQuery($log);			
   		
		return  form('Password has been reset, check your email for new one');
	}
	else{ // invalid email
		return forgotPrompt('Specified email does not exist.');
	}
}
 
 function login(){
 
 error_reporting(E_ALL);
ini_set('display_errors', '1');
 
 date_default_timezone_set('Africa/Johannesburg');
 $now = time('H:i');
 $day=date('w');

//	$now = "12:11";
// 	$day="6";
 
 	require_once('include/db_access.php');
  	$dbObject = new dbObject();
  	$dbObject->dbConnect();
  	
	$invalidChars = array("'",'"','-','=');
  	
	foreach($invalidChars as $i => $chars){
    	$error = stripos($_REQUEST['userLoginPassword'], $chars); 
		if($error !== false){
     		return form('Invalid character in password');
		}
	
		$error = stripos($_REQUEST['userLoginName'], $chars); 
	
		if($error !== false){
    		return form('Invalid character in username');
		}
 	} 

	$sql = "SELECT * FROM users	u
			LEFT JOIN jobinfoweb j ON(j.Customer=u.customer) 
    		WHERE loginName ='".$_REQUEST['userLoginName']."' 
			AND loginPassword ='".$_REQUEST['userLoginPassword']."'
			";
	//debug($sql);		 
  	$result = $dbObject->dbQuery($sql);
  	echo $noOfUsers = mysql_num_rows($result);
  	
	//print "[ $noOfUsers ]";
  	
	if($noOfUsers > 0){//login pass
   		$row = $dbObject->dbNextRecord($result);	 
		
			//switch($row['usr_Status']){
		  // 		case '1': return form('log in failed: account has not been activated by the administrator'); break;
		  // 		case '2': return form('log in failed: account suspended by the administrator'); break;
		 //  		case '3': return form('log in failed: account closed by the administrator'); break;
		 //  		case '4': continue; break; //active account
		//		default:
		//			case 1: return form('log in failed: inactive account'); break;
		//		break;
		//	}
   		session_start();
	   	$_SESSION['userId'] 		= $row['userId']; 
		
		if($row['userLimit']>0){$_SESSION['adminId'] = $row['userId']; }
	   
	   	$_SESSION['name'] 		= $row['CustomerName']; 
	   	//$_SESSION['userEmail'] 		= $row['userEmail']; 	 
	  	//$_SESSION['userCellphone'] 	= $row['userCellphone']; 
		//$_SESSION['role'] = $row['usr_Role'];
	   	$sql = "UPDATE users SET userLastLogin=now(),userNoLogins='".mysql_real_escape_string($row['userNoLogins']+1)."'  
				WHERE `loginName`='".mysql_real_escape_string($_REQUEST['userLoginName'])."' ";
	 	
		$result = $dbObject->dbQuery($sql);
		
		//Log event
		$event="User Logged in";
		$log="INSERT INTO time_control
						(date,time,userId,event) 
						VALUES
						('".mysql_real_escape_string(date("Y-m-d"))."',	
						 '".mysql_real_escape_string(date("H:i:s"))."',			
						 '".mysql_real_escape_string($row['userId'])."',
						 '".mysql_real_escape_string($event)."'
						 )";
		$logEvent=$dbObject->dbQuery($log);	
		
	
		echo "<script> alert('Welcome'); </script>";
		redirect("../dashboard.php");
		//exit();
		
  }
  else{
  		echo "<script> alert('Incorrect Login'); </script>";
		redirect("../onlinejobtracking.php");
  		/*$sql = "INSERT INTO incorrectLogin (userName,password,dateTime)
					VALUES ('".$_REQUEST['userLoginName']."','".$_REQUEST['userLoginPassword']."',NOW() )";
			 
  		$result = $dbObject->dbQuery($sql);
		
  		return form('log in failed: invalid username / password');*/
		
  }  
 }
// require_once "includes/footer.php";
//echo $date;
?>
