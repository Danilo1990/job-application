<?php

class shortcodeForm {

    public function __construct() {
        add_shortcode('form-application', array( $this, 'formShortcode'));

    }

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    public function formShortcode() {
        ob_start();
            include( PLUGIN_DIR . 'template/form-request-application.php');
        return ob_get_clean();
    }
}
shortcodeForm::getInstance();