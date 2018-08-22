<?php

require( 'class-database-manager.php' );

class BRG_PTT_Database_Interface extends Database_Table_Manager {

  public static $instance;

  public static function get_instance() {
    if( null == self::$instance) {
      self::$instance = new BRG_PTT_Database_Interface();
    }
    return self::$instance;
  }

  private function __construct() {
    $db_path = plugin_dir_path( __DIR__ ) . 'database.ini';
    $this->init_db( $db_path );
  }

  public function get_template( $post_type ) {
    global $wpdb;
    $sql = $wpdb->prepare( "SELECT template_html FROM {$wpdb->prefix}{$this->table_name} WHERE template_post_type=%s", array( $post_type ) );
    $results = $wpdb->get_results( $sql, ARRAY_A );
    return empty( $results ) ? array() : $results[0];
  }

  // Check if saving a new template OR updating. delegate the saving
  public function save_template( $post_type, $template_content ) {
    $have_row = $this->get_template( $post_type );
    if( empty( $have_row ) ) {
      $this->new_template( $post_type, $template_content );
    } else {
      $this->update_template( $post_type, $template_content );
    }
  }

  // Insert a new template into the DB table
  public function new_template( $post_type, $template_html ) {
    global $wpdb;
    $sql = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}{$this->table_name} (template_post_type, template_html ) VALUES (%s, '%s')", array(
      $post_type,
      $template_html
    ) );
    $wpdb->query( $sql );
  }

  // Update a template by post type
  public function update_template( $post_type, $template_html ) {
    global $wpdb;
    $sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}{$this->table_name} SET template_html=%s WHERE template_post_type=%s", array(
      $template_html,
      $post_type,
    ) );
    $wpdb->query( $sql );
  }
}