<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1'); 
    include "../library/stdinc.php";
    require_once(dirname(__FILE__).'/../config/config.inc.php');
	require_once("../newlib/index.php");
    $sql = "SELECT * FROM users u INNER JOIN jobinfoweb j ON (u.customer = j.Customer) WHERE j.CustomerName LIKE '%".$_GET['filter']."%' GROUP BY j.Customer";
   $db = IOC::make('database', array());
list($affect_rows, $datad) = $db->selectquerys($sql);
	
foreach ($datad as $row)
{
echo '<p id="'.$row['userId'].'">'.$row['loginName'].' => '.$row['CustomerName'].'&nbsp;<input type="checkbox" value="'.$row['userId'].'" name="account'.$row['userId'].'"/></p>';
			}
	
	
	

?>