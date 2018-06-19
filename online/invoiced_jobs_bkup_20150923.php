<?php

require_once dirname(dirname(__FILE__)) . '/bootstrap.php'; // load my required files
require_once dirname(dirname(__FILE__)) . "/library/odbc_interface.php";

TMy_Utils::print_Array(TOdbc_interface::getCustomerContact_odbc());

TMy_Utils::print_Array(TOdbc_interface::getInvoicedJobs_odbc());
