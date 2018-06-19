<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Closed Job Recon</title>
</head>

<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once("/home/partserve/public_html/online/include/config.php");
include_once("/home/partserve/public_html/online/include/db_access.php");

	$db_user        = "Master";
 	$db_pass        = "JobTrack";
	$sConnection= odbc_connect("test", $db_user, $db_pass);
	if(!$sConnection) die("Could not connect<br>");	//else die('Connected');


	$sql = "SELECT * FROM jobinfoweb";
	//$res = odbc_exec($sConnection,$sql);
	$mysql = new dbObject;
	$mysqlRes = $mysql->dbQuery($sql);

	while($row = mysql_fetch_array($mysqlRes)){
		$odbcSql= "SELECT * from jobinfoweb WHERE Job='".$row['Job']."';";
		
		//echo "query - ".$odbcSql."</br>";
		
		$test = odbc_exec($sConnection,$odbcSql);
		$arr = odbc_fetch_array($test);
		//echo "[".count($arr)."]";
		
		if( count($arr)==1 ){ 
			echo "Job Closed - ";
			//Updating must have double quotes 
			$sql = "DELETE FROM jobinfoweb 
					WHERE job='".$row['Job']."'
					LIMIT 1
				";
			$result = $mysql->dbQuery($sql);
			
			$sql = "DELETE FROM JobUpdateWeb 
					WHERE job='".$row['Job']."'
					LIMIT 1
				";
			$result = $mysql->dbQuery($sql);
			
			if($result){echo $row['Job']." Deleted from DB</br>";}
		}
		else {echo odbc_result($test,"job")."- Job Still Open</br>";}
	}
?>

<body>
</body>
</html>
