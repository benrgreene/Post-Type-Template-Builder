<?php

/**
    Plugin Name: Post Type Template Builder
    Plugin URI:
    Description: Add custom templates to set as you single view for post types
    Author: Ben Greene
    Version: 1
    License: MIT
 */

require( 'core/class-admin-controller.php' );
require( 'core/class-databse-interface.php' );

class BRG_Post_Type_Templates {

    public function __construct() {
      // Minimum level for users to update templates
      $this->min_level = apply_filters( 'brg/ptt/minimum_user_level', 'activate_plugins' );

      $this->admin_controller = new BRG_PTT_Admin_Interface_Controller( $this->min_level );
      $this->table_interface  = BRG_PTT_Database_Interface::get_instance();

      // Check for template updates
      $this->save_template();
    }

    // Check if there is a new template to save, and only allow users with permission to save the template
    public function save_template() {
      if( !current_user_can( $this->min_level ) ||
          !isset( $_POST['template_post_type'] ) ) {
        return;
      }

      $template_type = $_POST['template_post_type'];
      $template_html = $_POST['template_html'];

      $this->table_interface->save_template( $template_type, $template_html );
    }
}

add_action('init', function() {
  new BRG_Post_Type_Templates();
});