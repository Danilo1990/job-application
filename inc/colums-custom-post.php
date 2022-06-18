<?php

class columnsCustomPost {

    public function __construct() {
        add_filter('manage_job_application_posts_columns' , array($this,'custom_post_type_columns'));
        add_action( 'manage_job_application_posts_custom_column' , array($this,'fill_custom_post_type_columns'), 10, 2 );
    }

    /**
     * @return columnsCustomPost|null
     */

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    public function custom_post_type_columns($columns){
        unset(
            $columns['wpseo-score'],
            $columns['wpseo-title'],
            $columns['wpseo-metadesc'],
            $columns['wpseo-focuskw']
        );
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title'),
            'email' => __('Email'),
            'phone' => __('Phone'),
            'ticket' => __('Response'),
            'date' =>__( 'Date')
        );
        return $columns;
    }

    public function fill_custom_post_type_columns( $column, $post_id ) {
        // Fill in the columns with meta box info associated with each post
        switch ( $column ) {
            case 'email' :
                echo get_field(acforJobs::ACF_EMAIL, $post_id);
                break;
            case 'phone' :
                echo get_field(acforJobs::ACF_PHONE, $post_id);
                break;
            case 'ticket' :
                $ticket = get_field(acforJobs::ACF_TICKET, $post_id);
                if($ticket == 'approved') {
                    echo '<img src="'.plugin_dir_url( __FILE__ ) . 'icon/approve.png" >';
                } elseif ($ticket == 'rejected') {
                    echo '<img src="'.plugin_dir_url( __FILE__ ) . 'icon/rejected.png" >';
                } else {
                    echo '<img src="'.plugin_dir_url( __FILE__ ) . 'icon/waiting.png" >';
                }
                break;
        }
    }
}

columnsCustomPost::getInstance();