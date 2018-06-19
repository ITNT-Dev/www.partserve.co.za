<?php

//require_once('db_access.php');

function isOnLine(){
@session_start();
 if( (isset($_SESSION['userId']) ) && ($_SESSION['userId'] >= 1) ){
   return true;
 }
 return false;
}

function adminOnLine(){
@session_start();
  if( isset($_SESSION['adminId']) ){
		return true;
	}else{
		return false;
	}
 }

function escape_string($msg)
{
	//$db = new dbObject;
	//return mysql_real_escape_string($msg);
}

function send_email_attachment($email_to='',$email_subject='',$message='',$files=array(),$email_from='',$site_name='',$extraHeaders='')
{	
	$fileatt_type = "application/pdf";	
	$email_message = $message;	
	
	$headers  = "";
	$headers .= "From: ".$site_name."<".$email_from .">\n"; 
	$headers .= "Reply-To: ".$site_name."<".$email_from .">\n"; 
	$headers .= "Return-Path: ".$site_name."<".$email_from .">\n";  
	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	$headers .= "From: ".$email_from; 
	$headers .= "\nMIME-Version: 1.0\n" . 
	"Content-Type: multipart/mixed;\n" . 
	" boundary=\"{$mime_boundary}\"\n"; 
						 
	$email_message .= "This is a multi-part message in MIME format.\n\n" . 
	 "--{$mime_boundary}\n" . 
	 "Content-Type:text/html; charset=\"iso-8859-1\"\n" . 
	 "Content-Transfer-Encoding: 7bit\n\n" . 
	$email_message .= "\n\n"; 
	$cnt=1;
	foreach($files as $fileatt_name=> $fileatt)
	{			

		$file = fopen($fileatt,'rb'); 
		$data = fread($file,filesize($fileatt)); 
		fclose($file); 
		
		$data = chunk_split(base64_encode($data));  
		$email_message .="--{$mime_boundary}\n" . 
		"Content-Type: {$fileatt_type};\n" . 
		" name=\"".$fileatt_name."\"\n" . 
		"Content-Disposition: attachment;\n" . 
		" filename=\"".$fileatt_name."\"\n" . 
		"Content-Transfer-Encoding: base64\n\n" . 
		$data .= "\n\n" . 
		"--{$mime_boundary}--$cnt--\n"; 
		$filenames.= $fileatt_name."";
		$cnt++;
	}
	$headers .= $extraHeaders; 		
	$headers .= "Bcc: Raps<keorapetse@itnt.co.za> \n"; 
//die('<PRE>' . htmlentities($headers) );
	$sent = mail($email_to, $email_subject, $email_message, $headers, '-f'.$email_from); 	
 }

function redirect($url = '', $msg=''){
 $url = empty($url) ? 'index.php' : $url;
 $script = "<script>".(!empty($msg)?"alert('".$msg."');":"")."location.href='".$url."';</script>";
 echo $script;
 exit;
}

function passwordStrength($pwd){
	$error="";
	
	if( strlen($pwd) < 8 ) {
		$error .= "Password too short!";
	}
	
	if( strlen($pwd) > 20 ) {
		$error .= "Password too long!";
	}
	
	if( !preg_match("#[0-9]+#", $pwd) ) {
		$error .= "Password must include at least one number!";
	}
	
	
	if( !preg_match("#[a-z]+#", $pwd) ) {
		$error .= "Password must include at least one letter!";
	}
	
	
	if($error){
		$_REQUEST['passwordErr']="Password validation failure(your choice is weak): $error";
		return false;
	} else {
		$_REQUEST['passwordErr']="Your password is strong.";
		return true;
	}

}
?>