<?php include "db.php"; ?>
<?php include "../admin/includes/functions.php"; ?>
<?php session_start(); ?>

<?php
  if (isset($_POST['login'])) {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    $login_query = oneValueQuery("SELECT_String", "users", "username", $username);

    $row = mysqli_fetch_assoc($login_query);
    $db_username = $row['username'];
    $db_password = $row['user_password'];
    $db_fname = $row['user_fname'];
    $db_lname = $row['user_lname'];
    $db_user_role = $row['user_role'];
    $db_user_email = $row['user_email'];

    if (password_verify($password, $db_password)) {
      $_SESSION['username'] = $db_username;
      $_SESSION['user_fname'] = $db_fname;
      $_SESSION['user_lname'] = $db_lname;
      $_SESSION['user_role'] = $db_user_role;
      $_SESSION['user_email'] = $db_user_email;
      
      header("Location: ../admin");
    } else {
      header("Location: ../");
    }
    
  }

?>