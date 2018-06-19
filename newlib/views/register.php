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





<div class="pull-right" id="sub-menu" style="margin-right:10%;margin-top:1%;margin-bottom:1%; background-color:#c74433">        

	<ul class="nav nav-pills">
           
        
        <li>
             <a href="index.php?smiggle=index/index" style="color:#fff;font-family: century gothic;">Sign In</a>
        </li>

    </ul>		</div>









<br/><br/><br/><br/><br/>

  <div class="container-fluid" style="margin-top:0%;color:#FFFFFF;">
   
    <div class="admin-box" style="margin-left:4%; margin-top:0%; width:40%;">
   <?php
	  if(isset($registered))
	  {
		echo "<h4 style='color:#FF9900;'>$registered</h4><br/>";
	  }
  ?>
   <h4 style="margin-top:0%;font-family: century gothic; color:#FFFFFF;"> Register</h4>

    <form action="index.php?smiggle=index/register" method="post">
    			<input type="hidden" class="form-control" name="register" value="ok">
                <div class="form-group">
                Name and Surname:
                  <input type="text" class="form-control" name="names" placeholder="Name and Surname:">
                </div>
                <div class="form-group">
                Email:
                  <input type="text" class="form-control" name="email" placeholder="Email:">
                </div>
                <div class="form-group">
                Password:
                  <input type="password" class="form-control" name="pass" placeholder="Password:">
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-default" value="Register">
                </div> 

             
   </form>                
   
     </div></div>> 





	</div>
</div>


      
</body>
</html>