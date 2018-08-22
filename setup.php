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
      $this->admin_controller = new BRG_PTT_Admin_Interface_Controller();
      $this->table_interface  = BRG_PTT_Database_Interface::get_instance();
    }

}

new BRG_Post_Type_Templates();