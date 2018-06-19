<?php 
require_once('include/db_access.php');
require_once('include/functions.php');
require_once dirname(__FILE__) . '/_autoload.php';

	
if ( (isset($_GET['answer']) ) && ($_GET['answer']!=='null') ){

		@extract($_GET);
		
		$dbObject = new dbObject();
		$dbObject->dbConnect(); 
		
		$sqlUpdate="UPDATE jobinfoweb 
				SET Status='Quote Accepted' WHERE Job='".$Job."'
				";
		$resultsUpdate = $dbObject->dbQuery($sqlUpdate);

	
		//echo "mark".$_SESSION['userId'];	
		$sql="INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactTel,SalesContactCell,AcceptQuote,reason)
				VALUES
				(
				'".mysql_escape_string($Job)."',
				'".mysql_escape_string($Customer)."',
				'".mysql_escape_string($AccountContactName)."',
				'".mysql_escape_string($AccountContactEmail)."',
				'".mysql_escape_string($AccountContactTel)."',
				'".mysql_escape_string($AccountContactCell)."',
				'".mysql_escape_string($SalesContactName)."',
				'".mysql_escape_string($SalesContactEmail)."',
				'".mysql_escape_string($SalesContactTel)."',
				'".mysql_escape_string($SalesContactCell)."',
				'1',
				'".mysql_escape_string($answer)."'
				)
				";

		$results = $dbObject->dbQuery($sql);
                
                // http://newdev.itntdev.co.za/onlinejobtracking/online/accept.php?Job=//JN157965&Customer=&AccountContactName=&AccountContactEmail=&AccountContactTel=&AccountContactCell=&SalesContactName=&SalesContactEmail=&SalesContactTel=&SalesContactCell=

		if ($results)
		{

			$mail = new PHPMailer();

			$mail->isHTML(true);

			$htmlMessage = "Please Note:<br><br>Job : " . $Job . "<br><br>Customer: ".$Customer."<br><br>Quote has been ACCEPTED by client.<br/><br/>Regards<br/>Partserve Online";
//			$plainTextMessage = 'Dear ' . $user->usr_name . PHP_EOL
//				. 'Plese find attached the quotation for ' . $total . ' credits requested on ITNT BULK SMS.' . PHP_EOL . PHP_EOL
//				. 'Regard ' . PHP_EOL
//				. ' ITNT BULK SMS';
			$mail->setFrom('info@partserve.co.za', 'Partserve');
			$mail->addAddress($AccountContactEmail);
			$mail->addAddress('csteam@partserve.co.za');   //csteam@partserve.co.za
			if(isset($File) && $File != null)
			{
//				Here I add the pdf if the pdf it has been uplaoded by the user
				$mail->AddAttachment($File);
			}
			$mail->Subject = 'Quote Accepted';
			$mail->Body = $htmlMessage;
			$mail->send();

	    }
	
	}
	
	redirect("acceptCheck.php?Job=".$_GET['Job'] );
	
?>