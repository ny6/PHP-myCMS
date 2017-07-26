<?php
  if(!isAdmin($_SESSION['username'])) {
    header("Location: index.php");
  }
?>

<?php
  if(isset($_GET['edit'])) {
    $edit_category = $_GET['edit'];
    
    $edit_category_query = oneValueQuery("SELECT", "categories", "cat_id", $edit_category);
    
    while ($row = mysqli_fetch_assoc($edit_category_query)) {
      $cat_id_to_edit = $row['cat_id'];
      $cat_title_to_edit = $row['cat_title'];
    ?>
      <!-- Form will appear after clicking edit button -->
      <form action="" method="post">
        <div class="form-group">
          <label for="edit_cat_input">Update Category</label>
          <input type="text" name="edit_cat_input" class="form-control" value="<?php if(isset($_GET['edit'])) { echo $cat_title_to_edit; } ?>">
        </div>
        <div class="form-group">
          <input class="btn btn-warning" type="submit" name="edit_cat_btn" value="Update Category">
        </div>
      </form>

      <?php
        if (isset($_POST["edit_cat_btn"])) {
          $cat_input = $_POST["edit_cat_input"];
          $cat_input = mysqli_real_escape_string($connection, $cat_input);
          $query = "UPDATE categories SET cat_title = '{$cat_input}' WHERE cat_title = '{$cat_title_to_edit}'";
          $update_cat_query = mysqli_query($connection, $query);

          if(!$update_cat_query) {
            die("Query failed" . mysqli_error($connection));
          } else {
            header ("Location: categories.php");
          }
          
        }
    }
  }
?>