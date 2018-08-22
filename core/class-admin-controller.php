<?php

class BRG_PTT_Admin_Interface_Controller {

    const SETTINGS_PAGE_SLUG  = 'brg_ptt_settings_page';
    const SETTINGS_GROUP      = 'brg_ptt_group';

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu') );
        add_action( 'admin_init', array( $this, 'register_plugin_settings') );
    }

    public function add_admin_menu() {
        $min_level = $this->get_min_level();
        add_menu_page( 'Post Type Templates', 'Post Type Templates', $min_level, self::SETTINGS_PAGE_SLUG, '', 'dashicons-analytics' );

        // Register submenu for plugin settings - default page for the plugin
        add_submenu_page( self::SETTINGS_PAGE_SLUG, 'Settings', 'Settings', $min_level, self::SETTINGS_PAGE_SLUG, array( $this, 'display_settings_page' ) );


        // Register submenu for README page
        add_submenu_page( self::SETTINGS_PAGE_SLUG, 'README', 'Help', $min_level, self::SETTINGS_PAGE_SLUG . '-readme', array( $this, 'display_readme' ) );
    }

    public function get_min_level() {
        return apply_filters( 'brg/ptt/minimum_user_level', 'activate_plugins' );
    }

    public function register_plugin_settings() {
        // register_setting( self::SETTINGS_GROUP, $setting );
        $post_types = get_post_types();
        foreach( $post_types as $post_type ) {
           register_setting( self::SETTINGS_GROUP, $post_type );
        }
    }

    public function display_settings_page() {
        include plugin_dir_path( __DIR__ ) . 'templates/settings.php';
    }

    public function display_readme() {
        include plugin_dir_path( __DIR__ ) . 'templates/readme.php';
    }
}
