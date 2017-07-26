<?php include "includes/admin-header.php"; ?>

<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"><?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname'] . "'s"; ?> <small>Profile</small></h1>

        <?php 
          if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            $profile_query = oneValueQuery("SELECT_String", "users", "username", $username);

            $row = mysqli_fetch_assoc($profile_query);
            $fname = $row['user_fname'];
            $lname = $row['user_lname'];
            $email = $row['user_email'];
            $password = $row['user_password'];
            $image = $row['user_image'];
          }

          if (isset($_POST['submit'])) {
            $f_name = escape($_POST['user_fname']);
            $l_name = escape($_POST['user_lname']);
            $u_email = escape($_POST['user_email']);

            $u_image = escape($_FILES['u_image']['name']);
            $u_image_temp = escape($_FILES['u_image']['tmp_name']);
            
            $pass = escape($_POST['user_password']);

            move_uploaded_file($u_image_temp, "../img/users/{$u_image}");

            if(empty($u_image)) {
              $query = "SELECT * FROM users WHERE username = '{$username}'";
              $image_query = mysqli_query($connection, $query);
              query_confirmation($image_query);

              $row = mysqli_fetch_assoc($image_query);
              $u_image = $row['user_image'];
            }

            // Start of password query
              if(empty($pass)) {
                $pass = $password;
              } else {
                $pass = password_hash($pass, PASSWORD_BCRYPT, array('cost' =>12 ));
              }
            // End of password query

            $query = "UPDATE users SET ";
              $query .= "user_fname='{$f_name}', ";
              $query .= "user_lname='{$l_name}', ";
              $query .= "user_email='{$u_email}', ";
              $query .= "user_image='{$u_image}', ";
              $query .= "user_password='{$pass}' ";
              $query .= "WHERE username='{$username}'";

            $update_profile_query = mysqli_query($connection, $query);
            echo "<div class='alert alert-success'><strong>Profile updated Succesfully</strong></div>";
          }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="user_fname">First Name:</label>
            <input type="text" class="form-control" name="user_fname" value="<?php echo $fname; ?>">
          </div>

          <div class="form-group">
            <label for="user_lname">Last Name:</label>
            <input type="text" class="form-control" name="user_lname" value="<?php echo $lname; ?>">
          </div>

          <div class="form-group">
            <label for="user_email">Email:</label>
            <input type="email" class="form-control" name="user_email" value="<?php echo $email; ?>">
          </div>

          <div class="form-group">
            <label for="u_image">Image:</label>
            <img src="../img/users/<?php echo $image; ?>" alt="<?php echo $fname; ?>" width="100px">
            <input type="file" class="form-control" name="u_image">
          </div>

          <div class="form-group">
            <label for="user_password">Password:</label>
            <input type="password" class="form-control" name="user_password">
          </div>

          <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Update Profile">
          </div>
        </form>

      </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<!-- Footer file -->
<?php include "includes/admin-footer.php"; ?>