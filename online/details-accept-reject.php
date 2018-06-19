<?php
 //session_start();
 //require_once('include/functions.php');
 
// error_reporting(E_ALL);
//ini_set('display_errors', '1');

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

<?php 
//require_once('include/db_access.php');
//$dbObject = new dbObject();
//$dbObject->dbConnect(); 
error_reporting(E_ALL);
ini_set('display_errors', '1');

		

@extract($_GET);


$workList=@explode('|',$WorkDone);
$itemList=@explode('|',$Item);

$string="
	<table id='styled' cellspacing='0' summary='jobList' class='joblist' border='1'  >
			<tr>
				<th align='right' >Job No.</th>
				<td>".$Job."</td>
			</tr>
			
			<tr>
				<th align='right'>Fault Description</th>
				<td width='200'>".$FaultDescription."</td>
			</tr>
			
			<tr>
				<th align='right'>Work Done</th>
				<td>";

foreach ($workList as $job){ 

		$string.= $job."</br>";
}
								
$string.="		</td>
			</tr>
			
			<tr>
				<th align='right'>Item</th>
				<td nowrap>";


//print_r($itemList);

$string.="<table border='1'>
			<th>Store</th>
			<th>Part Number</th>
			<th>Description</th>
			<th>QTY</th>
			<th>Price</th>
			
			<tr>";
	


	foreach ($itemList as $items){ 
			
			$itemDetails=explode('~',$items);
			
			//print_r($itemDetails);
			foreach ($itemDetails as $itemDesc){ 
				$string.= "<td align='right'>".$itemDesc."</td>";
			}
			
			$string.="</tr>";
}				
				
$string.="<tr> <td></td> <td></td> <td></td> <td>Total</td> <td align='right'>$QuoteTotal</td> </tr>
		  <tr> <td></td> <td></td> <td></td> <td>VAT</td> <td align='right'>$QuoteTotalTax</td> </tr>
		  <tr> <td></td> <td></td> <td></td> <td>Grand Total</td> <td align='right'>$QuoteGrandTotal</td> </tr>
		</table>
		</td>
		</tr>
			
			<tr>
				<th align='right'>Accessories</th>
				<td>".$Accessories."</td>
			</tr>

			<tr>
			<td></td>
			<td colspan='100%'>
			<table>
				<tr>
				<td bgcolor='#57ff55' nowrap align='center' width='300px'>
						<a bgcolor='#57ff55' href='accept.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='accept' ".@$answer." >Accept</a> 
				</td>
				<td bgcolor='#FF0000' nowrap align='center' width='300px'>
						<a href='reject.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='reject' ".@$answer." >Reject</a> 
				</td>
				</tr>
				</table>
				</td>
				
			</tr>
			";
		

print $string."<br>"."<a href=\"javascript:history.go(-1)\">GO BACK</a>";
?>

<?php //include "include/footer.php"; ?>