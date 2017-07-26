<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php">CMS Admin</a>
  </div>
  <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
      <li><a href="#">Users Online: <span class="usersonline"></span></a></li>
      <li><a href="..\">CMS</a></li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-user"></i>
          <?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname']; ?>
          <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a></li>
          <li class="divider"></li>
          <li><a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
    <!-- End of Top Nav bar -->

    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav side-nav">
        <li><a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
        
        <?php
          // Admin navbar
          if(isAdmin($_SESSION['username'])) {
        ?>

          <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="posts_dropdown" class="collapse">
              <li><a href="posts.php">All Posts</a></li>
              <li><a href="posts.php?source=add-post">Add New</a></li>
            </ul>
          </li>
          <li><a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a></li>
          <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="users_dropdown" class="collapse">
              <li><a href="users.php">All Users</a></li>
              <li><a href="users.php?source=add-user">Add New</a></li>
            </ul>
          </li>
          <li><a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a></li>

        <?php
          } // End of Admin Navbar
        ?>
        
        <li><a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a></li>
      </ul>
    </div>

</nav>