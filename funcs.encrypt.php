<?php

/// direct link token string lenght
if(!isset($ecslswp__g_token_string_length))
{
$ecslswp__g_token_string_length = 3;
}
/// direct link token lenght
if(!isset($$ecslswp__g_token_length))
{
$ecslswp__g_token_length = 3;
}

/// very simple way of decoding the number
if(!function_exists('ecslswp__encode_number'))
{
function ecslswp__encode_number($number)
{
	return ($number*2 + 17)*2; 
}
}

if(!function_exists('ecslswp__decode_number'))
{
function ecslswp__decode_number($number)
{
	return ($number * 0.5 - 17) * 0.5;
}
}

if(!function_exists('ecslswp__encode_tokens'))
{
function ecslswp__encode_tokens($token1, $token2)
{
	$result = "";
	$pos1 =  0;
	$pos2 =  0;
	for($i = 0; $i<3; $i=$i+1)
	{
		
	}

	for($i = 0; $i<strlen($token1); $i=$i+1)
	{
		$result = $result . $token1[$i];
		$result = $result . $token2[$i];
	}
	
	for($i = strlen($token1);$i<strlen($token2);++$i)
	{
		$result = $result . $token2[$i];
	}
	
	return $result;
}
}

if(!function_exists('ecslswp__decode_tokens'))
{
function ecslswp__decode_tokens($input, &$token1, &$token2)
{
	$token1 = "";
	$token2 = "";
	
	/// input error
	if(strlen($input) < 24)
	{
		return;
	}
	
	for($i = 0; $i<8; $i=$i+1)
	{
		$token1 = $token1 . $input[$i*2];
		$token2 = $token2 . $input[$i*2+1];
	}
	
	for($i = 16;$i<strlen($input);++$i)
	{
		$token2 = $token2 . $input[$i];
	}
	
}
}