<?php include "includes/admin-header.php"; ?>

<?php
  $post_count = mysqli_num_rows(showAllQuery("posts"));
  $comment_count = mysqli_num_rows(showAllQuery("comments"));
  $user_count = mysqli_num_rows(showAllQuery("users"));
  $category_count = mysqli_num_rows(showAllQuery("categories"));
?>

<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Welcome to Dashboard <small><?php echo $_SESSION['user_fname'] . " " . $_SESSION['user_lname']; ?></small></h1>
      </div>
    </div>
    <!-- /.row -->
                    
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-file-text fa-5x"></i>
              </div>
          
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $post_count; ?></div>
                <div>Posts</div>
              </div>
            </div>
          </div>
    
          <a href="posts.php">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-comments fa-5x"></i>
              </div>
      
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $comment_count; ?></div>
                <div>Comments</div>
              </div>
            </div>
          </div>
          <a href="comments.php">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-user fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $user_count; ?></div>
                <div> Users</div>
              </div>
            </div>
          </div>
          <a href="users.php">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-list fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $category_count; ?></div>
                <div>Categories</div>
              </div>
            </div>
          </div>
          <a href="categories.php">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>

    </div>
    <!-- /.row -->



    <?php
      $published_post_count = mysqli_num_rows(oneValueQuery("SELECT_String", "posts", "post_status", "Published"));
      $draft_post_count = $post_count - $published_post_count;

      $approve_comment_count = mysqli_num_rows(oneValueQuery("SELECT_String", "comments", "comment_status", "Approved"));
      $unapprove_comment_count = $comment_count - $approve_comment_count;

      $admin_user_count = mysqli_num_rows(oneValueQuery("SELECT_String", "users", "user_role", "Admin"));
      $sub_user_count = $user_count - $admin_user_count;
    ?>

    <div class="row">
      <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Data', 'Count'],

            <?php
              $element_text = ['Total Posts', 'Published Posts', 'Draft Posts', 'Total Comments', 'Approve Comments', 'Unapprove Comments', 'Total Users', 'Admin Users', 'Subscriber', 'Total Categories'];
              $element_count = [$post_count, $published_post_count, $draft_post_count, $comment_count, $approve_comment_count, $unapprove_comment_count, $user_count, $admin_user_count, $sub_user_count, $category_count];
              
              for ($i = 0; $i < 10; $i++) {
                echo "['$element_text[$i]', $element_count[$i]],"; 
              }
            ?>
          ]);

          var options = {
            chart: {
              title: '',
              subtitle: '',
            }
          };

          var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

          chart.draw(data, google.charts.Bar.convertOptions(options));
        }
      </script>

      <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<!-- Footer file -->
<?php include "includes/admin-footer.php"; ?>