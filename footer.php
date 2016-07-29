<?php wp_footer(); ?>
</div>

<script type="text/javascript">
jQuery(window).on("scroll", function () {
    jQuery(".posts-container").addClass("opened");
    jQuery(".sidebar-container").addClass("closed");
});

jQuery("#menu-button").on("click", function () {
    jQuery("#menu-button").toggleClass("opened");
    jQuery(".menu-wrapper").toggleClass("opened");
});
</script>
</body>
</html>