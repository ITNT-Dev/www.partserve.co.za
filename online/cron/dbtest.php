<?php

require_once dirname(dirname(dirname(__FILE__))).'/bootstrap.php';

date_default_timezone_set('Africa/Johannesburg');

print '<pre>';
print_r(JobUpdateWeb::first());
