<?php

class BRG_PTT_Admin_Interface_Controller {

  const SETTINGS_PAGE_SLUG  = 'edit.php?post_type=brg_post_templates';
  const SETTINGS_GROUP      = 'brg_ptt_group';

  public function __construct( $min_level ) {
    $this->min_level = $min_level;
    // Check for template updates
    $this->save_template();
    // add the admin menu to the wp admin pages
    add_action( 'admin_menu', array( $this, 'add_admin_menu') );
  }

  public function add_admin_menu() {
    // Register submenu for plugin settings - default page for the plugin
    add_submenu_page(
      self::SETTINGS_PAGE_SLUG,
      'Set Templates',
      'Set Templates',
      $this->min_level,
      self::SETTINGS_PAGE_SLUG . 'settings',
      array( $this, 'display_settings_page' ) 
    );


    // Register submenu for README page
    add_submenu_page(
      self::SETTINGS_PAGE_SLUG,
      'README',
      'Help',
      $this->min_level, 
      self::SETTINGS_PAGE_SLUG . 
      '-readme', 
      array( $this, 'display_readme' ) 
    );
  }

  public function display_settings_page() {
    include plugin_dir_path( __DIR__ ) . 'templates/settings.php';
  }

  public function display_readme() {
    include plugin_dir_path( __DIR__ ) . 'templates/readme.php';
  }

  // Check if there is a new template to save, and if so make updates
  public function save_template() {
    // Only allow users with permission to save the template
    // Also, only run updates if the template settings page was submitted
    if( !current_user_can( $this->min_level ) || 
        !isset( $_POST['brg_template_form'] ) || 
        'should-save' !== $_POST['brg_template_form'] ) {
      return;
    }
    // Get the post typtes to save
    $post_types = apply_filters( 'brg/posts_with_templates', array() );
    foreach( $post_types as $post_type ) {
      // Option name the template relation is saved under
      $current_option = 'template_for_' . $post_type;
      // Check if the post type has a related template. If not, make sure there is NO option for the post type
      if( isset( $_POST[$current_option] ) && 
          false != $_POST[$current_option] &&
          is_numeric( $_POST[$current_option] ) ) {
        $template_id = $_POST[$current_option];
        update_option( $current_option, $template_id );
      } else {
        delete_option( $current_option );
      }
    }
  }
}
