<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//$sConnection = odbc_connect("DRIVER={Pervasive ODBC Engine Interface};ServerName=smtp.partserve.co.za;DBQ=JobTracking;","","");
//if(!$sConnection) die("Could not connect<br>");
//else die('Connected');
	//putenv('ODBCINI=/etc/odbc.ini');
	
	
	//putenv("LD_LIBRARY_PATH=/usr/local/psql/lib");
	//putenv("ODBCINSTINI=/etc/odbcinst.ini"); //this location will be determined by your driver install.
	//putenv("ODBCINI=/usr/local/psql/etc/odbc.ini"); //odbc.ini contains your DSNs, location determined by your driver install.
	//putenv("ODBCHOME=/usr/local");
	
	
//	$db_host        = "smtp.partserve.co.za:1583";
 //   $db_user        = "Master";
 //   $db_pass        = "JobTrack";
	
	 $db_user        = "Master";
    $db_pass        = "JobTrack";
	
//	$db_name		= "JobTracking";
 //   $dsn 			= "DRIVER={Pervasive ODBC client Interface};" .	"CommLinks=tcpip(Host=$db_host);" .	"DatabaseName=$db_name;" ."uid=$db_user; pwd=$db_pass";

	//$file_name= "odbcConnect2.php";
	//$path = "/home/dev/public_html/partserve/online/".$file_name;
	//$user_name = "psql";
	
	//chown($path, $user_name);// attempt to change the user.
   
   $sConnection= odbc_connect("test", $db_user, $db_pass);

	if(!$sConnection) die("Could not connect<br>");
	else die('Connected');
?>

<body>
</body>
</html>
