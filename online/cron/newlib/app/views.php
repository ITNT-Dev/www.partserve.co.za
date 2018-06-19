<?php

class views
{
private $vars = array();
 public function __set($index, $value)
 {
        $this->vars[$index] = $value;
 }
 
function shows($name) {
	$path = "views/$name.php";
	if (file_exists($path) == false)
	{
		throw new Exception('view not found in '. $path);
		return false;
	}

	foreach ($this->vars as $key => $value)
	{
		$$key = $value;
	}
       
	include ($path);               
}



}