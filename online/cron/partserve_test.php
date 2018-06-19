<?php


require_once (dirname(dirname(dirname(__FILE__))) . "/library/stdinc.php");

require_once (dirname(dirname(dirname(__FILE__))) . "/online/include/config.php");
require_once (dirname(dirname(dirname(__FILE__))) . "/online/_autoload.php");
 error_reporting(E_ALL);
ini_set( 'display_errors','1'); 


$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword);
$job_id = (isset($_GET['job']) ? $_GET['job'] : 'JN173701');
//echo $job_id;
$sql= "SELECT * FROM jobinfoweb WHERE Job = '".$job_id."'";
$stmt = $conn->query($sql); 
//$row = $stmt->fetchObject();

echo "customers name is ".$stmt->fetchObject()->CustomerName." for job id = $job_id ";

phpinfo();

/*
$db_server = mysql_connect($dbHost, $dbUser, $dbPassword);

if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());

mysql_select_db($db) or die ("Unable to select database: " . mysql_error());
 

$sql = "SHOW COLUMNS FROM jobinfoweb"; 
$query = "SELECT * FROM jobinfoweb";
 $br = '
';
$results = mysql_query($query);

$count = 0; 
$csv = '"Job","Customer","CustomerName","PhysicalAddress1","PhysicalAddress2","PhysicalAddress3","PhysicalAddress4","PhysicalAddress5","AccountContactName","AccountContactEmail","AccountContactTel","AccountContactCell","SalesContactName","SalesContactEmail","SalesContactCell","SalesContactTel","LastContactNotes","QuoteAccountNumber","QuoteDRRef","QuoteJobDate","QuoteMake","QuoteModel","QuoteSerialNumber","QuoteActionRequired","QuoteTotal","QuoteDiscountPer","QuoteDiscount","QuoteTotalTax","QuoteGrandTotal","StoreRefNo","VendorRefNo","FaultDescription","Accessories","WorkDone","Item","Status","closed","DeliveryAddress","Workshop","JobNotes"';
while ($rows = mysql_fetch_assoc($results))
{ 
	extract($rows);
$csv .=$br.'"'.$Job.'","'.$Customer.'","'.$CustomerName.'","'.$PhysicalAddress1.'","'.$PhysicalAddress2.'","'.$PhysicalAddress3.'","'.$PhysicalAddress4.'","'.$PhysicalAddress5.'","'.$AccountContactName.'","'.$AccountContactEmail.'","'.$AccountContactTel.'","'.$AccountContactCell.'","'.$SalesContactName.'","'.$SalesContactEmail.'","'.$SalesContactCell.'","'.$SalesContactTel.'","'.$LastContactNotes.'","'.$QuoteAccountNumber.'","'.$QuoteDRRef.'","'.$QuoteJobDate.'","'.$QuoteMake.'","'.$QuoteModel.'","'.$QuoteSerialNumber.'","'.$QuoteActionRequired.'","'.$QuoteTotal.'","'.$QuoteDiscountPer.'","'.$QuoteDiscount.'","'.$QuoteTotalTax.'","'.$QuoteGrandTotal.'","'.$StoreRefNo.'","'.$VendorRefNo.'","'.$FaultDescription.'","'.$Accessories.'","'.$WorkDone.'","'.$Item.'","'.$Status.'","'.$closed.'","'.$DeliveryAddress.'","'.$Workshop.'","'.$JobNotes.'"'; 
}
$path = dirname(dirname(dirname(__FILE__))) . "/online/cron/csv/jobinfoweb_".date('Y_m_d_H_i_s').".csv";
$path_string =  dirname(dirname(dirname(__FILE__))) . "/online/cron/";
$path_trim = ltrim($path,$path_string);
$ref = fopen($path, 'w+');
		fwrite($ref, $csv);   
		fclose($ref); 

 
$html_body = "<p>Hi Partserve</p>
<p>Please Find attached CSV File for Jobinfoweb table Date: ".date('Y_m_d_His')." </p> 

<br/> 
<p>* PLEASE DO NOT REPLY TO THIS MESSAGE AS THIS IS AN AUTOMATED CRON ENABLED EMAIL </p>
";
header("location: https://www.partserve.co.za/online/cron/part_serve_csv_email.php?path=$path_trim");
 
	
 
 $mail = new PHPMailer;
    $mail->setFrom('Partserve csv cron', 'Jobinfoweb CSV');
    $mail->addAddress("shantevdm@partserve.co.za", 'Jobinfoweb CSV');
    $mail->addBCC("demu@itnt.co.za");
    $mail->isHTML(true);
	$mail->addAttachment($path);

    $mail->Subject = 'Jobinfoweb CSV';
    $mail->Body    = $html_body;

    if($mail->send()){
		echo "First email Sent <br/>";
	}
	
	 $mail = new PHPMailer;
    $mail->setFrom('Partserve csv cron', 'Jobinfoweb CSV');
    $mail->addAddress("walterw@partserve.co.za", 'Jobinfoweb CSV');
    $mail->addBCC("demu@itnt.co.za");
    $mail->isHTML(true); 
	$mail->addAttachment($path);

    $mail->Subject = 'Jobinfoweb CSV';
    $mail->Body    = $html_body;

    if($mail->send()){
		echo "second email Sent <br/>";
	}
	
echo "exists and sent today modified now"; die();*/		
?>