<?php
//echo getcwd()."<br/><br/>";

require '/home/partserve/public_html/online/libraries/PHPMailer-master/PHPMailerAutoload.php';
require_once("newlib/index.php");

$sql = "SHOW COLUMNS FROM jobinfoweb"; 
$query = "SELECT * FROM jobinfoweb";
$db = IOC::make('database', array());
 $br = '
';
$csv = '"Job","Customer","CustomerName","PhysicalAddress1","PhysicalAddress2","PhysicalAddress3","PhysicalAddress4","PhysicalAddress5","AccountContactName","AccountContactEmail","AccountContactTel","AccountContactCell","SalesContactName","SalesContactEmail","SalesContactCell","SalesContactTel","LastContactNotes","QuoteAccountNumber","QuoteDRRef","QuoteJobDate","QuoteMake","QuoteModel","QuoteSerialNumber","QuoteActionRequired","QuoteTotal","QuoteDiscountPer","QuoteDiscount","QuoteTotalTax","QuoteGrandTotal","StoreRefNo","VendorRefNo","FaultDescription","Accessories","WorkDone","Item","Status","closed","DeliveryAddress","Workshop","JobNotes"';

list($affect_rows, $datad) = $db->selectquerys($query);
foreach ($datad as $rows)
{
	extract($rows);
	$csv .=$br.'"'.$Job.'","'.$Customer.'","'.$CustomerName.'","'.$PhysicalAddress1.'","'.$PhysicalAddress2.'","'.$PhysicalAddress3.'","'.$PhysicalAddress4.'","'.$PhysicalAddress5.'","'.$AccountContactName.'","'.$AccountContactEmail.'","'.$AccountContactTel.'","'.$AccountContactCell.'","'.$SalesContactName.'","'.$SalesContactEmail.'","'.$SalesContactCell.'","'.$SalesContactTel.'","'.$LastContactNotes.'","'.$QuoteAccountNumber.'","'.$QuoteDRRef.'","'.$QuoteJobDate.'","'.$QuoteMake.'","'.$QuoteModel.'","'.$QuoteSerialNumber.'","'.$QuoteActionRequired.'","'.$QuoteTotal.'","'.$QuoteDiscountPer.'","'.$QuoteDiscount.'","'.$QuoteTotalTax.'","'.$QuoteGrandTotal.'","'.$StoreRefNo.'","'.$VendorRefNo.'","'.$FaultDescription.'","'.$Accessories.'","'.$WorkDone.'","'.$Item.'","'.$Status.'","'.$closed.'","'.$DeliveryAddress.'","'.$Workshop.'","'.$JobNotes.'"'; 
}

$path = "/home/partserve/public_html/online/cron/csv/jobinfoweb_".date('Y_m_d_H_i_s').".csv";
$ref = fopen($path, 'w+');
		fwrite($ref, $csv);   
		if(fclose($ref))
		{
			
			
			$html_body = "<p>Hi Partserve</p>
<p>Please Find attached CSV File for Jobinfoweb table Date: ".date('Y_m_d_His')." </p> 

<br/> 
<p>* PLEASE DO NOT REPLY TO THIS MESSAGE AS THIS IS AN AUTOMATED CRON ENABLED EMAIL </p>
";


$mail = new PHPMailer;   
    $mail->setFrom('Partserve csv cron', 'Jobinfoweb CSV'); 
	//$mail->addAddress("walterw@partserve.co.za", 'Jobinfoweb CSV');
    //$mail->addAddress("shantevdm@partserve.co.za", 'Jobinfoweb CSV');
	$mail->addAddress("demu@itnt.co.za", 'Jobinfoweb CSV');
    
    $mail->isHTML(true);
	$mail->addAttachment($path); 

    $mail->Subject = 'Jobinfoweb CSV';
    $mail->Body    = $html_body;
 
    if($mail->send()){
		echo "First email Sent at ".date('Y_m_d_His')." again<br/>";
	}
	else
	{
		echo "First email Not Sent at ".date('Y_m_d_His')." again<br/>";
	}
			
			
			echo "inside test 2";
			
			
		}
		 $br = '
';
/*
$html_body = "<p>Hi Partserve</p>
<p>Please Find attached CSV File for Jobinfoweb table Date: ".date('Y_m_d_His')." </p> 

<br/> 
<p>* PLEASE DO NOT REPLY TO THIS MESSAGE AS THIS IS AN AUTOMATED CRON ENABLED EMAIL </p>
";


$mail = new PHPMailer;   
    $mail->setFrom('Partserve csv cron', 'Jobinfoweb CSV'); 
	//$mail->addAddress("walterw@partserve.co.za", 'Jobinfoweb CSV');
    //$mail->addAddress("shantevdm@partserve.co.za", 'Jobinfoweb CSV');
	$mail->addAddress("demu@itnt.co.za", 'Jobinfoweb CSV');
    
    $mail->isHTML(true);
	$mail->addAttachment($path); 

    $mail->Subject = 'Jobinfoweb CSV';
    $mail->Body    = $html_body;
 
    if($mail->send()){
		echo "First email Sent at ".date('Y_m_d_His')." again<br/>";
	}
	else
	{
		echo "First email Not Sent at ".date('Y_m_d_His')." again<br/>";
	}
echo "exists and sent today modified now"; die();	
*/
?>