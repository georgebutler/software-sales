<?php
/**
 * @package SoftwareSales
 */
/*
Plugin Name: Software Sales
Description: Used to create a platform for selling software keys and digital products.
Version: 1.0.0
Author: George Butler
Author URI: https://github.com/georgebutler
Text Domain: software-sales
*/

if ( !function_exists( 'add_action' ) ) {
    exit;
}

define( 'SOFTWARESALES__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'SoftwareSales', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'SoftwareSales', 'plugin_deactivation' ) );

require_once(SOFTWARESALES__PLUGIN_DIR . 'class.softwaresales.php');

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( SOFTWARESALES__PLUGIN_DIR . 'class.softwaresales-admin.php' );
    add_action( 'init', array( 'SoftwareSales_Admin', 'init' ) );
}

add_action( 'init', array( 'SoftwareSales', 'init' ) );