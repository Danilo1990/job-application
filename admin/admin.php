<?php
class MySettingsPage {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;


    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_options_page(
            'Settings Admin',
            'Job application settings',
            'manage_options',
            'my-setting-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>Job applications settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_form', // ID
            'Form', // Title
            array( $this, 'print_section_form' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'label', // ID
            'Hidden label', // Title
            array( $this, 'hidden_label_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_form' // Section
        );

        add_settings_field(
            'custom_class', // ID
            'Add custom class form', // Title
            array( $this, 'custom_class_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_form' // Section
        );

        add_settings_section(
            'setting_section_mail', // ID
            'Mail', // Title
            array( $this, 'print_section_mail' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'id_email', // ID
            'Email to send requests to:', // Title
            array( $this, 'id_email_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_mail' // Section
        );
        add_settings_field(
            'email_subject', // ID
            'Email subject for user', // Title
            array( $this, 'email_subject_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_mail' // Section
        );
        add_settings_field(
            'email_body', // ID
            'Text mail body for user', // Title
            array( $this, 'email_body_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_mail' // Section
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['email'] ) )
            $new_input['email'] = $input['email'];
            $new_input['title'] = $input['title'];
            $new_input['label'] = $input['label'];
            $new_input['custom_class'] = $input['custom_class'];
            $new_input['email_subject'] = $input['email_subject'];
            $new_input['email_body'] = $input['email_body'];
        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_form()
    {
        echo '<h3 class="admin-notice">Use shortcode [form-application] for display form</h3>';
        echo '<h3 class="admin-notice">Use shortcode [all-applications] for display all request on table</h3>';
    }

    public function print_section_mail()
    {
        print '<h4>Options to set the email you receive after each request</h4>';
    }


    public function id_email_callback()
    {
        printf(
            '<input type="text" id="email" name="my_option_name[email]" value="%s" />',
            isset( $this->options['email'] ) ? esc_attr( $this->options['email']) : ''
        );
    }


    public function hidden_label_callback()
    {
        printf(
            '<input id="%1$s" name="my_option_name[%1$s]" type="checkbox" %2$s />',
            'label',
            checked( isset( $this->options['label'] ), true, false )
        );
    }

    public function custom_class_callback()
    {
        printf(
            '<input type="text" id="custom_class" name="my_option_name[custom_class]" value="%s" />',
            isset( $this->options['custom_class'] ) ? esc_attr( $this->options['custom_class']) : ''
        );
    }

    public function email_subject_callback()
    {
        printf(
            '<input type="text" id="email_subject" name="my_option_name[email_subject]" value="%s" />',
            isset( $this->options['email_subject'] ) ? esc_attr( $this->options['email_subject']) : ''
        );
    }

    public function email_body_callback()
    {
        printf(
            '<textarea id="email_body" name="my_option_name[email_body]" rows="4">%s</textarea>',
            isset( $this->options['email_body'] ) ? esc_attr( $this->options['email_body']) : ''
        );
    }

}

if( is_admin() )
    $my_settings_page = new MySettingsPage();


