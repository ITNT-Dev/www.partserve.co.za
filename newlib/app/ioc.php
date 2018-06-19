<?php

class IOC
{

  protected static $resolver = array();
  public static function register($name, $resolver)
   {
	 static::$resolver[$name] = $resolver;
   }
  public static function make($name, $params = array())
   {
	if(isset(static::$resolver[$name]))
	   {
         $resolver = static::$resolver[$name];
		 return call_user_func_array($resolver, $params);
	}
     throw new Exception("No registered resolver for {$name} in ioc");

   }
   

}
?>
