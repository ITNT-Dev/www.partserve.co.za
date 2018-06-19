<?php

require_once dirname(dirname(dirname(__FILE__))).'/bootstrap.php';

date_default_timezone_set('Africa/Johannesburg');

set_time_limit(0); // :) run forever

$debug = false; // if set to true, then only the first record will be processed - for testing

if ( ! function_exists("write_log"))
{
    function write_log($section, $message)
    {
        try
        {
            $dirname = dirname(__FILE__)."/logs/".date("Y-m-d");

            if ( ! file_exists($dirname))
            {
                @mkdir($dirname);
            }

            // log this exception
            if ($handle = fopen($dirname."/".date('H').".txt", "a"))
            {
                fwrite($handle, date('Y-m-d H:i:s A: ').$section." - ".$message."\r\n");
                fclose($handle);
            }
        }
        catch (Exception $e)
        {
            print "{$e->getMessage()}<br>\r\n";
        }
    }
}

if ( ! function_exists("send_email"))
{
    function send_email($to, $subject, $message, $bcc = "")
    {
        try
        {
            $from = ''; // assuming mail will use the default mail 'partserve@vm.partserve.co.za'

            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Create email headers
            $headers .= 'From: '.$from."\r\n".
                "Bcc: {$bcc} \r\n".
                'Reply-To: '.$from."\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Sending email
            return mail($to, $subject, $message, $headers);
        }
        catch (Exception $exception)
        {
            write_log('send_mail', $exception->getMessage());
        }
    }
}

$odbc_dsn = "test";
$odbc_user = "Master";
$odbc_password = "JobTrack";

write_log("odbcConnect.php", strtoupper("Cron started executing at ".date('Y-m-d H:i:s A')));

if ( ! $connection = odbc_connect($odbc_dsn, $odbc_user, $odbc_password))
{
    //send_email("development@itnt.co.za", "DB update cron", "Cannot establish an odbc connection to Partserv server. <br>".odbc_error());
    die("Cannot establish an ODBC connection to Partserv server.");
}

echo "Connected to Partserv server.<br>";

$result = odbc_exec($connection, "SELECT * FROM jobinfoweb");
$counter = 0;

