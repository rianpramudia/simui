<!DOCTYPE html>
<html lang="en">
<?php
  ob_start();
  session_start(); 
  include("includes/config.php");
  date_default_timezone_set("Asia/Jakarta");
  error_reporting(E_ALL);
//VARIABEL
if(!isset($_SESSION['login'])){
$loggedin = 0;
$role = "";
$id = "";
$user_id = "";
$email = "";
} else {
$loggedin = $_SESSION['login'];
$role = $_SESSION['role'];
$id = $_SESSION['id'];
$user_id = $_SESSION['uid'];
$email = $_SESSION['email'];
}
$result = "";
$col = "";
$content = "";  
include("includes/head.php"); ?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?php include("includes/header.php") ?>
  <div class="content-wrapper">
 <?php
include("content/main.php");
    ?>
    <?php include("includes/footer.php") ?>
  </div>
      <script type='text/javascript' src="js/jquery-ui.js"></script>
</body>
</html>
<?php 
    pg_close($conn);
    ob_end_flush();
?>