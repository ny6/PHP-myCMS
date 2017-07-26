<?php include "includes/admin-header.php"; ?>

<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<?php
  if (isset($_POST['comment_array'])) {
    foreach($_POST['comment_array'] as $comment) {
      $bulk_comment = escape($_POST['bulk_comment']);
      switch($bulk_comment) {
        case "Approved":
          updateOneValueQuery("comments", "comment_status", "$bulk_comment", "comment_id", $comment);
          break;

        case "Unapproved":
          updateOneValueQuery("comments", "comment_status", "$bulk_comment", "comment_id", $comment);
          break;

        case "Delete":
          oneValueQuery("DELETE", "comments", "comment_id", $comment);
          break;
      }
    }
  }

  $p_id = $_GET['id'];

  // fetching post title
  $post_title_query = oneColumnQuery("post_title", "posts", "post_id", $p_id);
  $row = mysqli_fetch_assoc($post_title_query);
  $post_title = $row["post_title"];
?>

<div id="page-wrapper">

  <div class="container-fluid">
    <?php include "includes/delete-modal.php"; ?>
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">All Comments of <small><?php echo $post_title ; ?></small></h1>

        <form action="" method="post">
          <div class="col-xs-3" style="padding: 0;">
            <select name="bulk_comment" class="form-control">
              <option value="">Select Option</option>
              <option value="Approved">Approved</option>
              <option value="Unapproved">Unapproved</option>
              <option value="Delete">Delete</option>
            </select>
          </div>
          <div class="col-xs-3">
            <input type="submit" value="Apply" class="btn btn-primary" name="submit">
          </div>

          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th><input type="checkbox" class= name="bulk_option" onchange="checkAll(this)"></th>
                <th>ID</th>
                <th>Author</th>
                <th>Email</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php              
                $query = "SELECT * FROM comments WHERE comment_post_id={$p_id} ORDER BY comment_id DESC";
                $comments_query = mysqli_query($connection, $query);
                query_confirmation($comments_query);

                while ($row = mysqli_fetch_assoc($comments_query)) {
                  $comment_id = $row['comment_id'];
                  $comment_post_id = $row['comment_post_id'];
                  $comment_author = $row['comment_author'];
                  $comment_email = $row['comment_email'];
                  $comment_content = $row['comment_content'];
                  $comment_status = $row['comment_status'];
                  $comment_date = $row['comment_date'];

                  echo "<tr>";
                    echo "<td><input type='checkbox' class='comment_checkbox' name='comment_array[]' value='{$comment_id}'></td>";
                    echo "<td>{$comment_id}</td>";
                    echo "<td><a href='#'>{$comment_author}</a></td>";
                    echo "<td>{$comment_email}</td>";
                    echo "<td>{$comment_content}</td>";
                    echo "<td>{$comment_status}</td>";
                    echo "<td>{$comment_date}</td>";
                    echo "<td><a class='btn btn-success btn-sm' href='post_comments.php?id={$p_id}&approve={$comment_id}' title='Approve Comment'>Approve</a>";
                    echo "<td><a class='btn btn-warning btn-sm' href='post_comments.php?id={$p_id}&unapprove={$comment_id}' title='Unapprove Comment'>Unpprove</a>";
                    echo "<td><a class='btn btn-danger btn-sm delete_link' href='javascript:void(0);' rel='{$comment_id}' title='Delete Post'>Delete</a>";
                  echo "</tr>";

                  if(isset($_GET['delete'])) {
                    $comment_id = escape($_GET['delete']);
                    oneValueQuery("DELETE", "comments", "comment_id", $comment_id);
                    header("Location: post_comments.php?id={$p_id}");
                  }

                  if(isset($_GET['approve'])) {
                    $comment_id = escape($_GET['approve']);
                    updateOneValueQuery("comments", "comment_status", "Approved", "comment_id", $comment_id);
                    header("Location: post_comments.php?id={$p_id}");
                  }
    
                  if(isset($_GET['unapprove'])) {
                    $comment_id = escape($_GET['unapprove']);
                    updateOneValueQuery("comments", "comment_status", "Unapproved", "comment_id", $comment_id);
                    header("Location: post_comments.php?id={$p_id}");
                  }
                }
              ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<!-- Footer file -->
<?php include "includes/admin-footer.php"; ?>

<script>
  function checkAll(source) {
    var checkboxes = document.getElementsByClassName('comment_checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = source.checked;
    }
  }

  $(document).ready(function() {
    $(".delete_link").on("click", function() {
      var id = $(this).attr("rel");
      var delete_url = "comments.php?delete=" + id;
      $(".modal_delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });
  });
</script>