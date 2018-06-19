<?php

require_once dirname(dirname(__FILE__)).'/bootstrap.php';

date_default_timezone_set('Africa/Johannesburg');

set_time_limit(0); // :) run forever

$filename = "JobInfoWeb_2.txt";

if ( ! $handle = fopen($filename, 'r'))
{
    die("The file {$filename} could not be opened for import.");
}

$headers = array(
    'Job' => 0,
    'Customer' => 1,
    'CustomerName' => 2,
    'PhysicalAddress1' => 3,
    'PhysicalAddress2' => 4,
    'PhysicalAddress3' => 5,
    'PhysicalAddress4' => 6,
    'PhysicalAddress5' => 7,
    'AccountContactName' => 8,
    'AccountContactEmail' => 9,
    'AccountContactTel' => 10,
    'AccountContactCell' => 11,
    'SalesContactName' => 12,
    'SalesContactEmail' => 13,
    'SalesContactTel' => 14,
    'SalesContactCell' => 15,
    'LastContactNotes' => 16,
    'QuoteAccountNumber' => 17,
    'QuoteDRRef' => 18,
    'QuoteJobDate' => 19,
    'QuoteMake' => 20,
    'QuoteModel' => 21,
    'QuoteSerialNumber' => 22,
    'QuoteActionRequired' => 23,
    'QuoteTotal' => 24,
    'QuoteDiscountPer' => 25,
    'QuoteDiscount' => 26,
    'QuoteTotalTax' => 27,
    'QuoteGrandTotal' => 28,
    'FaultDescription' => 29,
    'Accessories' => 30,
    'WorkDone' => 31,
    'Item' => 32,
    'Status' => 33,
    'StoreRefNo' => 34,
    'VendorRefNo' => 35,
    'DeliveryAddress' => 36,
    'Workshop' => 37,
);

$records = array();

$counter = 0;

