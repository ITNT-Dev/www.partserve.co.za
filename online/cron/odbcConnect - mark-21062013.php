<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

//putenv('ODBCINI=/etc/odbc.ini');

include_once("include/config.php");
include_once("include/db_access.php");

	$db_user        = "Master";
 	$db_pass        = "JobTrack";
	$sConnection= odbc_connect("test", $db_user, $db_pass);
	if(!$sConnection) die("Could not connect<br>");	//else die('Connected');

//$sel = mssql_select_db($msDb, $con) or die('DB Selection failed');
//if ($sel){echo"MS SQL Database Selected</br>";}

//Query the master table and import the data
//echo "Inserting Data into Master table - </br>";


$sql = "SELECT * FROM jobinfoweb";
$res = odbc_exec($sConnection,$sql);

//$a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
//print_r($a);

$mysql = new dbObject;

	$num=0;
	while(odbc_fetch_row($res)){
		
		//print_r($res);
		
		$test = $mysql->dbQuery("SELECT * from jobinfoweb WHERE job='".odbc_result($res,"job")."' ");
	if(mysql_num_rows($test)>0){
			echo odbc_result($res,"job")."- Job already Exists in database</br>";
			
			
					//Updating must have double quotes 
					$sql = "UPDATE jobinfoweb 
							SET Customer='".trim(odbc_result($res,"Customer"))."',
								 CustomerName='".trim(odbc_result($res,"CustomerName"))."',
								 PhysicalAddress1='".trim(odbc_result($res,"PhysicalAddress1"))."',
								 PhysicalAddress2='".trim(odbc_result($res,"PhysicalAddress2"))."',
								 PhysicalAddress3='".trim(odbc_result($res,"PhysicalAddress3"))."',
								 PhysicalAddress4='".trim(odbc_result($res,"PhysicalAddress4"))."',
								 PhysicalAddress5='".trim(odbc_result($res,"PhysicalAddress5"))."',
								 AccountContactName='".trim(odbc_result($res,"AccountContactName"))."',
								 AccountContactEmail='".trim(odbc_result($res,"AccountContactEmail"))."',
								 AccountContactTel='".trim(odbc_result($res,"AccountContactTel"))."',
								 AccountContactCell='".trim(odbc_result($res,"AccountContactCell"))."',
								 SalesContactName='".trim(odbc_result($res,"SalesContactName"))."',
								 SalesContactEmail='".trim(odbc_result($res,"SalesContactEmail"))."',
								 SalesContactCell='".trim(odbc_result($res,"SalesContactCell"))."',
								 SalesContactTel='".trim(odbc_result($res,"SalesContactTel"))."',
								 LastContactNotes='".trim(odbc_result($res,"LastContactNotes"))."',
								 QuoteAccountNumber='".trim(odbc_result($res,"QuoteAccountNumber"))."',
								 QuoteDRRef='".trim(odbc_result($res,"QuoteDRRef"))."',
								 QuoteJobDate='".trim(odbc_result($res,"QuoteJobDate"))."',
								 QuoteMake='".trim(odbc_result($res,"QuoteMake"))."',
								 QuoteModel='".trim(odbc_result($res,"QuoteModel"))."',
								 QuoteSerialNumber='".trim(odbc_result($res,"QuoteSerialNumber"))."',
								 QuoteActionRequired='".trim(odbc_result($res,"QuoteActionRequired"))."',
								 QuoteTotal='".trim(odbc_result($res,"QuoteTotal"))."',
								 QuoteDiscountPer='".trim(odbc_result($res,"QuoteDiscountPer"))."',
								 QuoteDiscount='".trim(odbc_result($res,"QuoteDiscount"))."',
								 QuoteTotalTax='".trim(odbc_result($res,"QuoteTotalTax"))."',
								 QuoteGrandTotal='".trim(odbc_result($res,"QuoteGrandTotal"))."',
								 FaultDescription='".trim(odbc_result($res,"FaultDescription'"))."',
								 Accessories='".trim(odbc_result($res,"Accessories"))."',
								 WorkDone='".trim(odbc_result($res,"WorkDone"))."',
								 Item= '".trim(odbc_result($res,"Item"))."',
								 Status= '".trim(odbc_result($res,"Status"))."'
							WHERE job='".odbc_result($res,"job")."'
						";
					
					//$sql = "UPDATE jobinfoweb SET Customer='".trim(odbc_result($res,'Customer'))."' WHERE job='".odbc_result($res,"job")."' ";
			$result = $mysql->dbQuery($sql); //or echo "cannot Update Job";
			
		} 
		else{
		//echo $num++."-".odbc_result($res,"job")."<br>";
   			$sql = 'INSERT INTO jobinfoweb
						(
						 Job,Customer,CustomerName,
						 PhysicalAddress1,PhysicalAddress2,PhysicalAddress3,PhysicalAddress4,PhysicalAddress5,
						 AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,
						 SalesContactName,SalesContactEmail,SalesContactCell,SalesContactTel,
						 LastContactNotes,
						 QuoteAccountNumber,QuoteDRRef,QuoteJobDate,QuoteMake,QuoteModel,QuoteSerialNumber,
						 QuoteActionRequired,QuoteTotal,QuoteDiscountPer,QuoteDiscount,QuoteTotalTax,QuoteGrandTotal,
						 FaultDescription,Accessories,WorkDone,Item,Status
						 )
					VALUES(
						 "'.mysql_real_escape_string(trim(odbc_result($res,"Job"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"Customer"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"CustomerName"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"PhysicalAddress1"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"PhysicalAddress2"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"PhysicalAddress3"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"PhysicalAddress4"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"PhysicalAddress5"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"AccountContactName"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"AccountContactEmail"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"AccountContactTel"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"AccountContactCell"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"SalesContactName"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"SalesContactEmail"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"SalesContactCell"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"SalesContactTel"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"LastContactNotes"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteAccountNumber"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteDRRef"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteJobDate"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteMake"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteModel"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteSerialNumber"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteActionRequired"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteTotal"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteDiscountPer"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteDiscount"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteTotalTax"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"QuoteGrandTotal"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"FaultDescription'"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"Accessories"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"WorkDone"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"Item"))).'",
						 "'.mysql_real_escape_string(trim(odbc_result($res,"Status"))).'"
						)';
					
			$result = $mysql->dbQuery($sql);// or die("cannot insert Job");
			if($result){echo odbc_result($res,"Job")."</br>";}			
		}
	}

