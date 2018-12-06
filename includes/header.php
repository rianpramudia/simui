<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="index.php">SIMUI</a>
  
  <?php if($loggedin=='0'){ ?>
  <a href='index.php?action=loginform' style=';color:#fff;'>Login</a>&nbsp;&nbsp;&nbsp;
  <!--<a href='index.php?action=registerformselection' style=';color:#fff;'>Register</a>-->
  <?php } else { ?>
  <a href='index.php?action=logout' style=';color:#fff;'>Logout</a>
  <?php }; ?>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <?php include("includes/side_menu.php") ?>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form class="form-inline my-2 my-lg-0 mr-lg-2">
        </form>
      </li>
    </ul>
  </div>
  <div style='float:right;color:white;padding-right:10px;'><?php if($loggedin!='0'){echo ($_SESSION['id']." (".$_SESSION['role'].")");}?></div>
</nav>