<?php

$ecslswp___g_key_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_!,.";
$ecslswp___InputAlphabet = array ("a" => 1,
	"b" => 1,
	"c" => 1,
	"d" => 1,
	"e" => 1,
	"f" => 1,
	"g" => 1,
	"h" => 1,
	"i" => 1,
	"j" => 1,
	"k" => 1,
	"l" => 1,
	"m" => 1,
	"n" => 1,
	"o" => 1,
	"p" => 1,
	"q" => 1,
	"r" => 1,
	"s" => 1,
	"t" => 1,
	"u" => 1,
	"v" => 1,
	"w" => 1,
	"x" => 1,
	"y" => 1,
	"z" => 1,
	"A" => 1,
	"B" => 1,
	"C" => 1,
	"D" => 1,
	"E" => 1,
	"F" => 1,
	"G" => 1,
	"H" => 1,
	"I" => 1,
	"J" => 1,
	"K" => 1,
	"L" => 1,
	"M" => 1,
	"N" => 1,
	"O" => 1,
	"P" => 1,
	"Q" => 1,
	"R" => 1,
	"S" => 1,
	"T" => 1,
	"U" => 1,
	"V" => 1,
	"W" => 1,
	"X" => 1,
	"Y" => 1,
	"Z" => 1,
	"1" => 1,
	"2" => 1,
	"3" => 1,
	"4" => 1,
	"5" => 1,
	"6" => 1,
	"7" => 1,
	"8" => 1,
	"9" => 1,
	"0" => 1,
	"_" => 1,
	" " => 1
);

if(!function_exists('ecslswp__checkIsCleanInput'))
{

function ecslswp__checkIsCleanInput($str) {
	global $ecslswp___InputAlphabet;
	
	if($ecslswp___InputAlphabet == null)
	{
	$ecslswp___InputAlphabet = array ("a" => 1,
	"b" => 1,
	"c" => 1,
	"d" => 1,
	"e" => 1,
	"f" => 1,
	"g" => 1,
	"h" => 1,
	"i" => 1,
	"j" => 1,
	"k" => 1,
	"l" => 1,
	"m" => 1,
	"n" => 1,
	"o" => 1,
	"p" => 1,
	"q" => 1,
	"r" => 1,
	"s" => 1,
	"t" => 1,
	"u" => 1,
	"v" => 1,
	"w" => 1,
	"x" => 1,
	"y" => 1,
	"z" => 1,
	"A" => 1,
	"B" => 1,
	"C" => 1,
	"D" => 1,
	"E" => 1,
	"F" => 1,
	"G" => 1,
	"H" => 1,
	"I" => 1,
	"J" => 1,
	"K" => 1,
	"L" => 1,
	"M" => 1,
	"N" => 1,
	"O" => 1,
	"P" => 1,
	"Q" => 1,
	"R" => 1,
	"S" => 1,
	"T" => 1,
	"U" => 1,
	"V" => 1,
	"W" => 1,
	"X" => 1,
	"Y" => 1,
	"Z" => 1,
	"1" => 1,
	"2" => 1,
	"3" => 1,
	"4" => 1,
	"5" => 1,
	"6" => 1,
	"7" => 1,
	"8" => 1,
	"9" => 1,
	"0" => 1,
	"_" => 1,
	" " => 1
	);
	}
	
	if(strlen($str) > 0)
	{
		 
		for($i = 0; $i<strlen($str);++$i) {
			
			if( array_key_exists( $str[$i], $ecslswp___InputAlphabet))
			{
				
			}else
				return false;
			
		}
		
		return true;
	}
	
	return false;
}
}

if(!function_exists('ecslswp__generate_key_token'))
{

function ecslswp__generate_key_token($length = 20) {

  global $ecslswp___g_key_chars;
  
  if($ecslswp___g_key_chars == null)
	$ecslswp___g_key_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_!,.";
  
  $result = "";
  for($i = 0; $i<$length;++$i) {
   
	$result .= $ecslswp___g_key_chars[mt_rand(0, strlen($ecslswp___g_key_chars) - 1)];
  
  }

  return $result;
  //  $result = encodeString($result;
}

}

if(!function_exists('ecslswp__create_login_tableentry'))
{
	
function ecslswp__create_login_tableentry( $table_name, $tk1md5, $tk2md5, $token3, $user_id, $newlinkname, $email)
	{
		global  $wpdb;
		$result = 0;
		
		for($i = 0; $i<3; $i = $i + 1)
		{

			$querystr = "
					SELECT * 
					FROM ". $table_name .
					" WHERE tk1 = '" . $tk1md5 . "'" .
					";";

			$pageposts = $wpdb->get_results($querystr, OBJECT);

			if(count($pageposts) == 0)
			{
				$sqlquery = "";
				
				if(true or $email == 1)
				{
					$sqlquery = "INSERT INTO " . $table_name . "(tk1, tk2, tk3, ids, name, email) VALUES( " .
											"'" . $tk1md5 . "','" .  $tk2md5 . "','" . $token3 . "','" . $user_id . "','" . $newlinkname . "',' TRUE');";
					
				}else
				{
					$sqlquery = "INSERT INTO " . $table_name . "(tk1, tk2, tk3, ids, name, email) VALUES( " .
											"'" . $tk1md5 . "','" .  $tk2md5 . "','" . $token3 . "','" . $user_id . "','" . $newlinkname . "',' FALSE');";			
				}
				
				$wpdb->query($sqlquery);
				return 1;
			}
		
		}

		echo "Fatal error. Your key table is full";

		return 0;
		
	}
}
