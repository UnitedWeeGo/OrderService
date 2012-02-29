<?php

require_once "reqbase.php";
require ("../Services/Twilio.php");

class SMSTest extends ReqBase
{
	function SMSTest()
	{
		parent::__construct();
	}
	function process()
	{
		$lu = new Instance();
		
		$instance = $lu->Get(26);
		
		$account_sid = $instance->twilioAccountSID;
		$auth_token = $instance->twilioAuthToken;
		
		$http = new Services_Twilio_TinyHttp('https://api.twilio.com', array('curlopts' => array(
			CURLOPT_SSL_VERIFYPEER => false
		)));
		
		$client = new Services_Twilio($account_sid, $auth_token, '2010-04-01', $http);
		
		$message = $client->account->sms_messages->create(
		  $instance->twilioPhoneNumber, // From a Twilio number in your account
		  '+18015564968', // Text any number
		  $instance->twilioSMSMessage
		);
		echo 'Success: ' + $message->sid;
	}
}

$consumer = new SMSTest();
$consumer->process();


?>