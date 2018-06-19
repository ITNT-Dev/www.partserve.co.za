<?php
Class indexcontroller 
{
 	private $db, $global_vars, $views, $id, $user;
    public function __construct()
	{
		session_start();
		$this->db = IOC::make('database', array());
		$this->global_vars = IOC::make('g_variables', array());
		$this->views = IOC::make('views', array());
		if(isset($_SESSION['user_id']))
		{
			$this->id  = $_SESSION['user_id'];
			$this->user  = $_SESSION['profile_name'];
		}
	}
 
	public function index() {
		
		/*** set a template variable ***/
		$username= @$this->global_vars->post_data('username');
		$encrypt_password= @$this->global_vars->encrypt_password($this->global_vars->post_data('password')); 
		
		if((isset($username) && !empty($username))&& (isset($encrypt_password)
		 && !empty($encrypt_password)))
		{
		 
			// Check matching of username and password.
			list($affect_rows, $data) = $this->db->loginUsers($username, $encrypt_password);
			list($affect_rows, $datass) = $this->db->selectWhere("users", "email",$username);
		    $this->views->datass = $data;
			if($affect_rows!='0'){ // If match.
			$id = $data[0]['id'];
			//session_start();
			$_SESSION['user_id']= $id;
			$_SESSION['profile_name'] = $id = $datass[0]['names'];
			//var_dump($_SESSION); die();
			//$this->global_vars->set_sessions('username', $reso[1]);
			header('Location: index.php?smiggle=index/mytasks'); // Re-direct to main.php
			}
			else
			{
				$message="<br/>--- Incorrect Username or Password ---";
		  		$this->views->message=$message;	
			}
		}
		else
		{
		 	//$message="<br/>--- Incorrect Username or Password ---";
		  	//$this->views->message=$message;	
		}
		
		
	
		$this->views->shows('sign_in');
	
	}
			
			
		public function register()
	{
         if(isset($_POST['register']))
		 {
			  $form_datas[] = $this->global_vars->post_data("email");
			  $form_datas[] = $this->global_vars->encrypt_password($this->global_vars->post_data('pass'));
			  $form_datas[] = $this->global_vars->post_data("names");
			  $this->db->insert_data("users", $form_datas);
			  $_SESSION['profile_name'] = $this->global_vars->post_data("names");
			  $this->views->registered = "You registered Login";
			  $this->views->shows('register');
		}
		else
		{
		  $this->views->shows('register');
		}
	}
	
	
	public function profile()
	{
		  $this->global_vars->un_authorized();
         if(isset($_POST['profile_id']))
		 {
			  $id = $this->global_vars->post_data("profile_id");
		  $form_datas['email'] = $this->global_vars->post_data("Email");
			  $form_datas['password'] = $this->global_vars->encrypt_password($this->global_vars->post_data("pass"));
			  $form_datas['names'] = $this->global_vars->post_data("names");
		      $this->db->update("users", $form_datas, $id);
			  list($affect_rows, $datad) = $this->db->selectWhere("users", "id",$this->id);
			  $this->views->datad = $datad;
			  $this->views->updates = "Profile Updated";
			  $this->views->shows('profile');
		}
		else
		{ 
		
	
		  list($affect_rows, $datad) = $this->db->selectWhere("users", "id",$this->id);
		  $this->views->datad = $datad;
		  $this->views->shows('profile');
		}
	}
	
	
	
	public function mytasks()
	{
	    $this->global_vars->un_authorized();
         if(isset($_POST['register_task']))
		 {
			  $form_datas[] = $this->global_vars->post_data("assigned_by_id");
			  $form_datas[] = $this->global_vars->post_data("assigned_to_id");
			  $form_datas[] = $this->global_vars->post_data("completion_status");
			  $form_datas[] = $this->global_vars->post_data("priority_status");
			  $form_datas[] = $this->global_vars->post_data("task");
			  $this->db->insert_data("tasks", $form_datas);
			  header('Location: index.php?smiggle=index/tasklist');
		}
		else
		{
		  list($affect_rows, $data) = $this->db->selectAll("users");
		  $this->views->data = $data;
		  $this->views->shows('task');
		}
	}
			
			
	public function tasklist() {
	$this->global_vars->un_authorized();
	$url = $this->global_vars->url_query('smiggle');	
	  $url_part = explode('/', $url);
	  if(!empty($url_part[2]))
	  {
	    
	list($affect_rows, $data) = $this->db->selectWhere("tasks", "priority_status",$url_part[2]);
		  $this->views->data = $data;
		$this->views->shows('task_list');
		}
		else
		{
		   list($affect_rows, $data) = $this->db->selectWhere("tasks", "priority_status","Urgent");
		   $this->views->data = $data;
		   $this->views->shows('task_list');
		}

}		




public function update()
	{
	 // session_start();
	  $this->global_vars->un_authorized();
	  if(isset($_POST["task_update"]))
	  {
	  	   $url = $this->global_vars->url_query('smiggle');	
	  	  $url_part = explode('/', $url);
		  $id = $this->global_vars->post_data("task_id");
		  $form_datas['assigned_by_id'] = $this->global_vars->post_data("assigned_by_id");
			  $form_datas['assigned_to_id'] = $this->global_vars->post_data("assigned_to_id");
			  $form_datas['completion_status'] = $this->global_vars->post_data("completion_status");
			  $form_datas['priority_status'] = $this->global_vars->post_data("priority_status");
			  $form_datas['task'] = $this->global_vars->post_data("task");
		  $this->db->update("tasks", $form_datas, $id);
		  unset($_POST["registrar_sender"]);		
          header('Location: index.php?smiggle=index/tasklist');
	  }
	  
	  
	    if(!isset($_POST["task_update"]))
	  {
		  $url = $this->global_vars->url_query('smiggle');	
		  $url_part = explode('/', $url);
		  list($affect_rows, $datas) = @$this->db->view('tasks', $url_part[2]);
		  list($affect_rows, $data) = $this->db->selectAll("users");
		  $this->views->data = $data;
		  $this->views->datas = $datas;
		  $this->views->shows('task_update');
	  }
}





	public function delete() {
	$url = $this->global_vars->url_query('smiggle');	
		  $url_part = explode('/', $url);
	list($affect_rows, $data) = $this->db->delete("tasks", $url_part[2]);
		header('Location: index.php?smiggle=index/tasklist');

}		

	public function logout() {
		session_destroy();
		header('Location: index.php?smiggle=index/index');

}



}

?>
