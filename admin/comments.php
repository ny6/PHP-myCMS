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
?>

<div id="page-wrapper">

  <div class="container-fluid">
    <?php include "includes/delete-modal.php"; ?>
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">All Comments <small>Under CMS Project</small></h1>

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
                <th>In Response</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php show_all_comments(); ?>
              <?php approve_comment(); ?>
              <?php unapprove_comment(); ?>
              <?php delete_comment(); ?>
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