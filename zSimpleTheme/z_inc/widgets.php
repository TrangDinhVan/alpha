<?php
// Creating the widget
class wpb_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'zing_content',
            'Zing Content',
            array( 'description' => '' )
        );
    }
    public function widget( $args, $instance ) {
        echo $instance['content'];
    }
    public function form( $instance ) { ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <textarea style="display: block; width: 100%;" rows="8" name="<?php echo $this->get_field_name( 'content' ); ?>" id="<?php echo $this->get_field_id( 'content' ); ?>"><?php echo esc_attr( $instance['content'] ); ?></textarea>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}


// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' ); ?>