while (odbc_fetch_row($result))
{
    try
    {
        $status = trim(odbc_result($result, "Status"));

        if (in_array($status, array("Quote Accepted", "Quote Rejected")))
        {
            $table_name = JobInfoWeb::table_name();
            JobInfoWeb::query("UPDATE {$table_name} SET Status = 'Quote Accepted' WHERE Job = ? ", array(trim(odbc_result($result, "Job"))));
            unset($table_name);

            if ( ! $job_update_web = JobUpdateWeb::find_by_job(odbc_result($result, "Job")))
            {
                if ($status == 'Quote Accepted')
                {
                    JobUpdateWeb::create(array(
                        strtolower('Job') => trim(odbc_result($result, "Job")),
                        strtolower('Customer') => trim(odbc_result($result, "Customer")),
                        strtolower('AccountContactName') => trim(odbc_result($result, "AccountContactName")),
                        strtolower('AccountContactEmail') => trim(odbc_result($result, "AccountContactEmail")),
                        strtolower('AccountContactTel') => trim(odbc_result($result, "AccountContactTel")),
                        strtolower('AccountContactCell') => trim(odbc_result($result, "AccountContactCell")),
                        strtolower('SalesContactName') => trim(odbc_result($result, "SalesContactName")),
                        strtolower('SalesContactEmail') => trim(odbc_result($result, "SalesContactEmail")),
                        strtolower('SalesContactTel') => trim(odbc_result($result, "SalesContactTel")),
                        strtolower('SalesContactCell') => trim(odbc_result($result, "SalesContactCell")),
                        strtolower('AcceptQuote') => "1",
                        strtolower('reason') => 'AutoAccepted',
                    ));
                }
                else
                {
                    JobUpdateWeb::create(array(
                        strtolower('Job') => trim(odbc_result($result, "Job")),
                        strtolower('Customer') => trim(odbc_result($result, "Customer")),
                        strtolower('AccountContactName') => trim(odbc_result($result, "AccountContactName")),
                        strtolower('AccountContactEmail') => trim(odbc_result($result, "AccountContactEmail")),
                        strtolower('AccountContactTel') => trim(odbc_result($result, "AccountContactTel")),
                        strtolower('AccountContactCell') => trim(odbc_result($result, "AccountContactCell")),
                        strtolower('SalesContactName') => trim(odbc_result($result, "SalesContactName")),
                        strtolower('SalesContactEmail') => trim(odbc_result($result, "SalesContactEmail")),
                        strtolower('SalesContactTel') => trim(odbc_result($result, "SalesContactTel")),
                        strtolower('SalesContactCell') => trim(odbc_result($result, "SalesContactCell")),
                        strtolower('RejectQuote') => "1",
                        strtolower('reason') => 'AutoRejected',
                    ));
                }
            }
        }

        $attributes = array(
            strtolower('Job') => trim(odbc_result($result, "Job")),

            strtolower('Customer') => trim(odbc_result($result, "Customer")),
            strtolower('CustomerName') => trim(odbc_result($result, "CustomerName")),

            strtolower('PhysicalAddress1') => trim(odbc_result($result, "PhysicalAddress1")),
            strtolower('PhysicalAddress2') => trim(odbc_result($result, "PhysicalAddress2")),
            strtolower('PhysicalAddress3') => trim(odbc_result($result, "PhysicalAddress3")),
            strtolower('PhysicalAddress4') => trim(odbc_result($result, "PhysicalAddress4")),
            strtolower('PhysicalAddress5') => trim(odbc_result($result, "PhysicalAddress5")),

            strtolower('AccountContactName') => trim(odbc_result($result, "AccountContactName")),
            strtolower('AccountContactEmail') => trim(odbc_result($result, "AccountContactEmail")),
            strtolower('AccountContactTel') => trim(odbc_result($result, "AccountContactTel")),
            strtolower('AccountContactCell') => trim(odbc_result($result, "AccountContactCell")),

            strtolower('SalesContactName') => trim(odbc_result($result, "SalesContactName")),
            strtolower('SalesContactEmail') => trim(odbc_result($result, "SalesContactEmail")),
            strtolower('SalesContactCell') => trim(odbc_result($result, "SalesContactCell")),
            strtolower('SalesContactTel') => trim(odbc_result($result, "SalesContactTel")),

            strtolower('LastContactNotes') => trim(odbc_result($result, "LastContactNotes")),

            strtolower('QuoteAccountNumber') => trim(odbc_result($result, "QuoteAccountNumber")),
            strtolower('QuoteDRRef') => trim(odbc_result($result, "QuoteDRRef")),
            strtolower('QuoteJobDate') => trim(odbc_result($result, "QuoteJobDate")),
            strtolower('QuoteMake') => trim(odbc_result($result, "QuoteMake")),
            strtolower('QuoteModel') => trim(odbc_result($result, "QuoteModel")),
            strtolower('QuoteSerialNumber') => trim(odbc_result($result, "QuoteSerialNumber")),
            strtolower('QuoteActionRequired') => trim(odbc_result($result, "QuoteActionRequired")),
            strtolower('QuoteTotal') => trim(odbc_result($result, "QuoteTotal")),
            strtolower('QuoteDiscountPer') => trim(odbc_result($result, "QuoteDiscountPer")),
            strtolower('QuoteDiscount') => trim(odbc_result($result, "QuoteDiscount")),
            strtolower('QuoteTotalTax') => trim(odbc_result($result, "QuoteTotalTax")),
            strtolower('QuoteGrandTotal') => trim(odbc_result($result, "QuoteGrandTotal")),

            strtolower('StoreRefNo') => trim(odbc_result($result, "StoreRefNo")),
            strtolower('VendorRefNo') => trim(odbc_result($result, "VendorRefNo")),

            strtolower('FaultDescription') => trim(odbc_result($result, "FaultDescription'")),
            strtolower('Accessories') => trim(odbc_result($result, "Accessories")),
            strtolower('WorkDone') => trim(odbc_result($result, "WorkDone")),
            strtolower('Item') => trim(odbc_result($result, "Item")),

            strtolower('Status') => trim(odbc_result($result, "Status")),

            strtolower('DeliveryAddress') => trim(odbc_result($result, "DeliveryAddress")),

            strtolower('Workshop') => trim(odbc_result($result, "Workshop")),
        );

        // load local job
        $job = JobInfoWeb::find_by_job(odbc_result($result, "Job"));

        if ( ! is_null($job))
        {
            // update
            $job->set_attributes($attributes);
        }
        else
        {
            // create
            $job = new JobInfoWeb($attributes);
        }

        $job->save();

        write_log("jobinfoweb", "Success - retrieved and updated record for the job '{$job->job}' - {$job->customer} - {$job->customername} - {$job->status}");

        $counter++;

        unset($attributes);
    }
    catch (Exception $e)
    {
        // log this exception
        write_log("jobinfoweb", "Error - {$e->getMessage()}");
    }

    if ($debug) // process only the first record and break out
        break;
}

