<?php include "includes/delete-modal.php"; ?>

<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<?php
  if(isset($_POST['post_array'])) {
    foreach ($_POST['post_array'] as $p_id) {
      $bulk_option = $_POST['bulk_option'];

      switch($bulk_option) {
        case "Published":
          updateOneValueQuery("posts", "post_status", "$bulk_option", "post_id", $p_id);
          break;
        
        case "Draft":
          updateOneValueQuery("posts", "post_status", "$bulk_option", "post_id", $p_id);
          break;

        case "Delete":
          oneValueQuery("DELETE", "posts", "post_id", $p_id);
          break;

        case "Reset":
          updateOneValueQuery("posts", "post_view_count", 0, "post_id", $post_id);
          break;

        case "Clone":
          
          $post_query = oneValueQuery("SELECT", "posts", "post_id", $p_id);
          $row = mysqli_fetch_assoc($post_query);
          $post_category_id = $row['post_category_id'];
          $post_title = $row['post_title'];
          $post_author_id = $row['post_author_id'];
          $post_image = $row['post_image'];
          $post_content  = $row['post_content'];
          $post_tags = $row['post_tags'];

          $query = "INSERT INTO posts(post_category_id, post_title, post_author_id, post_image, post_content, post_tags, post_date) VALUES({$post_category_id}, '{$post_title}', {$post_author_id}, '{$post_image}', '{$post_content}', '{$post_tags}', now())";
          $insert_query = mysqli_query($connection, $query);
          query_confirmation($insert_query);
          
          break;
      }
    }
  }

?>

<form action="" method="post">
  
  <div class="col-xs-3" style="padding: 0;">
    <select name="bulk_option" class="form-control">
      <option value="">Select Option</option>
      <option value="Published">Publish</option>
      <option value="Draft">Draft</option>
      <option value="Delete">Delete</option>
      <option value="Clone">Clone</option>
      <option value="Reset">Reset Post Views</option>
    </select>
  </div>
  <div class="col-xs-3">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a href="posts.php?source=add-post" class="btn btn-primary">Add New</a>
  </div>

  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><input type="checkbox" class="select_all_checkbox" onchange="checkAll(this)"></th>
        <th>ID</th>
        <th>Category</th>
        <th>Title</th>
        <th>Author</th>
        <th>Date</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Status</th>
        <th>Post Views</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php show_all_posts(); ?>
      <?php delete_post(); ?>
      <?php reset_post_view_count(); ?>
    </tbody>
  </table>
</form>

<script>
  function checkAll(source) {
    var checkboxes = document.getElementsByClassName("single_checkbox");
    for(var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = source.checked;
    }
  }

  $(document).ready(function() {
    $(".delete_link").on('click', function() {
      var id = $(this).attr('rel');
      var delete_url = "posts.php?delete=" + id;
      $(".modal_delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });
  });
</script>