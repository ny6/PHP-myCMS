<?php
  
  function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
    // If you want to remove html tags too then do this: trim(strip_tags($string))
  }

  function query_confirmation($result) {
    global $connection;
    if (!$result) {
      die("Query failed!" . mysqli_error($connection));
    }
  }

  function showAllQuery($table) {
    global $connection;
    $query = "SELECT * FROM {$table}";
    return mysqli_query($connection, $query);
  }

  function oneValueQuery($task, $table, $column, $value) {
    global $connection;
    switch($task) {
      case 'SELECT':
        $query = "SELECT * FROM {$table} WHERE {$column} = {$value}";
        return mysqli_query($connection, $query);
        break;
      case 'DELETE':
        $query = "DELETE FROM {$table} WHERE {$column} = {$value}";
        return mysqli_query($connection, $query);
        break;
      case 'SELECT_String':
        $query = "SELECT * FROM {$table} WHERE {$column} = '{$value}'";
        return mysqli_query($connection, $query);
        break;
    }
  }

  function oneColumnQuery($getColumn, $table, $column, $value) {
    global $connection;
    $query = "SELECT {$getColumn} FROM {$table} WHERE {$column} = {$value}";
    return mysqli_query($connection, $query);
  }

  function updateOneValueQuery($table, $setColumn, $setValue, $column, $value) {
    global $connection;
    $query = "UPDATE {$table} SET {$setColumn}='{$setValue}' WHERE {$column}={$value}";
    return mysqli_query($connection, $query);
  }

  function add_category() {
    global $connection;
    if (isset($_POST['submit'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $category = escape($_POST['category']);

        if ($category == "" || empty($category)) {
          echo "This field should not be empty.";
        } else {
          $query = "INSERT INTO categories(cat_title) VALUES('{$category}')";
          $add_category_query = mysqli_query($connection, $query);
          query_confirmation($add_category_query);
          echo "<div class='alert alert-success'><strong>Category created Succesfully</strong></div>";
        }
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function show_all_category() {
    $category_query = showAllQuery('categories');

    while($row = mysqli_fetch_assoc($category_query)) {
      $id = $row['cat_id'];
      $category = $row['cat_title'];
      echo "<tr>";
      echo "<td>{$id}</td>";
      echo "<td><a href='../category.php?category={$id}'>{$category}</a></td>";
      echo "<td><a class='btn btn-xs btn-warning' href='categories.php?edit={$id}'>Edit</a></td>";
      echo "<td><a class='btn btn-xs btn-danger delete_link' href='javascript:void(0);' rel='{$id}'>Delete</a></td>";
      echo "</tr>";
    }
  }

  function delete_category() {
    if(isset($_GET['delete'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $cat_id_to_delete = escape($_GET['delete']);
        $delete_query = oneValueQuery('DELETE', 'categories', 'cat_id', $cat_id_to_delete);
        if(!$delete_query) {
          die("Query failed" . mysqli_error($connection));
        } else {
          header ("Location: categories.php");
        }
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function show_all_posts() {
    global $connection;
    // Start of Posts, Categories & Users Joining Query
    $query = "SELECT posts.*, categories.cat_id, categories.cat_title, users.user_id, users.user_fname, users.user_lname FROM posts ";
    $query .= "JOIN categories ON posts.post_category_id = categories.cat_id ";
    $query .= "JOIN users ON posts.post_author_id = users.user_id ORDER BY posts.post_id DESC";
    // End of Posts, Categories & Users Joining Query

    $posts_query = mysqli_query($connection, $query);
    
    query_confirmation($posts_query);

    while ($row = mysqli_fetch_assoc($posts_query)) {
      $post_id = $row['post_id'];
      $post_category_id = $row['post_category_id'];
      $post_title = $row['post_title'];
      $post_author_id = $row['post_author_id'];
      $post_date = $row['post_date'];
      $post_image = $row['post_image'];
      $post_tags = $row['post_tags'];
      $post_status = $row['post_status'];
      $post_view_count = $row['post_view_count'];
      $cat_title = $row['cat_title'];
      $post_author_name = "{$row['user_fname']} {$row['user_lname']}";
            
      // Start of Comment Count query
      $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
      $comment_count_query = mysqli_query($connection, $query);
      query_confirmation($comment_count_query);
      $post_comments = mysqli_num_rows($comment_count_query);
      // End of Comment Count query

      echo "<tr>";
        echo "<td><input type='checkbox' class='single_checkbox' name='post_array[]' value='{$post_id}'></td>";
        echo "<td>{$post_id}</td>";
        echo "<td><a href='../category.php?category={$post_category_id}'>{$cat_title}</a></td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
        echo "<td><a href='../author.php?author={$post_author_id}'>{$post_author_name}</a></td>";
        echo "<td>{$post_date}</td>";
        echo "<td><img class='img-responsive' width='100px' src='../img/{$post_image}'></td>";
        echo "<td>{$post_tags}</td>";
        echo "<td><a href='post_comments.php?id={$post_id}'>{$post_comments}</a></td>";
        echo "<td>{$post_status}</td>";
        echo "<td><a href='posts.php?reset={$post_id}' onClick=\"javascript: return confirm('Are you sure you want to Reset Post View Count to Zero(0)'); \" title='Reset View Count'>{$post_view_count}</a></td>";
        echo "<td><a class='btn btn-warning btn-sm' href='posts.php?source=edit-post&post-id={$post_id}' title='Edit Post'><span class='glyphicon glyphicon-edit'></span></a></td>";
        echo "<td><a class='btn btn-danger btn-sm delete_link' rel='{$post_id}' href='javascript:void(0)' title='Delete Post'><span class='glyphicon glyphicon-trash'></span></a></td>";
      echo "</tr>";
    }
  }

  function delete_post() {    
    if (isset($_GET['delete'])) {
      if ($_SESSION['user_role'] == 'Admin') {
        $post_id_to_del = escape($_GET['delete']);
        $delete_query = oneValueQuery("DELETE", "posts", "post_id", $post_id_to_del);
        header("Location: posts.php");
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function reset_post_view_count() {
    if (isset($_GET['reset'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $post_id = escape($_GET['reset']);
        updateOneValueQuery("posts", "post_view_count", 0, "post_id", $post_id);
        header("Location: posts.php");
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function add_post() {
    if(isset($_POST['submit-post'])) {
      global $connection;

      $post_title = escape($_POST['post_title']);
      $post_category_id = escape($_POST['post_category_id']);
      $post_author_id = escape($_POST['post_author_id']);
      $post_date = escape(date('d-M-y'));

      $post_image = escape($_FILES['post_image']['name']);
      $post_image_temp = escape($_FILES['post_image']['tmp_name']);

      $post_content = escape($_POST['post_content']);
      $post_tags = escape($_POST['post_tags']);
      $post_status = escape($_POST['post_status']);

      move_uploaded_file($post_image_temp, "../img/{$post_image}");

      $query = "INSERT INTO posts(post_title, post_category_id, post_author_id, post_date, post_image, post_content, post_tags, post_status) VALUES('{$post_title}', {$post_category_id}, '{$post_author_id}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
      $add_post_query = mysqli_query($connection, $query);
      query_confirmation($add_post_query);
      $post_id = mysqli_insert_id($connection);

      echo "<div class='alert alert-success'><strong>Post added Succesfully</strong> <a href='../post.php?p_id={$post_id}'>View post</a></div>";
    }
  }

  function show_all_comments() {
    global $connection;
    $query = "SELECT comments.*,posts.post_id, posts.post_title ";
    $query .= "FROM comments LEFT JOIN posts on comments.comment_post_id = posts.post_id ORDER BY comment_id DESC";
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
      $post_title = $row["post_title"];

      echo "<tr>";
        echo "<td><input type='checkbox' class='comment_checkbox' name='comment_array[]' value='{$comment_id}'></td>";
        echo "<td>{$comment_id}</td>";
        echo "<td><a href='#'>{$comment_author}</a></td>";
        echo "<td>{$comment_email}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_status}</td>";
        echo "<td><a href='post_comments.php?id={$comment_post_id}'>{$post_title}</a></td>";
        echo "<td>{$comment_date}</td>";
        echo "<td><a class='btn btn-success btn-sm' href='comments.php?approve={$comment_id}' title='Approve Comment'>Approve</a>";
        echo "<td><a class='btn btn-warning btn-sm' href='comments.php?unapprove={$comment_id}' title='Unapprove Comment'>Unpprove</a>";
        echo "<td><a class='btn btn-danger btn-sm delete_link' href='javascript:void(0);' rel='{$comment_id}' title='Delete Post'>Delete</a>";
      echo "</tr>";
    }
  }

  function delete_comment() {
    global $connection;
    if(isset($_GET['delete'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $comment_id = escape($_GET['delete']);
        oneValueQuery("DELETE", "comments", "comment_id", $comment_id);
        header("Location: comments.php");
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function approve_comment() {
    global $connection;
    if(isset($_GET['approve'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $comment_id = escape($_GET['approve']);
        updateOneValueQuery("comments", "comment_status", "Approved", "comment_id", $comment_id);
        $fileName = $_SERVER['PHP_SELF'];
        header("Location: $fileName");
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function unapprove_comment() {
    global $connection;
    if(isset($_GET['unapprove'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $comment_id = escape($_GET['unapprove']);
        updateOneValueQuery("comments", "comment_status", "Unpproved", "comment_id", $comment_id);
        $fileName = $_SERVER['PHP_SELF'];
        header("Location: $fileName");
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function show_all_users() {
    $user_query = showAllQuery('users');

    while ($row = mysqli_fetch_assoc($user_query)) {
      $user_id = $row["user_id"];
      $username = $row["username"];
      $user_fname = $row["user_fname"];
      $user_lname = $row["user_lname"];
      $user_email = $row["user_email"];
      $user_image = $row["user_image"];
      $user_role = $row["user_role"];
  
      echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$user_fname}</td>";
        echo "<td>{$user_lname}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td><img src='../img/users/{$user_image}' alt={$username} width='100px'></td>";
        echo "<td>{$user_role}</td>";
        echo "<td><a href='users.php?source=edit-user&user_id={$user_id}' class='btn btn-warning'>Edit</a></td>";
        echo "<td><a href='javascript:void(0);' rel='{$user_id}' class='btn btn-danger delete_link'>Delete</a></td>";
      echo "</tr>";
    }
  }

  function delete_user() {
    if (isset($_GET['delete'])) {
      if($_SESSION['user_role'] == 'Admin') {
        $user_id = escape($_GET['delete']);
        $delete_query = oneValueQuery("DELETE", "users", "user_id", $user_id);
        header("Location: users.php");
      } else {
        echo "<div class='alert alert-danger'><strong>You don't have such rights.</strong></div>";
      }
    }
  }

  function add_user() {
    global $connection;

    if(isset($_POST['submit'])) {
      $username = escape($_POST['username']);
      $user_password = escape($_POST['user_password']);
      $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
      $user_fname = escape($_POST['user_fname']);
      $user_lname = escape($_POST['user_lname']);
      $user_email = escape($_POST['user_email']);
      $user_image = escape($_FILES['user_image']['name']);
      $user_image_temp = escape($_FILES['user_image']['tmp_name']);
      $user_role = escape($_POST['user_role']);

      move_uploaded_file($user_image_temp, "../img/users/{$user_image}");

      if(username_exists($username)) {
        echo "<div class='alert alert-warning'><strong>Username already exists.</strong></div>";
      } elseif(email_exists($user_email)) {
        echo "<div class='alert alert-warning'><strong>Email already exists.</strong></div>";
      } else {
        $query = "INSERT INTO users(username, user_password, user_fname, user_lname, user_email, user_image, user_role) ";
          $query .= "VALUES('{$username}', '{$user_password}', '{$user_fname}', '{$user_lname}', '{$user_email}', '{$user_image}', '{$user_role}')";
        $add_user_query = mysqli_query($connection, $query);
        query_confirmation($add_user_query);
        
        echo "<div class='alert alert-success'><strong>User created Succesfully</strong></div>";
      }
    }
  }

  function users_online() {
    if(isset($_GET['onlineusers'])) {
      session_start();
      include("../../includes/db.php");

      $session = session_id();
      $time = time();
      $time_out_in_seconds = 60;
      $time_out = $time - $time_out_in_seconds;

      $query = "SELECT * FROM users_online WHERE session='{$session}'";
      $user_query = mysqli_query($connection, $query);

      $count = mysqli_num_rows($user_query);

      if ($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')");
      } else {
        mysqli_query($connection, "UPDATE users_online SET time='{$time}' WHERE session='{$session}'");
      }

      $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}'");
      echo $count_user = mysqli_num_rows($users_online_query);
    }
  }
  users_online();

  function isAdmin($username) {
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection, $query);
    query_confirmation($result);
    $row = mysqli_fetch_assoc($result);

    if($row['user_role'] == 'Admin') {
      return true;
    }else {
      return false;
    }
  }

  function username_exists($username) {
    global $connection;
    $query = "SELECT username FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection, $query);
    query_confirmation($result);

    if(mysqli_num_rows($result) > 0) {
      return true;
    }else {
      return false;
    }
  }

  function email_exists($email) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
    $result = mysqli_query($connection, $query);
    query_confirmation($result);

    if(mysqli_num_rows($result) > 0) {
      return true;
    }else {
      return false;
    }
  }

?>