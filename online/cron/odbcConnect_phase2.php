<?php
// set memory limit
ini_set('memory_limit', '2048M');

// set time limit
set_time_limit(0);

require_once (dirname(dirname(dirname(__FILE__))) . "/library/init_activerecord.php");
require_once (dirname(dirname(dirname(__FILE__))) . "/library/my_utils.php");
require_once (dirname(dirname(dirname(__FILE__))) . "/library/onlinejobtracking.class.php");
require_once (dirname(dirname(dirname(__FILE__))) . "/library/odbc_interface.php");

TOdbc_interface::synchroniseAll();

//TMy_Utils::print_Array(TOdbc_interface::getJobDateAudit_odbc());

print "Hoorah! I am done<br>";
