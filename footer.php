<?php wp_footer(); ?>
</div>

<script type="text/javascript">

var topPosition = 0;

function flvPrkFixSidebar() {
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

$(document).ready(function() {
  topPosition = 680;

  if($(window).width() > 992 
    && $('.sidebar-container').height() < $('.posts-container').height() 
    && $('.sidebar-container').height() < $(window).height()) {
    $(window).scroll(flvPrkFixSidebar);
  }
});

jQuery(window).resize(function() {
  topPosition = $('.sidebar-container').position().top;

  if($(window).width() > 992 
    && $('.sidebar-container').height() < $('.posts-container').height() 
    && $('.sidebar-container').height() < $(window).height()) {
    $(window).scroll(flvPrkFixSidebar);
  }
});

jQuery("#menu-button").on("click", function () {
    jQuery("#menu-button").toggleClass("opened");
    jQuery(".menu-wrapper").toggleClass("opened");
});
</script>
</body>
</html>