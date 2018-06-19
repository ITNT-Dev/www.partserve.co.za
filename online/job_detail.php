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
<title>Job Details</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<? include "include/header.php" ?>
<table summary="content" width="965" cellpadding="0" cellspacing="0">
  <tr><td width="31" class="title" headers="nameofpage"><img src="images/titlebg_left.jpg" width="31" height="56" /></td>
<td  class="titletext" nowrap="nowrap">Job Details Page</td>
<td width="38"><img src="images/titlebg_right.jpg" width="38" height="56" /></td>
<td width="573" class="titleline">&nbsp;</td></td><td width="13"><a href="contactus.php"><img src="images/titleend_line.jpg" width="154" height="56" /></a></td>
</tr>
</table>

<?php include "details.php"; ?>

<?php //include "include/footer.php"; ?>