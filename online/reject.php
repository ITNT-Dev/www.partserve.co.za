<?php
 //session_start();
 //require_once('include/functions.php');
 
 //error_reporting(E_ALL);
//ini_set('display_errors', '1');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reject Jobs</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/style2.css" rel="stylesheet">
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<? //include "include/header.php" ?>
<body>

  
  
    <div class="container">
      <div class="row">
      
        <table summary="partserve" width="1000" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="100%" valign="top" headers="logo" >&nbsp;</td>
</tr>

<tr><td height="4" colspan="100%" headers="menu">&nbsp;</td>
</tr></table>
<table summary="content" width="965" cellpadding="0" cellspacing="0" >
  	<tr>
  		<td width="31" class="title" headers="nameofpage"><img src="images/titlebg_left.jpg" width="31" height="56" /></td>
		<td  class="titletext" nowrap="nowrap">Reject Jobs</td>
		<td width="38"><img src="images/titlebg_right.jpg" width="38" height="56" /></td>
		<td width="573" class="titleline">&nbsp;</td></td><td width="13"><a href="contactus.php"><img src="images/titleend_line.jpg" width="154" height="56" /></a></td>
	</tr>
    <tr>
<td>
</table>
<a href="../dashboard.php">Go back to Dashboard</a>&nbsp; <?php @session_start(); echo "logged In as ".$_SESSION['name']."</br>";?>

<?php 
//require_once('include/db_access.php');
require_once('include/functions.php');




echo '<br/>
	<form method="post" name="getOrderNumber">
		<label>Enter Order Number with Reason for Rejection:</label>
		<input name="orderNum" type="text" />
		<input name="send" type="button" value="Send" onclick="check(this.form)" />
	</form>
	<script>
		function check(frm){
			if (frm.orderNum.value==""){
				alert ("Enter Order Number with Reason for Rejection")
				frm.orderNum.setFocus();
				return false;
			}
		frm.submit();
		}
	</script>';
?>
<br/>
<a href="javascript:history.go(-1)"><button type="button" class="btn btn-primary btn">Back</button></a>
</div>
</div>
<?php

if ( isset($_POST['orderNum']) ){
$writeUrl = 'rejectWrite.php?answer='.$_POST['orderNum'].'&Job='.$_GET['Job'].'&FaultDescription='.$_GET['FaultDescription'].'&WorkDone='.$_GET['WorkDone'].'&Item='.$_GET['Item'].'&QuoteTotal='.$_GET['QuoteTotal'].'&QuoteTotalTax='.$_GET['QuoteTotalTax'].'&QuoteGrandTotal='.$_GET['QuoteGrandTotal'].'&Accessories='.$_GET['Accessories'].'&Customer='.$_GET['Customer'].'&AccountContactName='.$_GET['AccountContactName'].'&AccountContactEmail='.$_GET['AccountContactEmail'].'&AccountContactTel='.$_GET['AccountContactTel'].'&AccountContactCell='.$_GET['AccountContactCell'].'&SalesContactName='.$_GET['SalesContactName'].'&SalesContactEmail='.$_GET['SalesContactEmail'].'&SalesContactTel='.$_GET['SalesContactTel'].'&SalesContactCell='.$_GET['SalesContactCell'].' ';

redirect($writeUrl);
}

?>