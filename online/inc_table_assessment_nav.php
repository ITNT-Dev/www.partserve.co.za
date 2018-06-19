<!--post_nav-->
<?php 
if ($no_records > _ROWS_) { ?>

  <ul class="pager">
 
    <?php if ($no_page > 1) { ?>
      <li class="previous">
        <a href="dashboard.php?page=<?php echo $no_page-1?>&sort=<?php echo $sort ?>&sort_order=<?php echo $sort_order ?>">&larr; Newer</a>
      </li>
    <?php } else { ?>
      <li class="previous disabled">
        <a href="#">&larr; Newer</a>
      </li>
    <?php } ?>

    <li><a href="dashboard.php?page=0&sort=<?php echo $sort ?>&sort_order=<?php echo $sort_order ?>" title="Home">Home</a></li>
		
		<?php
		$last_page = floor($no_records / _ROWS_) + 1;
		if($last_page < 0) {
		  $last_page = 0;
		}
    ?>

    <li><a href="dashboard.php?page=<?php echo $last_page?>&sort=<?php echo $sort ?>&sort_order=<?php echo $sort_order ?>" title="Last Page">Last Page</a></li>

    <?php if ($no_records > (_ROWS_ * $no_page)) { ?>
      <li class="next">
			  <a href="dashboard.php?page=<?php echo $no_page+1?>&sort=<?php echo $sort ?>&sort_order=<?php echo $sort_order ?>" title="Older">Older >></a>
			</li>
    <?php } else { ?>
      <li class="next disabled">
        <a href="#">&larr; Older</a>
      </li>
    <?php } ?>
	
	  <?php
		$last_page = floor($no_records / _ROWS_) + 1;
		if($last_page < 0) {
		  $last_page = 0;
		}
		?>
	
  </ul>

<?php } ?>
<!--/post_nav-->

