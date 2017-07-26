<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<?php
  if (isset($_GET['post-id'])) {
    $p_id = escape($_GET['post-id']);

    $get_posts_by_id = oneValueQuery("SELECT", "posts", "post_id", $p_id);
    $row = mysqli_fetch_assoc($get_posts_by_id);
    
    $post_category_id = $row['post_category_id'];
    $post_title = $row['post_title'];
    $post_author_id = $row['post_author_id'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_status = $row['post_status'];
    $post_view_count = $row['post_view_count'];
  }
  
  if(isset($_POST['submit-post'])) {

    $post_title = escape($_POST['post_title']);
    $post_category_id = escape($_POST['cat_id']);
    $post_author_id = escape($_POST['post_author_id']);

    $post_date = escape(date('d-M-y'));

    $post_image = escape($_FILES['post_image']['name']);
    $post_image_temp = escape($_FILES['post_image']['tmp_name']);

    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);
    $post_status = escape($_POST['post_status']);

    move_uploaded_file($post_image_temp, "../img/{$post_image}");

    if(empty($post_image)) {
      $image_query = oneColumnQuery("post_image", "posts", "post_id", $p_id);
      $row = mysqli_fetch_assoc($image_query);
      $post_image = $row['post_image'];
    }

    $query = "UPDATE posts SET ";
      $query .= "post_title = '{$post_title}', ";
      $query .= "post_category_id = {$post_category_id}, ";
      $query .= "post_author_id = '{$post_author_id}', ";
      $query .= "post_date = now(), ";
      $query .= "post_image = '{$post_image}', ";
      $query .= "post_content = '{$post_content}', ";
      $query .= "post_tags = '{$post_tags}', ";
      $query .= "post_status = '{$post_status}' ";
      $query .= "WHERE post_id = '{$p_id}' ";

    $update_post_query = mysqli_query($connection, $query);
    query_confirmation($update_post_query);
    
    echo "<div class='alert alert-success'><strong>Post updated Succesfully</strong> <a href='../post.php?p_id={$p_id}'>View post</a></div>";
  }

?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="post_title">Title:</label>
    <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
  </div>

  <div class="form-group">
    <label for="cat_id">Category:</label>
    <select name="cat_id" class="form-control">
      <?php
        $category_query = showAllQuery("categories");
        while($row = mysqli_fetch_assoc($category_query)) {
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];
          
          if($cat_id == $post_category_id) {
            echo "<option selected value='{$cat_id}'>{$cat_title}</option>";  
          } else {
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
          }
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="post_author_id">Author:</label>
    <!--<input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">-->
    <select name="post_author_id" class="form-control">
      <?php
        $user_query = showAllQuery("users");
        while($row = mysqli_fetch_assoc($user_query)) {
          $author_id = $row['user_id'];
          $author_name = "{$row['user_fname']} {$row['user_lname']}";
          echo "<option value={$author_id}>{$author_name}</option>";
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="post_date">Date:</label>
    <input type="date" class="form-control" name="post_date" value="<?php echo $post_date; ?>">
  </div>

  <div class="form-group">
    <img src="../img/<?php echo $post_image; ?>" alt="post_image" width="100px">
    <input type="file" name="post_image" class="form-control">
  </div>

  <div class="form-group">
    <label for="post_content">Content:</label>
    <textarea name="post_content" class="form-control" cols="30" rows="10"><?php echo str_replace('\r\n', '<br>', $post_content); ?></textarea>
  </div>

  <div class="form-group">
    <label for="post_category_id">Tags:</label>
    <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
  </div>  

  <div class="form-group">
    <label for="post_status">Status:</label>
    <select name="post_status" class="form-control">
      <option value="Published">Published</option>
      <option value="Draft">Draft</option>
    </select>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit-post" value="Update Post">
  </div>
</form>