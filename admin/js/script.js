tinymce.init({ selector:'textarea' });

// another loading screen, if need this then activate css too.

// var div_box = "<div id='load-screen'><div id='loading'></div></div>";
// $("body").prepend(div_box);
// $('#load-screen').delay(700).fadeOut(600, function() {
//   $(this).remove();
// });

// Start of shader
var shader = "<div id='shader' class='shader'><div class='loadingContainer'><div id='divLoading3'><div id='loader-wrapper'><div id='loader'></div></div></div></div></div>";
$("body").prepend(shader);
$('#shader').fadeIn(500).fadeOut(500, function() {
  $(this).remove();
});
// End of shader

// Start of live online users script
function loadOnlineUsers() {
  $.get("includes/functions.php?onlineusers=result", function(data) {
    $(".usersonline").text(data);
  });
}
setInterval(function() {
  loadOnlineUsers();
}, 500);
// End of live online users script