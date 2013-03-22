<?php

	//base variables
	$api_key = "5daa95527bd1521bf1ca847452b96808-us4";
	$list_id = "";/* INSERT LIST ID */
	$double_optin = false;
	$send_welcome = false;
	$email_type = "html";

	list($key, $datacenter) = explode('-', $api_key, 2);

	$submit_url = "http://".$datacenter.".api.mailchimp.com/1.3/?method=listSubscribe";

	//retrieve vars
	$email = $_POST['email'];

	$data = array(
		'email_address'=>$email,
		'apikey'=>$api_key,
		'id' => $list_id,
		'double_optin' => $double_optin,
		'send_welcome' => $send_welcome,
		'email_type' => $email_type
	);

	$payload = json_encode($data);
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $submit_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
	 
	$result = curl_exec($ch);
	curl_close ($ch);
	$data = json_decode($result);

	if ($data->error){
		$response['code'] = 400;
		$response['error'] = $data->error;
	} else {
		$response['code'] = 200;
	}

	//return result
	header('Content-Type: application/json');
	echo json_encode($response);

?>