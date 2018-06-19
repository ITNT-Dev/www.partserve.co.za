<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Client</title>
</head>

<body>



<?php
 require_once('include/functions.php');
 require_once("../newlib/config.php");	

$option='form'; 
if (isset($_REQUEST['option']) ){$option = ($_REQUEST['option']); }

switch($option){
case 'form':
   			print form();
  		break;

case 'write':
   			print write();
  		break;
}

function form(){
extract($_REQUEST);
$form ="<div align='center' style='padding:5px 15px 5px 15px; border:#0056a9 solid 2px;'>
			
			<h2>Add New User</h2>

	
		<form method='post'>
		<table>
			<input type='hidden' name='option' value='write' />
			<tr>
				<td align='right'><label  >Name</label></td>
				<td><input name='newUserName' value='".$newUserName."' />&nbsp;&nbsp;&nbsp;</br></td>
			</tr>
			<tr>
				<td align='right'><label>Surname</label></td>
				<td><input name='newUserSurname' value='".$newUserSurname."'  />&nbsp;&nbsp;&nbsp;</br></td>
			</tr>
			<tr>
				<td align='right'><label>Login Name</label></td>
				<td><input name='newUserLoginName' value='".$newUserLoginName."'/>&nbsp;&nbsp;&nbsp;</br></td>
			</tr>
			<tr>
				<td align='right'><label>Login Password</label></td>
				<td><input type='password' name='newUserLoginPassword' value='".$newUserLoginPassword."'/>&nbsp;&nbsp;&nbsp;</br></td>
				<td><label> min.8-max.20-Alphanumeric Characters </label></td>
			</tr>
			<tr>
				<td align='right'><label>Re-Enter Password</label></td>
				<td><input type='password' name='LoginPassword2' />&nbsp;&nbsp;&nbsp;</br></td>
			</tr>
			<tr>
				<td align='right'><label>Email Address</label></td>
				<td><input name='newUserEmail' value='".$newUserEmail."'/>&nbsp;&nbsp;&nbsp;</br></td>
			</tr>
			<tr>
				<td align='right'><label>Customer No.</label></td>
				<td><input name='customer' value='".$customer."'/>&nbsp;&nbsp;&nbsp;</br></td>
			</tr>
			<tr>
				<td></td>
				<td><input type='button' onclick=checkFields(this.form) name='addClient' value='Add Client' /></td>	
			</tr>
		
			
			<script>
				function checkFields(frm){
					if(frm.newUserName.value.length <3) {alert('Please enter User Name'); return false;}
					if(frm.newUserSurname.value.length <3) {alert('Please enter Surname'); return false;}
					if(frm.newUserLoginName.value.length <3) {alert('Please enter Login Name'); return false;}
					if(frm.newUserLoginPassword.value.length <3) {alert('Please enter Password'); return false;}
					if(frm.newUserLoginPassword.value!== frm.LoginPassword2.value) {alert('Passwords do not match'); return false;}
					if(frm.newUserEmail.value.length <2) {alert('Please enter Email Address'); return false;}
					if(frm.customer.value.length <3) {alert('Please Enter Customer Number'); return false;}
				
				frm.submit();
				return true;	
				}
			
			</script>
		</table>
		</form>
		</div>
		<div> <label class='white'>".$_REQUEST['passwordErr']."</label> </div>";
		
		
print $form;

//require_once('include/db_access.php');
	$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword); 

	$string = "<div align='center'>
	<form name='userList' action='' method='post'>
	
				<p>&nbsp;</p>
					<table id='styled' cellspacing='25' summary='jobList' class='joblist' border='0'  >
						<input type='hidden' name='option' value='save'>
							<thead>
								<tr>
									<th>User ID.</th>	
									<th>Name.</th>				
									<th>Login Name</th>
									<th>Email</th>
									<th>Customer</th>
									<th>Last Login</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>";		
		
		
		
		
		$sql ="SELECT * FROM users";//
		$results = $conn->query($sql);
		//$results = $dbObject->dbQuery($sql);
		$row = $results->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			extract($row);
				
			$string .= "	<tr>
								<td>".$userId."</td>
								<td>".$fullName."</td>
								<td>".$loginName."</td>
								<td>".$userEmail."</td>
								<td>".$customer."</td>
								<td>".$userLastLogin."</td>
								<td><a href='deleteUser.php?userId=".$userId." ' >Delete</a></td>
							</tr>
							";
		}
		while($row = $results->fetch(PDO::FETCH_ASSOC)){
			extract($row);
				
			$string .= "	<tr>
								<td>".$userId."</td>
								<td>".$fullName."</td>
								<td>".$loginName."</td>
								<td>".$userEmail."</td>
								<td>".$customer."</td>
								<td>".$userLastLogin."</td>
								<td><a href='deleteUser.php?userId=".$userId." ' >Delete</a></td>
							</tr>
							";
		}
		
		$string .= "</table></div>";

print $string;
}


function write(){	

error_reporting(E_ALL);
ini_set('display_errors', '1');
	extract($_REQUEST);
	
	if ($newUserLoginName==$newUserLoginPassword) {
		echo "<script> alert('Login Name and Password cannot be the same...'); </script>"; 
	return form($_REQUEST);
	}
	if (!passwordStrength($newUserLoginPassword) ) {
		echo "<script> alert('Password not strong enough'); </script>"; 
	return form($_REQUEST);
	}
	
	$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword);;
	
	$query = "SELECT * from users WHERE loginName='".$newUserLoginName."'";
	//$res= $dbObject->dbQuery($query);
	$res = $conn->query($query);
	$affected_rows = $query->rowCount();
	if($affected_rows > 0 ){
		echo "<script> alert('User Login Name ALREADY EXISTS...'); </script>"; 
		return form($_REQUEST);
	}
	
	$writeSql="INSERT INTO users
				(fullName, LoginName, LoginPassword, userEmail, customer) 
				VALUES
				('".$newUserName." ".$newUserSurname."', 
				 '".$newUserLoginName."', 
				 '".md5(mysql_escape_string($newUserLoginPassword))."',
				 '".$newUserEmail."', 
				 '".$customer."'
				)";
	//$writeRes = $dbObject->dbQuery($writeSql);
	
	$writeRes = $conn->query($writeSql);
	redirect("addUser.php","User Added...!");
}

?>


</body>
</html>
