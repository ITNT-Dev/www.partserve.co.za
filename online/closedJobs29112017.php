	`<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("../newlib/index.php");
$pagename = "closedJobs.php";

//  error_reporting(0);

date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ($userId < 1 ) {
  header("Location: ../onlinejobtracking.php");
  exit();
  // echo "User ID: " . $_SESSION['userId'] . "<br>";
}

// Connect to database
$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword);

$sort        = isset($_GET['sort']) ? htmlentities($_GET['sort']) : 0;
if ($sort < 1) {
  $sort = 1;
}
// echo "Sort: $sort <br>";

$sort_order  = isset($_GET['sort_order']) ? htmlentities($_GET['sort_order']) : "";
if ($sort == "") {
  $sort = 'A';
}
// echo "Sort: $sort <br>";

$browser    = $_SERVER['HTTP_USER_AGENT'];
$ipAddress  = $_SERVER['REMOTE_ADDR'];



// Get pagination details
$query = "SELECT * FROM users u ";
$query .= "LEFT JOIN jobinfoweb j ON (u.customer = j.customer) ";
$query .= "WHERE userId = '" . $_SESSION['userId'] . "' ";
$query .= "AND j.job IN (SELECT job FROM JobUpdateWeb) ";
$query .= "AND (Status = 'Quote Accepted' OR Status = 'Quote Rejected')";
$db = IOC::make('database', array());
list($affect_rows, $datad) = $db->selectquerys($query);
$no_records = $affect_rows;
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

// echo "No Start: $no_start<br>";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PartServe</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style2.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

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
  <body>

  
    <div class="container">
      <div class="row"></div>
<div class="row">
    
    
<?php require_once (dirname(__FILE__) . "/header.php"); ?>
      </div>

      <div class="row">

        <p>&nbsp;</p>

        <?php //include "inc_table_jobs.php"; ?>
          <?php
  // Old SQL Statement
	// $sql ="SELECT * FROM users u
	//		LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
	//		WHERE userId= '".$_SESSION['userId']."'
	//		AND j.job IN (SELECT job FROM JobUpdateWeb)
	//		AND Status like '%Quote%'
	//		ORDER BY QuoteJobDate DESC $max";//


  // Get data from database
  $query = "SELECT * FROM users u ";
$query .= "LEFT JOIN jobinfoweb j ON (u.customer = j.customer) ";
$query .= "WHERE userId = '" . $_SESSION['userId'] . "' ";
$query .= "AND j.job IN (SELECT job FROM JobUpdateWeb) ";
$query .= "AND (Status = 'Quote Accepted' OR Status = 'Quote Rejected')";

  if ($sort == 1) {
    $query .= "ORDER BY QuoteJobDate ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 2) {
    $query .= "ORDER BY QuoteMake ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 3) {
    $query .= "ORDER BY QuoteModel ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 4) {
    $query .= "ORDER BY QuoteSerialNumber ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 5) {
    $query .= "ORDER BY QuoteTotal ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 6) {
    $query .= "ORDER BY QuoteTotalTax ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 7) {
    $query .= "ORDER BY QuoteGrandTotal ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } else {
    // Default - List by date
    $query .= "ORDER BY QuoteJobDate DESC ";
  }
 
  ?>

  <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Job No</a></th>
        <th>Quote Job Date 
        <?php
        if ($sort == 1) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=1&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=1&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=1&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Make
        <?php
        if ($sort == 2) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=2&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=2&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=2&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Model 
        <?php
        if ($sort == 3) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=3&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=3&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=3&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Serial No
        <?php
        if ($sort == 4) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=4&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=4&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=4&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Amount 
        <?php
        if ($sort == 5) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=5&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=5&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=5&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Tax (VAT)
        <?php
        if ($sort == 6) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=6&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=6&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=6&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Total
        <?php
        if ($sort == 7) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=7&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=7&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=7&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Status</th>
        <th>Response</th>
	<th>Deliver Address</th>
	<th>Workshop</th>
      </tr>
    </thead>
    <tbody>

    <?php

	$db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($query);
	$j  =1;
      foreach ($datad as $row)
      {
		
        $job_jobno            = @$row['Job'];
        $job_quote_date       = $row['QuoteJobDate'];
        $job_quote_make       = $row['QuoteMake'];
        $job_quote_model      = $row['QuoteModel'];
        $job_quote_serial     = $row['QuoteSerialNumber'];
        $job_quote_amount     = $row['QuoteTotal'];
        $job_quote_tax        = $row['QuoteTotalTax'];
        $job_quote_total      = $row['QuoteGrandTotal'];
        $job_quote_status     = $row['Status'];
        $job_quote_accept     = @$row['AcceptQuote'];
        $job_quote_reject     = @$row['RejectQuote'];
	$delivery_address       = $row['DeliveryAddress'];
		$workshop       = $row['Workshop'];

        echo "<tr>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $j . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_jobno . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_date . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_make . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_model . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_serial . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_amount . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_tax . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_total . "</a></td>";
        echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=4'>" . $job_quote_status . "</a></td>";
        
        // Get Job rejected / accepted
        // if($line['AcceptQuote']==1){$label='Accepted';} else {$label='Rejected';}
//        $query2 = "SELECT * FROM JobUpdateWeb WHERE Job = '" . @$Job . "' "; // the bug was here
        $query2 = "SELECT * FROM JobUpdateWeb WHERE Job = '" . @$job_jobno . "' ";
        // echo "Query2: $query2 <br>";
		$result2 = $conn->query($query2);
        //$result2 = mysql_query($query2);
        //if (!$result2) die ("Database access failed: " . mysql_error());
        //$query_data2 = mysql_fetch_array($result2);
		$query_data2 = $result2->fetch(PDO::FETCH_ASSOC);

        $job_quote_accept = $query_data2['AcceptQuote'];

//        print "<pre>";
//        print_r($query_data2);
//        exit;

        if ($job_quote_accept == 1) {
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>Accepted</a></td>";
        } else {
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>Rejected</a></td>";
        }
	echo "<td><a href='quote.php?qid=" . $job_jobno . "'>".$delivery_address."</a></td>";
	  echo "<td><a href='quote.php?qid=" . $job_jobno . "'>".$workshop."</a></td>";
        echo "</tr>";
	$j ++;
	}
	
	
	
	
	
	
	

    
      ?>
      </tbody>


  </table>



      </div>
  
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>

