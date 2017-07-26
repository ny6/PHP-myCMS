<!-- Connecting Database -->
<?php include "includes/db.php"; ?>

<!-- Header file-->
<?php include "includes/header.php"; ?>

<!-- Navbar file -->
<?php include "includes/navbar.php"; ?>

<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <h1 class="page-header">Search results: <small>Under CMS Project</small></h1>
      
      <!-- Search PHP -->
      <?php
        if (isset($_POST["submit"])) {
          $search = escape($_POST["search"]);
        
          $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
          $search_query = mysqli_query($connection, $query);
          if (!$search_query) {
            die ("Query failed!" . mysqli_error($connection));
          }

          $count = mysqli_num_rows($search_query);
          if($count == 0) {
            echo "<h2>No result found</h2>";
          } else {
              while($row = mysqli_fetch_assoc($search_query)) {
                $post_id = $row['post_id'];
                $post_cat_id = $row["post_category_id"];
                $post_title = $row["post_title"];
                $post_author_id = $row["post_author_id"];
                $post_date = $row["post_date"];
                $post_content = substr($row["post_content"], 0, 300);
                $post_view_count = $row['post_view_count'];

                // Start of category query
                $query = "SELECT * FROM categories WHERE cat_id = $post_cat_id";
                $show_category_title_name = mysqli_query($connection, $query);
                query_confirmation($show_category_title_name);

                $row = mysqli_fetch_assoc($show_category_title_name);

                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                // End of category query

                // Start of author query
                $query = "SELECT * FROM users WHERE user_id = $post_author_id";
                $author_query = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($author_query);
                $post_author_id = $row['user_id'];
                $post_author_name = "{$row['user_fname']} {$row['user_lname']}";
                // End of author query

              ?> <!-- Closing php for entering html, but loop is still working! -->

              <h2><a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
              <p class="lead">
                <small>by</small> <a href="author.php?author=<?php echo $post_author_id; ?>"><?php echo $post_author_name; ?></a>
                <small>Category:</small> <a href="category.php?category=<?php echo $cat_id; ?>"><?php echo $cat_title; ?></a>
                <small><span class="glyphicon glyphicon-time"></span> Posted on</small> <?php echo $post_date; ?>
                <small>Total Post Views =</small> <?php echo $post_view_count; ?>
              </p>
              <hr>
              <p><?php echo $post_content; ?></p>
              <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

              <hr>

            <?php } //Completeing the while loop
          }
        }

      ?>      

    </div>
    <!-- End of Blog Entries Column -->
      
    <!-- Sidebar file -->
    <?php include "includes/sidebar.php"; ?>

  </div>
  <!-- End of row -->

  <hr>
<!-- Footer file -->
<?php include "includes/footer.php"; ?>