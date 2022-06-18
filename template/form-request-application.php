<div class="form-request-application <?= get_option( 'my_option_name' )['custom_class'] ?>">
    <?php
        acf_form(array(
            'post_id'         => 'new_post',
            'new_post'        => array(
                'post_type'     => JobCandidatePostType::CUSTOM_TYPE,
                'post_status'   => 'publish',
            ),
            'fields' => array(
                'field_name',
                'field_surname',
                'field_email',
                'field_phone',
                'field_description',
                'field_social',
                'field_type',
                'field_cv',
            ),
            'post_title'      => false,
            'post_content'    => false,
            'submit_value'   => __( "Send request", JobCandidatePostType::TEXT_DOMAIN ),
            'updated_message' => __("Request entered successfully", JobCandidatePostType::TEXT_DOMAIN),
        ));
    ?>
</div>
<?php
if(get_option( 'my_option_name' )['label'] == 'on') { ?>
<style type="text/css">
    .acf-label {
        display: none;
    }
</style>
<?php }