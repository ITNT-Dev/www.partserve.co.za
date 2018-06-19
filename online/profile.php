<?php
require_once('include/functions.php');
require_once("../newlib/index.php");

if(!isOnLine() )
redirect ("login.php");
if (!isset($_SESSION)) {
  session_start();
}

function personalDetails(){
	$user = $_SESSION['userId']; //get the user id from the session	
	$sql="SELECT *
			FROM users u
			LEFT JOIN jobinfoweb j ON ( u.customer = j.customer )
			WHERE userId ='".$user."' ";
	//$res = $dbObject->dbQuery($sql);
	$db = IOC::make('database', array());
	list($affect_rows, $row) = $db->selectquerys($sql);
		
	//$row = $dbObject->dbNextRecord($res);
	@extract($row);//extract all columns as variables
	
	/*$query="SELECT * 
				FROM debtors_account
				WHERE userId='".$user."'
				ORDER BY debtorId DESC";
	$result= $dbObject->dbQuery($query);
	$debt=$dbObject->dbNextRecord($result);*/
	
	$string = " <link href='style/sportscall.css' rel='stylesheet' type='text/css'/><br>
					<div style='width:100%' border='1' >
						
							<form>
							<div style='float:left; margin-right:35px'>
							<br>
							<a class='buttonSubmit' href='logout.php'>Log Out</a><br>
							ID:<a class='link'>$userId</a><br>
							User:<a class='link'>$loginName</a>
							</div>
							<div>
								<br>
								<table style='float:left; margin:0px 00px 0px 0px' border='0' width='350px' cellspacing='0' colspacing='0'>
									<tr>
										<td colspan='2'>
										<h3>Account Information</h3>
										</td>
										<td>
											<a href='editAccount.php' class='link'>Edit</a>
										</td>
										</tr>
									<tr>
										<td align='left' width=''>
											<strong>Name:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$CustomerName</a>
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Contact:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$AccountContactName</a>
										</td>
									</tr>
									<tr>
										<td align='left' width=''>
											<strong>Email:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$AccountContactEmail</a>
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Tel:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$AccountContactTel</a>
										</td>
									</tr>
									
									<tr>
										<td align='left'>
											<strong>Cell:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$AccountContactCell</a>
										</td>
									</tr>
							</div>	
							<div>	
									</table>
									<img style='float:left; margin:50px 60px 0px 0px'' src='../images/devider.jpg' width='10' height='157' /> 
									<table style='float:left;  border='0' width='350px' cellspacing='0' colspacing='0'>
									<tr>
										<td colspan='2'>
											<h3>Sales Information</h3>
										</td>
										<td>
											<a href='editSales.php' class='link'>Edit</a>
										</td>
									</tr>
									<tr>
										<td align='left' valign='top'>
											<strong>Contact:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$SalesContactName</a>
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Email:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$SalesContactEmail</a>
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Tel:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$SalesContactTel</a>
										</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Cell:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$SalesContactCell</a>
										</td>
									</tr>
							
									<tr>
										<td>&nbsp</td>
									</tr>
									<tr>
										<td align='left'>
											<strong>Last Contact Notes:&nbsp</strong>
										</td>
										<td align='right'>
											<a class='link'>$LastContactNotes</a>
										</td>
									</tr>
								</table>
								<br>
							</form>
					</div>";
						
return $string;
}


print personalDetails();

//include ("jobDetail.php");




?>
