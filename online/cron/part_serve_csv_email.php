<?php


require_once (dirname(dirname(dirname(__FILE__))) . "/library/stdinc.php");

require_once (dirname(dirname(dirname(__FILE__))) . "/online/include/config.php");
require_once (dirname(dirname(dirname(__FILE__))) . "/online/_autoload.php");

$html_body = "<p>Hi Partserve</p>
<p>Please Find attached CSV File for Jobinfoweb table Date: ".date('Y_m_d_His')." </p>  
 
<br/>  
<p>* PLEASE DO NOT REPLY TO THIS MESSAGE AS THIS IS AN AUTOMATED CRON ENABLED EMAIL </p>
";
$path = "csv/".$_GET['path']; 
//echo $path; 

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


	
/*
$db_server = mysql_connect($dbHost, $dbUser, $dbPassword);

if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());

mysql_select_db($db) or die ("Unable to select database: " . mysql_error());
 

$sql = "SHOW COLUMNS FROM jobinfoweb"; 
$query = "truncate table jobinfoweb";

$results = mysql_query($query);

 
$result = mysql_query($query);
  
while ($row = mysql_fetch_row($result))  
    { 
        echo $row[0].", Job ".$row[1].", Customer ".$row[2] ."<br/>";
        $looping++;
    }



$no_records = mysql_num_rows($result);

// echo "No records: $no_records<p>";


// Get page number and set variables 

$no_page = isset($_GET['page']) ? sanitiseString($_GET['page']) : 0;

if (!(isset($no_page) && ($no_page/1==$no_page) && $no_page!=0)) {
  
$no_page = 1;
}
$no_start = ($no_page-1) * _ROWS_;

// echo "No Start: $no_start<br>";
 

// Check if page number less than max number of records

if ($no_start >= $no_records) {
  
$no_start = $no_records - _ROWS_;

}


if ($no_start < 0) {
  
$no_start = 0;

}


   $conn = new dbObject;
   
	if(isset($_REQUEST['month'])){
		$monthNum  = $_REQUEST['month'];
		$monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
		$month = $_REQUEST['month'];
		$year = $_REQUEST['year'];
		
		$sql = "SELECT a.* , ins.*,fc.*, prd.productName,mk.makeName,md.modelName,cl.colourName,billLabel,billAmount, c.custIDNumber,c.custFirstName,c.custSurname,concat(cu.userName,' ',cu.userSurname) deletor, assetReasonDeleted,countryName, insurancerName, assetInsurerContact FROM customer_assets a INNER JOIN customers c ON (c.custId=a.assetCustomerId) LEFT JOIN billable bl ON (bl.billId=a.assetBillId) LEFT JOIN products prd ON(prd.productId=a.assetProductId) LEFT JOIN dropdown_colours cl ON (a.assetColourId=cl.ColourId) LEFT JOIN dropdown_models md ON (a.assetModelId=md.modelId) LEFT JOIN dropdown_makes mk ON (mk.makeId=md.modelMakeId) LEFT JOIN dropdown_fitmentcentres fc ON (fc.centreId=a.assetfitmentid) LEFT JOIN dropdown_installationtypes ins ON (ins.installationTypeId=a.assetInstallationTypeId) LEFT JOIN dropdown_provinces prv ON (c.streetProvinceId=prv.provinceId) LEFT JOIN dropdown_countries cnt ON (c.streetCountryId=cnt.countryId) LEFT JOIN dropdown_insurances inr ON (a.assetInsurerId=inr.insurancerId) LEFT JOIN salesperson sp ON (sp.salesId=a.assetSalesPersonId OR sp.salesId=c.custSalesPerson) LEFT JOIN users u ON (u.userid=a.assetCreatedBy) LEFT JOIN users cu ON (cu.userid=a.assetDeletedBy) 
		where MONTH(a.assetCreated) = $month and YEAR(a.assetCreated) = $year";
//debug($sql,1);
	 $csv = '"No. ","Month-Year","Installation date","Date Captured","Fitment Centre","Installer","PRODUCT","Type of Install","Cert Number","Device","CK/ID number","Sales Lead","Sales Lead Ref","Channel Reference","Channel Contact Person"';
	 $results = $conn->dbQuery($sql);
	 $counter = 1;
	 $br = '
';
$path = 'files/csv/sales_report_'.$type.$_SESSION['adminId'].'_' . date('Y_m_d_His') . '.csv';
$url = "<P ALIGN='center'>To download report as CSV file <A HREF='".$path."' TARGET='_blank'>click here</A></P>";
echo $url;
echo "<BR/>";

	 ?>

     <?php
	 while($row = $conn->dbNextRecord($results)){
	  extract($row);
	  $months_year = "$monthName - $year";
	  $installerss = $centreName."| ".$assetInstallater;
	   $csv.=$br.'"'.$counter.'","'.$months_year.'","'.$assetInstallationDate.'","'.$assetCreated.'","'.$centreName.'","'.$assetInstallater.'","'.$productName.'","'.$installationTypeName.'","'.$assetCertificateNo.'","'.$assetTagNo.'","'.$custIDNumber.'","'.$assetLead.'","'.$assetLeadRef.'","'.$dealerName.'","'.$dealerContact.'"';
	  ?>
      

		$counter++;
	 }
		
		
		$ref = fopen($path, 'w+');
		fwrite($ref, $csv);
		fclose($ref);
		
		
	}
		