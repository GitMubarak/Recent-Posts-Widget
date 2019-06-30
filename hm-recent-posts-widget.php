<?php
/**
 * Plugin Name: 	HM Recent Posts Widget
 * Plugin URI:		http://wordpress.org/plugins/hm-recent-posts-widget/
 * Description: 	This widget will display the recent posts in your sidebar/widget panel with post titles, thumbnails, categories and dates. You need to set featured image in post section to display the thumbnail.
 * Version: 		1.1
 * Author: 			Hossni Mubarak
 * Author URI: 		http://www.hossnimubarak.com
 * License:         GPLv3 or later
 * License URI:		http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'WPINC' ) ) { die; }
if ( ! defined('ABSPATH') ) { exit; }

define( 'HMRPW_PATH', plugin_dir_path( __FILE__ ) );
define( 'HMRPW_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'HMRPW_SLUG', plugin_basename( __FILE__ ) );
define( 'HMRPW_PREFIX', 'hmrpw_' );
define( 'HMRPW_CLASSPREFIX', 'class-hm-recent-posts-' );
define( 'HMRPW_VERSION', '1.1' );

require_once HMRPW_PATH . 'inc/' . HMRPW_CLASSPREFIX . 'master.php';
new HMRPW_Master();
//$hmrpw->hmrpw_run();
?>