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
  
   <h4 style="margin-top:0%;font-family: century gothic; color:#FFFFFF;"> CREATE A TASK</h4>

    <form action="index.php?smiggle=index/mytasks" method="post">
    <input type="hidden" class="form-control" name="register_task" value="ok" >
                <div class="form-group">
                Assigned By:
                  <input type="text" class="form-control" name="assigned_by_id" value="<?php if(isset($_SESSION['profile_name'])): echo $_SESSION['profile_name'];  endif; ?>" >
                </div>
                <div class="form-group">
                Asssigned To: (* Registred users appear here)
                <?php
                if (isset($data) && is_array($data)) :?>
                <select class="form-control" placeholder="Assigned By:" name='assigned_to_id'>
                    
                      <?php foreach ($data as $values) : ?>
                
                	<option value="<?php echo $values['id']; ?>"><?php echo $values['names']; ?></option>
                
                   
                <?php endforeach; ?>
                </select> 
                
                
                <?php else: ?>
                <input type="text" class="form-control" placeholder="Create Another user to be assigned to can't assign to yourself" disabled="disabled" />
                <?php endif; ?>
                </div>
                <div class="form-group">
                completion Status:
                <select class="form-control" name='completion_status'>
                <option value="Not Started">Not Started</option>
                	<option value="In Progress">In Progress</option>
                    <option value="Complete">Complete</option>
                </select>
                </div>
                <div class="form-group">
                Priority Status
                <select class="form-control"  name='priority_status'>
                <option value="Normal">Normal</option>
                	<option value="Medium">Medium</option>
                    <option value="Urgent">Urgent</option>
                </select>
                </div>
                
                <div class="form-group">
                Task Details:
                  <textarea class="form-control"  rows="3" cols="4"  name='task'></textarea>

                </div> 

                <div class="form-group">
                  <input type="submit" class="btn btn-default" value="Create A Task">
                </div> 

             
   </form>                
   
     </div></div>





	</div>
</div>


      
</body>
</html>