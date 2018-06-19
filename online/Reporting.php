<?php
 //session_start();
 //require_once('include/functions.php');
 
 error_reporting(E_ALL);
ini_set('display_errors', '1');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report Statistics</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<? include "include/header.php" ?>
<table summary="content" width="965" cellpadding="0" cellspacing="0" >
  	<tr>
  		<td width="31" class="title" headers="nameofpage"><img src="images/titlebg_left.jpg" width="31" height="56" /></td>
		<td  class="titletext" nowrap="nowrap">Report Statistics</td>
		<td width="38"><img src="images/titlebg_right.jpg" width="38" height="56" /></td>
		<td width="573" class="titleline">&nbsp;</td></td><td width="13"><a href="contactus.php"><img src="images/titleend_line.jpg" width="154" height="56" /></a></td>
	</tr>
    <tr>
<td>
</table>
<a href="../dashboard.php">Go back to Dashboard</a>

<?php
require_once('include/functions.php');
require_once("../newlib/index.php");
if(!adminOnLine() )
redirect ("../onlinejobtracking.php");

$string = "
	<form name='joblist' action='' method='post'>
	<div>
				<p>&nbsp;</p>
					<table id='styled' cellspacing='25' summary='jobList' class='joblist' border='0'  >
						<input type='hidden' name='option' value='save'>
							<thead>
								<tr>
									<th>Under Assessment</th>	
									<th>Quoted</th>
									<th>Busy With Repair</th>				
									<th>Completed/<br>Ready for Collection</th>
									<th>Closed</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>";	
		$assessmentSql ="SELECT count(*) AS count FROM  jobinfoweb WHERE status like '%Under Assessment%' ";//
		$db = IOC::make('database', array());
		list($affect_rows, $datad) = $db->selectquerys($assessmentSql);
		$asssesmentCount = $datad[0]['count(*)'];
		
		$quoteSql ="SELECT count(*) AS count FROM  jobinfoweb WHERE status like 'Quote' ";//
		$db = IOC::make('database', array());
		list($affect_rows, $datad) = $db->selectquerys($quoteSql);
		$quoteCount=$datad[0]['count(*)'];
		
		$busySql ="SELECT count(*) AS count FROM  jobinfoweb WHERE status like '%Quote Accepted%' ";//
		$db = IOC::make('database', array());
		list($affect_rows, $datad) = $db->selectquerys($busySql);
		busyCount=$datad[0]['count(*)'];
		
		$readySql ="SELECT count(*) AS count FROM  jobinfoweb WHERE status like '%Ready for Collection%' ";//
		$db = IOC::make('database', array());
		list($affect_rows, $datad) = $db->selectquerys($readySql);
		$readyCount=$datad[0]['count(*)'];

		$closedSql ="SELECT count(*) AS count FROM  jobinfoweb WHERE closed=1 ";//
		$db = IOC::make('database', array());
		list($affect_rows, $datad) = $db->selectquerys($closedSql);
		closedCount=$datad[0]['count(*)'];
				
		$string .= "<tr>
						<td>".$asssesmentCount."</td>
						<td>".$quoteCount."</td>
						<td>".$busyCount."</td>
						<td>".$readyCount."</td>
						<td>".$closedCount."</td>
						<td>".($asssesmentCount+$quoteCount+$closedCount+$readyCount+$busyCount)."</td>
					</tr>
					</div>
					";

print $string;


?>

<?php include "include/footer.php"; ?>