<?php

set_time_limit(5 * 60);

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

require_once dirname(dirname(__FILE__)) . '/library/test_odbc_interface.php';

$invoicedjobs = TTest_odbc_interface::executeOdbc_query("SELECT * FROM JobInvoice");

/*
foreach ($invoicedjobs as $row) {
    if (JobInvoice::find_by_job_and_customer($row['Job'], $row['Customer']) == NULL) {
        JobInvoice::create(array(
            'job' => $row['Job'],
            'customer' => $row['Customer'],
            'customername' => $row['CustomerName'],
            'physicaladdress1' => $row['PhysicalAddress1'],
            'physicaladdress2' => $row['PhysicalAddress2'],
            'physicaladdress3' => $row['PhysicalAddress3'],
            'physicaladdress4' => $row['PhysicalAddress4'],
            'physicaladdress5' => $row['PhysicalAddress5'],
            'accountcontactname' => $row['AccountContactName'],
            'accountcontactemail' => $row['AccountContactEmail'],
            'accountcontacttel' => $row['AccountContactTel'],
            'accountcontactcell' => $row['AccountContactCell'],
            'salescontactname' => $row['SalesContactName'],
            'salescontactemail' => $row['SalesContactEmail'],
            'salescontacttel' => $row['SalesContactTel'],
            'salescontactcell' => $row['SalesContactCell'],
            'lastcontactnotes' => $row['LastContactNotes'],
            'invoiceaccountnumber' => $row['InvoiceAccountNumber'],
            'invoicedrref' => $row['InvoiceDRRef'],
            'invoicedate' => $row['InvoiceDate'],
            'invoicemake' => $row['InvoiceMake'],
            'invoicemodel' => $row['InvoiceModel'],
            'invoiceserialnumber' => $row['InvoiceSerialNumber'],
            'invoiceactionrequired' => $row['InvoiceActionRequire'],
            'invoicetotal' => $row['InvoiceTotal'],
            'invoicediscountper' => $row['InvoiceDiscountPer'],
            'invoicediscount' => $row['InvoiceDiscount'],
            'invoicetotaltax' => $row['InvoiceTotalTax'],
            'invoicegrandtotal' => $row['InvoiceGrandTotal'],
            'faultdescription' => $row['FaultDescription'],
            'accessories' => $row['Accessories'],
            'workdone' => $row['WorkDone'],
            'item' => $row['Item'],
            'status' => $row['Status'],
            'storerefno' => $row['StoreRefNo'],
            'vendorrefno' => $row['VendorRefNo'],
            'deliveryaddress' => $row['DeliveryAddress'],
            'workshop' => $row['Workshop'],
            'invoicenumber' => $row['InvoiceNumber']
        ));
    }
}
*/

$customerContacts = TTest_odbc_interface::executeOdbc_query("SELECT * FROM CustomerContact");

TMy_Utils::print_Array($customerContacts);

/*
foreach ($customerContacts as $row) {
    if (CustomerContact::find_by_customer($row['Customer']) == NULL) {
        CustomerContact::create(array(
            'customer' => $row['Customer'],
            'customername' => $row['CustomerName'],
            'contactperson' => $row['ContactPerson'],
            'customeraddress1' => $row['CustomerAddress1'],
            'customeraddress2' => $row['CustomerAddress2'],
            'customeraddress3' => $row['CustomerAddress3'],
            'customeraddress4' => $row['CustomerAddress4'],
            'customeraddress5' => $row['CustomerAddress5'],
            'customertelephone' => $row['CustomerTelephone'],
            'customercellphone' => $row['CustomerCellphone'],
            'customeremail' => $row['CustomerEmail']
        ));
    }
    else {
        
    }
}
*/
