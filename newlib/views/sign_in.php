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

	<div class="navbar navbar-fixed-top navbar" id="topbar" style="height:10px; background-color:#c74433">
        <div class="navbar-inner">

<div class="pull-right" id="sub-menu" style="margin-right:10%;margin-top:1%;margin-bottom:1%;">
	<ul class="nav nav-pills">
                      <li>
            &nbsp;
        </li>
                  <li>
             &nbsp;
        </li>
                <li>
             &nbsp;
        </li>  
            
            
            
            
                    <li>
             &nbsp;
        </li>  
        <li>
             &nbsp;
        </li>  
        <li>
            &nbsp;
        </li>

    </ul>		</div>





        </div>
    </div>



 <div class="subnav navbar-fixed-top" style="margin-top:0%;">
	<div class="container-fluid" style="margin-top:0%;">
<br/><br/><br/><br/><br/>

<div class="body">
  <div class="container-fluid" style="margin-top:0%;color:#FFFFFF;">
   
    <div class="admin-box" style="margin-left:15%; margin-top:8%; width:60%; text-align:inherit">
  

<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WELCOME TO My Page !</H1>
<?php
if(isset($message))
{
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='-3'>$message</font>";
}
?>
    <form action="index.php?smiggle=index/index" method="post"  enctype="multipart/form-data" class'login_form'>

                <div class="form-group">
                Email:
                  <input type="text" class="form-control" name="username" placeholder="Email:">
                </div>
                <div class="form-group">
                Password:
                  <input type="password" class="form-control" name="password" placeholder="Password:">
                </div>
                
                <div class="form-group">
                  <input type="submit" class="btn btn-default" value="Sign In"> &nbsp; <a href="index.php?smiggle=index/register" style="color:#FFFFFF; text-decoration:underline; font-size:14px; text-transform:uppercase;"> Register A User</a>
                </div> 
                

             
   </form>                
   
     </div></div></div> 





	</div>
</div>


      
</body>
</html>