<?php
/**
 Plugin Name: Download Proxy
 Plugin URI: https://bleepblorp.pub
 Description: Plugin to show referenced downloads in the sidebar
 Version: 1.0.1
 Author: Brian Anderson
 Author URI: https://bleepblorp.pub
 License: MIT
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );

$plugin_data = get_plugin_data( __FILE__ );

define( 'BA_DS_VERSION', $plugin_data['Version'] );
define( 'BA_DS_DEBUG', FALSE );
define( 'BA_DS_PATH', plugin_dir_path( __FILE__ ) );
define( 'BA_DS_URL', plugins_url( '', __FILE__ ) );
define( 'BA_DS_PLUGIN_FILE', basename( __FILE__ ) );
define( 'BA_DS_PLUGIN_DIR', plugin_basename( dirname( __FILE__ ) ) );
// define( 'BA_DS_ADMIN_DIR', MATF_PATH . 'admin' );
// define( 'BA_DS_PUBLIC_DIR', 'public' );
// define( 'BA_DS_PUBLIC', MATF_PATH . MATF_PUBLIC_DIR );

// Adding Hook Class
// require_once( BA_DS_PUBLIC . '/ba-tweet-feeds-shortcode.php' );

function ba_download_sidebar_proxy_downloads( $atts , $content = null ) {
  $regex_for_downloads = '/\[download.*id="([0-9]+)"\]/';
  $ids = [];
  $html = [];
  $title = "Additional Information";

  $current_content = get_the_content();

  preg_match_all($regex_for_downloads, $current_content, $matches);
  foreach ($matches as $i => $match) {
    if ($i > 0){
      $ids = array_merge($ids, $match);
    }
  }

  if( !empty($ids) ){
    $html[]='<h2>'.$title.'</h2>';
  }
  foreach($ids as $id){
    $html[] = '<p>[download id="'.$id.'"]</p>';
  }

  return do_shortcode( join( "\n", $html ) );
}

add_shortcode( 'ba-proxy-downloads', 'ba_download_sidebar_proxy_downloads' );
