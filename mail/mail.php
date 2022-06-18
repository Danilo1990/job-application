<?php

class mailSentForm {

    public function __construct() {
        add_action('acf/save_post', array($this, 'sendEmailAdministrator'), 20);
        add_action('acf/save_post', array($this, 'sendEmailUser'), 20);
    }

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }


    public function sendEmailAdministrator($post_id) {
        if(get_post_type($post_id) == JobCandidatePostType::CUSTOM_TYPE) {
            $optionPlugin = get_option( 'my_option_name' );

            $post = get_post($post_id);
            $custom = get_post_custom($post_id);

            $toEmail = $optionPlugin['email'];
            $subject = __('New request application job', JobCandidatePostType::TEXT_DOMAIN);
            $email_body = __('You have received a new collaboration request', JobCandidatePostType::TEXT_DOMAIN);

            $was_email_sent = wp_mail($toEmail, $subject, $email_body);
        }
    }

    public function sendEmailUser($post_id) {
        if(get_post_type($post_id) == JobCandidatePostType::CUSTOM_TYPE) {
            $optionPlugin = get_option( 'my_option_name' );

            $post = get_post($post_id);
            $custom = get_post_custom($post_id);

            $email = get_field(acforJobs::ACF_EMAIL, $post_id);
            $subjectEmail = $optionPlugin['email_subject'];
            $email_bodySend = $optionPlugin['email_body'];

            $toEmail =  $email ;
            $subject = $subjectEmail;
            $email_body = $email_bodySend;

            $was_email_sent = wp_mail($toEmail, $subject, $email_body);
        }
    }

}
mailSentForm::getInstance();