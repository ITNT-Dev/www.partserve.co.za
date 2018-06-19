  <?php
  // Old SQL Statement
	// $sql ="SELECT * FROM users u
	//		LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
	//		WHERE userId= '".$_SESSION['userId']."'
	//		AND j.job IN (SELECT job FROM JobUpdateWeb)
	//		AND Status like '%Quote%'
	//		ORDER BY QuoteJobDate DESC $max";//

require_once("../newlib/index.php");
  // Get data from database
  $query = "SELECT * FROM users u ";
  $query .= "LEFT JOIN jobinfoweb j ON (u.customer = j.customer) ";
  $query .= "WHERE userId = '" . $_SESSION['userId'] . "' ";
  $query .= "AND j.job IN (SELECT job FROM JobUpdateWeb) ";
  $query .= "AND Status like '%Quote%' ";

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
  $query .= " LIMIT " . $no_start . ", " . _ROWS_;
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
      </tr>
    </thead>
    <tbody>

    <?php
    $db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($query);
		foreach ($datad as $row)
		{
        $job_jobno            = $row['Job'];
        $job_quote_date       = $row['QuoteJobDate'];
        $job_quote_make       = $row['QuoteMake'];
        $job_quote_model      = $row['QuoteModel'];
        $job_quote_serial     = $row['QuoteSerialNumber'];
        $job_quote_amount     = $row['QuoteTotal'];
        $job_quote_tax        = $row['QuoteTotalTax'];
        $job_quote_total      = $row['QuoteGrandTotal'];
        $job_quote_status     = $row['Status'];
        $job_quote_accept     = $row['AcceptQuote'];
        $job_quote_reject     = $row['RejectQuote'];

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
        $query2 = "SELECT * FROM JobUpdateWeb WHERE Job = '" . $Job . "' ";
        // echo "Query2: $query2 <br>";
        $result2 = mysql_query($query2);
        if (!$result2) die ("Database access failed: " . mysql_error());
        $query_data2 = mysql_fetch_array($result2);

        $job_quote_accept       = $query_data2['AcceptQuote'];

        if ($job_quote_accept == 1) {
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>Accepted</a></td>";
        } else {
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>Rejected</a></td>";
        }

        echo "</tr>";
      }
      ?>
      </tbody>


  </table>

