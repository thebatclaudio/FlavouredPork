<?php wp_footer(); ?>
</div>

<script type="text/javascript">

var topPosition = 0;

function flvPrkFixSidebar() {
  console.log(topPosition);
  if($(window).width() > 992 && $('.sidebar-container').height() < $('.posts-container').height() && $('.sidebar-container').height() < $(window).height()) {
    if ($(window).scrollTop() > topPosition) {
      $('.sidebar-container').css({
        'position': 'fixed',
        'top': '0px',
        'right': '0px'
      });     
    } else {
      $('.sidebar-container').css({
        'position': 'relative',
        'top': 'auto'
      });     
    }
  }
}

$(document).ready(function() {
  topPosition = $('.sidebar-container').position().top;
  $(window).scroll(flvPrkFixSidebar);
});

jQuery(window).resize(function() {
  topPosition = $('.sidebar-container').position().top;
});

jQuery("#menu-button").on("click", function () {
    jQuery("#menu-button").toggleClass("opened");
    jQuery(".menu-wrapper").toggleClass("opened");
});
</script>
</body>
</html>