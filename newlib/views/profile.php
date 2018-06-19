<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>INIT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/bootstrap-responsive.css" rel="stylesheet" />
<style type="text/css">
</style>
</head>

<body style="background-color:#dd4b39; font-family: century gothic;">
	<div class="pull-right" id="sub-menu" style="margin-right:10%;margin-top:1%;margin-bottom:1%; background-color:#c74433;">  
	<ul class="nav nav-pills">
                      <li>
            <a href="index.php?smiggle=index/profile" style="color:#fff;font-family: century gothic;">Your Profile</a>
        </li>
                  <li>
            <a href="index.php?smiggle=index/mytasks" style="color:#ccc;font-family: century gothic;">Create A Task</a>
        </li>
                <li>
            <a href="index.php?smiggle=index/tasklist" style="color:#ccc;font-family: century gothic;">Task List</a>
        </li>  
            
            
              
        
        <li>
            <a href="index.php?smiggle=index/logout" style="color:#fff;font-family: century gothic;">Logout</a>
            
        </li>
        
        <li>
            &nbsp;
            
        </li>
        <li><a><?php if(isset($_SESSION['profile_name'])): echo $_SESSION['profile_name'];  endif; ?></a></li>

    </ul>		</div>






<br/><br/><br/><br/><br/>


  <div class="container-fluid" style="margin-top:0%;color:#FFFFFF;">
   
    <div class="admin-box" style="margin-left:4%; margin-top:0%; width:40%;">

  <?php
	  if(isset($updates))
	  {
		echo "<h4 style='color:#FF9900;'>$updates</h4><br/>";
	  }
  ?>
   <h4 style="margin-top:0%;font-family: century gothic; color:#FFFFFF;"> Profile</h4>

    <form action="index.php?smiggle=index/profile" method="post">
               
    			<input type="hidden" class="form-control" name="profile_id" value="<?php echo $datad[0]['id']; ?>">
                <div class="form-group">
                Name and Surname:
                  <input type="text" class="form-control" name="names" value="<?php echo $datad[0]['names']; ?>">
                </div>
                <div class="form-group">
                Email:
                  <input type="text" class="form-control" name="Email" value="<?php echo $datad[0]['email']; ?>">
                </div>
                <div class="form-group">
                Password:
                  <input type="password" class="form-control" name="pass"  placeholder="Enter New Password">
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-default" value="Update Profile">
                </div> 

             
   </form>                
   
     </div></div>
      
</body>
</html>