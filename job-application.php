<?php
/*
Plugin Name: Job application
Plugin URI:
Author: Danilo Calabrese
Author URI: https://www.danilocalabrese.it
Description: A custom post type add application jobs.
Version: 1.0.0
*/
define( 'PLUGIN_DIR', dirname(__FILE__).'/' );
class JobCandidatePostType {

    const NAME = 'Job application';
    const CUSTOM_TYPE = 'job_application';
    const TEXT_DOMAIN = 'job_application';
    const SINGLE_LABEL = 'Job application';
    const PLURAL_LABEL = 'Job applications';
    const TAXONOMY = 'Type';
    const TAXONOMY_PLURAL = 'Types';

    static public function getInstance() {
        static $instance = null;

        if(is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }

    public function __construct() {

        add_action( 'init', array( $this, 'init' ) );
        add_action( 'init', array( $this, 'requires') );

        add_filter('plugin_action_links_'.plugin_basename(__FILE__), array( $this, 'jobPluginAddPageSettingLink'));

        add_action('plugins_loaded', array($this, 'onPluginsLoadedExtensions'));
        add_action('wp', array($this, 'acfFormHead'));

        add_action('init', array($this, 'add_post_type'));
        add_action( 'init', array( $this, 'add_taxonomies'), 0 );

        add_action( 'admin_enqueue_scripts', array ( $this, 'jobAdminStyles' ) , 500 );

    }


    public function onPluginsLoadedExtensions() {
        if($this -> isElementorInstalled()) {
            require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "elementor" . DIRECTORY_SEPARATOR . "class-widgets.php");
        }
        if($this -> isAcfActive() || $this -> isAcfProActive()) {
            require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "acf-extension.php");
        }else {
            add_action( 'admin_notices', array($this, 'errorNotice') );
            deactivate_plugins(__FILE__);
        }
    }

    public function errorNotice() {
        ?>
        <div class="error notice">
            <p><?php __( 'Please install Advanced Custom Fields, it is required for this plugin to work properly!', self::TEXT_DOMAIN ); ?></p>
        </div>
        <?php
    }

    public function acfFormHead() {
        return acf_form_head();
    }

    public function installPlugins($plugin) {
        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        return is_plugin_active($plugin);
    }

    public function isElementorInstalled() {
        return $this -> installPlugins('elementor/elementor.php');
    }

    public function isAcfActive() {
        return $this -> installPlugins('advanced-custom-fields/acf.php');
    }
    public function isAcfProActive() {
        return $this -> installPlugins('advanced-custom-fields-pro/acf.php');
    }

    public function init($options = null){
        if($options) {
            foreach($options as $key => $value){
                $this->$key = $value;
            }
        }
    }

    public function jobPluginAddPageSettingLink( $links ) {
        $links[] = '<a href="' .
            admin_url( 'options-general.php?page=my-setting-admin' ) .
            '">' . __('Settings') . '</a>';
        return $links;
    }

    public function jobAdminStyles() {
     	wp_enqueue_style(
     		'Job_Admin_Plugin',
     		plugins_url( 'admin/css/admin.css', __FILE__ ),
     		[],
     	);
     }

    public function requires() {
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "acf.php");
        acforJobs::__installRequestForm();
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "colums-custom-post.php");
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "shortcode" . DIRECTORY_SEPARATOR . "shortcode-form.php");
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "shortcode" . DIRECTORY_SEPARATOR . "shortcode-all-applications.php");
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR . "admin.php");
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mail" . DIRECTORY_SEPARATOR . "mail.php");
    }

    # Create Custom Post Type
    public function add_taxonomies() {
        register_taxonomy(
            self::TAXONOMY,
            array(self::CUSTOM_TYPE),
            array(
                'hierarchical' => true,
                'labels' => array(
                    'name' => __( self::TAXONOMY, self::TEXT_DOMAIN),
                    'singular_name' => __(self::TAXONOMY_PLURAL, self::TEXT_DOMAIN),
                    'all_items' => __('All' . self::TAXONOMY_PLURAL, self::TEXT_DOMAIN),
                    'add_new_item' => __('Add New ' . self::TAXONOMY, self::TEXT_DOMAIN),
                ),
                'public' => true,
                'query_var' => true,
                'rewrite' => array(
                    'slug' => self::TAXONOMY
                ),
            )
        );

    }

    # Create Taxonomy
    public function add_post_type(){
        $labels = array(
            'name' => _x(self::PLURAL_LABEL, self::TEXT_DOMAIN),
            'singular_name' => _x(self::SINGLE_LABEL, self::TEXT_DOMAIN),
            'add_new' => _x('Add ' . self::SINGLE_LABEL, self::TEXT_DOMAIN),
            'add_new_item' => __('Add New ' . self::SINGLE_LABEL, self::TEXT_DOMAIN),
            'edit_item' => __('Edit ' . self::SINGLE_LABEL, self::TEXT_DOMAIN),
            'new_item' => __('New ' . self::SINGLE_LABEL, self::TEXT_DOMAIN),
            'view_item' => __('View ' . self::SINGLE_LABEL, self::TEXT_DOMAIN),
            'search_items' => __('Search ' . self::PLURAL_LABEL, self::TEXT_DOMAIN),
            'not_found' =>  __('No ' . self::PLURAL_LABEL . ' Found', self::TEXT_DOMAIN),
            'not_found_in_trash' => __('No ' . self::PLURAL_LABEL . ' found in Trash', self::TEXT_DOMAIN),
            'parent_item_colon' => ''
        );
        $options = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => strtolower(self::PLURAL_LABEL)),
            'capability_type' => 'post',
            'hierarchical' => false,
            'has_archive' => true,
            'menu_position' => null,
            'taxonomies' => array(self::TAXONOMY),
            'supports' => array(
                'title',
            ),
        );
        register_post_type(self::CUSTOM_TYPE, $options);
    }

}
JobCandidatePostType::getInstance();
