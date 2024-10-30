<?php

	/**
	 * Removes all connection options
	 */
if(!function_exists('ecslswp__plugin_deactivation'))
{
	function ecslswp__plugin_deactivation( ) {
		global $wpdb;
		
		//deactivate_key( self::get_api_key() );
		//echo "YB";
		//$sdfdf = $abc123;
		
		/*$role = get_role("loginsmith_admin");
		
		if($role !== null)
		{
			$sdfdf = $abc;
			$role->remove_cap("loginsmith_edit_menu");
			remove_role( "loginsmith_admin" );
			
		}*/
		
		$table_name = $wpdb->prefix . "loginsmith_keys";
		$sql = "DROP TABLE IF EXISTS $table_name";
		/// dont drp the table !
		//require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
		//dbDelta( $sql );
		
		//$spdb->query($sql);
		
		// Remove any scheduled cron jobs.
		/*$loginsmith_cron_events = array(
			'loginsmith_schedule_cron_recheck',
			'loginsmith_scheduled_delete',
		);*/
		
		/*foreach ( $loginsmith_cron_events as $loginsmith_cron_event ) {
			$timestamp = wp_next_scheduled( $loginsmith_cron_event );
			
			if ( $timestamp ) {
				wp_unschedule_event( $timestamp, $loginsmith_cron_event );
			}
		}*/
	}
}

