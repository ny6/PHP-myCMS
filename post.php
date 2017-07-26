<?php include "includes/header.php"; ?>

<!-- Page Content -->
<div class="container">
  <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <?php
        $p_id = escape($_GET["p_id"]);

        $query = "SELECT posts.*, categories.cat_id, categories.cat_title, users.user_id, users.user_fname, users.user_lname ";
        $query .= "FROM posts JOIN categories ON posts.post_category_id = categories.cat_id ";
        $query .= "JOIN users ON posts.post_author_id = users.user_id ";
        $query .= "WHERE post_id = {$p_id}";

        $select_all_posts_query = mysqli_query($connection, $query);
        query_confirmation($select_all_posts_query);

        $row = mysqli_fetch_assoc($select_all_posts_query);
        $post_status = $row["post_status"];
        $post_title = $row["post_title"];
        $post_author_id = $row["post_author_id"];
        $post_cat_id = $row["post_category_id"];
        $post_date = $row["post_date"];
        $post_img = $row["post_image"];
        $post_content = $row["post_content"];
        $post_view_count = $row['post_view_count'];
        $cat_title = $row['cat_title'];
        $post_author_name = "{$row['user_fname']} {$row['user_lname']}";

        $role = "";
        if (isset($_SESSION['user_role'])) {
          $role = $_SESSION['user_role'];
        }
        
        if($post_status == 'Published' || $role == 'Admin') {

          // Start of update view post count 
          $query = "UPDATE posts SET post_view_count=post_view_count + 1 WHERE post_id={$p_id}";
          $update_post_view_count_query = mysqli_query($connection, $query);
          query_confirmation($update_post_view_count_query);
          // End of update view post count

        ?>
          <h2><?php echo $post_title; ?></h2>
          
          <p class="lead">
            <small>by</small> <a href="author.php?author=<?php echo $post_author_id; ?>"><?php echo $post_author_name; ?></a>
            <small>Category:</small> <a href="category.php?category=<?php echo $post_cat_id; ?>"><?php echo $cat_title; ?></a>
            <span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?>
            Total Post Views = <?php echo $post_view_count + 1; ?>
          </p>
          <hr>
          <img class="img-responsive" src="img/<?php echo $post_img; ?>" alt="">
          <hr>
          <p><?php echo $post_content; ?></p>
          <hr>
          <?php include "includes/comments.php"; ?>
        <?php 
          } else {
            header("Location: index.php");
          }
      ?>
    </div>
    <!-- End of Blog Entries Column -->
      
    <!-- Sidebar file -->
    <?php include "includes/sidebar.php"; ?>

  </div>
  <!-- End of row -->

  <hr>
<?php include "includes/footer.php"; ?>