$sql = "SELECT * FROM JobUpdateCustomer";
$res = odbc_exec($sConnection,$sql);

//$a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
//print_r($a);

$mysql = new dbObject;

	$num=0;
	while(odbc_fetch_row($res)){
		
		//print_r($res);
		
		$test = $mysql->dbQuery("SELECT * from users WHERE loginName='".odbc_result($res,"CustomerID")."' ");
	if(mysql_num_rows($test)>0){
			echo odbc_result($res,"CustomerID")."-User already Exists in database</br>";
			
			//Updating not working
			$sql = "UPDATE users 
					SET	 loginName= '".trim(odbc_result($res,"CustomerID"))."',
						 loginPassword= '".trim(odbc_result($res,"Password"))."',
						 customer= '".trim(odbc_result($res,"CustomerID"))."'
					WHERE loginName='".odbc_result($res,"CustomerID")."'
					";
					
			$result = $mysql->dbQuery($sql);//or echo "cannot Update User";
			
		} 
		else{
		//echo $num++."-".odbc_result($res,"job")."<br>";
   			$sql = 'INSERT INTO users
						(
						 loginName,loginPassword,customer
						 )
					VALUES(
						 "'.trim(odbc_result($res,"CustomerID")).'",
						 "'.trim(odbc_result($res,"Password")).'",
						 "'.trim(odbc_result($res,"CustomerID")).'"
						)';
					
			$result = $mysql->dbQuery($sql) or die("cannot insert User");
			if($result){echo odbc_result($res,"CustomerID")."</br>";}			
		}
	}

?>

<body>
</body>
</html>