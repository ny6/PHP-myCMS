<?php include "includes/header.php"; ?>
<?php
  $users = oneValueQuery("SELECT", "users", "user_id", escape($_GET["author"]));
  $row = mysqli_fetch_assoc($users);
  $post_author_name = "{$row['user_fname']} {$row['user_lname']}";
?>
<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <h1 class="page-header">All Posts from Author <small><?php echo $post_author_name; ?></small></h1>
      <?php
        if (isset($_GET["author"])) {
          $author = escape($_GET["author"]);

          if (isset($_GET['page'])) {
            $page_no = $_GET['page'];
          } else {
            $page_no = "";
          }

          if ($page_no == "" || $page_no == 1) {
            $page = 0;
          } else {
            $page = ($page_no * 5) - 5;
          }
          $query = "SELECT * FROM posts WHERE post_author_id={$author} AND post_status='Published'";
          $post_count = mysqli_query($connection, $query);
          query_confirmation($post_count);

          $count = mysqli_num_rows($post_count);
          $count = ceil($count / 5);
          
          if($count < 1) {
            echo "<h2 class='text-center text-primary'>No posts published by this Author.</h2>";
          }
          
          $query = "SELECT posts.*, categories.cat_id, categories.cat_title ";
          $query .= "FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
          $query .= "WHERE posts.post_author_id={$author} AND posts.post_status='Published' ";
          $query .= "ORDER BY post_id DESC LIMIT {$page}, 5";

          $select_all_posts_query = mysqli_query($connection, $query);
          
          query_confirmation($select_all_posts_query);

          while($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_id = $row["post_id"];
            $post_title = $row["post_title"];
            $post_author_id = $row["post_author_id"];
            $post_cat_id = $row["post_category_id"];
            $post_date = $row["post_date"];
            $post_img = $row["post_image"];
            $post_content = substr($row["post_content"], 0, 300);
            $post_view_count = $row['post_view_count'];
            $cat_title = $row['cat_title'];

          ?> <!-- Closing php for entering html, but loop is still working! -->
          
          <h2><a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
          <p class="lead">
            <small>by</small> <a href="author.php?author=<?php echo $post_author_id; ?>"><?php echo $post_author_name; ?></a>
            <small>Category:</small> <a href="category.php?category=<?php echo $post_cat_id; ?>"><?php echo $cat_title; ?></a>
            <small><span class="glyphicon glyphicon-time"></span> Posted on</small> <?php echo $post_date; ?>
            <small>Total Post Views =</small> <?php echo $post_view_count; ?>  
          </p>
          <hr>
          <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="img/<?php echo $post_img; ?>" alt=""></a>
          <hr>
          <p><?php echo $post_content; ?></p>
          <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
          <hr>
        <?php  } // Completeing the while loop
      }?>

      <!-- Start of Pagination -->
      <div class="text-center">
        <ul class="pagination pagination-lg">
          <?php
            for ($i = 1; $i <= $count; $i++) {
              if($i == $page_no) {
                echo "<li class='active'><a href='author.php?author={$author}&page={$i}'>{$i}</a></li>";
              } else {
                echo "<li><a href='author.php?author={$author}&page={$i}'>{$i}</a></li>";
              }
            }
          ?>
        </ul>
      </div>
      <!-- End of Pagination -->

    </div>
    <!-- End of Blog Entries Column -->
      
    <!-- Sidebar file -->
    <?php include "includes/sidebar.php"; ?>

  </div>
  <!-- End of row -->

  <hr>
<!-- Footer file -->
<?php include "includes/footer.php"; ?>