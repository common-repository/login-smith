<?php

if(!class_exists('ecslswp__LoginSmithSettingsPage'))
{
class ecslswp__LoginSmithSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
	public static $loginsmith_options_name = "loginsmithoptions"; 

    /**
     * Start up
     */
    public function __construct()
    {
		
       add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
   
	}

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
		add_menu_page('LoginSmith', 'LoginSmith', 'read', 'loginsmith', array( $this, 'create_admin_page' ) );

    }
	


    /**
     * Options page callback ...
     */
    public function create_admin_page()
    {
		global  $wpdb;
		
        // Set class property
		$table_name = $wpdb->prefix . "loginsmith_keys";
		$new_key_generated = false;
		$new_key_link = "";
		$new_key_ending = "";
		$new_key_linkname = "";
		
        $this->options = get_option( self::$loginsmith_options_name /*'my_option_name'*/ );
        
		$word_name = "";
		$word_passcode = "";
		$word_name_error = "";
		$word_passcode_error = "";
		
		/// attempt to delete a link
		if(array_key_exists('lskdelet', $_GET))
		{
			$newlinkid = $_GET["lskdelet"];
			/// first check wheather the user is authorisized
			$querystr = "
							SELECT * 
							FROM ". $table_name .
							" WHERE id =  '" . $newlinkid .
							"';";

			
			$keys = $wpdb->get_results($querystr, OBJECT);
			$count = 0;
			
			if(count($keys) > 0)
			{
				$mykey = $keys[0];
				if($mykey->ids == ecslswp__encode_number(get_current_user_id()) )
				{
					$querystr = "
							DELETE FROM ". $table_name .
							" WHERE id =  '" . $mykey->id .
							"';";
					
					$wpdb->query( $querystr );					
				}

			}
			
		}else /// attampt to create a link
		if(array_key_exists('lskn', $_GET))
		{
			$newlinkname = $_GET["lskn"];
			$linkwithmail = 0;
			$word_name = $newlinkname;
			
			if(array_key_exists('lskm', $_GET))
				$linkwithmail = $_GET["lskm"];
		
			if(array_key_exists('lskp', $_GET))
			{
							$newlinkpasscode = $_GET["lskp"];
							$word_passcode = $_GET["lskp"];
			}
			
			/// create a login !
			if($newlinkname !== null && $newlinkpasscode !== null)
			{
				require_once( LOGINSMITH_PLUGIN_DIR . 'funcs.encrypt.php');
				require_once( LOGINSMITH_PLUGIN_DIR . 'funcs.loginsmith.php');
					

				if((!ecslswp__checkIsCleanInput($newlinkname) or strlen($newlinkname) > 32 or strlen($newlinkname) < 6) or (!ecslswp__checkIsCleanInput($newlinkpasscode) and strlen($newlinkpasscode) > 0) or strlen($newlinkpasscode) > 16)
				{
					
					
					if((!ecslswp__checkIsCleanInput($newlinkname) or strlen($newlinkname) > 32 or strlen($newlinkname) < 6))
					{
						$word_name_error = "Input format not allowed. Expecting a text of size between 6 and 32 letters [Aa-Zz 0-9_];";
					}
					
					if((!ecslswp__checkIsCleanInput($newlinkpasscode) and strlen($newlinkpasscode) > 0) or strlen($newlinkpasscode) > 0)
					{
						$word_passcode_error = "Input format not allowed. Expecting a text of size between 0 and 16 letters [Aa-Zz 0-9_];";
					}
				}
				else
				if(ecslswp__checkIsCleanInput($newlinkname) && (ecslswp__checkIsCleanInput($newlinkpasscode) || strlen($newlinkpasscode) == 0))
				{
					$haspasscode = false;
					$passcodestring = "";
					//// create table entry
					if(strlen($newlinkpasscode) > 0)
					{
						/// has passcode
						$haspasscode = true;
						$passcodestring = $newlinkpasscode;
					}else
					{
						/// has no passcode
						
					}
					
					//  $sql = "INSERT INTO passtokens (token1, token2, type, status, counter_participants, key_token, file_name, init, link_string) VALUES(".$DBD->quote($tokens[0]).", ".$DBD->quote($tokens[1])."," . $DBD->quote("login") . ", " . $DBD->quote("open") . ", 0, '".$key_token."',". $DBD->quote($filename) . ", NOW()" . ", " . $DBD->quote($link) . ")"; 
					/*
					 * 		id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							time datetime DEFAULT '0000-00-00 00:00:00',
							tk1 VARCHAR(4),
							tk2 VARCHAR(32),
							tk3 VARCHAR(32),
							ids mediumint(9), /// userid
							name VARCHAR(32),
							warnings int
							) $charset_collate;";
					 * 
					 * */
					 
					$user_id = ecslswp__encode_number( get_current_user_id() );
					

					if($user_id  > 0)
					{
						$token1 = ecslswp__generate_key_token(8);
						$token2 = ecslswp__generate_key_token(16);
						$token3 = "";
						
						
						if($haspasscode)
						{
								$token3 = MD5($passcodestring);
						}

						$new_key_linkname = wp_login_url();
						$new_key_ending = "?lskey=" . ecslswp__encode_tokens($token1 , $token2);
						
						$tk1md5 = substr( MD5($token1), 0, 8);
						$tk2md5 = substr( MD5($token2), 0, 16);
						
						//$sqlquery = "INSERT INTO " . $table_name . "(tk1, tk2, tk3, ids, name) VALUES( " .
						//			"'" . $tk1md5 . "','" .  $tk2md5 . "','" . $token3 . "','" . $user_id . "','" . $newlinkname  "','" . $linkwithmail . "');";
						if(ecslswp__create_login_tableentry($table_name, $tk1md5, $tk2md5, $token3, $user_id, $newlinkname, $linkwithmail) == 0)
						{
							
							
							exit;
						}
					
						$word_name = "";
						$word_passcode = "";
						
						$new_key_generated = true;
						$new_key_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."";
						
					
					}
					
					//// generate the link
					
				//	INSERT INTO table(c1,c2,...)
		//VALUES (v1,v2,...);
				
				}
			}
		
		}
		
		
		?>
		
		
        <div class="wrap">
            <h1>LoginSmith</h1>
            <form method="post" action="options.php">
			
            <?php
                // This prints out all hidden setting fields
               // settings_fields( 'my_option_group' );
               // do_settings_sections( 'loginsmithsettings' );
				
               // submit_button();
            ?>
			
            </form>
			<h2>Generate token logins</h2>
            <form method="get" id="loginsmithgenerator">
					  <div style="height:0px;"></div>

					  <div>Link name</div>
					  
					  <?php if(strlen($word_name_error) > 0) {?>  
						<div style="background-color:red;padding:10px;width:235px">
					  <?php } ?>
					  <input type="text" name="lskn" 
									value="<?php echo $word_name; ?>">

					  <?php if(strlen($word_name_error) > 0) {?>  
						<div style="font-weight:bold">
							<?php echo $word_name_error; ?>
						</div>
						</div>
					  <?php } ?>

					  <br/>

					<!--  <input disable type="radio" name="haspasscode" value="0" checked> Password less<br>
					  <input disable type="radio" name="haspasscode" value="1" on> With passcode<br> -->
					  
					  <div style="height:15px;"></div>
					  <div>Passcode (optional)</div>
					  <?php if(strlen($word_passcode_error) > 0) {?>  
						<div style="background-color:red;padding:10px;width:235px">
					  <?php } ?>
					  <input type="text" name="lskp" 
									value="<?php echo $word_passcode; ?>">
						<?php if(strlen($word_passcode_error) > 0) {?>  
						<div style="font-weight:bold">
							<?php echo $word_passcode_error; ?>
						</div>
						</div>
					  <?php } ?>
					  <br/>
					<input type="hidden" name="page" 
									value="loginsmith">
					<div style="height:20px;"></div>
					<button type="submit" class="button" form="loginsmithgenerator" value="value" >Generate login</button>
            </form>
			
			<br/>
			<br/>
			<?php

			
			$table_name = $wpdb->prefix . "loginsmith_keys";

			$querystr = "
					SELECT * 
					FROM ". $table_name .
					" WHERE ids =  " . ecslswp__encode_number( get_current_user_id() ) .
					";";

			$pageposts = $wpdb->get_results($querystr, OBJECT);
			
			//print_r($pageposts);

			if($new_key_generated)
			{
				/// output to user
				include( LOGINSMITH_PLUGIN_DIR . 'html.loginsmithcreated.php' );
				?>
				

				<div style="padding:10px; width:480px; background-color:#cfcfcf; margin-top:5px">
					Usage: Download the file and login to your wordpress account by opening the file.
					As well as you can login by using the link. Once your login is being hacked, you will
					receive a new login link, your old link will be deleted.
				</div>
<?php
			}
?>
			<h2>Generated token login status</h2>

			<table style="width:500px">
			  <tr>
				<th>Name</th>
				
				<th>Delete</th>
			  </tr>

			<?php 
			$formcounter = 0;
			foreach($pageposts as $post)
			{
			?>
				
			  <tr>
				<td><?php echo $post->name ?></td>
				
				<td>
					<form method="get" id="deletelink<?php echo $formcounter; ?>">
						<input type="hidden" name="lskdelet" 
									value="<?php echo $post->id; ?>"/>
						<input type="hidden" name="page" value="loginsmith"/>
						<button type="submit" class="button" form="deletelink<?php echo $formcounter; ?>" value="value" >Delete login</button>
					</form>
				</td>
			  </tr>
			
			<?php 
				$formcounter = $formcounter + 1;
			} ?>
			
			</table> 			
		</div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {     
   

		
        register_setting(
            'my_option_group', // Option group
            ///*'my_option_name'*/, // Option name
            self::$loginsmith_options_name,
			array( $this, 'sanitize' ) // Sanitize
        );

      /*  add_settings_section(
            'setting_section_id', // ID
            'Generate Logins', // Title
            array( $this, 'print_section_info' ), // Callback
            'loginsmithsettings' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'loginsmithsettings', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'loginsmithsettings', 
            'setting_section_id'
        ); */

      /*  add_settings_section(
            'setting_section_id', // ID
            'Generate Logins', // Title
            array( $this, 'print_section_info' ), // Callback
            'loginsmithsettings' // Page
        );  */

   /*     add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'loginsmithsettings', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'loginsmithsettings', 
            'setting_section_id'
        );  */    
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Generate logins for yourself';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" ' . self::$loginsmith_options_name . '[id_number] value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name=' . self::$loginsmith_options_name . "my_option_name" . '[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

}

//if( is_admin() ) is not only available to the admin but to all users
    $ecslswp__my_settings_page = new ecslswp__LoginSmithSettingsPage();