write_log("jobinfoweb", strtoupper("Success - {$counter} records successfully updated."));

unset($result, $counter);

$result = odbc_exec($connection, "SELECT * FROM JobUpdateCustomer");
$counter = 0;

while (odbc_fetch_row($result))
{
    try
    {
        $attributes = array(
            'loginname' => trim(odbc_result($result, "CustomerID")),
            'loginpassword' => trim(odbc_result($result, "Password")),
            'customer' => trim(odbc_result($result, "CustomerID")),
        );

        if ( ! $user = User::find_by_loginname(odbc_result($result, "CustomerID")))
        {
            User::create($attributes);
        }
        else
        {
            $user->update_attributes($attributes);
        }

        write_log("JobUpdateCustomer", "Success - retrieved and updated record for customer '{$attributes['customer']}'");

        $counter++;

        unset($attributes);
    }
    catch (Exception $e)
    {
        // log this exception
        write_log("JobUpdateCustomer", "Error - {$e->getMessage()}");
    }

    if ($debug) // process only the first record and break out
        break;
}

write_log("JobUpdateCustomer", strtoupper("Success - {$counter} records successfully updated."));

// close connection
odbc_close($connection);

unset($connection, $counter);

// start writeBack
$records = JobUpdateWeb::find_all_by_synced("0");

write_log("writeBack: 'JobUpdateWeb'", "Processing ".count($records)." records for 'JobUpdateWeb'.");

foreach ($records as $row)
{
    try
    {
        if ( ! $connection = odbc_connect($odbc_dsn, $odbc_user, $odbc_password))
        {
            throw new Exception("Odbc writeBack error: ".odbc_error($connection));
        }

        $sql = <<<ODBC_SQL
INSERT INTO JobUpdateWeb 
( 
    Job, Customer, AccountContactName, AccountContactEmail, 
    AccountContactTel, AccountContactCell, SalesContactName, SalesContactEmail, 
    SalesContactCell, SalesContactTel, AcceptQuote, RejectQuote 
)
VALUES
( 
    ?, ?, ?, ?, 
    ?, ?, ?, ?, 
    ?, ?, ?, ? 
)
ODBC_SQL;

        $odbc_query = odbc_prepare($connection, $sql);

        if (odbc_execute($odbc_query, array(
            $row->job, $row->customer, $row->accountcontactname, $row->accountcontactemail,
            $row->accountcontacttel, $row->accountcontactcell, $row->salescontactname, $row->salescontactemail,
            $row->salescontactcell, $row->salescontacttel, $row->acceptquote, $row->rejectquote,
        )))
        {
            $table_name = JobUpdateWeb::table_name();
            JobUpdateWeb::query("UPDATE {$table_name} SET synced = '1' WHERE Job = ?", $row->job);

            write_log("writeBack :'JobUpdateWeb'", "Success - record for job '{$row->job}' written back to Partserve ");

            unset($table_name);
        }
        else
        {
            write_log("writeBack :'JobUpdateWeb'", "Error - record for job '{$row->job}' cannot be written back to Partserve : ".odbc_error());
        }

        odbc_close($connection);
        unset($connection);
    }
    catch (Exception $e)
    {
        // log this exception
        write_log("writeBack: 'JobUpdateWeb'", "Error - {$e->getMessage()}");
    }

    if ($debug) // process only the first record and break out
        break;
}

write_log("writeBack: 'JobUpdateWeb'", strtoupper(count($records)." JobUpdateWeb records processed."));

unset($records);

// Compose a simple HTML email message
$message = <<<HTML_MESSAGE
    odbcConnect.php has been run
HTML_MESSAGE;

// Sending email
if(send_email($debug ? 'demu@itnt.co.za' : 'onlinejt@partserve.co.za', 'DB update cron', $message, $debug ? '' : "demu@itnt.co.za"))
{
    echo 'Your mail has been sent successfully.';
}
else
{
    echo 'Unable to send email. Please try again.';
}

echo "Script terminated.<br>";

write_log("odbcConnect.php", strtoupper("Cron finished executing at ".date('Y-m-d H:i:s A')));

exit;
