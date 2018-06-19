<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete Client</title>
</head>

<body>



<?php
 require_once('include/functions.php');
require_once("../newlib/index.php");
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$writeSql="DELETE FROM users where userId='".$_GET['userId']."' ";
	$db = IOC::make('database', array());
	$db->make_query($writeSql);
	redirect('addUser.php',"User Deleted...!");

?>


</body>
</html>
