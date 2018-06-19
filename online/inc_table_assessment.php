  <?php
  // Old assessment SQL
  // SELECT * FROM users u
	//	LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
  //				WHERE userId= '".$_SESSION['userId']."' 
	//				AND Status like '%Under Assessment%'
	//  			ORDER BY QuoteJobDate DESC $max";
 
  // Get data from database
  require_once("../newlib/index.php");
  $query = "SELECT * FROM users u ";
  $query .= "LEFT JOIN jobinfoweb j ON (u.customer=j.customer) ";
  $query .= "WHERE userId = '" . $_SESSION['userId'] . "' ";
  $query .= "AND Status like '%Under Assessment%' ";

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
  // echo "Query: $query <br>";
  $result = mysql_query($query);
  if (!$result) die ("Database access failed: " . mysql_error());
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
      </tr>
    </thead>
    <tbody>

    <?php
    $db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($query);
		foreach ($datad as $row)
		{
          $row = mysql_fetch_assoc($result);

          $job_jobno            = $row['Job'];
          $job_quote_date       = $row['QuoteJobDate'];
          $job_quote_make       = $row['QuoteMake'];
          $job_quote_model      = $row['QuoteModel'];
          $job_quote_serial     = $row['QuoteSerialNumber'];
          $job_quote_amount     = $row['QuoteTotal'];
          $job_quote_tax        = $row['QuoteTotalTax'];
          $job_quote_total      = $row['QuoteGrandTotal'];
          $job_quote_status     = $row['Status'];

          echo "<tr>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=2'>" . $j . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_jobno . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_date . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_make . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_model . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_serial . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_amount . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_tax . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_total . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_status . "</a></td>";

          echo "</tr>";
        }

    } else {

      echo "<tr><td colspan='10'>No jobs to show</td></tr>";

    }
    ?>
    </tbody>
  </table>
