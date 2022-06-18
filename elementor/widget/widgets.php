<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    // Exit if accessed directly.
    exit;
}

class Latest_Posts_Widget extends Widget_Base {

    /**
     * Get the widget's name.
     *
     * @return string
     */
    public function get_name(): string {
        return 'job-application-form';
    }

    /**
     * Get the widget's title.
     *
     * @return string
     */
    public function get_title(): string {
        return esc_html__( 'Job application Form' , JobCandidatePostType::TEXT_DOMAIN );
    }

    /**
     * Get the widget's icon.
     *
     * @return string
     */
    public function get_icon(): string {
        return 'dashicons dashicons-menu';
    }

    /**
     * Add the widget to a category.
     * Previously setup in the class-widgets.php file.
     *
     * @return string[]
     */
    public function get_categories(): array {
        return [ 'job-category' ];
    }

    /**
     * Return Form
     *
     * @return void
     */

    protected function render() {
        include( PLUGIN_DIR . 'template/form-request-application.php');
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Latest_Posts_Widget() );