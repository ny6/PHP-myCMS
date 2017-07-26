<!-- Footer -->
  <footer>
    <div class="row">
      <div class="col-lg-12">
        <p>Powered by: <a href="https://yeshu.info" target="_blank">Yeshu K.</a></p>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<script>
  // Start of live online users script
  function loadOnlineUsers() {
    $.get("admin/includes/functions.php?onlineusers=result", function(data) {
      $(".usersonline").text(data);
    });
  }
  setInterval(function() {
    loadOnlineUsers();
  }, 500);
  // End of live online users script
</script>
</body>
</html>