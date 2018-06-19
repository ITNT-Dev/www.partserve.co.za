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
if (isset($_SESSION['userId'])) die("<script>location.href='dashboard.php';</script>");
@$goto = $_REQUEST['goto'];
 $string = "<center>
 			<div style='width:100%;'>
				<div align='center'>
				
					
						<form method='post' action='online/login.php?option=login&goto=".$goto."'>
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
	
	
	
	
	require_once("../newlib/index.php");
  	$dbObject = new dbObject(); 
	
	$sql = "SELECT * FROM users WHERE userEmail='".$_REQUEST['userEmail']."';";
	$db = IOC::make('database', array());
	list($affect_rows, $data) = $db->selectquerys($sql);
	
	
	if($affect_rows >= 1){ //valid email address
		$row = $data[0];
		$len = rand(6,9);	 
		$now = md5(date('sihmydj'));
	 	$newPass = substr($now, 0, $len); 	 
	 	
		$update = "UPDATE users SET `userLoginPassword`=md5('".mysql_real_escape_string($newPass)."')
	  				WHERE userId='".$row['userId']."' LIMIT 1;";
					$db = IOC::make('database', array());
	 	                       $db->make_query($update );
				       
		$body = "Dear ".$row['userFirstName']."<BR/>Your new password is ' <b>".$newPass."</b> '";
	 	$headers  = 'MIME-Version: 1.0' . "\r\n";
	 	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 	$headers .= "From: ITNT Support<support@itnt.co.za>" . "\r\n";
	 		
		mail($_REQUEST['userEmail'], 'New Sports Call password', $body, $headers,'-fsupport@itnt.co.za') 
	 		or die(form('Password could not be reseted, please try again later'));		 
   
   		
		
		//log the event
		$event="request for Password";
		$log="INSERT INTO time_control
						(date,time,userId,event) 
						VALUES
						('".$date."',	
						 '".$time."',			
						 '".$row['userId']."',
						 '".$event."') ";
						 $db = IOC::make('database', array());
	 	                       $db->make_query($log);			
   		
		return  form('Password has been reset, check your email for new one');
	}
	else{ // invalid email
		return forgotPrompt('Specified email does not exist.');
	}
}
 
 function login()
 {
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
 
    date_default_timezone_set('Africa/Johannesburg');
    $now = time('H:i');
    $day=date('w');
 
 	require_once(dirname(__FILE__).'/../config/config.inc.php');
  	require_once("../newlib/index.php");
  	
	$invalidChars = array("'",'"','-','=');
  	
	/*
	foreach($invalidChars as $i => $chars)
    {
    	$error = stripos($_REQUEST['userLoginPassword'], $chars); 
		if($error !== false)
        {
     		return form('Invalid character in password');
		}
	
		$error = stripos($_REQUEST['userLoginName'], $chars); 
	
		if($error !== false)
        {
    		return form('Invalid character in username');
		}
 	}
	*/
	

	$sql = "SELECT * FROM users WHERE loginName ='".$_REQUEST['userLoginName']."' AND loginPassword ='".$_REQUEST['userLoginPassword']."'";
	$db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($sql);
    
     	
  	$noOfUsers = $affect_rows;
  
	if($noOfUsers > 0)
    {//login pass
		$row = $datad[0];
		//print_r("<pre>");var_dump($row); die();
        $sql = "UPDATE users SET userLastLogin=NOW(), userNoLogins='".($row['userNoLogins']+1)."' WHERE userId='".$row['userId']."' ";
        $db = IOC::make('database', array());
		$db->make_query($sql);
	   	$_SESSION['userId'] = $row['userId'];
        $_SESSION['name'] = $row['loginName'];
		$_SESSION['vendorWorkshop'] = json_decode($row['vendorWorkshop'], true);
	
		
        if ($row['userLimit'] == 5)
        {
            $_SESSION['description'] = $row['fullName'];
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['adminId'] = $row['userId'];
			
            redirect("admin_page.php");
        }else if ($row['userLimit'] == 10)
        {
            $_SESSION['userId'] = $row['userId'];
            redirect("superuser_add.php");
        }
		else if($row['userLimit'] == 100){
			$_SESSION['userId'] = $row['userId'];
            //redirect("vnd_list.php");
			header("Location: vnd_list.php");
			
		}else{
			$_SESSION['adminId'] = $row['userId']; 
			$_SESSION['name'] = $row['customer'];
		
			redirect("../dashboard.php");
		}
	   
	   	
		//Log event
		$event="User Logged in";
		$log="INSERT INTO time_control
						(date,time,userId,event) 
						VALUES
						('".date("Y-m-d")."',	
						 '".date("H:i:s")."',			
						 '".$row['userId']."',
						 '".$event."'
						 )";
						 $db = IOC::make('database', array());
		$db->make_query($log);
	 
		
	
		// echo "<script> alert('Welcome'); </script>";
		
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
