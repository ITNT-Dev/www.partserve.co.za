<?php

require_once dirname(__FILE__)."/_autoload.php";

require_once (dirname(dirname(__FILE__)) . "/library/init_activerecord.php");
require_once (dirname(dirname(__FILE__)) . "/library/my_utils.php");
require_once (dirname(dirname(__FILE__)) . "/library/onlinejobtracking.class.php");
require_once (dirname(dirname(__FILE__)) . "/library/odbc_interface.php");

$invoiced_jobs = TOdbc_interface::getInvoicedJobs_odbc();

print "<pre>";
print_r($invoiced_jobs);