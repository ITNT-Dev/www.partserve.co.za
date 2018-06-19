<?php
class globalVars
{
	private $_get, $_post, $_session; 
	
    public function __construct()
    {
        $this->_get    = &$_GET;
        $this->_post     = &$_POST;
		
    }
	public function url_query($param = null){
		            return $this->_get[$param];
	}
	public function encrypt_password($param = null){
		            return md5($param);
	}
	public function post_data($param = null){
		            return $this->_post[$param];
	}
	public function set_sessions($param = null, $info){
	
		            $_SESSION[$param] = $info;
	}
	public function get_sessions($param){
		            return $_SESSION[$param];
	}
	public function un_authorized(){
		            if(!isset($_SESSION['user_id']))
					{
						header('Location: index.php?smiggle=index/index');
					}
	}

}

?>