<?php
//require_once('app/views.php');
//require_once('app/router.php');
require_once('app/model.php');
//require_once('app/globalVars.php');
//require_once('app/indexcontroller.php');
require_once('app/ioc.php');
require_once('config.php');

// Register databased details
IOC::register('database', function()
	{
		// Uaw constants defined in from config file
		return new model(array(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD));
	});

IOC::register('PDO', function($server,$database, $user,$password)
	{
		return new PDO("mysql:host=$server;dbname=$database", "$user", "$password");
	});


	
//$dispatch = new router();	
//$dispatch->gets();
?>
