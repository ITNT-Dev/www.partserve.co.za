<?php
// the message
$time= date("Y-m-d h:s");
echo $time;

$msg = "This is a cron test @ $time<br/>";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
if(mail("demu@itnt.co.za","Test cron $time",$msg))
{
 echo "email Sent @ $time";
}

?> 