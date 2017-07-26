<?php
  if(isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $comment_post_id = escape($_GET['p_id']);
      $comment_content = escape($_POST['comment_content']);
      $comment_email = $_SESSION['user_email'];
      $comment_author = $_SESSION['username'];

      $error = [
        'comment' => ''
      ];

      if($comment_content == '') {
        $error['comment'] = "<span class='text-danger'>Comment cannot be blank.</span>";
      }

      foreach ($error as $key => $value) {
        if(empty($value)) {
          unset($error[$key]);
        }
      }

      if(empty($error)) {
        $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_date, comment_status) ";
        $query .= "VALUES({$p_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', NOW(), 'Approved' ) ";
        $post_comment_query = mysqli_query($connection, $query);
        query_confirmation($post_comment_query);
      } 
    }
  } else {
    $error['comment'] = "<span class='text-danger'>Please Login or Register to post comment.</span>";
  }
?>

<!-- Comments Form -->
<div class="well">
  <h4>Leave a Comment:</h4>
  <form action="" method="post">
    <div class="form-group">
      <label for="comment_content">Comment:</label>
      <textarea name="comment_content" class="form-control" rows="3"></textarea>
      <p><?php echo isset($error['comment']) ? $error['comment'] : '' ?></p>
    </div>
    <button type="submit" class="btn btn-primary" name="submit_comment">Submit Comment</button>
  </form>
</div>

<hr>

<!-- Display Comment -->
<h3 id="comment">Comments:</h3>
<?php
  if (isset($_GET['p_id'])) {
    $p_id = escape($_GET['p_id']);

    $query = "SELECT comments.*, users.username, users.user_image, users.user_fname, users.user_lname ";
    $query .= "FROM comments LEFT JOIN users ON comments.comment_author = users.username ";
    $query .= "WHERE comment_post_id = {$p_id} AND comment_status='Approved' ";
    $query .= "ORDER BY comment_id DESC";
    
    $comment_query = mysqli_query($connection, $query);
    query_confirmation($comment_query);

    while ($row = mysqli_fetch_assoc($comment_query)) {
      $comment_post_id = $row['comment_post_id'];
      $comment_content = $row['comment_content'];
      $comment_status = $row['comment_status'];
      $comment_date = $row['comment_date'];
      $comment_author = "{$row['user_fname']} {$row['user_lname']}";
      $user_image = $row['user_image'];
    ?>

      <div class="media">
        <!--<a class="pull-left" href="#">-->
          <img class="media-object pull-left" src="img/users/<?php echo $user_image; ?>" alt="<?php echo $user_image; ?>" style="width:64px;height:64px;">
        <!--</a>-->
        <div class="media-body">
          <h4 class="media-heading"><?php echo $comment_author; ?>
            <small><?php echo $comment_date; ?></small>
          </h4>
          <?php echo $comment_content; ?>
        </div>
      </div>

    <?php } 
  } 
?>