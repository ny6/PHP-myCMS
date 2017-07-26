<?php ob_start(); ?>
<?php session_start(); ?>

<?php
  $_SESSION['username'] = null;
  $_SESSION['user_fname'] = null;
  $_SESSION['user_lname'] = null;
  $_SESSION['user_role'] = null;
  $_SESSION['user_email'] = null;

  header("Location: ../");
?>