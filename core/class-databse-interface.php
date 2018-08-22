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
}