<?php wp_footer(); ?>
</div>

<script type="text/javascript">

function flvPrkFixSidebar() {
  if ($(window).scrollTop() > $('.sidebar-container').position().top) {
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
  $('.sidebar-container').position().top;

  if($(window).width() > 992 
    && $('.sidebar-container').height() < $('.posts-container').height() 
    && $('.sidebar-container').height() < $(window).height()) {
    $(window).scroll(flvPrkFixSidebar);
  }
});

jQuery(window).resize(function() {
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