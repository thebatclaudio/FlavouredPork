<?php
 
// Create Custom Post Type
function register_slides_posttype() {
    $labels = array(
        'name'              => _x( 'Slides', 'post type general name' ),
        'singular_name'     => _x( 'Slide', 'post type singular name' ),
        'add_new'           => __( 'Add New Slide' ),
        'add_new_item'      => __( 'Add New Slide' ),
        'edit_item'         => __( 'Edit Slide' ),
        'new_item'          => __( 'New Slide' ),
        'view_item'         => __( 'View Slide' ),
        'search_items'      => __( 'Search Slides' ),
        'not_found'         => __( 'Slide' ),
        'not_found_in_trash'=> __( 'Slide' ),
        'parent_item_colon' => __( 'Slide' ),
        'menu_name'         => __( 'Slides' )
    );

    $taxonomies = array();

    $supports = array('title','thumbnail');

    $post_type_args = array(
        'labels'            => $labels,
        'singular_label'    => __('Slide'),
        'public'            => true,
        'show_ui'           => true,
        'publicly_queryable'=> true,
        'query_var'         => true,
        'capability_type'   => 'post',
        'has_archive'       => false,
        'hierarchical'      => false,
        'rewrite'           => array( 'slug' => 'slides', 'with_front' => false ),
        'supports'          => $supports,
        'menu_position'     => 27, // Where it is in the menu. Change to 6 and it's below posts. 11 and it's below media, etc.
        'taxonomies'        => $taxonomies
    );
    register_post_type('slides',$post_type_args);
}
add_action('init', 'register_slides_posttype');

function flv_prk_add_slidelink_2_meta_box() {
 
    global $slidelink_2_metabox;        
 
    foreach($slidelink_2_metabox['page'] as $page) {
        add_meta_box($slidelink_2_metabox['id'], $slidelink_2_metabox['title'], 'flv_prk_show_slidelink_2_box', $page, 'normal', 'default', $slidelink_2_metabox);
    }
}
 
// function to show meta boxes
function flv_prk_show_slidelink_2_box()  {
    global $post;
    global $slidelink_2_metabox;
    global $flv_prk_prefix;
    global $wp_version;
     
    // Use nonce for verification
    echo '<input type="hidden" name="flv_prk_slidelink_2_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
     
    echo '<table class="form-table">';
 
    foreach ($slidelink_2_metabox['fields'] as $field) {
        // get current post meta data
 
        $meta = get_post_meta($post->ID, $field['id'], true);
         
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
                '<td class="flv_prk_field_type_' . str_replace(' ', '_', $field['type']) . '">';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
                break;
        }
        echo    '<td>',
            '</tr>';
    }
     
    echo '</table>';
}   
 
// Save data from meta box
add_action('save_post', 'flv_prk_slidelink_2_save');
function flv_prk_slidelink_2_save($post_id) {
    global $post;
    global $slidelink_2_metabox;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['flv_prk_slidelink_2_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
 
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
 
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
     
    foreach ($slidelink_2_metabox['fields'] as $field) {
     
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
         
        if ($new && $new != $old) {
            if($field['type'] == 'date') {
                $new = flv_prk_format_date($new);
                update_post_meta($post_id, $field['id'], $new);
            } else {
                if(is_string($new)) {
                    $new = $new;
                } 
                update_post_meta($post_id, $field['id'], $new);
                 
                 
            }
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
 
// Enqueue Flexslider Files
function flv_prk_slider_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_enqueue_style( 'flex-style', get_template_directory_uri() . '/css/flexslider.css' );

    wp_enqueue_script( 'flex-script', get_template_directory_uri() .  '/js/jquery.flexslider-min.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'flv_prk_slider_scripts' );

// Initialize Slider
function flv_prk_slider_initialize() { ?>
    <script type="text/javascript" charset="utf-8">
        jQuery(window).load(function() {
            jQuery('.flexslider').flexslider({
                animation: "fade",
                direction: "horizontal",
                slideshowSpeed: 7000,
                animationSpeed: 600,
                controlNav: false
            });
        });
    </script>
<?php }
add_action( 'wp_head', 'flv_prk_slider_initialize' );

// Create Slider
function flv_prk_slider_template() {

    // Query Arguments
    $args = array(
        'post_type' => 'slides',
        'posts_per_page' => 5
    );  

    // The Query
    $the_query = new WP_Query( $args );

    // Check if the Query returns any posts
    if ( $the_query->have_posts() ) {

        // Start the Slider ?>
        <div class="flexslider">
            <ul class="slides">

                <?php
                // The Loop
                while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <li>

                    <?php // Check if there's a Slide URL given and if so let's a link to it
                    if ( get_post_meta( get_the_id(), 'flv_prk_slideurl', true) != '' ) { ?>
                        <a href="<?php echo esc_url( get_post_meta( get_the_id(), 'flv_prk_slideurl', true) ); ?>">
                    <?php }

                    // The Slide's Image
                    echo the_post_thumbnail();

                    // Close off the Slide's Link if there is one
                    if ( get_post_meta( get_the_id(), 'flv_prk_slideurl', true) != '' ) { ?>
                        </a>
                    <?php } ?>

                    </li>
                <?php endwhile; ?>

            </ul><!-- .slides -->
        </div><!-- .flexslider -->

    <?php }

    // Reset Post Data
    wp_reset_postdata();
}

// Slider Shortcode
function flv_prk_slider_shortcode() {
    ob_start();
    flv_prk_slider_template();
    $slider = ob_get_clean();
    return $slider;
}
add_shortcode( 'slider', 'flv_prk_slider_shortcode' );

// Create Slider
function flv_prk_top_slider_template() {

    // Query Arguments
    $args = array(
        'post_type' => 'slides',
        'posts_per_page' => 5
    );  

    // The Query
    $the_query = new WP_Query( $args );

    // Check if the Query returns any posts
    if ( $the_query->have_posts() ) {

        // Start the Slider ?>
        <div class="flexslider">
            <ul class="slides">

                <?php
                // The Loop
                while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <li>

                    <?php // Check if there's a Slide URL given and if so let's a link to it
                    if ( get_post_meta( get_the_id(), 'flv_prk_slideurl', true) != '' ) { ?>
                        <a href="<?php echo esc_url( get_post_meta( get_the_id(), 'flv_prk_slideurl', true) ); ?>">
                    <?php }

                    ?>
                    <figure class="slide" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));?>')">
                        <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));?>" alt="<?php the_title(); ?>" />
                    </figure>                    
                    <?php

                    // Close off the Slide's Link if there is one
                    if ( get_post_meta( get_the_id(), 'flv_prk_slideurl', true) != '' ) { ?>
                        </a>
                    <?php } ?>

                    </li>
                <?php endwhile; ?>

            </ul><!-- .slides -->
        </div><!-- .flexslider -->

    <?php }

    // Reset Post Data
    wp_reset_postdata();
}

?>