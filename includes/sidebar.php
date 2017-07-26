<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

  <!-- Blog Search Well -->
  <div class="well">
    <h4>Blog Search</h4>
    <form action="search.php" method="post">
      <div class="input-group">
        <input type="text" name="search" class="form-control">
        <span class="input-group-btn">
          <button class="btn btn-default" name="submit" type="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </form>
    <!-- /.input-group -->
  </div>

  <!-- Login Form -->

  <?php
    if(!isset($_SESSION['username'])) {
  ?>

    <div class="well">
      <h4>Login</h4>
      <form action="includes/login.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="username" placeholder="Enter Username">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Enter Password">
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-success" name="login" value="Login">
          <a href="registration.php" class="btn btn-primary">Register</a>
        </div>
      </form>
    </div>

  <?php } ?>
  <!-- End of Login Form -->

    <!-- Widget file -->
    <?php include "widget.php"; ?>

  <!-- Blog Categories Well -->
  <div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
      <div class="col-lg-12">
        <ul class="list-unstyled">

          <?php
            $category_query = showAllQuery("categories");

            while ($row = mysqli_fetch_assoc($category_query)) {
              $cat_id = $row["cat_id"];
              $category = $row['cat_title'];
              echo "<li><a href='category.php?category={$cat_id}'>{$category}</a></li>";
            }
          ?>

        </ul>
      </div>
      <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
  </div>
</div>