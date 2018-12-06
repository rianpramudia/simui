
<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
  <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
    <a class="nav-link" href="index.php">
      <i class="fa fa-fw fa-dashboard"></i>
      <span class="nav-link-text">Home</span>
    </a>
  </li>
  <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data Table">

      <ul class="sidenav-second-level" id="collapseData">
        <li>
          <a href="index.php?action=show-organisasi">Organisasi</a>
        </li>
        <li>
          <a href="index.php?action=show-kepanitiaan"> Kepanitiaan</a>		
        </li>
		 <li>
          <a href="index.php?action=show-event">Event</a>		
        </li>
		

<?php
/*

switch($role){
case "admin":
	echo "
	<hr color='#727b83' width='90%'/>
	<li><a href='index.php?action=show-organisasi'>Lihat Organisasi</a></li>
	<li><a href='index.php?action=show-kepanitiaan'>Lihat Kepanitiaan</a></li>
	<li><a href='index.php?action=show-event'>Lihat Event</a></li>
	";
	break;
case "non_admin":
	echo "
	<hr color='#727b83' width='90%'/>
	<li><a href='index.php?action=show-organisasi'>Lihat Organisasi</a></li>
	<li><a href='index.php?action=show-kepanitiaan'>Lihat Kepanitiaan</a></li>
	<li><a href='index.php?action=show-event'>Lihat Event</a></li>
	";
	break;
}
*/
?>

		</ul>
  </li>  
</ul>