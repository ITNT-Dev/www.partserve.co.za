<?php
 //session_start();
 //require_once('include/functions.php');
 
// error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once '../bootstrap.php'; // load my required files

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accept Jobs</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/style2.css" rel="stylesheet">
<script type="text/javascript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
    

<? //include "include/header.php" ?>

  <body onLoad="MM_preloadImages('../images/but_home2.jpg','../images/but_aboutus2.jpg','../images/but_warranty2.jpg','../images/but_refurbished2.jpg','../images/but_onlinejob2.jpg','../images/but_partsearch2.jpg','../images/but_newsroom2.jpg','../images/but_companyinfo2.jpg','../images/but_recruit2.jpg','../images/but_contact2.jpg')">

  
  
    <div class="container">
      <div class="row">
      
        <table summary="partserve" width="1000" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="100%" valign="top" headers="logo" ><p><img src="../images/top_logo.jpg" style="display:block;" alt="PartServe Logo" width="993" height="116" usemap="#Map" border="0" />
            <map name="Map"><area shape="rect" coords="894,89,921,114" href="http://twitter.com/partserve_jhb" target="_blank" alt="twitter"><area shape="rect" coords="864,89,889,113" href="http://www.facebook.com/pages/Partserve-Channel-Support/235582823230231" target="_blank" alt="facebook">
            <area shape="rect" coords="637,2,936,23" href="../subscribe.php" alt="click here to subscribe to daily email specials">
            <area shape="rect" coords="780,90,858,114" href="../contactus.php" target="_parent" alt="Live Chat">
    </map>
    </p></td>
</tr>

<tr><td height="4" colspan="100%" headers="menu"><a href="../index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../images/but_home2.jpg',1)"><img src="../images/but_home.jpg" alt="HOME" name="Image2" width="47" height="50" border="0" id="Image2" /></a>
<a href="../aboutus.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../images/but_aboutus2.jpg',1)"><img src="../images/but_aboutus.jpg" alt="ABOUT US" name="Image3" width="64" height="50" border="0" id="Image3" /></a>
<a href="../warranty.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../images/but_warranty2.jpg',1)"><img src="../images/but_warranty.jpg" alt="WARRANTY" name="Image4" width="74" height="50" border="0" id="Image4" /></a>
<a href="../allproducts.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../images/but_refurbished2.jpg',1)"><img src="../images/but_refurbished.jpg" alt="REFURBISHED PRODUCTS" name="Image5" width="151" height="50" border="0" id="Image5" /></a>
<a href="../onlinejobtracking.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../images/but_onlinejob2.jpg',1)"><img src="../images/but_onlinejob.jpg" alt="ONLINE JOB TRACKING" name="Image6" width="131" height="50" border="0" id="Image6" /></a>
<a href="../partssearch.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','../images/but_partsearch2.jpg',1)"><img src="../images/but_partsearch.jpg" alt="PARTS SEARCH" name="Image7" width="92" height="50" border="0" id="Image7" /></a>
<a href="http://www.itweb.co.za/office/partserve/" target="_blank" onMouseOver="MM_swapImage('Image8','','../images/but_newsroom2.jpg',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/but_newsroom.jpg" alt="NEWS ROOM" name="Image8" width="83" height="50" border="0" id="Image8" /></a>
<a href="../companyinfo.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','../images/but_companyinfo2.jpg',1)"><img src="../images/but_companyinfo.jpg" alt="COMPANY INFORMATION" name="Image9" width="146" height="50" border="0" id="Image9" /></a>
<a href="../recruitment.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image10','','../images/but_recruit2.jpg',1)"><img src="../images/but_recruit.jpg" alt="RECRUITMENT" name="Image10" width="93" height="50" border="0" id="Image10" /></a>
<a href="../contactus.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11','','../images/but_contact2.jpg',1)"><img src="../images/but_contact.jpg" alt="CONTACT US" name="Image11" width="80" height="50" border="0"></a></td>
</tr></table>

<table summary="content" width="965" cellpadding="0" cellspacing="0" >
  	<tr>
  		<td width="31" class="title" headers="nameofpage"><img src="images/titlebg_left.jpg" width="31" height="56" /></td>
		<td  class="titletext" nowrap="nowrap">Accept Jobs</td>
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

$ccEmailAddress = "";

if (isset($_GET['AccountContactEmail']) && trim($_GET['AccountContactEmail']) != '') {
	$ccEmailAddress = $_GET['AccountContactEmail'];
}
else if (isset($_GET['SalesContactEmail']) && trim($_GET['SalesContactEmail']) != '') {
	$ccEmailAddress = $_GET['SalesContactEmail'];	
}

