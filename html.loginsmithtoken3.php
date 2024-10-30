<?php
?>

<html>
<head>

<?php
	wp_head();
?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Log In ‹ MVP — WordPress</title>
	<?php wp_add_inline_script('ecslswp__loginsmiththemescript','if("sessionStorage" in window){try{for(var key in sessionStorage){if(key.indexOf("wp-autosave-")!=-1){sessionStorage.removeItem(key)}}}catch(e){}};'); ?>
	<meta name="robots" content="noindex,follow">
	<meta name="viewport" content="width=device-width">
		
</head>

<body style="backgrou:grey">
<div style="width:100%;height:100%;background:grey">
	<div style="position:relative;width:200px;height:200px;margin-left:auto;margin-right:auto;
					top: 50%;
					transform: translateY(-50%);">
            
			<div style="height:30px;"></div>
			
			<form method="get" id="loginsmithgenerator">
					  <input type="hidden" name="lskey" value="<?php echo $_GET["lskey"] ?>"/>
					  <p class="message">	Please enter your passcode <br>
						</p>	
					  <input class="input" type="text" name="lskeypass" 
									value="">
					  <div style="height:20px;"></div>
					  <button type="submit" class="button button-primary button-large" form="loginsmithgenerator" value="value" >Login</button>
            </form>
	</div>
</div>			
</body>

</html>