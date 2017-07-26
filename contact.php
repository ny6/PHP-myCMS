<?php  include "includes/header.php"; ?>
 
<?php
  if (isset($_POST['submit'])) {
    $from = escape($_POST['email']);
    $to = 'yeshu@outlook.in';
    $subject = "Contact Form: " . escape($_POST['subject']);
    $message = escape($_POST['message']);

    $headers = "From: {$from}";

    mail($to, $subject, $message, $headers);
  }
?>

<!-- Page Content -->
<div class="container">
  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1>Contact</h1>
            <form role="form" action="" method="post" autocomplete="off">

              <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your Email">
              </div>
              <div class="form-group">
                <label for="subject">Your Subject:</label>
                <input type="text" name="subject" class="form-control" placeholder="Enter Subject here">
              </div>
              <div class="form-group">
                <label for="message">Your Message:</label>
                <textarea name="message" class="form-control" placeholder="Your message here" rows="10" cols="50"></textarea>
              </div>
              
              <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
            </form>    
          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>

<hr>

<?php include "includes/footer.php";?>