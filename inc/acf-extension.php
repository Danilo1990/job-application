<?php

class acfExtension {

    public function __construct() {
        add_action('acf/save_post', array( $this, 'acfChangeTitleJob'), 5);
        add_action('acf/upload_prefilter/name=cv', array( $this, 'field_name_upload_prefilter'));

    }

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * @param $post_id
     * @return wp_update_post()
     */

    public function acfChangeTitleJob( $post_id ) {

        $my_post = array();
        $my_post['ID'] = $post_id;
        $my_post['post_title'] = $_POST['acf']['field_name'] . ' ' .  $_POST['acf']['field_surname'];

        wp_update_post( $my_post );

    }

    /**
     * Create folder /cv on folder /uploads for the attachements
     */

    public function field_name_upload_prefilter($errors) {
        add_action('upload_dir', array( $this, 'field_name_upload_dir'));
        return $errors;
    }

    public function field_name_upload_dir($uploads) {
        $uploads['path'] = $uploads['basedir'].'/cv';
        $uploads['url'] = $uploads['baseurl'].'/cv';
        $uploads['subdir'] = '';
        return $uploads;
    }
}

acfExtension::getInstance();