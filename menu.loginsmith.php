<?php


function loginsmith_registermenuoptions()
{
	
	add_option( 'loginsmith_login_admin_passcode', ( get_option( 'loginsmith_login_admin_passcode' ) === 'false' ? '0' : '1' ) );
	add_option( 'loginsmith_login_users_passcode', ( get_option( 'loginsmith_login_users_passcode' ) === 'false' ? '0' : '1' ) );
	
}