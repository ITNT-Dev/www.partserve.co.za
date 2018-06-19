<?php
class model{

private static $instance = NULL;
public static $dbconfigs;

	public function __construct($config) {
	
	  	self::$dbconfigs = $config;
		
	}

	public static function getInstance() {
	
	if (!self::$instance)
		{
		$db_details = self::$dbconfigs;
		self::$instance = IOC::make('PDO', $db_details);
		self::$instance-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	return self::$instance;
	}
	
	public function insert_data($table, $query) {
		   foreach($query as $v)
		   {
		   $ra[] = "'$v'";
		   }
		   $rase = implode(',',$ra);
          $sql= "insert into $table values('null',$rase)";
		$handle = self::getInstance();
		$query = $handle->query($sql);
	
	} 
	
	public function delete($table,$id)
  {
  
 	$sql = "delete from $table where id = $id";

     $handle = self::getInstance();
		$query = $handle->query($sql);

  }
  
  
  public function make_query($table)
  {
  
 	$sql = $table;

     $handle = self::getInstance();
		$query = $handle->query($sql);

  }		
	
	public function selectquerys($table) {
	
		$handle = self::getInstance();
		$query = $handle->query($table);
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		$result = $query->fetch(PDO::FETCH_ASSOC);
		//var_dump($result); die();
		if($result)
		{
			$rows[]=$result;
		}
		else{
			$rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function selectWhere2($table, $col,$param1, $col2,$param2) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM $table WHERE $col = '$param1' AND  $col2 = '$param2' ");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		$result = $query->fetch(PDO::FETCH_ASSOC);
		//var_dump($result); die();
		if($result)
		{
			$rows[]=$result;
		}
		else{
			$rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
		
		public function selectWhereLike($table, $col1,$param1,$col2,$param2,$col3,$param3) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM $table WHERE $col1 like '%$param1%' and $col2 = '$param2' and $col3 = '$param3'");
		//echo "SELECT * FROM $table WHERE $col1 like '%$param1%' and $col2 = '$param2'";
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
	
	
	
	
	
	
	
	public function selectWhere($table, $col,$param1) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM $table WHERE $col = '$param1'");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		$result = $query->fetch(PDO::FETCH_ASSOC);
		//var_dump($result); die();
		if($result)
		{
			$rows[]=$result;
		}
		else{
			$rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
		
		
		
		public function selectWhere_pages($table, $col,$param1,$order_collumn, $start_num , $num_per_pages) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM $table WHERE $col = '$param1' order by $order_collumn asc limit $start_num , $num_per_pages");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
		
		
		
		
		
		
		
		
		
		
		
		
			public function selectAll($table) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM $table");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}

		
		
		


	public function loginUsers($param1, $param2) {
	
		$handle = self::getInstance();
		$query = $handle->query("select * from users where email='".$param1."' and password='".$param2."'");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}



 function update($table,$post,$ids)
   {


     foreach($post as $k=>$v)
     {
          $ra[] = "`$k`='$v'";
     }

     $rase = implode(',',$ra);

     $sql = "update $table set $rase where id = $ids";
	 //echo $sql; die();
	 $handle = self::getInstance();
	 $query = $handle->query($sql);
   }
   
   function update_dif_id($table,$post,$col, $ids)
   {


     foreach($post as $k=>$v)
     {
          $ra[] = "`$k`='$v'";
     }

     $rase = implode(',',$ra);

     $sql = "update $table set $rase where $col = $ids";
	 //echo $sql; die();
	 $handle = self::getInstance();
	 $query = $handle->query($sql);
   }
   
   public function view($table,$id) {
	
		$handle = self::getInstance();
		$query = $handle->query("select * from $table where id=$id");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}



	public function selectUsers() {
	
		$handle = self::getInstance();
		$query = $handle->query("select * from users");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}

public function selectUsersStatus($id) {
	
		$handle = self::getInstance();
		$query = $handle->query("select * from users where id=$id");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}

	public function getMessages($param1, $param2) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM messages where (sent_from=$param1 and sent_to=$param2) or (sent_from=$param2 and sent_to=$param1)");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
	
	
	
	
	public function getMessagesRest($param1, $param2) {
	
		$handle = self::getInstance();
		$query = $handle->query("SELECT * FROM messages where (sent_from
		in (select id from users where email ='$param1')
		 and sent_to
		 in (select id from users where email ='$param2')) 
		 or 
		 (sent_from
		 in (select id from users where email ='$param2')
		 and sent_to
		 in (select id from users where email ='$param1'))");
		if($query)
		{
			$affected_rows = $query->rowCount();
		}
		else
		{
			$affected_rows = 0;
		}
		
		while($result = $query->fetch(PDO::FETCH_ASSOC))
			{
				$rows[]=$result;
			}
			if($affected_rows>0)
			{
			$rows;
			}
			else
			{
			$rows = 0;
			}
			return array($affected_rows,$rows);
		}
	
	
	
	
	public function insertMessages($param1, $param2, $messages, $email) {
	
		$handle = self::getInstance();
		$query = $handle->query("INSERT INTO  `messages` (
	`id` ,
	`sent_from` ,
	`sent_to` ,
	`message` ,
	`email` ,
	`date`
	)
	VALUES (
	NULL ,  '{$param1}', '{$param2}', '{$messages}', '{$email}', NOW())");
	
	} 
	
	public function updateUreadMessaages($param1, $param2, $param3) {
	
		$handle = self::getInstance();
		$query = $handle->query("update unread_messages set unread_messages = $param1 where sent_from = $param2 and sent_to = $param3");
	
		}


	
	public function updateLoginStatus($param1, $param2) {
	
		$handle = self::getInstance();
		$query = $handle->query("update users set login_status = '".$param1."' where id =$param2;");
	
		}
		
	public function updateUnreadStatus($param1, $param2) {
	
		$handle = self::getInstance();
		$query = $handle->query("update unread_messages set unread_messages = 0 where sent_from =$param2 and sent_to =$param1  ;");
	
		}
}
?>
