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
require( 'core/class-content-template-loader.php' );

class BRG_Post_Type_Templates {

  public function __construct() {
    add_action('init', array( $this, "setup" ) );
  }

  public function setup() {
    // Minimum level for users to update templates
    $this->min_level = apply_filters( 'brg/ptt/minimum_user_level', 'activate_plugins' );

    add_filter( 'brg/posts_with_templates', array( $this, 'post_types_with_templates' ), 10, 1 );

    $this->admin_controller = new BRG_PTT_Admin_Interface_Controller( $this->min_level );
    $this->template_loader  = new BRG_Template_Loader(); 

    // setup the template post type
    $this->setup_posttype();
  }

  // Setup the templates post type. Should not be public, since it isn't actually displayed anywhere
  public function setup_posttype() {
    register_post_type( 'brg_post_templates',
      array(
        'labels' => array(
          'name'          => 'Templates',
          'singular_name' => 'Template'
        ),
        'description' => 'Template for a post type single view',
        'public'      => false,
        'show_ui'     => true
      )
    );
  }

  // This is the default
  public function post_types_with_templates( $post_types ) {
    $post_types = array_merge( $post_types, get_post_types( array(
      '_builtin' => false,
    ) ) );
    $post_types = array_merge( $post_types, array( 
      'post', 'page',
    ) );
    // Remove the templates type from accepting a template
    unset( $post_types['brg_post_templates'] );
    return $post_types;
  }
}

new BRG_Post_Type_Templates();