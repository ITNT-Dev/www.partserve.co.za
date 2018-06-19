<?php 
//require_once('include/db_access.php');
//$dbObject = new dbObject();
//$dbObject->dbConnect(); 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

		

@extract($_GET);


$workList=explode('|',$WorkDone);
$itemList=explode('|',$Item);

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
			
			";
		

print $string."<br>"."<a href=\"javascript:history.go(-1)\">GO BACK</a>";
?>