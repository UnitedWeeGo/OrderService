<?php

//initialize the request variable
			$request = "";
			
			$param["SMSDestination"] = "14042190686"; // TODO:: Get actual customer number, strip out non-digits and if no country code, assume "1"
			
			
			$param["Username"] = "SAPIENT";
			$param["Password"] = "password";
			
			$param["CustomerNickname"] = "SAPIENT"; 
			//$param["CarrierId"] = ?
			$param["Message"] = $param["CustomerNickname"].", your order is ready!";
			
			//traverse through each member of the param array
			foreach($param as $key=>$val){
				//we have to urlencode the values
				$request.= $key."=".urlencode($val);
				//append the ampersand (&) sign after each paramter/value pair
				$request.= "&";
			}
			//remove the final ampersand sign from the request
			$request = substr($request, 0, strlen($request)-1); 
			echo $request."<br/><br/>";
			
    // Create a curl handle
    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://gateway.celltrust.net/TxTNotify/TxTNotify'); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //return as a variable
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
	$response = curl_exec($ch); //run the whole process and return the response

	echo $response."<br/><br/>";

    // Check if any error occured
    if(!curl_errno($ch)) {
        $info = curl_getinfo($ch);
        echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
    }

curl_close($ch); //close the curl handle
    
?>