if(!class_exists('ecslswp__LoginSmith'))
{
class ecslswp__LoginSmith {

	private static $login_admin_passcode = false;
	private static $login_user_passcode = false;
	
	public static $settings_page;
	/// prefix for the file send to the user
	private static $keyfile_prefix;
	/// website url
	private static $loginsmith_websiteUrl;

	public static function loginuser($id) {
			global  $wpdb;

			$user = get_user_by("id" ,$id);
			
			if($user !== null)
			{
			
				wp_set_current_user( $id, $user->user_login );
				wp_set_auth_cookie( $id );
				do_action( 'wp_login', $user->user_login );
			
			}

/*			$querystr = "
							SELECT * 
							FROM ". $table_name .
							" WHERE tk1 =  " . tk1 .
							";";

						$keys = $wpdb->get_results($querystr, OBJECT);
						$count = 0;
*/
		
	}
	
	public static function send_email_passage($oldkey)
	{
		global $wpdb;
		
		$table_name = $wpdb->prefix . "loginsmith_keys";
		$new_key_generated = false;
		$new_key_link = "";
		$new_key_ending = "";
		$new_key_linkname = "";
	

		$token1 = ecslswp__generate_key_tokengenerate_key_token(8);
		$token2 = ecslswp__generate_key_tokengenerate_key_token(16);
		$token3 = "";

		$token3 = $oldkey->tk3;

		$new_key_linkname = wp_login_url();
		$new_key_ending = "?lskey=" . encode_tokens($token1 , $token2);
		$newlinkname = $oldkey->name;
		$user_id = $oldkey->ids;
		
		$tk1md5 = substr( MD5($token1), 0, 8);
		$tk2md5 = substr( MD5($token2), 0, 16);
		
		//$sqlquery = "INSERT INTO " . $table_name . "(tk1, tk2, tk3, ids, name) VALUES( " .
		//			"'" . $tk1md5 . "','" .  $tk2md5 . "','" . $token3 . "','" . $user_id . "','" . $newlinkname  "','" . $linkwithmail . "');";
		if(ecslswp__create_login_tableentry($table_name, $tk1md5, $tk2md5, $token3, $user_id, $newlinkname, 1) == 0)
		{
			exit;
		}
						

		$current_user = wp_get_current_user();
		$entry_url = wp_login_url() . $new_key_ending;
		
		$to = $current_user->user_email;//'sendto@example.com';
		$subject = 'Wordpress login warnings.';
		$body = 'Dear '. $current_user->user_firstname . ' ' . $current_user->user_lastname . ',' . "\n\n Your Wordpress login from " . get_site_url() . " was removed due to security warnings. We are sending you a new link:\n<a href='" . $entry_url . "'>". $entry_url ."</a>  \n\n\n Yours Faithfully, \n\n\n Electronic Key Smith.";
		$headers = array('Content-Type: text/html; charset=UTF-8');
		//echo $body;
		wp_mail( $to, $subject, $body, $headers );
	}
	
	/// delete the loginpass
	public static function check_delete_loginpass($pass, $tablename)
	{
		global  $wpdb;

		if(property_exists($pass, 'warnings') and $pass->warnings > 3)
		{
				//DELETE FROM wp_loginsmith_keys WHERE id = 1
			$sql = "DELETE FROM " . $tablename . " WHERE id = '" . $pass->id . "';";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
			///echo $sql;
			$wpdb->query( $sql );

			self::send_email_passage($pass);
			
			if(property_exists($pass, 'email') and $pass->email != 0)
			{
				/// send an email with new login informaiton
			}
			
		}
	}
	
	public static function redirect_to_loggedin_site()
	{
		wp_redirect( get_site_url() ); ///"form.loginsmithtoken3.php?lskey=" . $link );
		
		exit;
	}

/// subroutine that updates the warnings of a login token
	public static function plugin_login_checkwarnings($checkwarnings, $value, $table_name)
	{
			global  $wpdb;
			
			$sql = "";
							if($checkwarnings)
							{
								if( property_exists($value, 'warnings') ) 
								{
	 
									if($value->warnings === null)
									{
										
										$sql = "UPDATE " . $table_name . " SET warnings = 1 WHERE id = '" . $value->id . "';";
										//echo $sql;
										require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
										dbDelta( $sql );
										
										self::check_delete_loginpass($value, $table_name);
									}
									else{
									
										$sql = "UPDATE " . $table_name . " SET warnings = warnings + 1 WHERE id = '" . $value->id . "';";
										require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
										dbDelta( $sql );
										
										self::check_delete_loginpass($value, $table_name);

									}
									
								}else
								{
									//$dda = $dffdfd;

									$sql = "UPDATE " . $table_name . " SET warnings = 1 WHERE id = '" . $value->id . "';";
									require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
									dbDelta( $sql );
									
									self::check_delete_loginpass($value, $table_name);
								}
							}
	}
	
	public static function reset_warnings($value, $tablename)
	{
			global  $wpdb;
			//echo "restting";
			
			$sql = "UPDATE " . $table_name . " SET warnings = 0 WHERE id = '" . $value->id . "';";
			//echo $sql;
			$wpdb->query($sql);
	}
	//// always called when loading wordpress
	public static function plugin_login(){
		global  $wpdb;

			//echo "calling";
		if(is_user_logged_in())
		{
			//echo "I am logged in";
			if(array_key_exists('lskey', $_GET))
			{
				//echo "logged in";
				self::redirect_to_loggedin_site();
			}
			
		}else
		{
				if(array_key_exists('lskey', $_GET))
				{
					$link = $_GET["lskey"];
					//$ddfd = dafsdfsd;
					
					$tk1 = "";//substr($link, 0, 8);
					$tk2 = "";//substr($link, 8, 16);
					$tk3 = "";
					
					ecslswp__decode_tokens($link, $tk1, $tk2);
					
					$tk1md5 = substr( MD5($tk1), 0 , 8);
					$tk2md5 = substr( MD5($tk2), 0 , 16);
					
					if(array_key_exists('lskeypass', $_GET))
						$tk3 = $_GET["lskeypass"]; 
					//$tk3 = "";
					
					//if(strlen($link) > 16)
					//	$tk3 = substr($link, 16, strlen($link) - 16);
					
					/// $newlinkpasscode = $_GET["lskp"];
					/// create a login !
					if($link !== null && strlen($link) > 0)
					{
						require_once( LOGINSMITH_PLUGIN_DIR . 'funcs.encrypt.php');
						require_once( LOGINSMITH_PLUGIN_DIR . 'funcs.loginsmith.php');

						$table_name = $wpdb->prefix . "loginsmith_keys";

						$querystr = "
							SELECT * 
							FROM ". $table_name .
							" WHERE tk1 =  '" . $tk1md5 .
							"';";

						//echo $querystr;
						$keys = $wpdb->get_results($querystr, OBJECT);
						$count = 0;
						foreach($keys as $value)
						{
							$checkwarnings = false;

							if(strcmp( $value->tk2, $tk2md5 ) == 0 )
							{
								//// key fits
								if( property_exists($value, 'tk3') and strlen($value->tk3) > 0 )
								{

									if(strlen($tk3) > 0 and strcmp(MD5($tk3), $value->tk3) == 0)
									{
										/// login the user
										self::reset_warnings($value, $table_name);
										self::loginuser( ecslswp__decode_number($value->ids) );
										self::redirect_to_loggedin_site();
										//exit;
										
									}else
									{
										$checkwarnings = true;
										include( LOGINSMITH_PLUGIN_DIR . "html.loginsmithtoken3.php" );
										
										if(strlen($tk3) > 0)
											self::plugin_login_checkwarnings($checkwarnings, $value, $table_name);
										//// redirect to the login site
										// exit( wp_redirect( admin_url( 'options-general.php?page=myplugin_settings' ) )
										//wp_redirect( LOGINSMITH_PLUGIN_DIR . "form.loginsmithtoken3.php?lskey=" . $link );
										exit;
									}
										
								
								}else /// login
								{
									/// found a user !
									self::reset_warnings($value, $table_name);
									self::loginuser(ecslswp__decode_number($value->ids));
									self::redirect_to_loggedin_site();
							
								}
								
							}else
								$checkwarnings = true;
							
							
							self::plugin_login_checkwarnings($checkwarnings, $value, $table_name);
							
							$count = $count + 1;
						}
						
						
					}
				}
			
		}
		//echo "Y AM I AM HERE";
		
	}

	public static function plugin_activation() {
		global $wpdb;
		
		if ( version_compare( $GLOBALS['wp_version'], LOGINSMITH_MINIMUM_WP_VERSION, '<' ) ) {
		///	load_plugin_textdomain( 'akismet' );
			
			$message = '<strong>'.sprintf(esc_html__( 'LoginSmith %s requires WordPress %s or higher.' , 'loginsmith'), LOGINSMITH_VERSION, 
											LOGINSMITH_MINIMUM_WP_VERSION ).'</strong> '.
											sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version, or <a href="%2$s">downgrade to version 2.4 of the LoginSmith plugin</a>.', 
											'loginsmith'), 
											'https://codex.wordpress.org/Upgrading_WordPress', 
											'https://wordpress.org/extend/plugins/loginsmith/download/');

			LoginSmith::bail_on_activation( $message );
		}
		else
		{
			if( get_role('loginsmith_admin') !== null )
			{
				// ? what is going on here ?
			///	abcd();
			}
			else
			{
				//$role = add_role( "loginsmith_admin", "loginsmith admin");
				//$role->add_cap("loginsmith_edit_menu");
			}
				
			/// now create the mysql table and
			$table_name = $wpdb->prefix . "loginsmith_keys";
			$charset_collate = $wpdb->get_charset_collate();
			
			$sql = "CREATE TABLE $table_name (
						id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
						time datetime DEFAULT '0000-00-00 00:00:00',
						tk1 VARCHAR(8) ,
						tk2 VARCHAR(32),
						tk3 VARCHAR(32),
						ids mediumint(9),
						name VARCHAR(32),
						email BIT DEFAULT 1,
						warnings int,
						INDEX (tk1, ids)
						) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta( $sql );
			
/*			$table_name = $wpdb->prefix . "loginsmith_abuselist";
			$sql = "CREATE TABLE $table_name (
						id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
						time datetime DEFAULT '0000-00-00 00:00:00',
						tk1 VARCHAR(4),
						tk2 VARCHAR(32),
						tk3 VARCHAR(32),
						ids mediumint(9),
						name VARCHAR(32),
						warnings int
						) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta( $sql );	*/		
			
			self::initAndLoadVariables();
			
			register_deactivation_hook( __FILE__, 'plugin_deactivation' );
			
		}
	}
	
	public static function initAndLoadVariables()
	{
		
		if( is_admin() )	
			$settings_page = new ecslswp__LoginSmithSettingsPage();		
		//if( current_user_can() )
		{
		
		}
	}

	
	private static function bail_on_activation( $message, $deactivate = true ) {
?>
<!doctype html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<style>
* {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}
p {
	margin-top: 1em;
	font-size: 18px;
}
</style>
</head>
<body>
<p><?php echo esc_html( $message ); ?></p>
</body>
</html>
<?php
		if ( $deactivate ) {
			$plugins = get_option( 'active_plugins' );
			$loginsmith = plugin_basename( LOGINSMITH_PLUGIN_DIR . 'loginsmith.php' );
			$update  = false;
			foreach ( $plugins as $i => $plugin ) {
				if ( $plugin === $loginsmith ) {
					$plugins[$i] = false;
					$update = true;
				}
			}

			if ( $update ) {
				update_option( 'active_plugins', array_filter( $plugins ) );
			}
		}
		exit;
	}
	
	

	public static function evaluatePassToken($value)
	{
		
	}

}

}