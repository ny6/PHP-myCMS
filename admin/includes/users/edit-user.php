<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<?php
  if (isset($_GET['user_id'])) {
    $user_id = escape($_GET['user_id']);

    $get_users_by_id = oneValueQuery("SELECT", "users", "user_id", $user_id);

    while($row = mysqli_fetch_assoc($get_users_by_id)){
      $username = $row['username'];
      $user_fname = $row['user_fname'];
      $user_lname = $row['user_lname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];
      $user_password = $row['user_password'];
    }
  
    if(isset($_POST['submit-user'])) {

      // $username = escape($_POST['username']);
      $user_fname = escape($_POST['user_fname']);
      $user_lname = escape($_POST['user_lname']);
      $user_new_email = escape($_POST['user_email']);
      $user_password = escape($_POST['user_password']);
      
      $user_image = escape($_FILES['user_image']['name']);
      $user_image_temp = escape($_FILES['user_image']['tmp_name']);

      $user_role = escape($_POST['user_role']);
      
      move_uploaded_file($user_image_temp, "../img/users/{$user_image}");

      if(empty($user_image)) {
        $image_query = oneColumnQuery("user_image", "users", "user_id", $user_id);
        $row = mysqli_fetch_assoc($image_query);
        $user_image = $row['user_image'];
      }

      if(empty($user_password)) {
        $password_query = oneColumnQuery("user_password", "users", "user_id", $user_id);
        $row = mysqli_fetch_assoc($password_query);
        $user_password = $row['user_password'];
      } else {
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
      }

      if($user_new_email !== $user_email && email_exists($user_new_email)) {
        echo "<div class='alert alert-warning'><strong>Email already exists.</strong></div>";
      } else {
        $query = "UPDATE users SET ";
          $query .= "username = '{$username}', ";
          $query .= "user_fname = '{$user_fname}', ";
          $query .= "user_lname = '{$user_lname}', ";
          $query .= "user_email = '{$user_new_email}', ";
          $query .= "user_image = '{$user_image}', ";
          $query .= "user_role = '{$user_role}', ";
          $query .= "user_password = '{$user_password}' ";
          $query .= "WHERE user_id = {$user_id} ";

        $update_user_query = mysqli_query($connection, $query);
        query_confirmation($update_user_query);
        echo "<div class='alert alert-success'><strong>User updated Succesfully</strong></div>";
        header("Location: users.php?source=edit-user&user_id={$user_id}");
      }
    }
  } else {
    header("Location: index.php");
  }
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="username">Username:</label>
    <input disabled type="text" class="form-control" name="username" value="<?php echo $username; ?>">
  </div>

  <div class="form-group">
    <label for="user_fname">First Name:</label>
    <input type="text" class="form-control" name="user_fname" value="<?php echo $user_fname; ?>">
  </div>

  <div class="form-group">
    <label for="user_lname">Last Name:</label>
    <input type="text" class="form-control" name="user_lname" value="<?php echo $user_lname; ?>">
  </div>

  <div class="form-group">
    <label for="user_email">Email:</label>
    <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
  </div>

  <div class="form-group">
    <label for="user_password">Password:</label>
    <input type="password" class="form-control" name="user_password">
  </div>

  <div class="form-group">
    <img src="../img/users/<?php echo $user_image; ?>" alt="<?php echo $user_fname; ?>" width="100px">
    <input type="file" name="user_image">
  </div>

  <div class="form-group">
    <label for="user_role">User Role:</label>
    <select name="user_role" class="form-control">
      <?php 
        if($user_role == "Admin") {
          echo "<option value='Admin'>Admin</option>";
          echo "<option value='Subscriber'>Subscriber</option>";
        } else {
          echo "<option value='Subscriber'>Subscriber</option>";
          echo "<option value='Admin'>Admin</option>";
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit-user" value="Update User">
  </div>
</form>