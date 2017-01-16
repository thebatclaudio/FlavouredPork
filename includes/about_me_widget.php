<?php

class FlvPrkAboutMeWidget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'scripts'));

        parent::__construct(
            'about_me_widget', // Base ID
            __( 'About Me', 'flv_prk' ), // Name
            array( 'description' => __( 'About Me Widget', 'flv-prk' ), ) // Args
        );
    }

    public function scripts()
    {
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_media();
        wp_enqueue_script('about_me_widget', get_template_directory_uri() . '/js/about_me_widget.js', array('jquery'));
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'About Me', 'flv-prk' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
        $description = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Description', 'flv-prk' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( esc_attr( 'Description:' ) ); ?></label> 
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
        </p>
        <?php
        $image_url = ! empty( $instance['image_url'] ) ? $instance['image_url'] : "";
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php _e( esc_attr( 'Image URL:' ) ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text" value="<?php echo esc_attr( $image_url ); ?>">
            <button class="upload_image_button button button-primary">Upload Image</button>
        </p>
        <?php 
        $circle_image = ! empty( $instance['circle_image'] ) ? $instance['circle_image'] : "";
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'circle_image' ) ); ?>">
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'circle_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'circle_image' ) ); ?>" type="checkbox" <?php if($circle_image){ ?> checked <?php } ?>>
                 <?php _e( esc_attr( 'Rounded image' ) ); ?>
            </label> 
        </p>
        <?php 
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        ?>
        <?php if($instance['circle_image']): ?>
            <div class="about-me-image" style="background-image: url('<?php echo $instance['image_url']; ?>")'></div>
        <?php else: ?>
            <img src="<?php echo $instance['image_url']; ?>" class="about-me-image">
        <?php endif; ?>
        <div class="about-me-description">
            <?php echo apply_filters( 'description', $instance['description'] ); ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
        $instance['image_url'] = ( ! empty( $new_instance['image_url'] ) ) ? strip_tags( $new_instance['image_url'] ) : '';
        $instance['circle_image'] = ( ! empty( $new_instance['circle_image'] ) ) ? strip_tags( $new_instance['circle_image'] ) : false;

        return $instance;
    }
}

function flv_prk_register_about_me_widget() {
    register_widget( 'FlvPrkAboutMeWidget' );
}

add_action( 'widgets_init', 'flv_prk_register_about_me_widget' );
?>