while ($line = fgets($handle))
{
    $counter++;
    
//    if ($counter == 10) { break; }
    
    $data = explode(",", $line);
    
    if (count($data) != count($headers))
    {
        print "Invalid data at line {$counter}<br>";
//        print '<pre>';
//        print_r($data);
//        print '<pre>';
        continue;
    }
    elseif (trim($data[0]) == "Job" && trim($data[1]) == "Customer")
    {
        print "Header record detected at line {$counter}<br>";
        continue;
    }
    
    echo "{$counter}. ".count($data)." fields detected. {$data[$headers['Job']]} - {$data[$headers['Customer']]} - {$data[$headers['CustomerName']]} - {$data[$headers['Status']]}<br>";
    $records[] = $data;
    
//    continue;
    
//    print '<pre>';
//    print_r($data);
//    print '<pre>';
    
    // 1. Check status
    if (trim($data[$headers['Status']]) == "Quote Accepted" || trim($data[$headers['Status']]) == 'Quote Rejected')
    {
        // Update jobinfoweb
//        $sql = "UPDATE jobinfoweb SET Status = 'Quote Accepted' WHERE Job = ?";        
        if ($tempJob = JobInfoWeb::find_by_Job(trim($data[$headers['Job']])))
        {
            $tempJob->update_attributes(array(
                'Status' => 'Quote Accepted'
            ));
        }
        
        try
        {
            JobUpdateWeb::create(array(
                'Job' => trim($data[$headers['Job']]),
                'Customer' => trim($data[$headers['Customer']]),
                'AccountContactName' => trim($data[$headers['AccountContactName']]),
                'AccountContactEmail' => trim($data[$headers['AccountContactEmail']]),
                'AccountContactTel' => trim($data[$headers['AccountContactTel']]),
                'AccountContactCell' => trim($data[$headers['AccountContactCell']]),
                'SalesContactName' => trim($data[$headers['SalesContactName']]),
                'SalesContactEmail' => trim($data[$headers['SalesContactEmail']]),
                'SalesContactTel' => trim($data[$headers['SalesContactTel']]),
                'SalesContactCell' => trim($data[$headers['SalesContactCell']]),
                'reason' => trim($data[$headers['Status']]) == "Quote Accepted" ? 'AutoAccepted' : 'AutoRejected',
            ));
        }
        catch (Exception $e)
        {
            
        }
        
        print "JobUpdateWeb '{$data[$headers['Job']]}' created for status '{$data[$headers['Status']]}' <br>";        
    }
    
    // load local jobinfoweb
    $job = JobInfoWeb::find_by_job(trim($data[$headers['Job']]));
    
    try
    {
        if ( ! is_null($job))
        {
            // update
            $sql = "UPDATE jobinfoweb 
                    SET Customer=?,
                             CustomerName=?,
                             PhysicalAddress1=?,
                             PhysicalAddress2=?,
                             PhysicalAddress3=?,
                             PhysicalAddress4=?,
                             PhysicalAddress5=?,
                             AccountContactName=?,
                             AccountContactEmail=?,
                             AccountContactTel=?,
                             AccountContactCell=?,
                             SalesContactName=?,
                             SalesContactEmail=?,
                             SalesContactCell=?,
                             SalesContactTel=?,
                             LastContactNotes=?,
                             QuoteAccountNumber=?,
                             QuoteDRRef=?,
                             QuoteJobDate=?,
                             QuoteMake=?,
                             QuoteModel=?,
                             QuoteSerialNumber=?,
                             QuoteActionRequired=?,
                             QuoteTotal=?,
                             QuoteDiscountPer=?,
                             QuoteDiscount=?,
                             QuoteTotalTax=?,
                             QuoteGrandTotal=?,

                             StoreRefNo=?,
                             VendorRefNo=?,

                             FaultDescription=?,
                             Accessories=?,
                             WorkDone=?,
                             Item= ?,
                             Status= ?,
                             DeliveryAddress= ?,
                             Workshop= ?
                    WHERE job=?
                                                    ";
            JobInfoWeb::query($sql, array(
                trim($data[$headers['Customer']]),
                trim($data[$headers['CustomerName']]),

                trim($data[$headers['PhysicalAddress1']]),
                trim($data[$headers['PhysicalAddress2']]),
                trim($data[$headers['PhysicalAddress3']]),
                trim($data[$headers['PhysicalAddress4']]),
                trim($data[$headers['PhysicalAddress5']]),

                trim($data[$headers['AccountContactName']]),
                trim($data[$headers['AccountContactEmail']]),
                trim($data[$headers['AccountContactTel']]),
                trim($data[$headers['AccountContactCell']]),

                trim($data[$headers['SalesContactName']]),
                trim($data[$headers['SalesContactEmail']]),
                trim($data[$headers['SalesContactCell']]),
                trim($data[$headers['SalesContactTel']]),

                trim($data[$headers['LastContactNotes']]),

                trim($data[$headers['QuoteAccountNumber']]),
                trim($data[$headers['QuoteDRRef']]),
                trim($data[$headers['QuoteJobDate']]),
                trim($data[$headers['QuoteMake']]),
                trim($data[$headers['QuoteModel']]),
                trim($data[$headers['QuoteSerialNumber']]),
                trim($data[$headers['QuoteActionRequired']]),
                trim($data[$headers['QuoteTotal']]),
                trim($data[$headers['QuoteDiscountPer']]),
                trim($data[$headers['QuoteDiscount']]),
                trim($data[$headers['QuoteTotalTax']]),
                trim($data[$headers['QuoteGrandTotal']]),

                trim($data[$headers['StoreRefNo']]),
                trim($data[$headers['VendorRefNo']]),

                trim($data[$headers['FaultDescription']]),
                trim($data[$headers['Accessories']]),
                trim($data[$headers['WorkDone']]),
                trim($data[$headers['Item']]),
                trim($data[$headers['Status']]),
                trim($data[$headers['DeliveryAddress']]),
                trim($data[$headers['Workshop']]),

                trim($data[$headers['Job']]),
            ));

            print "JobInfoWeb '{$data[$headers['Job']]}' record updated <br>";
        }
        else
        {
            // insert
            JobInfoWeb::create(array(
                'Customer' => trim($data[$headers['Customer']]),
                'CustomerName' => trim($data[$headers['CustomerName']]),

                'PhysicalAddress1' => trim($data[$headers['PhysicalAddress1']]),
                'PhysicalAddress2' => trim($data[$headers['PhysicalAddress2']]),
                'PhysicalAddress3' => trim($data[$headers['PhysicalAddress3']]),
                'PhysicalAddress4' => trim($data[$headers['PhysicalAddress4']]),
                'PhysicalAddress5' => trim($data[$headers['PhysicalAddress5']]),

                'AccountContactName' => trim($data[$headers['AccountContactName']]),
                'AccountContactEmail' => trim($data[$headers['AccountContactEmail']]),
                'AccountContactTel' => trim($data[$headers['AccountContactTel']]),
                'AccountContactCell' => trim($data[$headers['AccountContactCell']]),

                'SalesContactName' => trim($data[$headers['SalesContactName']]),
                'SalesContactEmail' => trim($data[$headers['SalesContactEmail']]),
                'SalesContactCell' => trim($data[$headers['SalesContactCell']]),
                'SalesContactTel' => trim($data[$headers['SalesContactTel']]),

                'LastContactNotes' => trim($data[$headers['LastContactNotes']]),

                'QuoteAccountNumber' => trim($data[$headers['QuoteAccountNumber']]),
                'QuoteDRRef' => trim($data[$headers['QuoteDRRef']]),
                'QuoteJobDate' => trim($data[$headers['QuoteJobDate']]),
                'QuoteMake' => trim($data[$headers['QuoteMake']]),
                'QuoteModel' => trim($data[$headers['QuoteModel']]),
                'QuoteSerialNumber' => trim($data[$headers['QuoteSerialNumber']]),
                'QuoteActionRequired' => trim($data[$headers['QuoteActionRequired']]),
                'QuoteTotal' => trim($data[$headers['QuoteTotal']]),
                'QuoteDiscountPer' => trim($data[$headers['QuoteDiscountPer']]),
                'QuoteDiscount' => trim($data[$headers['QuoteDiscount']]),
                'QuoteTotalTax' => trim($data[$headers['QuoteTotalTax']]),
                'QuoteGrandTotal' => trim($data[$headers['QuoteGrandTotal']]),

                'StoreRefNo' => trim($data[$headers['StoreRefNo']]),
                'VendorRefNo' => trim($data[$headers['VendorRefNo']]),

                'FaultDescription' => trim($data[$headers['FaultDescription']]),
                'Accessories' => trim($data[$headers['Accessories']]),
                'WorkDone' => trim($data[$headers['WorkDone']]),
                'Item' => trim($data[$headers['Item']]),
                'Status' => trim($data[$headers['Status']]),
                'DeliveryAddress' => trim($data[$headers['DeliveryAddress']]),
                'Workshop' => trim($data[$headers['Workshop']]),

                'Job' => trim($data[$headers['Job']]),
            ));

            print "JobInfoWeb '{$data[$headers['Job']]}' record created <br>";
        }
    }
    catch (Exception $e)
    {
        
    }
}

print '<pre>';
print_r($records);

