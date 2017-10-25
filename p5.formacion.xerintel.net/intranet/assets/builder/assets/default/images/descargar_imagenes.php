<?php 
	for ($i=1;$i<47;$i++){
		$numero=str_pad($i,2,"0",STR_PAD_LEFT);
		$ch = curl_init('http://innovastudio.com/builderdemo/assets/default/'.$numero.'.jpg');
		$fp = fopen($numero.'.jpg', 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		
	echo $numero.'.jpg<br>';
	}
	echo 'fin';
	

	
	?>