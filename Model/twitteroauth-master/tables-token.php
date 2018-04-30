<?php 

//`text_twitter`
	include "config/koneksi.php";
	$tweet = mysqli_query($DBcon, "SELECT * FROM `text_twitter`");
	
	$string = array();

	foreach ($tweet as $result) {
					
		$st = str_replace("@BiznetHome", "", $result["text"]);
		array_push($string, $st);
	}
	$Count = 0;
	foreach ($string as $key) {
		
		?>
			
		<?php
		$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";	
		$key1 = preg_replace($regex, "", $key);
		$string12 = preg_replace("/[^A-Za-z0-9\-]/", " ", $key1);
		if(preg_match("/[a-z]/i", $string12)){
			$Count++;
		?>
			<tr>
			<td><?php echo $Count;?></td>
			<td>
		<?php
			$tokens = $tokenizer->tokenize($string12);
						
			for ($i=0; $i < count($tokens); $i++) { 
							
				if($i == (count($tokens) -1)){
							echo $tokens[$i].".";
				}
				else{
					echo $tokens[$i].", ";
				}
			}
				echo "<br>";
		}
		?>
			</td>
			</tr>
		<?php
	}
	
?>

