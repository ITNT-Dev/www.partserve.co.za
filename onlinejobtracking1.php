<!DOCTYPE html>
<?php
   $login_status = false;
   $_error       = false;
   if(isset($_POST['__p']) && $_POST['__p'] == '_p'){
   	$_username = $_POST['username'];
   	$_password = $_POST['password'];
   
   	$query = "select * from users where loginName='" . $_username . "' and loginPassword='" . $_password . "'";
   
   	$conn = new mysqli('localhost', 'partserve', 'hna12360n8sd0gs2nb', 'partserveonline');
   	if (! $conn->connect_error ){
   		$result = $conn->query($query);
   		if($result->num_rows > 0){
   			session_start();
   			$c = 0;
   			while( $row = $result->fetch_assoc()){
   
   					foreach($row as $key => $val){
   
   						if($key == 'password') continue;
   						$_SESSION[$key] = $val;
   						if($key == 'loginName'){
   							$_SESSION['name'] = $val;
   						}
   
   						if($key == 'vendorWorkshop'){
   							$_SESSION['vendorWorkshop'] = json_decode($val, true);
   
   						}
   
   						$sql = "UPDATE users SET userLastLogin=NOW(), userNoLogins='".($row['userNoLogins']+1)."' WHERE userId='".$row['userId']."' ";
   						$conn->query($sql);
   
   							if ($_SESSION['accountType'] == 'admin'){
   								$_SESSION['description'] = $row['fullName'];
   								$_SESSION['userId'] = $row['userId'];
   								$_SESSION['adminId'] = $row['userId'];
								echo "<script>window.location.href = 'online/admin_page.php';</script>";
   							}else if ($_SESSION['userLimit'] == 10){
                                $_SESSION['userId'] = $row['userId'];

								echo "<script>window.location.href = 'online/superuser_add.php';</script>";
   							}else if($_SESSION['userLimit'] == 100){
                                $_SESSION['userId'] = $row['userId'];
   								echo "<script>alert('Page loading...');window.location.href = 'online/vnd_list.php'; </script>";
   
   							}elseif($_SESSION['accountType'] == null ){
                                $_SESSION['adminId'] = $row['userId']; 
                                $_SESSION['name'] = $row['customer'];
								echo "<script>window.location.href = 'dashboard.php';</script>";
                            }else{
                                $_SESSION['adminId'] = $row['userId']; 
                                $_SESSION['name'] = $row['customer'];
								echo "<script>window.location.href = 'dashboard.php';</script>";
   							}
   						}
   				$c++;
   			}
   
   			}else{
   			$_error = true;
   		}
   	}else{
   		die("Please contact administrator"); //Stop
   	} 
   }
   ?>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
         body {
         font-family: Arial, Helvetica, sans-serif;
         }
         form {
         border: 3px solid #f1f1f1;
         }
         input[type=text],
         input[type=password] {
         width: 100%;
         padding: 12px 20px;
         margin: 8px 0;
         display: inline-block;
         border: 1px solid #ccc;
         box-sizing: border-box;
         }
         button {
         background-color: #4CAF50;
         color: white;
         padding: 14px 20px;
         margin: 8px 0;
         border: none;
         cursor: pointer;
         width: 100%;
         }
         button:hover {
         opacity: 0.8;
         }
         .cancelbtn {
         width: auto;
         padding: 10px 18px;
         background-color: #f44336;
         }
         .imgcontainer {
         text-align: center;
         margin: 24px 0 12px 0;
         }
         img.avatar {
         width: 40%;
         border-radius: 50%;
         }
         .container {
         padding: 16px;
         width: 40%
         }
         span.psw {
         float: right;
         padding-top: 16px;
         }
         /* Change styles for span and cancel button on extra small screens */
         @media screen and (max-width: 300px) {
         span.psw {
         display: block;
         float: none;
         }
         .cancelbtn {
         width: 100%;
         }
         }
      </style>
   </head>
   <body>
      <?php
         ?>
      <center>
         <h2>Online Job Tracking Login</h2>
         <form method="post" style="width: 70%" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">
            <div class="imgcontainer">
               <img style="width: 20%" src="https://cdn0.iconfinder.com/data/icons/yummy-pc/100/yummy-pc-43-512.png" alt="Login Avatar" class="avatar">
            </div>
            <?php if($_error){ ?>
            <h4 style="color: red">Please enter correct credintials</h4>
            <?php }?>
            <div class="container">
               <label for="username"><b>Username</b></label>
               <input type="text" placeholder="Enter Username" name="username" required>
               <label for="password"><b>Password</b></label>
               <input type="password" placeholder="Enter Password" name="password" required>
               <input type="text" hidden style="display: none" name="__p" value="_p">
               <button type="submit">Login</button>
            </div>
         </form>
      </center>
   </body>
</html>