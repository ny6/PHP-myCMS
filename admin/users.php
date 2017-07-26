<?php include "includes/admin-header.php"; ?>

<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Users <small>Under CMS Project</small></h1>

        <?php
          if(isset($_GET['source'])) {
            $source = escape($_GET['source']);
          } else {
            $source = "";
          }

          switch($source) {
            case 'add-user':
              include "includes/users/add-user.php";
              break;
            
            case 'edit-user':
              include "includes/users/edit-user.php";
              break;

            default:
              include "includes/users/view-all-users.php";
              break;
          }
        ?>

      </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<!-- Footer file -->
<?php include "includes/admin-footer.php"; ?>