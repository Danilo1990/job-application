<?php

class acforJobs {

    const ACF_GROUP_DETAILS = 'group_request_form';
    const ACF_NAME = 'name';
    const ACF_SURNAME = 'surname';
    const ACF_EMAIL = 'email';
    const ACF_PHONE = 'phone';
    const ACF_DESCRIPTION = 'description';
    const ACF_TYPE = 'type';
    const ACF_CV = 'cv';
    const ACF_TICKET= 'ticket';
    const ACF_SOCIAL= 'social';

    /**
     * @return acforJobs|null
     */

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * @return void
     */

    public function __installRequestForm()
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }
        acf_add_local_field_group(array(
            'key' => self::ACF_GROUP_DETAILS,
            'title' => __('Date', JobCandidatePostType::TEXT_DOMAIN),
            'fields' => array(
                self::__settingTicketRequest(),
                self::__settingNameField(),
                self::__settingSurnameField(),
                self::__settingPhoneField(),
                self::__settingEmailField(),
                self::__settingDescriptionField(),
                self::__settingSocialField(),
                self::__settingIntervationType(),
                self::__settingUploadCV(),

            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => JobCandidatePostType::CUSTOM_TYPE,
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }

    public function __settingNameField() {
        return array(
            'key' => 'field_' . self::ACF_NAME,
            'label' => __('Name', JobCandidatePostType::TEXT_DOMAIN),
            'placeholder' =>  __('Name', JobCandidatePostType::TEXT_DOMAIN),
            'name' => self::ACF_NAME,
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 0,
            'readonly_edit' => 0,
            'unique_constraint' => 0,
            'slugify_input' => 0,
        );
    }
    public function __settingSurnameField() {
        return array(
            'key' => 'field_' . self::ACF_SURNAME,
            'label' => __('Surname', JobCandidatePostType::TEXT_DOMAIN),
            'placeholder' =>  __('Surname', JobCandidatePostType::TEXT_DOMAIN),
            'name' => self::ACF_SURNAME,
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 0,
            'readonly_edit' => 0,
            'unique_constraint' => 0,
            'slugify_input' => 0,
        );
    }
    public function __settingEmailField() {
        return array(
            'key' => 'field_' . self::ACF_EMAIL,
            'label' => __('Email', JobCandidatePostType::TEXT_DOMAIN),
            'placeholder' =>  __('Email', JobCandidatePostType::TEXT_DOMAIN),
            'name' => self::ACF_EMAIL,
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 0,
            'readonly_edit' => 0,
            'unique_constraint' => 0,
            'slugify_input' => 0,
        );
    }
    public function __settingPhoneField() {
        return array(
            'key' => 'field_' . self::ACF_PHONE,
            'label' => __('Phone', JobCandidatePostType::TEXT_DOMAIN),
            'placeholder' =>  __('Phone', JobCandidatePostType::TEXT_DOMAIN),
            'name' => self::ACF_PHONE,
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 0,
            'readonly_edit' => 0,
            'unique_constraint' => 0,
            'slugify_input' => 0,
        );
    }
    public function __settingDescriptionField() {
        return array(
            'key' => 'field_' . self::ACF_DESCRIPTION,
            'label' => __('About you', JobCandidatePostType::TEXT_DOMAIN),
            'placeholder' =>  __('About you...', JobCandidatePostType::TEXT_DOMAIN),
            'name' => self::ACF_DESCRIPTION,
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 0,
            'readonly_edit' => 0,
            'unique_constraint' => 0,
            'slugify_input' => 0,
        );
    }
    public function __settingSocialField() {
        return array(
            'key' => 'field_' . self::ACF_SOCIAL,
            'label' => __('Link social', JobCandidatePostType::TEXT_DOMAIN),
            'placeholder' =>  __('Link social', JobCandidatePostType::TEXT_DOMAIN),
            'name' => self::ACF_SOCIAL,
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'readonly' => 0,
            'readonly_edit' => 0,
            'unique_constraint' => 0,
            'slugify_input' => 0,
        );
    }
    protected function __settingIntervationType() {
        return array(
            'key'               => 'field_' . self::ACF_TYPE,
            'label'             => __( 'What are you running for?', JobCandidatePostType::TEXT_DOMAIN ),
            'name'              => self::ACF_TYPE,
            'type'              => 'taxonomy',
            'instructions'      => '',
            'required'          => 0,
            'conditional_logic' => 0,
            'wrapper'           => array(
                'width' => '',
                'class' => '',
                'id'    => '',
            ),
            'readonly'          => 0,
            'readonly_edit'     => 0,
            'unique_constraint' => 0,
            'slugify_input'     => 0,
            'taxonomy' => JobCandidatePostType::TAXONOMY,
            'field_type' => 'select',
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 0,
            'return_format' => 'id',
            'multiple' => 0,
            'allow_null' => 0,
        );
    }
    protected function __settingUploadCV() {
        return array(
            'key'               => 'field_' . self::ACF_CV,
            'label'             => __( 'Upload CV', JobCandidatePostType::TEXT_DOMAIN ),
            'name'              => self::ACF_CV,
            'type'              => 'file',
            'instructions'      => '',
            'required'          => 0,
            'conditional_logic' => 0,
            'wrapper'           => array(
                'width' => '',
                'class' => '',
                'id'    => '',
            ),
            'return_format' => 'url',
            'description' => '',
            'max_size' => '10',
            'mime_types' => 'pdf',
            'uploader' => 'basic',
        );
    }
    protected function __settingTicketRequest() {
        return array(
            'key'               => 'field_' . self::ACF_TICKET,
            'label'             => __( 'Request', JobCandidatePostType::TEXT_DOMAIN ),
            'name'              => self::ACF_TICKET,
            'type'              => 'select',
            'instructions'      => '',
            'required'          => 0,
            'conditional_logic' => 0,
            'choices' => array(
                'waiting'	=> 'Waiting',
                'approved'	=> 'Approved',
                'rejected'	=> 'Rejected',
            ),
            'default_value' => 'Waiting',
            'wrapper'           => array(
                'width' => '',
                'class' => '',
                'id'    => '',
            ),
        );
    }
}

acforJobs::getInstance();
