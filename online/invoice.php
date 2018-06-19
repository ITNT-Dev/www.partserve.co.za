<?php
   if(! empty($_POST)){
  
   require_once './mpdf/mpdf.php';
   $mpdf = new Mpdf();
   ob_start();
   ?>
<!doctype html>
<html>
   <?php
      session_start();
      require_once("../newlib/index.php");
      include "../library/stdinc.php";
      require_once(dirname(__FILE__).'/../config/config.inc.php');
      
      require_once '../bootstrap.php'; // load my required files
      
      
      $pagename = "";
      
      date_default_timezone_set('Africa/Johannesburg');
      
      $userId = $_SESSION['userId'];
      if ($userId < 1 ) {
        header("Location: onlinejobtracking.php");
        exit();
        // echo "User ID: " . $_SESSION['userId'] . "<br>";
      }
      $Job   = htmlentities($_GET['qid']);
      // echo "Job: $Job<br>";
      $icon  = isset($_GET['icon']) ? htmlentities($_GET['icon']) : "";
      // echo "Icon: $icon<br>";
      if ($icon == "") {
        $icon = 1;
      }
      // echo "Icon $icon <br>";
      $browser    = $_SERVER['HTTP_USER_AGENT'];
      $ipAddress  = $_SERVER['REMOTE_ADDR'];
      
              // Get 
              $query = "SELECT * FROM JobUpdateWeb ";
              $query .= "WHERE Job = '" . $Job . "' ";
      //         echo "Query: $query <br>";
             $db = IOC::make('database', array());
      	list($affect_rows, $datad) = $db->selectquerys($query);
          
           foreach ($datad as $query_data)
            {
             
           
              $Customer              = $query_data['Customer'];
             // echo "Customer: $Customer <br>";
              $AccountContactName    = $query_data['AccountContactName'];
              $AccountContactEmail   = $query_data['AccountContactEmail'];
              $AccountContactTel     = $query_data['AccountContactTel'];
              $AccountContactCell    = $query_data['AccountContactCell'];
              $SalesContactName      = $query_data['SalesContactName'];
              $SalesContactEmail     = $query_data['SalesContactEmail'];
              $SalesContactTel       = $query_data['SalesContactTel'];
              $SalesContactCell      = $query_data['SalesContactCell'];
              $AcceptQuote           = $query_data['AcceptQuote'];
              $RejectQuote           = $query_data['RejectQuote'];
              $Reason                = $query_data['reason'];
           }
      
              // Get Job Information
              $query = "SELECT * FROM jobinfoweb ";
              $query .= "WHERE Job = '" . $Job . "' ";
              // echo "Query: $query <br>";
             
              
              $db = IOC::make('database', array());
      	list($affect_rows, $datad) = $db->selectquerys($query);
          
           foreach ($datad as $query_data)
            {
              $QouteAccountEmail      = $query_data['AccountContactEmail']; 
              
              $QuoteAccountNumber     = $query_data['QuoteAccountNumber'];
              $QuoteJobDate           = $query_data['QuoteJobDate'];
              $QuoteMake              = $query_data['QuoteMake'];
              $QuoteModel             = $query_data['QuoteModel'];
              $QuoteSerialNumber      = $query_data['QuoteSerialNumber'];
              $QuoteTotal             = $query_data['QuoteTotal'];
              $QuoteTotalTax          = $query_data['QuoteTotalTax'];
              $QuoteGrandTotal        = $query_data['QuoteGrandTotal'];
      
              $FaultDescription       = $query_data['FaultDescription'];
              $WorkDone               = $query_data['WorkDone'];
              $workList               = explode('|', $WorkDone);
              $Item                   = $query_data['Item'];
              $itemList               = explode('|', $Item);
              $Accessories            = $query_data['Accessories'];
              $AccessoriesList        = explode('|', $Accessories);
              $Status                 = $query_data['Status'];
              $JobNotes               = trim($query_data['JobNotes']);
              
              $LastContactNotes = trim($query_data['LastContactNotes']);
       }
              $cTemp = "List job " . $Job . " for customer " . $Customer . " ";
              ?>
   <head>
      <style>
         .invoice-box {
         max-width: 800px;
         margin: auto;
         padding: 5px;
         height: 95%;
         font-size: 16px;
         line-height: 24px;
         font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
         color: #555;
         }
         .invoice-box table {
         width: 100%;
         line-height: inherit;
         text-align: left;
         }
         .invoice-box table td {
         padding: 5px;
         vertical-align: top;
         }
         .invoice-box table tr td:nth-child(2) {
         text-align: right;
         }
         .invoice-box table tr.top table td {
         padding-bottom: 20px;
         }
         .invoice-box table tr.top table td.title {
         font-size: 45px;
         line-height: 45px;
         color: #333;
         }
         .invoice-box table tr.information table td {
         padding-bottom: 40px;
         }
         .invoice-box table tr.heading td {
         background: #eee;
         border-bottom: 1px solid #ddd;
         font-weight: bold;
         }
         .invoice-box table tr.details td {
         padding-bottom: 20px;
         }
         .invoice-box table tr.item td{
         border-bottom: 1px solid #eee;
         }
         .invoice-box table tr.item.last td {
         border-bottom: none;
         }
         .invoice-box table tr.total td:nth-child(2) {
         border-top: 2px solid #eee;
         font-weight: bold;
         }
         @media only screen and (max-width: 600px) {
         .invoice-box table tr.top table td {
         width: 100%;
         display: block;
         text-align: center;
         }
         .invoice-box table tr.information table td {
         width: 100%;
         display: block;
         text-align: center;
         }
         }
         /** RTL **/
         .rtl {
         direction: rtl;
         font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
         }
         .rtl table {
         text-align: right;
         }
         .rtl table tr td:nth-child(2) {
         text-align: left;
         }
      </style>
   </head>
   <body>
      <div class="invoice-box">
         <table cellpadding="0" cellspacing="0" border="1px">
            <tr class="top">
               <td colspan="6">
                  <table>
                     <tr>
                        <td class="title">
                           <img src="https://www.partserve.co.za/images/logo/PartServe_Logo.png" style="width:100%; max-width:200px;">
                        </td>
                        <td>
                           PROFORMA INVOICE #: <?php echo $Job ?><br>
                           Created: <?php echo date('d F Y') ?><br>
						   <?php if( $Customer =! '' &&  $Customer != ''){?>
						   To: <?php echo  $Customer; ?>
						   <?php } ?>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr class="information">
               <td colspan="6">
                  <table>
                     <tr>
                        <td>
                           PARTSERVE CHANNEL SUPPORT (PTY)<br>
                           PO Box 781744<br>
                           Sandton<br>2146
                        </td>
                        <td>
                           Reg No: 1999/26552/07<br>
                           Vat Number: 420 018 6346<br>
                           Phone: 011 201 7777<br>
                           Fax: 011 201 7999
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
			<tr class="information">
               <td colspan="6" style="font-size: 10px">
                  <b>Model :</b> <?php echo $QuoteModel; ?><br>
				  <b>Serial number :</b> <?php echo $QuoteSerialNumber; ?>
                  
               </td>
            </tr>
            <tr class="information">
               <td colspan="6" style="font-size: 10px">
                  <b>Fault description</b><br>
                  <?php echo strtolower($FaultDescription) ?>
               </td>
            </tr>
			<tr class="information">
               <td colspan="6" style="font-size: 10px">
                  <b>Work Done</b><br>
                  <?php echo strtolower($WorkDone) ?>
               </td>
            </tr>
            <tr class="item">
               <td colspan="6" style="font-size: 15px">
               </td>
            </tr>
            <tr class="heading">
               <td width="1px">
                  Store
               </td>
               <td>
                  Part Number
               </td>
               <td>
                  Description
               </td>
               <td>
                  QTY
               </td>
               <td>
                  Price
               </td>
               <td>
                  Part ETA
               </td>
            </tr>
            <?php 
               foreach($itemList as $item_string){ 
                 $item_info = explode('~', $item_string);
               ?>
            <tr class="item">
               <?php  
                  foreach( $item_info as $description){ ?>
               <td>
                  <?php echo $description; ?>
               </td>
               <?php } ?>
            </tr>
            <?php 
               } ?>
            <tr rowspan=3 class="total">
               <td colspan=6 style="text-align: right;">
                  VAT: <?php echo $QuoteTotalTax; ?>
               </td>
            </tr>
            <tr class="total">
               <td colspan=6 style="text-align: right;">
                  Total: <?php echo $QuoteTotal; ?>
               </td>
            </tr>
            <tr class="total">
               <td colspan=6 style="text-align: right;">
                  Grand Total: <?php echo $QuoteGrandTotal; ?>
               </td>
            </tr>
            <tr class="total">
               <td colspan=6>
                  <br><br> <br><br>
                  The banking details are as follows:
               </td>
            </tr>
            <tr class="information">
               <td colspan="6" style="text-align: right;">
                  <table>
                     <tr>
                        <td style="font-size: 10px">
                           PAYMENT DETAILS<br>
                           BANK : Standard bank Sandton<br>
                           Account number 420 96 44 60<br>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
			<tr class="information">
               <td colspan="6" style="text-align: center; font-size:  10px">
			     <br><br><br><br>
                 <p>Note for COD customers a 50% deposit is required before work will be commenced</p>
               </td>
            </tr>
         </table>
      </div>
   </body>
   <p>&nbsp;</p>
   <?php 
      $html = ob_get_contents();
      ob_end_clean();
      $mpdf->WriteHTML(utf8_encode($html));
      
      if(isset($_POST['download'])){
      	$mpdf->Output('./invoices/'.$Job.'.pdf', 'F');
      	
      	
      
          
      
      
      	
      }else{
      	$config['protocol'] = 'sendmail';
      	$config['mailpath'] = '/usr/sbin/sendmail';
      	$config['charset'] = 'iso-8859-1';
      	$config['wordwrap'] = TRUE;
      
      	require_once './Email.php';
      
      	$email = new Email($config);
      	$content = $mpdf->Output('./invoices/'.$Job.'.pdf', 'S');
      
      	//attach($file, $disposition = '', $newname = NULL, $mime = '')
      
      
      	$email->attach($content, '', $Job . '.pdf', 'application/pdf');
      	$email->to($_POST['email']);
      	$email->from('no-reply@partserve.co.co.za');
      	$email->subject('PROFORMA INVOICE FOR JOB '.$Job);
      	$email->message('Please find the attached document: .');
      	$email->send();
      }
      $_POST = null;
      }
      ?>