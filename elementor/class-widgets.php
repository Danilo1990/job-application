<?php
if ( ! in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

class JobElementorWidget {

    /**
     * @since 1.9.2
     */

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * @since 1.9.2
     */
    public function __construct() {
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
        add_action( 'elementor/elements/categories_registered', array( $this, 'elementor_widget_categories' ) );
    }

    /**
     * Register the widgets.
     *
     * @since 1.9.2
     */
    public function widgets_registered() {
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "widget" . DIRECTORY_SEPARATOR . "widgets.php");
    }


    /**
     * Custom elementor dashboard widgets category.
     * The widgets will be visible here.
     *
     * @since 1.9.2
     *
     * @param $elements_manager
     */
    public function elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'job-category',
            [
                'title' => esc_html__( 'Projects Engine', JobCandidatePostType::NAME ),
                'icon'  => 'fa fa-plug',
            ]
        );
    }
}

JobElementorWidget::getInstance();