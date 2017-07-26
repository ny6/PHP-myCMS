<?php include "includes/admin-header.php"; ?>

<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<div id="page-wrapper">

  <div class="container-fluid">
    <?php include "includes/delete-modal.php"; ?>
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Cateories <small>Under CMS Project</small></h1>
      </div>

      <div class="col-lg-6">

        <!-- Add category function -->
        <?php add_category(); ?>

        <form action="" method="post">
          <div class="form-group">
            <label for="category">Add Category</label>
            <input type="text" name="category" class="form-control">
          </div>
          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Add New Category">
          </div>
        </form>
        <br>

        <!-- Update category file -->
        <?php include "includes/update-category.php"; ?>
        
      </div>

      <div class="col-lg-6">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <!-- Show all category function -->
            <?php show_all_category(); ?>

            <?php delete_category(); ?>

          </tbody>
        </table>
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
  $(document).ready(function() {
    $(".delete_link").on("click", function() {
      var id = $(this).attr("rel");
      var delete_url = "categories.php?delete=" + id;
      $(".modal_delete_link").attr("href", delete_url);
      $("#myModal").modal("show");
    });
  });
</script>