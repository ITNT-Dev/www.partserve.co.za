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
th
{
	font-family: century gothic;
	font-size:12px;
	font-weight:normal;
	color:#FFFFFF;
	text-transform:capitalize;

}
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
   
    <div class="admin-box" style="margin-left:4%; margin-top:0%; width:70%;">
  
   <h4 style="margin-top:0%;font-family: century gothic; color:#FFFFFF;"> 
            <h4>Task List</h4><br/>
 Select A List To See: (already arangent by Top Priority) &nbsp;&nbsp;&nbsp; &rarr;&nbsp;&rarr;&nbsp;&nbsp;<a href="index.php?smiggle=index/tasklist/Normal" style="color:#fff;">Normal Priority</a> |  <a href="index.php?smiggle=index/tasklist/Medium" style="color:#fff;">Medium Priority</a> |  <a href="index.php?smiggle=index/tasklist/Urgent" style="color:#fff;">Urgent Priority</a><br/><br/>
     <table class="table">
            <thead> 
                   
                    
                   
                
                   <tr>
                       
                        <th style="width: 7em">ASSIGNED to</th>
                      <th style="width: 7em">VISITOR'S NAME</th>
                      <th style="width: 4em">EMAIL</th>
                      <th style="width: 4em">COMPLETION</th>
                       <th style="width: 7em">PRIORITY </th>
                      <th style="width: 7em">&nbsp;</th>
                    </tr>
                </thead>
               
                <tbody>
                <?php
                if (isset($data) && is_array($data)) :?>
                    <?php foreach ($data as $post) : ?>
                                                        <tr bgcolor="#fff" style="color:#333">
                        <td><a href="index.php?smiggle=visitors/update/2" style="color:#c74433;">
                                <?php echo $post['assigned_by_id']; ?>                          </a> </td>
                        <td>
                            <a href="index.php?smiggle=visitors/update/2" style="color:#c74433;">
                                <?php echo $post['assigned_to_id']; ?>                              </a>                        </td>
                        
                                                    <td>
                                                      <?php echo $post['task']; ?>                                                 </td>
                                                    <td>
                             <?php echo $post['completion_status']; ?>                         </td>
                            <td>
                             <?php echo $post['priority_status'];  ?>                         </td>
                                                    <td>
                             <a href="index.php?smiggle=visitors/view/2" style="color:#c74433;">View</a>&nbsp;&nbsp;&nbsp;<a href="index.php?smiggle=index/update/<?php echo $post['id'];  ?>" style="color:#c74433;">Edit</a>&nbsp;&nbsp;&nbsp;<a href='index.php?smiggle=index/delete/<?php echo $post['id'];  ?>' style="color:#c74433;"><span>Delete</span></a>                      </td>
                    </tr>
                                        <?php endforeach; ?><?php else: ?>
                <tr>
                        <td colspan="3">
                            <br/>
                            <div class="alert alert-warning">
                                No Task found.                            </div>                        </td>
                    </tr>
                <?php endif; ?>
                
                
                
                                                    </tbody>
            </table>
            





    
    
   
     </div></div> 






      
</body>
</html>