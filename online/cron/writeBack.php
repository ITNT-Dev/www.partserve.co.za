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

include_once("/home/partserve/public_html/online/include/config.php");
include_once("/home/partserve/public_html/online/include/db_access.php");


	$mysql = new dbObject;
	
	$querySql ="SELECT * from JobUpdateWeb WHERE synced=0";
	$queryResult = $mysql->dbQuery($querySql) or die("no new records");
	while ($row = mysql_fetch_array($queryResult) ){
		extract ($row);
	
		$db_user        = "Master";
 		$db_pass        = "JobTrack";

		$sConnection= odbc_connect("test", $db_user, $db_pass);
		if(!$sConnection) die("Could not connect<br>");	//else die('Connected');

//		$insertSql = "INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactCell,SalesContactTel,AcceptQuote,RejectQuote,AccRejReason)
//					VALUES( 
//							'".$Job."',
//							 '".$Customer."',
//							 '".$AccountContactName."',
//							 '".$AccountContactEmail."',
//							 '".$AccountContactTel."',
//							 '".$AccountContactCell."',
//							 '".$SalesContactName."',
//							 '".$SalesContactEmail."',
//							 '".$SalesContactCell."',
//							 '".$SalesContactTel."',
//							 '".$AcceptQuote."',
//							 '".$RejectQuote."',
//							 '".$reason."'
//							)";
                
                $insertSql = "INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactCell,SalesContactTel,AcceptQuote,RejectQuote)
					VALUES( 
							'".$Job."',
							 '".$Customer."',
							 '".$AccountContactName."',
							 '".$AccountContactEmail."',
							 '".$AccountContactTel."',
							 '".$AccountContactCell."',
							 '".$SalesContactName."',
							 '".$SalesContactEmail."',
							 '".$SalesContactCell."',
							 '".$SalesContactTel."',
							 '".$AcceptQuote."',
							 '".$RejectQuote."'
							)";
						
		//echo $sql."</br>";
		$insertResult = odbc_exec($sConnection,$insertSql);
		if($insertResult){
			
			echo $Job."</br>";
			$updateSql ="UPDATE JobUpdateWeb set synced=1 WHERE Job='".$Job."' ";
			$updateResult = $mysql->dbQuery($updateSql) or die("Could not Update synced Item");
			
		
		}

	}

//$Customer,$AccountContactName,$AccountContactEmail,$AccountContactTel,$AccountContactCell,$SalesContactName,$SalesContactEmail,$SalesContactCell,$SalesContactTel,$AcceptQuote,$RejectQuote	
 						
?>

<body>
</body>
</html>
