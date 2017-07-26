<?php include "includes/delete-modal.php"; ?>

<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Image</th>
      <th>Role</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php show_all_users(); ?>
    <?php delete_user(); ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $(".delete_link").on("click", function() {
      var id = $(this).attr("rel");
      var delete_url = "users.php?delete=" + id;
      $(".modal_delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });
  });
</script>