<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>
<?php add_post(); ?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="post_title">Title:</label>
    <input type="text" class="form-control" name="post_title">
  </div>
  
  <div class="form-group">
    <label for="post_category_id">Category:</label>
    <select name="post_category_id" class="form-control">
      <?php
        $category_query = showAllQuery("categories");
        while($row = mysqli_fetch_assoc($category_query)) {
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];

          echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="post_author_id">Author:</label>
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
    <input type="date" class="form-control" name="post_date">
  </div>

  <div class="form-group">
    <label for="post_image">Image:</label>
    <input type="file" class="form-control" name="post_image">
  </div>

  <div class="form-group">
    <label for="post_content">Content:</label>
    <textarea name="post_content" class="form-control" cols="30" rows="10"></textarea>
  </div>

  <div class="form-group">
    <label for="post_category_id">Tags:</label>
    <input type="text" class="form-control" name="post_tags">
  </div>  

  <div class="form-group">
    <label for="post_status">Status:</label>
    <select name="post_status" class="form-control">
      <option value="Published">Published</option>
      <option value="Draft">Draft</option>
    </select>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit-post" value="Publish Post">
  </div>
</form>