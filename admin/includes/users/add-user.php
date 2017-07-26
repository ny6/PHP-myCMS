<?php add_user(); ?>

<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username">
  </div>

  <div class="form-group">
    <label for="user_password">Password:</label>
    <input type="password" class="form-control" name="user_password">
  </div>

  <div class="form-group">
    <label for="user_fname">First Name:</label>
    <input type="text" class="form-control" name="user_fname">
  </div>

  <div class="form-group">
    <label for="user_lname">Last Name:</label>
    <input type="text" class="form-control" name="user_lname">
  </div>

  <div class="form-group">
    <label for="user_email">Email:</label>
    <input type="email" class="form-control" name="user_email">
  </div>

  <div class="form-group">
    <label for="user_image">Image:</label>
    <input type="file" class="form-control" name="user_image">
  </div>

  <div class="form-group">
    <label for="user_role">Role:</label>
    <select name="user_role" class="form-control">
      <option value="Subscriber">Subscriber</option>
      <option value="Admin">Admin</option>
    </select>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit" value="Add User">
  </div>
</form>