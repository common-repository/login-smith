<?php
/**
* @package LoginSmithPlugin
*/


/*
plugin Name: Login Smith
Plugin URI: http://loginsmith.ekeysmith.com/wordpressplugin
Description: This is the beta version of Electronics Key Smith (EKS) Word press plugin demonstrating basic principles for EKSs login and authentication software suite based on tokenized logins. You can use it to generate token logins and use these logins to login to your wordpress account. Find the generator and an overview of your token logins at the LoginSmith page, when you are logged in. When generating a login you will be given a link or an html file. The link allows you to login to your account. The file allows you to login by opening the html file. A first glimpse into what additional features the suite holds is presented by the passcode, which can be set to increase login security. Find out more about it on our website or get in touch with us.
Version: 0.0.1
Author: Electronic Key Smith
Author URI: http://ekeysmith.com
License: GPLv2 ? check license
*/

/// License Header

if( ! defined( 'ABSPATH' ) )
{
	die;
}


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}


define( 'LOGINSMITH_VERSION', '0.0.3');
define( 'LOGINSMITH_MINIMUM_WP_VERSION', '4.0' );
define( 'LOGINSMITH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LOGINSMITH_DELETE_LIMIT', 100000 );


require_once( LOGINSMITH_PLUGIN_DIR . 'class.loginsmith.php' );
require_once( LOGINSMITH_PLUGIN_DIR . 'class.options.php');
require_once( LOGINSMITH_PLUGIN_DIR . 'funcs.encrypt.php');


register_activation_hook( __FILE__, array( 'ecslswp__LoginSmith', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, 'ecslswp__plugin_deactivation' );
add_action( 'wp_loaded', array( 'ecslswp__LoginSmith', 'plugin_login' ) );

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );


if( class_exists('ecslswp__LoginSmith') )
{
	$ecslswp__g_loginSmith = new ecslswp__LoginSmith();
}

