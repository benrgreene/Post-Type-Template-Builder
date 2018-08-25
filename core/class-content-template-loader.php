<?php 

class BRG_Template_Loader {

  // Setup filter for the content
  public function __construct() {
    $this->apply_filter = true;

    // need the post info setup before adding all the nessecary filters
    add_action( 'wp', array( $this, 'setup_loader' ) );

    // Add the plugin shortcodes for going in the templates
    add_shortcode( 'default-content', array( $this, 'display_default_content' ) );
  }

  // Check if we should add a filter for the content or not
  public function setup_loader() {
    $this->post_type = get_post_type();
    $have_template = get_option( 'template_for_' . $this->post_type );

    if( $have_template && is_singular( $this->post_type ) ) {
      add_filter( 'the_content', array( $this, 'load_post_type_template' ), 10, 1 );
    }
  }

  // Load the content for the template
  public function load_post_type_template( $content ) {
    // Get and proccess the template
    if( $this->apply_filter === true ) {
      // Don't want to recursivley apply this filter and cause an infinite loop
      $this->apply_filter = false;
      $post_template      = get_option( 'template_for_' . $this->post_type );
      $content            = get_post_field( 'post_content', $post_template );
      $content            = apply_filters( 'the_content', $content );
      $this->apply_filter = true;
    }
    
    return $content;
  }

  // Print out the default content
  public function display_default_content( $atts ) {
    $content = apply_filters( 'the_content', get_the_content() );
    return $content;
  }
}