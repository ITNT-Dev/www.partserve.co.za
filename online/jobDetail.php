<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="main-content">
<br><br><br><br><br><br><br><br><br>
<img class="stripe" src="../images/stripe_large.png" width="1100" height="5">
<h2><img class="star" src="../images/star-heading.png" width="10" height="11">Job Information<img class="star" src="../images/star-heading.png" width="10" height="11"></h2>
    <img class="stripe" src="../images/stripe_large.png" width="1100" height="5">
<?php 
	require_once("../newlib/index.php");
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
			
	
		//@extract($row);

	$string = "
	<form name='joblist' action='' method='post'>
	</div>
				<p>&nbsp;</p>
					<table id='styled' cellspacing='25' summary='jobList' class='joblist' border='0'  >
						<input type='hidden' name='option' value='save'>
							<thead>
								<tr>
									<th>Job No.</th>	
									<th>Quote Account</th>				
									<th>Quote Job Date</th>
									<th>Make</th>
									<th>Model</th>
									<th>Serial No.</th>
									<th>Amount</th>
									<th>Tax.(VAT)</th>
									<th>Total</th>
									<th>Accept</th>
									<th>Reject</th>
									
									<th>Status</th>
									<th>Fault Description</th>
									<th>Work Done</th>
									<th>Item</th>
									<th>Accessories</th>
								</tr>
							</thead>
							<tbody>";		
		
		
		
		//session_start();
		
		//echo "mark".$_SESSION['userId'];	
		$sql ="SELECT * FROM users u
				LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
				WHERE userId= '".$_SESSION['userId']."' 
				ORDER BY QuoteJobDate DESC
				";//
		$db = IOC::make('database', array()); 
		list($affect_rows, $datad) = $db->selectquerys($sql);
			foreach ($datad as $row)
		  {
		  		extract($row);
				
				$sql ="SELECT * FROM JobUpdateWeb
						WHERE job= '".$Job."' ";//
				$db = IOC::make('database', array());
				list($affect_rows, $datad) = $db->selectquerys($sql);
				$answer="visible";
				if($affect_rows>0 ){ $answer="hidden";}
				
			$string .= "	<tr>
								<td>".$Job."</td>
								<td>".$QuoteAccountNumber."</td>
								<td>".$QuoteJobDate."</td>
								<td>".$QuoteMake."</td>
								<td>".$QuoteModel."</td>
								<td>".$QuoteSerialNumber."</td>
								<td>".$QuoteTotal."</td>
								<td>".$QuoteTotalTax."</td>			
								<td>".$QuoteGrandTotal."</td>					
								<td align='center'>
									<a href='accept.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='accept' ".@$answer." >Accept</a> 
								</td>
								<td align='center'>
									<a href='reject.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='reject' ".@$answer." >Reject</a> 
								</td>
								<td>".$Status."</td>
								<td>".$FaultDescription."</td>		
								<td>".$WorkDone."</td>	
								<td>".$Item."</td>	
								<td>".$Accessories."</td>	
							</tr>
							";
		}

print $string;




?>
<!--<form method="post" action="" target="_self" name="mainForm">
<table dir="ltr" class="">
	<tr>
		<td align="right">Job Number</td>
		<td><input type="text" accesskey="" alt="" name="jobNum" size="" src="" value="" maxlength="" title="" class="" disabled></td>
	</tr>
	<tr>
		<td align="right">Customer</td>
		<td><input type="text" accesskey="" alt="" name="customer" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Customer Name</td>
		<td><input type="text" accesskey="" alt="" name="customerName" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Physical Address</td>
		<td><input type="text" accesskey="" alt="" name="physicalAddress" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
		<td align="right">Account Contact Name</td>
		<td><input type="text" accesskey="" alt="" name="accContactName" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Account Contact Email</td>
		<td><input type="text" accesskey="" alt="" name="accContactEmail" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Account Contact Tel</td>
		<td><input type="text" accesskey="" alt="" name="accContactTel" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Account Contact Cell</td>
		<td><input type="text" accesskey="" alt="" name="accContactCell" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
		<td align="right">Sales Contact Name</td>
		<td><input type="text" accesskey="" alt="" name="salesContactName" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Sales Contact Tel</td>
		<td><input type="text" accesskey="" alt="" name="salesContactTel" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Sales Contact Cell</td>
		<td><input type="text" accesskey="" alt="" name="salesContactCell" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Sales Contact Email</td>
		<td><input type="text" accesskey="" alt="" name="salesContactEmail" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Last Contact Notes</td>
		<td><input type="text" accesskey="" alt="" name="lastContactNotes" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
		<td align="right">Quote Account Number</td>
		<td><input type="text" accesskey="" alt="" name="quoteAccNum" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Quote DR REF</td>
		<td><input type="text" accesskey="" alt="" name="quoteDrRef" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Quote Job date</td>
		<td><input type="text" accesskey="" alt="" name="quoteJobDate" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Quote Make</td>
		<td><input type="text" accesskey="" alt="" name="quoteMake" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Quote Model</td>
		<td><input type="text" accesskey="" alt="" name="quoteModel" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
     <tr>
		<td align="right">Quote Serial Number</td>
		<td><input type="text" accesskey="" alt="" name="quoteSerialNumber" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
        <tr>
		<td align="right">Fault Description</td>
		<td><input type="text" accesskey="" alt="" name="faultDescription" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Accessories</td>
		<td><input type="text" accesskey="" alt="" name="accessories" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Work Done</td>
		<td><input type="text" accesskey="" alt="" name="workDone" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr>
		<td align="right">Item</td>
		<td><input type="text" accesskey="" alt="" name="item" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
     <tr>
		<td align="right">Status</td>
		<td><input type="text" accesskey="" alt="" name="status" size="" src="" value="" maxlength="" title="" class="" ></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
    	<th align="right">Action Required</th>
        <th align="right">Amount</th>
		<th align="right">Discount</th>
		<th align="right">Tax</th>
		<th align="right">Total</th>
        <td>&nbsp;</td>
       
    </tr>
	<tr>
    	<td align="right"><input type="text" accesskey="" alt="" name="quoteActionRequired" size="" src="" value="" maxlength="" title="" class="" ></td>
        <td align="right"><input type="text" accesskey="" alt="" name="quoteAmount" size="" src="" value="" maxlength="" title="" class="" ></td>
        <td align="right"><input type="text" accesskey="" alt="" name="quoteDisount" size="" src="" value="" maxlength="" title="" class="" ></td>
        <td align="right"><input type="text" accesskey="" alt="" name="quoteTax" size="" src="" value="" maxlength="" title="" class="" ></td>
        <td align="right"><input type="text" accesskey="" alt="" name="quoteTotal" size="" src="" value="" maxlength="" title="" class="" ></td>
        <td>&nbsp;</td>
        <td align="right"><input type="button" accesskey="" alt="" name="accept" size="" src="" value="Accept" maxlength="" title="" class="" >
       					  <input type="button" accesskey="" alt="" name="decline" size="" src="" value="Decline" maxlength="" title="" class="" ></td>
    </tr>
    
</table>
</form>-->


</body>
</html>
