<?php
if (session_id() == "") { session_start(); }

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;

require_once (dirname(dirname(__FILE__)) . "/library/onlinejobtracking.class.php");
?>

<!--<div class="col-md-8">-->
<div class="col-12">
    <ul class="nav nav-pills" style="position:relative;left:60px;">
        <li <?php if (strtolower($pagename) == "dashboard.php") { echo " class='active' "; } else { ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;" <?php } ?>><a href="dashboard.php">Global View  <span class="badge"> <?php echo TOnlineJobTracking::getJobsCount($userId); ?></span></a></li>
        <li <?php if (strtolower($pagename) == "assesment_job.php") { echo " class='active' "; } else { ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;" <?php } ?>><a href="assesment_job.php">Under Assessment  <span class="badge"> <?php echo TOnlineJobTracking::getJobsUnderAssessmentCount($userId) ?></span></a></li>
        <li <?php if (strtolower($pagename) == "collection_job.php") { echo " class='active' "; } else { ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;" <?php } ?>><a href="collection_job.php">Ready for Collection  <span class="badge"> <?php echo TOnlineJobTracking::getJobsReadyForCollectionCount($userId); ?></span></a></li>
        <li <?php if (strtolower($pagename) == "closedjobs.php") { echo " class='active' "; } else { ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;" <?php } ?>><a href="closedJobs.php">Accepted and Rejected Jobs  <span class="badge"> <?php echo TOnlineJobTracking::getJobsClosedCount($userId); ?></span></a></li>
        <li <?php if (strtolower($pagename) == "current_job.php") { echo " class='active' "; } else { ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;" <?php } ?>><a href="current_job.php">Quoted Jobs  <span class="badge"> <?php echo TOnlineJobTracking::getJobsQuotedCount($userId); ?></span></a></li>
    </ul>
</div>
    
<div class="col-12">
    <center><div>
            <p>&nbsp;</p>
      <a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>

      <?php if (isset($_SESSION['adminId'])) { ?>
      <br><br><a href="admin_page.php"><button type="button" class="btn btn-success">Back to Admin</button></a>
      <?php } ?>
    </div>
    </center>

  </div>

