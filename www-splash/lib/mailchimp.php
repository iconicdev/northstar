<?php

	//base variables
	$api_key = "d861580414f98581afad700ac685b121-us5";
	$list_id = "016b89bb83";/* INSERT LIST ID */
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

		//check if error is because user has already signed-up
		$pos = strpos($data->error, 'already subscribed');
		if($pos !== false) {
			$response['code'] = 300;
			$response['error'] = 'You have already signed-up.';
		} else {
			$response['code'] = 400;
			$response['error'] = $data->error;
		}
	} else {
		$response['code'] = 200;
	}

	//return result
	header('Content-Type: application/json');
	echo json_encode($response);

?>