<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1');
session_start();

include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("../newlib/index.php");
date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ($userId < 1 )
{
  header("Location: ../onlinejobtracking.php");
  exit();
}
    if (isset($_GET['aid']))
    {
        $sql = "DELETE FROM users WHERE userId='".$_GET['aid']."'";
        $db = IOC::make('database', array());
		$db->make_query($sql);
    }
    
    header("Location: superuser_list.php");
?>
