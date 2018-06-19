<?php
class router{
 public $getter;
  public function __construct()
	{
	  $this->getter = &$_GET;
	}


  public function gets()
	{ 
	  if(isset($this->getter['smiggle']))
	  {
		  $url_part = explode('/', $this->getter['smiggle']);
		  $controller = $url_part[0];
		  $action = $url_part[1];
	  }
	  else
	  {
	  	$controller = "index";
		$action = "index";
		  
	  }
	  $class = $controller. 'controller';
	  $controller = new $class();
	  $controller->$action();
	}
	
}

?>
