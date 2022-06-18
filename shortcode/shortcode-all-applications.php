<?php

class shortcodeAllApplications {

    public function __construct() {
        add_shortcode('all-applications', array( $this, 'allApplicationsShortcode'));

    }

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    public function allApplicationsShortcode() {
        ob_start();
            include( PLUGIN_DIR . 'template/show-all-application.php');
        return ob_get_clean();
    }
}
shortcodeAllApplications::getInstance();