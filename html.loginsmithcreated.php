<?php




?>
<div>
	<div style="width:500px;height:150px;opacity:0.8;background:#cfcfcf;border-left:10px">
		<div style="height:10px"></div>
		<table style="width:500px;">
			  <tr>
			    <th style="width:20px"></th>
				<th>Login Link</th>
				<th>Login File</th>
			    <th style="width:20px"></th>
			  </tr>

			  <tr>
				<td style="width:20px"></td>
				<td>
					<a href="<?php echo wp_login_url() . $new_key_ending; ?>">
						<?php echo wp_login_url() . $new_key_ending; ?>
					</a>
				</td>
				<td>

				<script> 
						function ecslswp__download(filename, text) {
							  var element = document.createElement("a");
							  element.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(text));
							  element.setAttribute("download", filename);

							  element.style.display = "none";
							  document.body.appendChild(element);

							  element.click();

							  document.body.removeChild(element);
						}
				</script> 
					
						<?php 
							$entry1 = "0; url=" . wp_login_url() . $new_key_ending;
							$entry2 = wp_login_url() . $new_key_ending;
					
						 $longstring = "<!DOCTYPE HTML><html lang=\'en-US\'><head><meta charset=\'UTF-8\'><meta http-equiv=\'refresh\' content=\'". $entry1 . "\' ><script type=\'text/javascript\'>window.location.href = \'" .  $entry2 . "\'</script><title>Page Redirection</title></head><body>If you are not redirected automatically, follow this <a href=\'" . $entry2; "\' . >link to example</a>.</body></html>";
						?>

								
						
					

					<button style="width:100px;height:80px;margin-left:auto;margin-right:auto"
						class="btn"
						onclick="ecslswp__download('htmlfile', '<?php echo $longstring; ?>')";
						> Download as file </button>";
						
				</td>
				<td style="width:20px"></td>
			  </tr>
			
			
		</table> 	
	

	

	</div>
</div>