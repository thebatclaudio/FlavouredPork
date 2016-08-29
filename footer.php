<?php wp_footer(); ?>
</div>

<script type="text/javascript">

jQuery(function($) {
  var top = $('.sidebar-container').position().top;

  function fixSidebar() {
    var sidebar = $('.sidebar-container');
    if ($(window).scrollTop() > top) {
      sidebar.css({
        'position': 'fixed',
        'top': '0px',
        'right': '0px'
      });    	
  	} else {
      sidebar.css({
        'position': 'relative',
        'top': 'auto'
      });  		
  	}
  }

  if($(window).width() > 992) {
    $(window).scroll(fixSidebar);
    fixDiv();    
  }
});

jQuery("#menu-button").on("click", function () {
    jQuery("#menu-button").toggleClass("opened");
    jQuery(".menu-wrapper").toggleClass("opened");
});
</script>
</body>
</html>