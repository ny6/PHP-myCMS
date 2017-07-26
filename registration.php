<?php  include "includes/header.php"; ?>
 
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = escape($_POST['firstname']);
    $lname = escape($_POST['lastname']);
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    $password_confirm = escape($_POST['repeat_password']);

    $error = [
      'username' => '',
      'email' => '',
      'password' => '',
      'password_confirm' => ''
    ];

    if(strlen($username) < 5) {
      $error['username'] = "<span class='text-warning'>Username too short</span>";
    }
    if($username == '') {
      $error['username'] = "<span class='text-danger'>Username cannot be blank</span>";
    }
    if(username_exists($username)) {
      $error['username'] = "<span class='text-danger'>Username already exists</span>";
    }
    if($email == '') {
      $error['email'] = "<span class='text-danger'>Email cannot be blank</span>";
    }
    if(email_exists($email)) {
      $error['email'] = "<span class='text-danger'>Email already exists. <a href='index.php'>Login Here</a></span>";
    }
    if(strlen($password) < 5) {
      $error['password'] = "<span class='text-warning'>Password too short</span>";
    }
    if($password == '') {
      $error['password'] = "<span class='text-danger'>Password cannot be blank</span>";
    }
    if($password !== $password_confirm) {
      $error['password_confirm'] = "<span class='text-danger'>Password do not match</span>";
    }

    foreach ($error as $key => $value) {
      if(empty($value)) {
        unset($error[$key]);
      }
    }

    if(empty($error)) {
      $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

      $query = "INSERT INTO users(user_fname, user_lname, username, user_email, user_password, user_role) ";
      $query .= "VALUES('{$fname}', '{$lname}', '{$username}', '{$email}', '{$password}', 'Subscriber')";
      $register_query = mysqli_query($connection, $query);
      query_confirmation($register_query);

      $message = "<div class='alert alert-success'><strong>Registration Successful. <a href='index.php'>Login Here</a></strong></div>";
    }
  }
?>

<!-- Page Content -->
<div class="container">
  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1>Register</h1>
            <h4><?php echo isset($message) ? $message : '' ?></h4>
            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">

              <div class="form-group">
                <label for="firstname" class="sr-only">First Name</label>
                <input type="text" name="firstname" class="form-control" placeholder="Enter First Name" autocomplete="on" value="<?php echo isset($fname) ? $fname : '' ?>">
              </div>
              <div class="form-group">
                <label for="lastname" class="sr-only">Last Name</label>
                <input type="text" name="lastname" class="form-control" placeholder="Enter Last Name" autocomplete="on" value="<?php echo isset($lname) ? $lname : '' ?>">
              </div>
              <div class="form-group">
                <label for="username" class="sr-only">username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
              </div>
              <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
              </div>

              <div class="form-group">
                <label for="repeat_password" class="sr-only">Password</label>
                <input type="password" name="repeat_password" class="form-control" placeholder="Repeat Password">
                <p><?php echo isset($error['password_confirm']) ? $error['password_confirm'] : '' ?></p>
              </div>
              
              <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
            </form>    
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>

<hr>

<?php include "includes/footer.php";?>