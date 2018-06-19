<?php

class dbObject{
 function dbObject(){
  include('config.php'); 
  $this->server = $dbHost;
  $this->user = $dbUser;
  $this->password = $dbPassword;
  $this->database = $db;
  $this->dbConnect();
 }
 
 function dbConnect(){
  $this->connnection = mysql_connect($this->server,$this->user,$this->password) 
    or die('Could not connect to host server on '.$this->server);
	
  mysql_select_db($this->database)
   or die('Could not not to database '.$this->database.' on host '.$this->server);	
 }

 function dbQuery($query = ''){
  $this->results = mysql_query($query);
  if(mysql_error())
  {
   	print mysql_error()."<br />";
  }
  else
  {
  	return $this->results; 
  }	
 }
 function dbNextRecord(){
//  $nxtRec = @mysql_fetch_array($this->results);
  $nxtRec = @mysql_fetch_assoc($this->results);
  return $nxtRec;
 }
 
 function switchConnection($index = 0){
  include('config.php'); 
  if(!$dbHost[$index]){
	 die("<P CLASS='error'>Database switching failed</P>");
   return NULL; // 
  }
  $this->server = $dbHost[$index];
  $this->user = $dbUser[$index];
  $this->password = $dbPassword[$index];
  $this->database = $db[$index];
  $this->dbConnect();
 }
}

 function dbQuerys($query = ''){
  $tis = new dbObject();
  $tis->results = mysql_query($query);
  if(mysql_error())
   print mysql_error()."<br />";
  return $tis->results; 
 }
?>