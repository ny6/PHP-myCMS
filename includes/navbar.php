<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">CMS Project</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!-- Adding categories to navbar -->
        <?php
          $categories_query = showAllQuery("categories");

          while ($row = mysqli_fetch_assoc($categories_query)) {
            $cat_id = $row["cat_id"];
            $category = $row["cat_title"];
            
            $page_name = basename($_SERVER['PHP_SELF']);
            $contact = "contact.php";
            $registration = "registration.php";

            $category_class = "";
            $contact_class = "";
            $registration_class = "";

            if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
              $category_class = "active";
            } else if ($page_name == $registration) {
              $registration_class = "active";
            } else if ($page_name == $contact) {
              $contact_class = "active";
            }

            echo "<li class='{$category_class}'><a href='category.php?category={$cat_id}'>{$category}</a></li>";
          }
        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="<?php echo $contact_class; ?>"><a href="contact.php">Contact</a></li>
        <?php 
          if(isset($_SESSION["username"])) {
            
            if(isset($_GET["p_id"])) {
              $p_id = escape($_GET["p_id"]);
              echo "<li><a href='admin/posts.php?source=edit-post&post-id={$p_id}'>Edit Post</a></li>";
            } ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>
                <?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname']; ?>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li><a href='admin'>Dashboard</a></li>
                <li class="divider"></li>
                <li><a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          <?php } else if(!isset($_SESSION["username"])) {
            echo "<li class='{$registration_class}'><a href='registration.php'>Registration</a></li>";
          }
        ?>
        <!-- End of adding categories to navbar -->
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>