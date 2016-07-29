<?php

require_once("includes/about-me-widget.php");

/**
 * Function called to load common scripts and styles (e.g Bootstrap, jQuery, FontAwesome)
 * @return boolean
 */
function flv_prk_load_scripts_and_styles () {
    /*Load Scripts*/
    wp_register_script( 'jquery-script', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js','','',false );
    wp_enqueue_script( 'jquery-script' );

    wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js','','',true );
    wp_enqueue_script( 'bootstrap' );

    /*Load Styles*/
    wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Montserrat:400,700|Oswald:400,700,300');
    wp_enqueue_style( 'google-fonts');

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style( 'bootstrap');

    wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style( 'font-awesome');

    wp_register_style('main-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style( 'main-style');

    return true;
}

add_action( 'wp_enqueue_scripts', 'flv_prk_load_scripts_and_styles' );

// Adding theme support for thumbnails
add_theme_support( 'post-thumbnails' ); 

// Adding one top menu
register_nav_menus( array(
    'top' => 'Top Menu',
));

/**
 * Function that implement posts' numeric pagination
 * @return string
 */
function flv_prk_numeric_posts_nav () {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="pagination">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link("Prev") );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li class="disabled"><a href="#">…</a></li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="disabled"><a href="#">…</a></li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link("Next") );
 
    echo '</ul>' . "\n";

}

// Replace [...] with ... in the "Read more"
function new_excerpt_more ( $more ) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

//Register main sidebar
function flv_prk_widgets_init () {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'flv-prk' ),
        'id' => 'main-sidebar',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'flv-prk' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}

add_action( 'widgets_init', 'flv_prk_widgets_init' );


?>