echo '<br/>
	<form method="post" name="getOrderNumber" enctype="multipart/form-data">
		<label>Enter Order number:</label>
		<input name="orderNum" value="" type="text" /> <small><em>( *if you do not have an Order Number please insert your Contact Number )</em></small>
                <br>
                <br>
                <label>Upload Purchase Order File Or Proof Of Payment <small><em>( *.pdf )</em></small>:</label>
		<input name="orderFile" value="" type="file" />
                <br>
		<a href="javascript:history.go(-1)"><button type="button" class="btn btn-warning btn">Back</button></a> &nbsp; <input name="send" type="button" class="btn btn-primary btn" value="Send" onclick="return check(this.form)" />
	</form>
	<script>
		function check(frm){
			if (frm.orderNum.value==""){
				alert ("Please Enter Order Number!")
				frm.orderNum.setFocus();
				return false;
			}
                        if (frm.orderFile.value == "") {
                           alert ("Please Upload The Purchase Order PDF File!")
                           frm.orderFile.setFocus();
			    return false;
                        }
			

		frm.submit();
		}
	</script>
	';
    
?>
<!--<br/>
<a href="javascript:history.go(-1)"><button type="button" class="btn btn-warning btn">Back</button></a>-->

</div>
</div>

<?php

if ( isset($_POST['orderNum']) ){

    $filename = "";
    $purchaseOrder = JobPurchaseOrder::find_by_job($_GET['Job']);
    
    if ($purchaseOrder == NULL) {
        $purchaseOrder = new JobPurchaseOrder();
    }
    
//    TMy_Utils::print_Post();
//    TMy_Utils::print_Files();

//    Check the pdf it has not be uploaded
    if (isset($_FILES['orderFile']) && isset($FILES['orderFile']['name']) == null) {
        //Do things here if the pdf is excluded
        $writeUrl = 'acceptWrite.php?answer='.$_POST['orderNum'].'&Job='.$_GET['Job'].'&FaultDescription='.$_GET['FaultDescription']
            .'&WorkDone='.$_GET['WorkDone'].'&Item='.$_GET['Item'].'&QuoteTotal='.$_GET['QuoteTotal'].'&QuoteTotalTax='
            .$_GET['QuoteTotalTax'].'&QuoteGrandTotal='.$_GET['QuoteGrandTotal'].'&Accessories='.$_GET['Accessories'].'&Customer='
            .$_GET['Customer'].'&AccountContactName='.$_GET['AccountContactName'].'&AccountContactEmail='.$_POST['ccEmailAddress']
            .'&AccountContactTel='.$_GET['AccountContactTel'].'&AccountContactCell='.$_GET['AccountContactCell'].'&SalesContactName='
            .$_GET['SalesContactName'].'&SalesContactEmail='.$_GET['SalesContactEmail'].'&SalesContactTel='.$_GET['SalesContactTel'].'&SalesContactCell='.$_GET['SalesContactCell'];

        //example  http://newdev.itntdev.co.za/onlinejobtracking/online/accept.php?Job=//JN157965&Customer=&AccountContactName=&AccountContactEmail=&AccountContactTel=&AccountContactCell=&SalesContactName=&SalesContactEmail=&SalesContactTel=&SalesContactCell=
        redirect($writeUrl);
    }
    else {
        try {
            $filename = "files/purchase_orders/" . $_GET['Job'] . "_PO.pdf";
            
            if (!move_uploaded_file($_FILES['orderFile']['tmp_name'], $filename)) {
                echo "<script>alert('File upload failed');</script>";
            }
            else {
                $purchaseOrder->job = $_GET['Job'];
                $purchaseOrder->file = $filename;
                $purchaseOrder->date = date('Y-m-d H:i:s');
                $purchaseOrder->synched = 0;
                $purchaseOrder->timesynched = "0000-00-00 00:00:00";
                $purchaseOrder->save();

                $writeUrl = 'acceptWrite.php?answer='.$_POST['orderNum'].'&Job='.$_GET['Job'].'&FaultDescription='.$_GET['FaultDescription']
		.'&WorkDone='.$_GET['WorkDone'].'&Item='.$_GET['Item'].'&QuoteTotal='.$_GET['QuoteTotal'].'&QuoteTotalTax='
		.$_GET['QuoteTotalTax'].'&QuoteGrandTotal='.$_GET['QuoteGrandTotal'].'&Accessories='.$_GET['Accessories'].'&Customer='
		.$_GET['Customer'].'&AccountContactName='.$_GET['AccountContactName'].'&AccountContactEmail='.$_POST['ccEmailAddress']
		.'&AccountContactTel='.$_GET['AccountContactTel'].'&AccountContactCell='.$_GET['AccountContactCell'].'&SalesContactName='
		.$_GET['SalesContactName'].'&SalesContactEmail='.$_GET['SalesContactEmail'].'&SalesContactTel='.$_GET['SalesContactTel'].'&SalesContactCell='.$_GET['SalesContactCell'];

             //example  http://newdev.itntdev.co.za/onlinejobtracking/online/accept.php?Job=//JN157965&Customer=&AccountContactName=&AccountContactEmail=&AccountContactTel=&AccountContactCell=&SalesContactName=&SalesContactEmail=&SalesContactTel=&SalesContactCell=
                redirect($writeUrl); 
            }
        }
        catch (Exception $ex) {
            echo "<script>alert('" . $ex->getMessage() . "');</script>";
        }
    }
}

?>