<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/**
 * Adds Podamibe Appointment Calendar Widget
 */
function register_pac_widget() {
    register_widget('PAC_Widget');
}

class PAC_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'PAC_Widget', // Base ID
                esc_html__('Podamibe Appointment Calendar', PAC_TEXT_DOMAIN ), // Name
                array('description' => esc_html__('Podamibe Appointment Calendar to display the calendar and form', PAC_TEXT_DOMAIN ) )
                );
    }

    /**
     * Back-end widget form.
     */
    public function form($instance) {
        $pac_title  = isset($instance['pac_title']) ? $instance['pac_title']:''; ?>
        
        <p>
            <label for="<?php echo $this->get_field_id('pac_title'); ?>">
                <?php esc_html_e("Title:", PAC_TEXT_DOMAIN ); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('pac_title');?>" name="<?php echo $this->get_field_name('pac_title'); ?>" type="text" value="<?php echo esc_html($pac_title); ?>"/>
        </p>

        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance[ 'pac_title' ] = esc_html( $new_instance[ 'pac_title' ] );
        return $instance;
    }

    /**
     * Front-end display of widget.
     */
    public function widget($args, $instance) {

        echo $args['before_widget'];

        if (!empty($instance['pac_title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['pac_title']) . $args['after_title'];
        }

        echo pac_calendar_shortcode(true);   
        
        echo $args['after_widget'];
    }

} // class PAC_Widget